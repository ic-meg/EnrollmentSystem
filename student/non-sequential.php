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
  <title>Oxford Academe | Enrollment Form - Non-Sequential</title>
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
            <a href="returnee.php"><p>Returnee</p></a>
            <p class="<?= basename($_SERVER['PHP_SELF']) == 'non-sequential.php' ? 'active' : '' ?>">Non-Sequential</p>
          </div>
        </div>

        <!-- Non-Sequential Form -->
        <div class="Form-regular">
          <p class="description">Non-Sequential Application</p>
          <p class="description--1">
            Please complete the application form below to apply as a non-sequential student at our institution. Ensure that you attach all required documents.
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

              <!-- Contact Information -->
              <div class="form-row">
                <div class="form-group">
                  <label for="email">Email Address</label>
                  <input type="email" id="email" name="email" placeholder="Enter your email">
                </div>
                <div class="form-group">
                  <label for="phone">Phone Number</label>
                  <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
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

              <!-- Academic Background -->
              <div class="form-row">
                <div class="form-group">
                  <label for="last-school">Last Attended School</label>
                  <input type="text" id="last-school" name="last-school" placeholder="Enter school name">
                </div>
                <div class="form-group">
                  <label for="year-graduated">Year Graduated/Left</label>
                  <input type="text" id="year-graduated" name="year-graduated" placeholder="Enter year">
                </div>
              </div>

              <!-- Course Details -->
              <div class="form-row">
                <div class="form-group">
                  <label for="intended-course">Intended Course</label>
                  <select id="intended-course" name="intended-course">
                    <option value="">Enter your course</option>
                    <option value="course1">Information Technology</option>
                    <option value="course2">Psychology</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="reason">Reason for Application</label>
                  <textarea id="reason" name="reason" placeholder="State your reason" rows="4"></textarea>
                </div>
              </div>

              <!-- Preferences -->
              <div class="form-row">
                <div class="form-group">
                  <label for="preferred-start-date">Preferred Start Date</label>
                  <input type="date" id="preferred-start-date" name="preferred-start-date">
                </div>
                <div class="form-group">
                  <label for="mode-of-study">Mode of Study</label>
                  <select id="mode-of-study" name="mode-of-study">
                    <option value="">Select</option>
                    <option value="online">Online</option>
                    <option value="on-campus">On-Campus</option>
                  </select>
                </div>
              </div>

              <!-- Required Documents -->
              <div class="form-row">
                <div class="form-group">
                  <label for="cert-moral">*Certificate of Good Moral</label>
                  <input type="file" id="cert-moral" name="cert-moral" required>
                  <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                </div>
                <div class="form-group">
                  <label for="other-docs">*Transcript of Records (TOR)</label>
                  <input type="file" id="other-docs" name="other-docs" required>
                  <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                </div>
              </div>


              <div class="form-actions">
                <button type="submit" class="button-submit">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
