<?php
  include "../dbcon.php";
  include "sessioncheck.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="enrollment-regular.css">
  <title>Oxford Academe | Enrollment Form - Returnee</title>
</head>
<style>
  
</style>
<body>
  <?php include "stud-sidebar.php"; ?>

  <main>
    <div class="container">
      <div class="header">
        <h1>Student Enrollment</h1>
      </div>

      <div class="content-wrapper">
        <!-- Sidebar -->
        <div class="side--container">
          <div class="regular">
            <a href="enrollment-regular.php"><p>Freshmen</p></a>
            <a href="transferee.php"><p>Transferee</p></a>
            <p class="<?= basename($_SERVER['PHP_SELF']) == 'returnee.php' ? 'active' : '' ?>">Returnee</p>
            <a href="non-sequential.php"><p>Non-sequential </p></a>
          </div>
        </div>

        <!-- Returnee Form -->
        <div class="Form-regular">
          <p class="description">Returnee Application</p>
          <p class="description--1">
            Please complete the application form below to apply as a returnee student. Ensure that you attach all required documents.
          </p>
          <p class="description--1" style="color: #888; font-size: 13px; margin-bottom: 25px;">
            <strong style="color: red;">*</strong> indicates required fields.
          </p>
          <form>
            <div class="form-section">
              <!-- Name Section -->
              <div class="form-row">
                <div class="form-group">
                  <label for="first-name">First Name</label>
                  <input type="text" id="first-name" name="first-name" placeholder="Enter your first name">
                </div>
                <div class="form-group">
                  <label for="middle-initial">Middle Initial</label> 
                  <input type="text" id="middle-initial" name="middle-initial" placeholder="M.I.">
                </div>
                <div class="form-group">
                  <label for="last-name">Last Name</label>
                  <input type="text" id="last-name" name="last-name" placeholder="Enter your last name">
                </div>
              </div>

              <!-- Additional Details -->
              <div class="form-row">
                <div class="form-group">
                  <label for="dob">Date of Birth</label>
                  <input type="date" id="dob" name="dob">
                </div>
                <div class="form-group">
                  <label for="sex">Sex</label>
                  <select id="sex" name="sex">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>
              </div>

              <!-- Return Details -->
              <div class="form-row">
                <div class="form-group">
                  <label for="last-enrollment">Last Enrollment Date</label>
                  <input type="date" id="last-enrollment" name="last-enrollment">
                </div>
                <div class="form-group">
                  <label for="reason">Reason for Returning</label>
                  <textarea id="reason" name="reason" placeholder="State your reason for returning" rows="4"></textarea>
                </div>
              </div>

              <!-- Additional Fields -->
              <div class="form-row">
                <div class="form-group">
                  <label for="prev-course">Previous Course/Program</label>
                  <input type="text" id="prev-course" name="prev-course" placeholder="Enter your previous course or program">
                </div>
                <div class="form-group">
                  <label for="expected-graduation">Expected Graduation Date</label>
                  <input type="date" id="expected-graduation" name="expected-graduation">
                </div>
              </div>
              
              <!-- Required Documents -->
              <div class="form-row">
                <div class="form-group">
                  <label for="transcript">Transcript of Records</label>
                  <input type="file" id="transcript" name="transcript">
                  <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                </div>
                <div class="form-group">
                  <label for="clearance">Updated Medical Certificate</label>
                  <input type="file" id="clearance" name="clearance">
                  <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                </div>
                <div class="form-group">
                  <label for="id-photo">ID Photo</label>
                  <input type="file" id="id-photo" name="id-photo">
                  <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                </div>
              </div>


              <!-- Submit Section -->
              <div class="form-actions">
                <button type="submit">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
