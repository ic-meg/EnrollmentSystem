<?php 

include "session_check.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Support Inbox</title>
  <link rel="stylesheet" href="Support_admin.css">
  <style>
    .hidden {
      display: none;
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
        

          $query = "SELECT * FROM supportpage";
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
              <button type="submit" class="send-btn" >Send Response</button>
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

  document.addEventListener('click', function (event) {
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

          // Fill modal fields
          inquiryDate.textContent = data.DateSubmitted || 'N/A';
          inquiryName.textContent = data.Name || 'N/A';
          inquiryEmail.textContent = data.Email || 'N/A';
          inquiryTopic.textContent = data.Topic || 'N/A';
          inquiryMessage.textContent = data.userMessage || 'No message provided';
          supportIdInput.value = supportId;

          // Render the form or the admin response
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

          // Rebind cancel button after innerHTML is reset
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

  // Handle submit
  responseForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const supportId = responseForm.querySelector('#supportId')?.value;
    const adminResponse = responseForm.querySelector('#adminResponse')?.value;

    if (!adminResponse) {
      alert("Response is required.");
      return;
    }

    fetch('updatesupport.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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

  // Close modal with ✕
  closeModalButton.addEventListener('click', () => modal.classList.add('hidden'));
});
</script>

</body>
</html>
