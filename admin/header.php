<?php
include "session_check.php";

if (!isset($_SESSION['admin_read_notifications'])) {
  $_SESSION['admin_read_notifications'] = [];
}


$adminName = "Admin";

if (isset($_SESSION['admin_id'])) {
  $userId = $_SESSION['admin_id'];
  include "../dbcon.php";
  $stmt = $conn->prepare("SELECT FirstName FROM adminaccount WHERE admin_id = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    $adminName = $admin['FirstName'];
  }
  $stmt->close();
}

$adminNotifications = [];

// 1. New enrollee submissions
$enrolleeQuery = $conn->query("SELECT name, dateSubmitted FROM enrollee WHERE Status = 'Pending'");
while ($row = $enrolleeQuery->fetch_assoc()) {
  $adminNotifications[] = [
    'message' => "{$row['name']} submitted their application for review.",
    'date' => date("F j, Y", strtotime($row['dateSubmitted'])),
    'status' => 'unread'
  ];
}

// 2. Payment confirmations
$paymentQuery = $conn->query("SELECT name, amountPaid, PaymentDate FROM paymentinfo WHERE PaymentStatus = 'Paid'");
while ($row = $paymentQuery->fetch_assoc()) {
  $adminNotifications[] = [
    'message' => "Payment of ₱" . number_format($row['amountPaid'], 2) . " received from {$row['name']}.",
    'date' => date("F j, Y", strtotime($row['PaymentDate'])),
    'status' => 'unread'
  ];
}

// 3. Rejections
$rejectedQuery = $conn->query("SELECT name, dateSubmitted FROM enrollee WHERE Status = 'Rejected'");
while ($row = $rejectedQuery->fetch_assoc()) {
  $adminNotifications[] = [
    'message' => "Application from {$row['name']} was rejected.",
    'date' => date("F j, Y", strtotime($row['dateSubmitted'])),
    'status' => 'unread'
  ];
}

// 4. Approvals
$approvedQuery = $conn->query("SELECT name, dateSubmitted FROM enrollee WHERE Status = 'Approved'");
while ($row = $approvedQuery->fetch_assoc()) {
  $adminNotifications[] = [
    'message' => "Application from {$row['name']} was approved.",
    'date' => date("F j, Y", strtotime($row['dateSubmitted'])),
    'status' => 'unread'
  ];
}
$unreadCount = 0;

foreach ($adminNotifications as $notif) {
  $isRead = in_array($notif['message'], $_SESSION['admin_read_notifications']);
  if (!$isRead) {
    $unreadCount++;
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <audio id="notifSound" src="assets/ding.mp3" preload="auto"></audio>

  <meta charset="UTF-8">
  <title>Profile and Notifications Dropdowns</title>
  <link rel="stylesheet" href="header-style.css">
  <link rel="stylesheet" href="notif-drop.css">
  <script src="https://kit.fontawesome.com/b99e675b6e.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

</head>
<style>
  .notification_dd ul {
    padding: 0;
    list-style-type: none;
  }

  .notification_dd_body {
    max-height: 300px;
    overflow-y: auto;
    padding-right: 5px;
  }

  .notification_dd_body::-webkit-scrollbar {
    width: 6px;
  }

  .notification_dd_body::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 4px;
  }

  .notif-count-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    background: red;
    color: white;
    border-radius: 50%;
    padding: 3px 7px;
    font-size: 10px;
    font-weight: bold;
    line-height: 1;

  }

  .notif-count-badge {
    animation: pulse 1s ease-in-out infinite alternate;
  }

  @keyframes pulse {
    from {
      transform: scale(1);
    }

    to {
      transform: scale(1.15);
    }
  }
</style>

