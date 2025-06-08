<?php
include "../dbcon.php";
include "session_check.php";

//  pagination
$perPage = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $perPage;


$selectedStatus = isset($_GET['status']) ? $_GET['status'] : 'Pending';
$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM supportpage WHERE status = '$selectedStatus'");
$total_row = mysqli_fetch_assoc($total_result);
$total_entries = $total_row['total'];
$total_pages = ceil($total_entries / $perPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Support Inbox | Admin Panel</title>
  <link rel="stylesheet" href="Support_admin.css">
  <style>
    .hidden {
      display: none;
    }

    .pagination-container a {
      padding: 4px 10px;
      border-radius: 4px;
      text-decoration: none;
      margin: 0 2px;
    }

    .tabs {
      display: flex;
      justify-content: flex-end;
      background-color: #e0e0e0;
      border-radius: 8px;
      overflow: hidden;
      width: fit-content;
      margin-left: auto;
      margin-bottom: 20px;
    }

    .tab {
      padding: 10px 20px;
      text-decoration: none;
      font-weight: 600;
      color: #333;
      background-color: #f1f1f1;
      transition: 0.3s;
    }

    .tab.active {
      background-color: #0d6efd;
      color: white;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
    }

    .tab:not(.active):hover {
      background-color: #d0d0d0;
    }
  </style>
</head>

<body>
  <?php include "admin-sidebar.php"; ?>

  <main>
    </div>
    </div>
    <br><br><br><br>
    <div class="support-header">
      <h1>Support Inbox</h1>
    </div>
    <div class="table-container">
      <div class="tabs">
        <a href="Support_admin.php?status=Pending" class="tab <?= $selectedStatus == 'Pending' ? 'active' : '' ?>">Pending</a>
        <a href="Support_admin.php?status=Resolved" class="tab <?= $selectedStatus == 'Resolved' ? 'active' : '' ?>">Resolved</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Topic</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include "../dbcon.php";  

          $query = "SELECT * FROM supportpage WHERE status = '$selectedStatus' ORDER BY DateSubmitted DESC LIMIT $start, $perPage";

          $result = $conn->query($query);

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
              echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
              echo "<td>" . htmlspecialchars($row['Topic']) . "</td>";
              echo "<td>" . htmlspecialchars($row['DateSubmitted']) . "</td>";
              echo "<td>" . htmlspecialchars($row['status']) . "</td>";
              echo "<td><button class='view-btn' data-id='" . htmlspecialchars($row['SupportID']) . "'>View</button></td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='6'>No support inquiries found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination Block: Right-aligned -->
    <?php
    $startItem = ($page - 1) * $perPage + 1;
    $endItem = min($startItem + $perPage - 1, $total_entries);
    $prevPage = $page > 1 ? $page - 1 : 1;
    $nextPage = $page < $total_pages ? $page + 1 : $total_pages;
    ?>
    <div class="pagination-container" style="display: flex; justify-content: flex-end; align-items: center; gap: 15px; margin-top: 20px; font-family: sans-serif; font-size: 14px; color: #444;">
      <span><?= "$startItem - $endItem of $total_entries" ?></span>
      <a href="Support_admin.php?status=<?= $selectedStatus ?>&page=<?= $prevPage ?>" style="font-size: 18px; text-decoration: none;">❮</a>
      <div style="display: flex; gap: 5px;">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <a href="Support_admin.php?status=<?= $selectedStatus ?>&page=<?= $i ?>" style="
            padding: 4px 10px;
            border-radius: 4px;
            text-decoration: none;
            background: <?= $i == $page ? '#0d6efd' : '#eee' ?>;
            color: <?= $i == $page ? '#fff' : '#000' ?>;
            font-weight: <?= $i == $page ? 'bold' : 'normal' ?>;
          ">
            <?= $i ?>
          </a>
        <?php endfor; ?>
      </div>
      <a href="Support_admin.php?status=<?= $selectedStatus ?>&page=<?= $nextPage ?>" style="font-size: 18px; text-decoration: none;">❯</a>
    </div>

    <!-- Modal -->
    <div id="inquiryModal" class="modal hidden">
      <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div class="modal-header">
          <h2>Inquiry Details</h2>
          <p>Date: <span id="inquiryDate"></span></p>
        </div>
        <div class="modal-body">
          <p><strong>Name:</strong> <span id="inquiryName"></span></p>
          <p><strong>Email:</strong> <span id="inquiryEmail"></span></p>
          <p><strong>Topic:</strong> <span id="inquiryTopic"></span></p>
          <p><strong>Message:</strong></p>
          <p id="inquiryMessage"></p>

          <form id="responseForm">
            <input type="hidden" id="supportId" name="supportId">
            <textarea id="adminResponse" name="adminResponse" placeholder="Type your response here..." required></textarea>
            <div class="modal-footer">
              <button type="button" class="cancel-btn">Cancel</button>
              <button type="submit" class="send-btn">Send Response</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const modal = document.getElementById('inquiryModal');
      const closeModalButton = document.querySelector('.close-btn');
      const responseForm = document.getElementById('responseForm');
      const supportIdInput = document.getElementById('supportId');
      const inquiryDate = document.getElementById('inquiryDate');
      const inquiryName = document.getElementById('inquiryName');
      const inquiryEmail = document.getElementById('inquiryEmail');
      const inquiryTopic = document.getElementById('inquiryTopic');
      const inquiryMessage = document.getElementById('inquiryMessage');

      document.addEventListener('click', function(event) {
        if (event.target.classList.contains('view-btn')) {
          const supportId = event.target.getAttribute('data-id');

          fetch(`fetch.php?id=${supportId}`)
            .then(response => {
              if (!response.ok) {
                throw new Error(`Server returned status ${response.status}`);
              }
              return response.json();
            })
            .then(data => {
              if (data.error) {
                alert(data.error);
                return;
              }

              inquiryDate.textContent = data.DateSubmitted || 'N/A';
              inquiryName.textContent = data.Name || 'N/A';
              inquiryEmail.textContent = data.Email || 'N/A';
              inquiryTopic.textContent = data.Topic || 'N/A';
              inquiryMessage.textContent = data.userMessage || 'No message provided';
              supportIdInput.value = supportId;

              if (data.status === "Resolved") {
                responseForm.innerHTML = `
                <input type="hidden" id="supportId" name="supportId" value="${supportId}">
                <p><strong>Admin Response:</strong> ${data.adminResponse || 'No response available'}</p>
                <div class="modal-footer">
                  <button type="button" class="cancel-btn">Close</button>
                </div>
              `;
              } else {
                responseForm.innerHTML = `
                <input type="hidden" id="supportId" name="supportId" value="${supportId}">
                <textarea id="adminResponse" name="adminResponse" placeholder="Type your response here..." required></textarea>
                <div class="modal-footer">
                  <button type="button" class="cancel-btn">Cancel</button>
                  <button type="submit" class="send-btn">Send Response</button>
                </div>
              `;
              }
              responseForm.querySelector('.cancel-btn')?.addEventListener('click', () => {
                modal.classList.add('hidden');
              });

              modal.classList.remove('hidden');
            })
            .catch(error => {
              console.error('Fetch error:', error);
              alert("An error occurred while fetching data.");
            });
        }
      });

      responseForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const supportId = responseForm.querySelector('#supportId')?.value;
        const adminResponse = responseForm.querySelector('#adminResponse')?.value;

        if (!adminResponse) {
          alert("Response is required.");
          return;
        }

        fetch('updatesupport.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `supportId=${supportId}&adminResponse=${encodeURIComponent(adminResponse)}`
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert("Response sent successfully!");
              modal.classList.add('hidden');
              location.reload();
            } else {
              alert(data.error || "Failed to send response.");
            }
          })
          .catch(error => {
            console.error('Submit error:', error);
            alert("An error occurred while sending the response.");
          });
      });

      closeModalButton.addEventListener('click', () => modal.classList.add('hidden'));
    });
  </script>

</body>

</html>