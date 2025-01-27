<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Profile</title>
  <link rel="stylesheet" href="Profile.css">
</head>
<body>
  <?php include "stud-sidebar.php"; ?>

  <main>
    <div class="container">
      <!-- Left Side -->
      <div class="layout-left">
        <!-- Profile Section -->
        <div class="section profile">
          <div style="position: relative;">
            <!-- Profile Picture -->
            <img src="images/Profile.png" alt="Profile Picture">
          </div>
          <!-- Profile Information -->
          <div class="profile-info">
            <h2>Giuliani Calais</h2>
          </div>
        </div>

        <!-- Upload Documents Section -->
        <div class="section upload-section">
          <h3>Upload Documents</h3>
          <button class="doc-button">
            Application Form
          </button>
          <button class="doc-button">
            Form 137
          </button>
          <button class="doc-button">
            Birth Certificate
          </button>
          <button class="doc-button">
            1x1 Picture
          </button>
          
          <!-- Black Submit Button -->
          <button class="submit-button">Submit</button>
        </div>
      </div>

      <!-- Right Side -->
      <div class="layout-right">
        <!-- Personal Information -->
        <div class="section">
          <h3>Personal Information</h3>
          <hr>
          <br>
          <div class="info-grid">
            <div><strong>Last Name:</strong> Calais</div>
            <div><strong>First Name:</strong> Giuliani</div>
            <div><strong>Middle Name:</strong> Dela Pena</div>
            <div><strong>Suffix:</strong> -</div>
            <div><strong>Username:</strong> Gil123</div>
            <div><strong>Birthdate:</strong> 09/04/2003</div>
            <div><strong>Place of Birth:</strong> Manila</div>
            <div><strong>Age:</strong> 21</div>
            <div><strong>Email:</strong> gil.calais.03@gmail.com</div>
            <div><strong>Phone:</strong> 09341658632</div>
          </div>
        </div>

        <!-- Emergency Information -->
        <div class="section">
          <h3>Emergency Information</h3>
          <div class="info-grid">
            <div><strong>Guardian Name:</strong> Melv Calais</div>
            <div><strong>Contact No:</strong> 09462137654</div>
            <div><strong>Relationship:</strong> Father</div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
