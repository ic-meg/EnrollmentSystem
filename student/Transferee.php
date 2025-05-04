<?php
include "../dbcon.php";
include "sessioncheck.php";

if (isset($_POST["submitReg"])) {
    $user_id = $_SESSION['user_id']; 
    $firstName = $_POST["first-name"];
    $middleInitial = isset($_POST["middle-initial"]) ? $_POST["middle-initial"] : null;
    $lastName = $_POST["last-name"];
    $dob = $_POST["dob"];
    $sex = $_POST["sex"];
    $phone = $_POST["contact-number"];
    $email = $_POST["email"];
    $prevSchool = $_POST["prev-school"];
    $prevProgram = $_POST["prev-program"];
    $intendedCourse = $_POST["intended-course"];
    $guardianName = $_POST["guardian-name"];
    $guardianContact = $_POST["guardian-contact"];

    $fullName = $firstName . " " . $lastName;
    $status = "Pending";  
    $enrollmentType = "Transferee";  

    // File Upload Directory
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Function to handle file uploads
    function uploadFile($fileInput, $uploadDir) {
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
    $goodMoral = uploadFile("good-moral", $uploadDir);

    if (!$tor || !$goodMoral) {
        echo "<script>alert('File upload failed. Please upload valid files (JPG, PNG, PDF, Max 5MB).');</script>";
    } else {
        $conn->begin_transaction();

        try {
            // Insert into transferee table
            $stmt1 = $conn->prepare("INSERT INTO transferee (user_id, FirstName, MiddleInitial, LastName, DateOfBirth, Sex, ContactNum, Email, PreviousSchool, PreviousProgram, IntendedCourse, GuardiansName, GuardiansContact, TOR, GoodMoral) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            if (!$stmt1) {
                die("SQL Error (transferee): " . $conn->error); // Print MySQL error
            }
            

            $stmt1->bind_param("issssssssssssss", 
                $user_id, 
                $firstName, 
                $middleInitial, 
                $lastName, 
                $dob, 
                $sex, 
                $phone, 
                $email, 
                $prevSchool, 
                $prevProgram, 
                $intendedCourse, 
                $guardianName, 
                $guardianContact, 
                $tor, 
                $goodMoral
            );

            $documents_uploaded = 0;
            if ($tor) $documents_uploaded++;
            if ($goodMoral) $documents_uploaded++;

            if ($stmt1->execute()) {
                // Insert into enrollee table
                $stmt2 = $conn->prepare("INSERT INTO enrollee (user_id, name, Status, enrollment_type, program, documents_uploaded) 
                VALUES (?, ?, ?, ?, ?, ?)");
                
                if (!$stmt2) {
                    die("SQL Error (enrollee): " . $conn->error); // Print MySQL error
                }
                
                $stmt2->bind_param("issssi", 
                    $user_id, 
                    $fullName, 
                    $status, 
                    $enrollmentType, 
                    $intendedCourse, 
                    $documents_uploaded
                );

                if ($stmt2->execute()) {
                    $conn->commit();
                    echo "<script>alert('Your application has been successfully submitted. Please wait for further updates.'); window.location.href='studConfirmApplication.php';</script>";
                } else {
                    throw new Exception("Failed to insert into enrollee table.");
                }
                $stmt2->close();
            } else {
                throw new Exception("Failed to insert into transferee table.");
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
  <title>Oxford Academe | Enrollment Form - Transferee</title>
</head>
<style>
  :root {
    --color: #000;
    --background: #2DB2FF;
    --txt-color: #B6B1B1;
    --secondary-color: white;
    --line-color:#777777;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box; 
    font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .content-wrapper {
    display: flex; /* Align sidebar and form horizontally */
    justify-content: space-between; /* Distribute space evenly */
  }

  .header {
    text-align: center;
    padding: 20px;
  }

  .side--container {
    background: #DADADA;
    display: flex;
    flex-direction: column;
    width: 20%;
    margin-top: 50px;
    padding-left: 20px;
  }

  .side--container .regular p {
    margin: 10px 10px;
    padding: 10px;
    background: var(--secondary-color);
    color: var(--color);
    text-align: center;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .side--container .regular p:hover {
    background: var(--line-color);
    color: var(--secondary-color);
  }

  .Form-regular {
    margin-top: 50px;
    flex: 2;
    padding: 20px;
    background-color: var(--secondary-color);
    border-radius: 8px;
    overflow-y: auto;
  }

  .form-row {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
  }

  .form-group {
    flex: 1;
    min-width: 200px;
  }

  input, select, textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--line-color);
    border-radius: 4px;
    margin-bottom: 10px;
  }

  button {    
    padding: 10px 20px;
    background: var(--background);
    color: var(--secondary-color);
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }

  button:hover {
    background: #005a9e;
  }

  @media (max-width: 768px) {
    .content-wrapper {
        flex-direction: column;
    }

    .side--container {
        width: 100%;
    }

    .Form-regular {
        width: 100%;
    }
  }
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
            <a href="non-sequential.php"><p>Non-sequential Students</p></a>
          </div>
        </div>

        <!-- Transferee Form -->
        <div class="Form-regular">
          <p class="description">Transferee Application</p>
          <p class="description--1">
            Please complete the application form below to apply as a transferee at our institution. Ensure that you attach all required documents.
          </p>

          <form method="POST" action="Transferee.php" enctype="multipart/form-data">

            <div class="form-section">
              <!-- Name Section -->
              <div class="form-row">
                <div class="form-group">
                  <label for="first-name">*First Name</label>
                  <input type="text" id="first-name" name="first-name" placeholder="Enter your first name" required>
                </div>
                <div class="form-group">
                  <label for="middle-initial">Middle Initial</label> 
                  <input type="text" id="middle-initial" name="middle-initial" placeholder="M.I.">
                </div>
                <div class="form-group">
                  <label for="last-name">*Last Name</label>
                  <input type="text" id="last-name" name="last-name" placeholder="Enter your last name" required>
                </div>
              </div>

              <!-- Contact Details -->
              <div class="form-row">
                <div class="form-group">
                <label for="contact-number">*Contact Number</label>
                <input type="text" id="contact-number" name="contact-number" placeholder="Enter your contact number" maxlength="11" required />

                <script>
                  document.getElementById("contact-number").addEventListener("input", function (e) {
                      this.value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
                      if (this.value.length > 11) {
                          this.value = this.value.slice(0, 11); 
                      }
                  });
                </script>

                </div>
                <div class="form-group">
                  <label for="email">*Email Address</label>
                  <input type="email" id="email" name="email" placeholder="Enter your email address" required>
                </div>
              </div>

              <!-- Additional Details -->
              <div class="form-row">
                <div class="form-group">
                  <label for="dob">*Date of Birth</label>
                  <input type="date" id="dob" name="dob" required>
                </div>
                <div class="form-group">
                  <label for="sex">*Sex</label>
                  <select id="sex" name="sex" required>
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                  </select>
                </div>
              </div>

              <!-- Previous School Section -->
              <div class="form-row">
                <div class="form-group">
                  <label for="prev-school">*Previous School</label>
                  <input type="text" id="prev-school" name="prev-school" placeholder="Enter your previous school" required>
                </div>
                <div class="form-group">
                  <label for="prev-program">*Previous Program</label>
                  <input type="text" id="prev-program" name="prev-program" placeholder="Enter your previous program" required>
                </div>
              </div>

              <!-- Academic Preferences -->
              <div class="form-row">
                <div class="form-group">
                  <label for="intended-course">*Intended Course</label>
                  <select id="intended-course" name="intended-course" required>
                  <option value="">Select your Intended Course</option>
                                      <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                                      <option value="Bachelor of Science in Information Systems">Bachelor of Science in Information Systems</option>
                                      <option value="Bachelor of Science in Computer Science">Bachelor of Science in Computer Science</option>
                                      <option value="Bachelor of Science in Business Administration">Bachelor of Science in Business Administration</option>
                                      <option value="Bachelor of Science in Accountancy">Bachelor of Science in Accountancy</option>
                                      <option value="Bachelor of Secondary Education">Bachelor of Secondary Education</option>
                                      <option value="Bachelor of Elementary Education">Bachelor of Elementary Education</option>
                                      <option value="Bachelor of Science in Nursing">Bachelor of Science in Nursing</option>
                                      <option value="Bachelor of Science in Civil Engineering">Bachelor of Science in Civil Engineering</option>
                                    <option option value="Bachelor of Science in Electrical Engineering">Bachelor of Science in Electrical Engineering</option>
                                    <option value="Bachelor of Science in Management">Bachelor of Science in Management</option>
                                    <option value="Bachelor of Science in Psychology">Bachelor of Science in Psychology</option>
                  </select>
                </div>
              </div>

              <!-- Guardian Information -->
              <div class="form-row">
                <div class="form-group">
                  <label for="guardian-name">*Guardian's Name</label>
                  <input type="text" id="guardian-name" name="guardian-name" placeholder="Enter guardian's name" required>
                </div>
                <div class="form-group">
                <label for="guardian-contact">*Guardian's Contact</label>
                <input type="tel" id="guardian-contact" name="guardian-contact" placeholder="Enter guardian's contact number" maxlength="11" required />

                <script>
                  document.getElementById("guardian-contact").addEventListener("input", function (e) {
                      this.value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
                      if (this.value.length > 11) {
                          this.value = this.value.slice(0, 11); // Ensure max length of 11
                      }
                  });
                </script>

                </div>
              </div>

              <!-- Required Documents -->
              <div class="form-row">
                <div class="form-group">
                  <label for="tor">*Transcript of Records (TOR)</label>
                  <input type="file" id="tor" name="tor" required>
                </div>
                <div class="form-group">
                  <label for="good-moral">*Certificate of Good Moral</label>
                  <input type="file" id="good-moral" name="good-moral" required>
                </div>
              </div>

              <!-- Submit Section -->
              <div class="form-actions">
                <button type="submit" name="submitReg">Submit</button>

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
