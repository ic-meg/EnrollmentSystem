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

if (isset($_POST["submitN"])) {
  $user_id = $_SESSION['user_id'];
  $firstName = $_POST["first-name"];
  $middleInitial = isset($_POST["middle-initial"]) ? $_POST["middle-initial"] : null;
  $lastName = $_POST["last-name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $dob = $_POST["dob"];
  $sex = $_POST["sex"];
  $lastSchool = $_POST["last-school"];
  $yearLeft = $_POST["year-left"];
  $intendedCourse = $_POST["intended-course"];
  $reason = $_POST["reason"];
  $startDate = $_POST["start-date"];
  $mode = $_POST["mode"];
  $yearLevel = $_POST["year-level"];

  $fullName = $firstName . " " . $lastName;
  $status = "Pending";
  $enrollmentType = "Nonsequential";

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

  $goodMoral = uploadFile("cert-moral", $uploadDir);
  $tor = uploadFile("tor", $uploadDir);


  if (!$tor || !$goodMoral) {
    echo "<script>alert('File upload failed. Please upload valid files (JPG, PNG, PDF, Max 5MB).');</script>";
  } else {
    $conn->begin_transaction();

    try {
      $stmt1 = $conn->prepare("INSERT INTO nonsequential (user_id, FirstName, MiddleInitial, LastName, Email, PhoneNum, DateOfBirth, Sex, LastAttendedSchool, YearGraduatedLeft, IntendedCourse, ReasonForApplication, PreferredStartDate, ModeOfStudy, GoodMoral, TOR, yearLevel) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

      if (!$stmt1) {
        die("SQL Error (returnee): " . $conn->error);
      }

      $stmt1->bind_param(
        "issssssssssssssss",
        $user_id,
        $firstName,
        $middleInitial,
        $lastName,
        $email,
        $phone,
        $dob,
        $sex,
        $lastSchool,
        $yearLeft,
        $intendedCourse,
        $reason,
        $startDate,
        $mode,
        $goodMoral,
        $tor,
        $yearLevel
      );

      $documents_uploaded = ($tor ? 1 : 0) + ($goodMoral ? 1 : 0);

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
          $intendedCourse,
          $documents_uploaded
        );

        if ($stmt2->execute()) {
          $conn->commit();
          header("Location: studConfirmApplication.php");
          exit;
        } else {
          throw new Exception("Failed to insert into enrollee table.");
        }
        $stmt2->close();
      } else {
        throw new Exception("Failed to insert into nonsequential table: " . $stmt1->error);
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            <a href="enrollment-regular.php">
              <p>Freshmen</p>
            </a>
            <a href="transferee.php">
              <p>Transferee</p>
            </a>
            <a href="returnee.php">
              <p>Returnee</p>
            </a>
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
          <form method="POST" enctype="multipart/form-data">
            <div class="form-section">
              <!-- Name Section -->
              <div class="form-row">
                <div class="form-group">
                  <label for="first-name">*First Name</label>
                  <input type="text" id="first-name" name="first-name" placeholder="Enter your first name" value="<?= isset($profile['first_name']) ? htmlspecialchars($profile['first_name']) : '' ?>" readonly required>
                </div>
                <div class="form-group">
                  <label for="middle-initial">Middle Initial</label>
                  <input type="text" id="middle-initial" name="middle-initial" placeholder="M.I.">
                </div>
                <div class="form-group">
                  <label for="last-name">*Last Name</label>
                  <input type="text" id="last-name" name="last-name" placeholder="Enter your last name" value="<?= isset($profile['first_name']) ? htmlspecialchars($profile['last_name']) : '' ?>" readonly required>
                </div>
              </div>

              <!-- Contact Information -->
              <div class="form-row">
                <div class="form-group">
                  <label for="email">*Email Address</label>
                  <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" readonly required>
                </div>
                <div class="form-group">
                  <label for="phone">*Phone Number</label>
                  <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" value="<?= isset($profile['phone']) ? htmlspecialchars($profile['phone']) : '' ?>"
                    maxlength="11" readonly required>


                </div>
              </div>

              <!-- Additional Details -->
              <div class="form-row">
                <div class="form-group">
                  <label for="dob">*Date of Birth</label>
                  <input type="date" id="dob" name="dob" value="<?= isset($profile['birthdate']) ? htmlspecialchars($profile['birthdate']) : '' ?>" readonly required>
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

              <!-- Academic Background -->
              <div class="form-row">
                <div class="form-group">
                  <label for="last-school">*Last Attended School</label>
                  <input type="text" id="last-school" name="last-school" placeholder="Enter school name" required>
                </div>
                <div class="form-group">
                  <label for="year-left">*Year Last Enrolled</label>
                  <input
                    type="text"
                    id="year-left"
                    name="year-left"
                    placeholder="e.g., 2022"
                    pattern="\d{4}"
                    title="Please enter a 4-digit year (e.g., 2022)"
                    maxlength="4"
                    required>
                </div>
              </div>

              <!-- Course Details -->
              <div class="form-row">
                <div class="form-group">
                  <label for="intended-course">*Intended Course</label>
                  <select id="intended-course" name="intended-course">
                    <option value="" disabled selected hidden>Select a program</option>
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
                  <label for="reason">*Reason for Application</label>
                  <textarea id="reason" name="reason" placeholder="State your reason" rows="4" required></textarea>
                </div>
              </div>

              <!-- Preferences -->
              <div class="form-row">
                <div class="form-group">
                  <label for="preferred-start-date">*Preferred Start</label>
                  <select id="preferred-start-date" name="start-date" required>
                    <option value="" disabled selected hidden>Select preferred start date</option>
                    <option value="1st Semester AY 2025-2026">1st Semester AY 2025–2026</option>
                    <option value="Summer Term AY 2025-2026">Summer Term AY 2025–2026</option>
                  </select>

                </div>
                <div class="form-group">
                  <label for="mode-of-study">*Mode of Study</label>
                  <select id="mode-of-study" name="mode" required>
                    <option value="" disabled selected hidden>Select</option>
                    <option value="online">Online</option>
                    <option value="on-campus">On-Campus</option>
                  </select>
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
              <!-- Required Documents -->
              <div class="form-row">
                <div class="form-group">
                  <label for="cert-moral">*Certificate of Good Moral</label>
                  <input type="file" id="cert-moral" name="cert-moral" accept=".jpg,.jpeg,.png,.pdf" required>
                  <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                  <div id="preview-cert-moral"></div>
                </div>
                <div class="form-group">
                  <label for="other-docs">*Transcript of Records (TOR)</label>
                  <input type="file" id="tor" name="tor" accept=".jpg,.jpeg,.png,.pdf" required>
                  <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                  <div id="preview-tor"></div>
                </div>
              </div>


              <div class="form-actions">
                <button type="submit" class="button-submit" name="submitN">Submit</button>
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
  setupFilePreview("cert-moral");
</script>

</html>