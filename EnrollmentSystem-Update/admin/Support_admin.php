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
  <!-- Include any font/icon library if needed -->
</head>
<body>
  <?php include "admin-sidebar.php"; ?>
  <main> 
  </div>
  </div> 

  <br><br>
  <main class="main-content">
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
          <tr>
            <td>Giuliani Calais</td>
            <td>giulianicalais@example.com</td>
            <td>Application Inquiry</td>
            <td>2024-11-18</td>
      
            <td>Pending</td>
            <td><button class="view-btn">View</button></td>
          </tr>
          <tr>
            <td>Meg Fabian</td>
            <td>megfabian@example.com</td>
            <td>Admissions Requirements</td>
            <td>2024-11-18</td>
        
            <td>Resolved</td>
            <td><button class="view-btn">View</button></td>
          </tr>
          <tr>
            <td>Shanley Galo</td>
            <td>leygalo@example.com</td>
            <td>Program Information</td>
            <td>2024-11-18</td>
   
            <td>Resolved</td>
            <td><button class="view-btn">View</button></td>
          </tr>
          <tr>
            <td>Kate Serrano</td>
            <td>kateserrano@example.com</td>
            <td>Technical Support</td>
            <td>2024-11-18</td>
         
            <td>In Progress</td>
            <td><button class="view-btn">View</button></td>
          </tr>
          <tr>
            <td>Pam Murillo</td>
            <td>pammurillo@example.com</td>
            <td>Application Inquiry</td>
            <td>2024-11-18</td>
        
            <td>In Progress</td>
            <td><button class="view-btn">View</button></td>
          </tr>
        </tbody>
      </table>

      <!-- Modal -->
<div id="inquiryModal" class="modal hidden">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <div class="modal-header">
      <h2>Inquiry Details</h2>
      <p>Date: <span id="inquiryDate">2024-11-18</span></p>
    </div>
    <div class="modal-body">
      <p><strong>Name:</strong> <span id="inquiryName">Giuliani Calais</span></p>
      <p><strong>Email:</strong> <span id="inquiryEmail">giulianicalais@example.com</span></p>
      <p><strong>Priority:</strong> <span id="inquiryPriority">High</span></p>
      <p><strong>Topic:</strong> <span id="inquiryTopic">Application Inquiry</span></p>
      <p><strong>Message:</strong></p>
      <p id="inquiryMessage">
        Hello, I recently submitted my application for admission to Oxford Academe and would like to confirm if it has been received. Could you also let me know the next steps in the process? Thank you for your assistance.
      </p>
      <textarea placeholder="Type your response here..."></textarea>
    </div>
    <div class="modal-footer">
      <button class="cancel-btn">Cancel</button>
      <button class="send-btn">Send Response</button>
    </div>
  </div>
</div>

    </div>
  </main>

  <script>
  const modal = document.getElementById('inquiryModal');
  const viewButtons = document.querySelectorAll('.view-btn');
  const closeModalButton = document.querySelector('.close-btn');
  const cancelBtn = document.querySelector('.cancel-btn');

  // Show Modal
  viewButtons.forEach((btn) => {
    btn.addEventListener('click', () => {
      modal.classList.remove('hidden');
    });
  });

  // Close Modal
  const closeModal = () => {
    modal.classList.add('hidden');
  };

  closeModalButton.addEventListener('click', closeModal);
  cancelBtn.addEventListener('click', closeModal);

  // Close modal when clicking outside content
  window.addEventListener('click', (event) => {
    if (event.target === modal) {
      closeModal();
    }
  });
</script>

</body>
</html>