<?php
error_reporting(E_ALL & ~E_NOTICE);
include "../dbcon.php";
include "sessioncheck.php";

$user_id = $_SESSION['user_id'];

$profile = null;

$stmt1 = $conn->prepare("SELECT * FROM studentprofile WHERE user_id = ?");
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
$result1 = $stmt1->get_result();

if ($result1 && $result1->num_rows > 0) {
  $profile = $result1->fetch_assoc();
}
$stmt1->close();

$email = null;
$stmt2 = $conn->prepare("SELECT email FROM useraccount WHERE user_id = ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

if ($result2 && $result2->num_rows > 0) {
  $email = $result2->fetch_assoc()['email'];
}
$stmt2->close();

if (isset($_POST["submitRet"])) {
  $user_id = $_SESSION['user_id'];
  $firstName = $_POST["first-name"];
  $middleInitial = isset($_POST["middle-initial"]) ? $_POST["middle-initial"] : null;
  $lastName = $_POST["last-name"];
  $dob = $_POST["dob"];
  $sex = $_POST["sex"];
  $lastEnrollment = $_POST["last-enrollment"];
  $reason = $_POST["reason"];
  $prevCourse = $_POST["prev-course"];
  $expectedGrad = isset($_POST["expected-graduation"]) ? $_POST["expected-graduation"] : null;
  $yearLevel = $_POST["year-level"];

  $fullName = $firstName . " " . $lastName;
  $status = "Pending";
  $enrollmentType = "Returnee";

  // File Upload Directory
  $uploadDir = "uploads/";
  if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
  }

  // Function to handle file uploads
  function uploadFile($fileInput, $uploadDir)
  {
    if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]["error"] == UPLOAD_ERR_NO_FILE) {
      return null;
    }

    $fileName = $_FILES[$fileInput]["name"];
    $fileTmp = $_FILES[$fileInput]["tmp_name"];
    $fileSize = $_FILES[$fileInput]["size"];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedTypes = ["jpg", "jpeg", "png", "pdf"];
    if (!in_array($fileExt, $allowedTypes) || $fileSize > 5 * 1024 * 1024) {
      return null;
    }

    $newFileName = uniqid() . "-" . basename($fileName);
    $targetFilePath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmp, $targetFilePath)) {
      return $newFileName;
    }
    return null;
  }

  // Upload required documents
  $tor = uploadFile("tor", $uploadDir);
  $clearance = uploadFile("clearance", $uploadDir);
  $idPhoto = uploadFile("id-photo", $uploadDir);


  if (!$tor || !$clearance || !$idPhoto) {
    echo "<script>alert('File upload failed. Please upload valid files (JPG, PNG, PDF, Max 5MB).');</script>";
  } else {
    $conn->begin_transaction();

    try {
      $stmt1 = $conn->prepare("INSERT INTO returnee (user_id, FirstName, MiddleInitial, LastName, DateOfBirth, Sex, LastEnrollmentDate, ReasonForReturning, PreviousProgram, ExpectedGraduationDate, TOR, MedCert, IDPhoto, yearLevel) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

      if (!$stmt1) {
        die("SQL Error (returnee): " . $conn->error);
      }

      $stmt1->bind_param(
        "isssssssssssss",
        $user_id,
        $firstName,
        $middleInitial,
        $lastName,
        $dob,
        $sex,
        $lastEnrollment,
        $reason,
        $prevCourse,
        $expectedGrad,
        $tor,
        $clearance,
        $idPhoto,
        $yearLevel
      );

      $documents_uploaded = ($tor ? 1 : 0) + ($clearance ? 1 : 0) + ($idPhoto ? 1 : 0);

      if ($stmt1->execute()) {
        $stmt2 = $conn->prepare("INSERT INTO enrollee (user_id, name, Status, enrollment_type, program, documents_uploaded) 
                    VALUES (?, ?, ?, ?, ?, ?)");

        if (!$stmt2) {
          die("SQL Error (enrollee): " . $conn->error);
        }

        $stmt2->bind_param(
          "issssi",
          $user_id,
          $fullName,
          $status,
          $enrollmentType,
          $prevCourse,
          $documents_uploaded
        );

        if ($stmt2->execute()) {
          $conn->commit();
          echo "
          <div class='toast-container position-fixed top-0 end-0 p-3' style='z-index: 9999;'>
            <div id='successToast' class='toast align-items-center text-white bg-success border-0 show' role='alert' aria-live='assertive' aria-atomic='true'>
              <div class='d-flex'>
                <div class='toast-body'>
                  Your application has been successfully submitted. Please wait for further updates.
                </div>
                <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
              </div>
            </div>
          </div>

          <script>
            setTimeout(() => {
              const toast = document.getElementById('successToast');
              if (toast) {
                var toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
                toastBootstrap.show();
              }
              setTimeout(() => {
                window.location.href = 'studConfirmApplication.php';
              }, 3000);
            }, 300);
          </script>
          ";
        } else {
          throw new Exception("Failed to insert into enrollee table.");
        }
        $stmt2->close();
      } else {
        throw new Exception("Failed to insert into returnee table: " . $stmt1->error);
      }

      $stmt1->close();
    } catch (Exception $e) {
      $conn->rollback();
      echo "<script>alert('Database Error: " . $e->getMessage() . "');</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="enrollment-regular.css">
  <title>Oxford Academe | Enrollment Form - Returnee</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
            <a href="enrollment-regular.php">
              <p>Freshmen</p>
            </a>
            <a href="transferee.php">
              <p>Transferee</p>
            </a>
            <p class="<?= basename($_SERVER['PHP_SELF']) == 'returnee.php' ? 'active' : '' ?>">Returnee</p>
            <a href="non-sequential.php">
              <p>Non-sequential </p>
            </a>
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
          <form method="POST" enctype="multipart/form-data">
            <div class=" form-section">
              <!-- Name Section -->
              <div class="form-row">
                <div class="form-group">
                  <label for="first-name">*First Name</label>
                  <input type="text" id="first-name" name="first-name" placeholder="Enter your first name" value="<?= isset($profile['first_name']) ? htmlspecialchars($profile['first_name']) : '' ?>" required readonly>
                </div>
                <div class="form-group">
                  <label for="middle-initial">Middle Initial</label>
                  <input type="text" id="middle-initial" name="middle-initial" placeholder="M.I.">
                </div>
                <div class="form-group">
                  <label for="last-name">*Last Name</label>
                  <input type="text" id="last-name" name="last-name" placeholder="Enter your last name" value="<?= isset($profile['first_name']) ? htmlspecialchars($profile['last_name']) : '' ?>" required readonly>
                </div>
              </div>

              <!-- Additional Details -->
              <div class="form-row">
                <div class="form-group">
                  <label for="dob">*Date of Birth</label>
                  <input type="date" id="dob" name="dob" value="<?= isset($profile['birthdate']) ? htmlspecialchars($profile['birthdate']) : '' ?>" required readonly>
                </div>
                <div class="form-group">
                  <label for="sex">*Sex</label>
                  <select id="sex" name="sex" required>
                    <option value="" disabled selected hidden>Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>
              </div>

              <!-- Return Details -->
              <div class="form-row">
                <div class="form-group">
                  <label for="last-enrollment">*Last Enrollment Date</label>
                  <input type="date" id="last-enrollment" name="last-enrollment" required >
                </div>
                <div class="form-group">
                  <label for="reason">*Reason for Returning</label>
                  <textarea id="reason" name="reason" placeholder="State your reason for returning" rows="4" required></textarea>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="year-level">*What year level are you applying for?</label>
                  <select id="year-level" name="year-level" required>
                    <option value="" disabled selected hidden>Select year level</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd Year</option>
                    <option value="4th Year">4th Year</option>
                  </select>
                </div>
              </div>
              <!-- Additional Fields -->
              <div class="form-row">
                <div class="form-group">
                  <label for="prev-course">*Previous Course/Program</label>
                  <select id="program" name="prev-course">
                    <option value="" disabled selected hidden>Select your previous program</option>
                    <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                    <option value="Bachelor of Science in Psychology">Bachelor of Science in Psychology</option>
                    <option value="Bachelor of Science in Education">Bachelor of Science in Education</option>
                    <option value="Bachelor of Science in Human Resource">Bachelor of Science in Human Resource</option>
                    <option value="Bachelor of Science in Nursing">Bachelor of Science in Nursing</option>
                    <option value="Bachelor of Science in Law">Bachelor of Science in Law</option>
                    <option value="Bachelor of Science in Criminology">Bachelor of Science in Criminology</option>
                    <option value="Bachelor of Science in Nursing">Bachelor of Science in Tourism</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="expected-graduation">Expected Graduation Date</label>
                  <input type="date" id="expected-graduation" name="expected-graduation">
                </div>
              </div>

              <!-- Required Documents -->
              <div class="form-row">
                <div class="form-group">
                  <label for="transcript">*Transcript of Records</label>
                  <input type="file" id="tor" name="tor" accept=".jpg,.jpeg,.png,.pdf" required>
                  <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                  <div id="preview-tor"></div>
                </div>
                <div class="form-group">
                  <label for="clearance">*Updated Medical Certificate</label>
                  <input type="file" id="clearance" name="clearance" accept=".jpg,.jpeg,.png,.pdf" required>
                  <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                  <div id="preview-clearance"></div>
                </div>
                <div class="form-group">
                  <label for="id-photo">*ID Photo</label>
                  <input type="file" id="id-photo" name="id-photo" accept=".jpg,.jpeg,.png,.pdf" required>
                  <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                  <div id="preview-id-photo"></div>
                </div>
              </div>


              <!-- Submit Section -->
              <div class="form-actions">
                <button type="submit" class="button-submit" name="submitRet">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
  <div id="file-preview-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background-color:rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:10000;">
    <div style="max-width:90%; max-height:90%; position:relative;">
      <span onclick="closePreview()" style="position:absolute; top:-30px; right:0; color:white; font-size:24px; cursor:pointer;">&times;</span>
      <div id="file-preview-content"></div>
    </div>
  </div>
</body>
<script>
  function setupFilePreview(inputId) {
    const input = document.getElementById(inputId);
    const previewContainer = document.getElementById("preview-" + inputId);

    input.addEventListener("change", function() {
      const file = this.files[0];
      if (!file) return;

      const fileType = file.type;
      const fileSizeMB = file.size / (1024 * 1024);

      previewContainer.innerHTML = "";

      if (fileSizeMB > 5) {
        previewContainer.innerHTML = "<p style='color:red;'>File exceeds 5MB limit.</p>";
        return;
      }

      const link = document.createElement("a");
      link.href = "#";
      link.textContent = file.name;
      link.style.color = "#007bff";
      link.style.textDecoration = "underline";
      link.onclick = function(e) {
        e.preventDefault();
        showFilePreview(file);
      };

      previewContainer.appendChild(link);
    });
  }

  function showFilePreview(file) {
    const modal = document.getElementById("file-preview-modal");
    const content = document.getElementById("file-preview-content");
    content.innerHTML = "";

    if (file.type.startsWith("image/")) {
      const img = document.createElement("img");
      img.src = URL.createObjectURL(file);
      img.style.maxWidth = "100%";
      img.style.maxHeight = "80vh";
      content.appendChild(img);
    } else if (file.type === "application/pdf") {
      const iframe = document.createElement("iframe");
      iframe.src = URL.createObjectURL(file);
      iframe.style.width = "80vw";
      iframe.style.height = "80vh";
      iframe.style.border = "none";
      content.appendChild(iframe);
    } else {
      content.innerHTML = "<p style='color:white;'>Unsupported file type.</p>";
    }

    modal.style.display = "flex";
  }

  function closePreview() {
    document.getElementById("file-preview-modal").style.display = "none";
  }

  setupFilePreview("tor");
  setupFilePreview("clearance");
  setupFilePreview("id-photo");
</script>

</html>