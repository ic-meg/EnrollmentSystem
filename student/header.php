<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['read_notifications']) || !is_array($_SESSION['read_notifications'])) {
  $_SESSION['read_notifications'] = [];
}


$user_id = $_SESSION['user_id'];
$notifications = [];

// --- 1. Profile Completion ---
$profileStmt = $conn->prepare("SELECT created_at FROM studentprofile WHERE user_id = ?");
$profileStmt->bind_param("i", $user_id);
$profileStmt->execute();
$profileResult = $profileStmt->get_result();
if ($profileResult->num_rows > 0) {
  $headerProfile = $profileResult->fetch_assoc();
  $notifications[] = [
    'message' => 'Thank you for completing your profile. You can now proceed to enroll.',
    'date' => date("F j, Y", strtotime($profile['created_at'])),
    'status' => 'unread'
  ];
}
$profileStmt->close();

// --- 2. Enrollment Status ---
$enrolleeStmt = $conn->prepare("SELECT Status, dateSubmitted FROM enrollee WHERE user_id = ?");
$enrolleeStmt->bind_param("i", $user_id);
$enrolleeStmt->execute();
$enrolleeResult = $enrolleeStmt->get_result();
if ($enrolleeResult->num_rows > 0) {
  $enrollee = $enrolleeResult->fetch_assoc();
  $enrolleeStatus = $enrollee['Status'];
  $submittedDate = date("F j, Y", strtotime($enrollee['dateSubmitted']));

  if ($enrolleeStatus === 'Pending') {
    $notifications[] = [
      'message' => "Thank you for submitting your application! It’s now under review, and we’ll update you soon.",
      'date' => $submittedDate,
      'status' => 'unread'
    ];
  } elseif ($enrolleeStatus === 'Approved') {
    $notifications[] = [
      'message' => "Congratulations! Your application has been approved. You can now proceed with the next steps.",
      'date' => $submittedDate,
      'status' => 'unread'
    ];
  } elseif ($enrolleeStatus === 'Rejected') {
    $notifications[] = [
      'message' => "We regret to inform you that your application has been rejected. Please contact the registrar for assistance.",
      'date' => $submittedDate,
      'status' => 'unread'
    ];
  }
}
$enrolleeStmt->close();

// --- 3. Payment Info ---
$paymentStmt = $conn->prepare("SELECT PaymentStatus, PaymentDate FROM paymentinfo WHERE user_id = ?");
$paymentStmt->bind_param("i", $user_id);
$paymentStmt->execute();
$paymentResult = $paymentStmt->get_result();
while ($payment = $paymentResult->fetch_assoc()) {
  $payDate = date("F j, Y", strtotime($payment['PaymentDate']));
  if ($payment['PaymentStatus'] === 'Unpaid') {
    $notifications[] = [
      'message' => "You have pending fees. Please complete your payment to proceed.",
      'date' => $payDate,
      'status' => 'unread'
    ];
  } elseif ($payment['PaymentStatus'] === 'Paid') {
    $notifications[] = [
      'message' => "Your payment has been received successfully. Thank you!",
      'date' => $payDate,
      'status' => 'unread'
    ];
  }
}
$paymentStmt->close();

$unreadCount = 0;
foreach ($notifications as $notif) {
  if (!in_array($notif['message'], $_SESSION['read_notifications'])) {
    $unreadCount++;
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
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


  .bell-wrapper {
    position: relative;
    display: inline-block;
  }


  @keyframes pulse {
    from {
      transform: scale(1);
    }

    to {
      transform: scale(1.15);
    }
  }



  .notif-count-badge {
    position: absolute;
    top: 0;
    right: 0;
    transform: translate(50%, -50%);
    background: red;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 10px;
    font-weight: bold;
    line-height: 1;
    animation: pulse 1s ease-in-out infinite alternate;
    z-index: 10;
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
      <input placeholder="Search" type="search" class="input">
    </div>
    <div class="navbar_right">
      <div class="notifications">
        <div class="icon_wrap bell-wrapper">
          <svg class="notif-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path d="M21.636,17.869c-0.016-0.016-1.581-1.635-1.581-3.952v-2.9c0-3.996-2.957-7.309-6.806-7.91V2.25C13.25,1.56,12.69,1,12,1
    s-1.25,0.56-1.25,1.25v0.857c-3.849,0.601-6.806,3.914-6.806,7.91v2.9c0,2.317-1.565,3.936-1.576,3.947
    c-0.359,0.357-0.467,0.895-0.274,1.363C2.288,19.695,2.744,20,3.25,20H9c0,1.657,1.343,3,3,3s3-1.343,3-3h5.75
    c0.503,0,0.956-0.305,1.15-0.77C22.095,18.766,21.989,18.228,21.636,17.869z" />
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
                <button class="mark-all-read" onclick="markAllAsRead()">

                  <i class="fas fa-check-double"></i>
                  Mark all as read
                </button>
              </div>
            </div>
            <div class="notification_dd_body">
              <ul>

                <?php
                if (!isset($_SESSION['read_notifications'])) {
                  $_SESSION['read_notifications'] = [];
                }

                foreach ($notifications as $notif):
                  $isRead = in_array($notif['message'], $_SESSION['read_notifications']);
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
                      <div class="circle-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0,0,256,256" style="fill:#1A1A1A;">
                          <g fill="#fafafa">
                            <g transform="scale(10.66667,10.66667)">
                              <path d="M12,2c-5.523,0 -10,4.477 -10,10c0,5.523 4.477,10 10,10c5.523,0 10,-4.477 10,-10c0,-5.523 -4.477,-10 -10,-10zM17.707,9.707l-7,7c-0.195,0.195 -0.451,0.293 -0.707,0.293c-0.256,0 -0.512,-0.098 -0.707,-0.293l-3,-3c-0.391,-0.391 -0.391,-1.023 0,-1.414c0.391,-0.391 1.023,-0.391 1.414,0l2.293,2.293l6.293,-6.293c0.391,-0.391 1.023,-0.391 1.414,0c0.391,0.391 0.391,1.023 0,1.414z"></path>
                            </g>
                          </g>
                        </svg>
                      </div>
                    </div>
                  </li>
                <?php endforeach; ?>


              </ul>
            </div>

        </div>
      </div>
    </div>
  </div>


</body>

</html>
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
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/datatables/datatables.min.js"></script>
<script src="assets/js/initiate-datatables.js"></script>
<script src="assets/js/script.js"></script>

<script>
  function markAllAsRead() {
    fetch('mark_all_read.php', {
        method: 'POST',
      })
      .then(response => response.text())
      .then(data => {
        if (data === 'success') {
          location.reload();
        }
      })
      .catch(err => console.error('Failed to mark notifications as read:', err));
  }
</script>