<body>

  <div class="navbar">
    <div class="navbar_left">
    </div>
    <div class="group">
      <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
        <g>
          <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
        </g>
      </svg>
      <input id="voiceSearchInput" placeholder="Search..." type="search" class="input">
      <button id="voiceBtn" title="Speak" style="margin-left: 5px; background: none; border: none; cursor: pointer;">
        <i class="fas fa-microphone"></i>
      </button>

    </div>
    <div class="navbar_right">
      <div class="notifications">
        <div class="icon_wrap">
          <svg class="notif-icon" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="24" height="24" viewBox="0 0 24 24">
            <path d="M21.636,17.869c-0.016-0.016-1.581-1.635-1.581-3.952v-2.9c0-3.996-2.957-7.309-6.806-7.91V2.25C13.25,1.56,12.69,1,12,1 s-1.25,0.56-1.25,1.25v0.857c-3.849,0.601-6.806,3.914-6.806,7.91v2.9c0,2.317-1.565,3.936-1.576,3.947 c-0.359,0.357-0.467,0.895-0.274,1.363C2.288,19.695,2.744,20,3.25,20H9c0,1.657,1.343,3,3,3s3-1.343,3-3h5.75 c0.503,0,0.956-0.305,1.15-0.77C22.095,18.766,21.989,18.228,21.636,17.869z"></path>
          </svg>
          <?php if ($unreadCount > 0): ?>
            <span class="notif-count-badge"><?= $unreadCount ?></span>
          <?php endif; ?>
        </div>
        <!-- Dropdown -->
        <div class="notification_dd">
          <ul class="notification_ul">
            <!-- Header inside the dropdown -->
            <div class="notification_header">
              <div class="notification_left">
                <span>Notifications</span>
              </div>
              <div class="notification_right">
                <button class="mark-all-read" onclick="markAllAdminRead()">
                  <i class="fas fa-check-double"></i>
                  Mark all as read
                </button>

              </div>
            </div>
            <div class="notification_dd_body">
              <ul>
                <?php foreach ($adminNotifications as $notif):

                  $isRead = in_array($notif['message'], $_SESSION['admin_read_notifications']);
                  $notif['status'] = $isRead ? 'read' : $notif['status'];
                ?>

                  <li class="<?= $notif['status'] === 'unread' ? 'unread' : 'read' ?>">
                    <div class="left">
                      <?php if ($notif['status'] === 'unread'): ?>
                        <span class="status-dot"></span>
                      <?php endif; ?>
                      <div class="message-content">
                        <p class="message"><?= htmlspecialchars($notif['message']) ?></p>
                        <p class="date"><?= $notif['date'] ?></p>
                      </div>
                    </div>
                    <div class="right">
                      <div class="circle-icon" style="background-color: <?= $notif['status'] === 'unread' ? '#4DD44D' : '#aaa' ?>;">
                        <!-- generic check icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" viewBox="0 0 24 24">
                          <path d="M20.285 2l-11.285 11.293-5.285-5.293-3.715 3.707 9 9 15-15z" />
                        </svg>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>


              </ul>
            </div>
          </ul>
          <ul>
          </ul>
        </div>
      </div>
    </div>
  </div>



  </div>
  <script type="text/javascript" src="notif.js" defer></script>
  <script>
    const toggleButton = document.getElementById('toggle-btn');
    const sidebar = document.getElementById('sidebar');
    const navbar = document.querySelector('.navbar');



    function toggleSidebar() {
      sidebar.classList.toggle('close');
      toggleButton.classList.toggle('rotate');


      navbar.classList.toggle('close', sidebar.classList.contains('close'));

      closeAllSubMenus();
    }

    function toggleSubMenu(button) {
      if (!button.nextElementSibling.classList.contains('show')) {
        closeAllSubMenus();
      }

      button.nextElementSibling.classList.toggle('show');
      button.classList.toggle('rotate');

      if (sidebar.classList.contains('close')) {
        sidebar.classList.toggle('close');
        toggleButton.classList.toggle('rotate');
      }
    }

    function closeAllSubMenus() {
      Array.from(sidebar.getElementsByClassName('show')).forEach(ul => {
        ul.classList.remove('show');
        ul.previousElementSibling.classList.remove('rotate');
      });
    }
  </script>

  <script>
    function markAllAdminRead() {
      fetch("mark_all_admin_read.php", {
          method: "POST"
        })
        .then(res => res.text())
        .then(data => {
          if (data === "success") {
            sessionStorage.removeItem("adminNotifPlayed");
            location.reload();
          }
        })
        .catch(err => console.error("Failed to mark notifications as read:", err));
    }
  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/annyang/2.6.1/annyang.min.js"></script>
  <script>
    const adminName = <?php echo json_encode($adminName); ?>;
  </script>
  <script src="header.js"></script>
  <script>
    const unreadCount = <?= json_encode($unreadCount) ?>;
    const hasPlayed = sessionStorage.getItem("adminNotifPlayed");

    if (unreadCount > 0 && !hasPlayed) {
      const sound = document.getElementById("notifSound");
      sound.play().catch(e => console.warn("Sound auto-play blocked:", e));

      sessionStorage.setItem("adminNotifPlayed", "true");
    }
  </script>

</body>

</html>