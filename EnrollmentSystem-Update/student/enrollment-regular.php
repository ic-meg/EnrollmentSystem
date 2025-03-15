<?php
include "../dbcon.php";
include "sessioncheck.php";

if (isset($_POST["submitReg"])) {
    $user_id = $_SESSION['user_id']; 
    $firstName = $_POST["first-name"];
    $middleInitial = isset($_POST["middle-initial"]) ? $_POST["middle-initial"] : null;
    $lastName = $_POST["last-name"];
    $suffix = isset($_POST["suffix"]) ? $_POST["suffix"] : null;
    $dob = $_POST["dob"];
    $sex = $_POST["sex"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $streetAddress = $_POST["address"];
    $city = $_POST["city"];
    $province = $_POST["province"];
    $zipCode = $_POST["zip-code"];
    $program = $_POST["program"];


    $fullName = $firstName . " " . $lastName;

  
    $status = "Pending";  
    $enrollmentType = "Freshmen";

  
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

    
    $form137 = uploadFile("form-137", $uploadDir);
    $form138 = uploadFile("form-138", $uploadDir);
    $picture = uploadFile("picture", $uploadDir);

   
    if (!$form137 || !$form138 || !$picture) {
        echo "<script>alert('File upload failed. Please upload valid files (JPG, PNG, PDF, Max 5MB).');</script>";
    } else {
      
        $conn->begin_transaction();

        try {
            // Insert into freshmen table
            $stmt1 = $conn->prepare("INSERT INTO freshmen (user_id, FirstName, MiddleInitial, LastName, Suffix, DateOfBirth, Sex, Phone, Email, StreetAddress, City, Province, ZipCode, Program, Form137, Form138, Picture) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt1->bind_param("issssssssssssssss", 
                $user_id, 
                $firstName, 
                $middleInitial, 
                $lastName, 
                $suffix, 
                $dob, 
                $sex, 
                $phone, 
                $email, 
                $streetAddress, 
                $city, 
                $province, 
                $zipCode, 
                $program, 
                $form137, 
                $form138, 
                $picture
            );
            
          
            $documents_uploaded = 0;
            if ($form137) $documents_uploaded++;
            if ($form138) $documents_uploaded++;
            if ($picture) $documents_uploaded++;

            if ($stmt1->execute()) {
              $stmt2 = $conn->prepare("INSERT INTO enrollee (user_id, name, Status, enrollment_type, program, documents_uploaded) 
              VALUES (?, ?, ?, ?, ?, ?)");

              $stmt2->bind_param("issssi", 
              $user_id, 
              $fullName, 
              $status, 
              $enrollmentType, 
              $program, 
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
                throw new Exception("Failed to insert into freshmen table.");
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

  <title>Oxford Academe | Enrollment Form - Freshmen </title>
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
        <!-- Content Wrapper -->
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

                        <!-- Main Form -->
                        <div class="Form-regular" style="background-color: #f9f9f9;">
                        <p class="description">Regular Application</p>
                        <p class="description--1">
                            Please complete the application form below to apply as a regular student at our institution. Thank you!
                        </p>
                        
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-section">
                            <!-- Name Section -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="first-name">*First Name</label>
                                    <input type="text" id="first-name" name="first-name" required>
                                </div>
                                <div class="form-group">
                                    <label for="middle-initial">Middle Initial</label>
                                    <input type="text" id="middle-initial" name="middle-initial">
                                </div>
                                <div class="form-group">
                                    <label for="last-name">*Last Name</label>
                                    <input type="text" id="last-name" name="last-name" required>
                                </div>
                                <div class="form-group">
                                    <label for="suffix">Suffix</label>
                                    <input type="text" id="suffix" name="suffix">
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
                                <div class="form-group">
                                    <label for="phone">*Phone</label>
                                    <input type="tel" id="phone" name="phone" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">*Email</label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                            </div>

                            <!-- Address Section -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="address">*Street Address</label>
                                    <input type="text" id="address" name="address" required>
                                </div>
                                <div class="form-group">
                                    <label for="city">*City</label>
                                    <input type="text" id="city" name="city" required>
                                </div>
                                <div class="form-group">
                                    <label for="province">*Province</label>
                                    <input type="text" id="province" name="province" required>
                                </div>
                                <div class="form-group">
                                    <label for="zip-code">*Zip Code</label>
                                    <input type="text" id="zip-code" name="zip-code" required>
                                </div>
                            </div>

                            <!-- Program Section -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="program">*Program</label>
                                    <select id="program" name="program">
                                      <option value="">Select a program</option>
                                      <option value="bsit">Bachelor of Science in Information Technology</option>
                                      <option value="bsis">Bachelor of Science in Information Systems</option>
                                      <option value="bscs">Bachelor of Science in Computer Science</option>
                                      <option value="bsba">Bachelor of Science in Business Administration</option>
                                      <option value="bsa">Bachelor of Science in Accountancy</option>
                                      <option value="bsed">Bachelor of Secondary Education</option>
                                      <option value="beed">Bachelor of Elementary Education</option>
                                      <option value="bsn">Bachelor of Science in Nursing</option>
                                      <option value="bsce">Bachelor of Science in Civil Engineering</option>
                                      <option value="bsee">Bachelor of Science in Electrical Engineering</option>
                                      <option value="bsm">Bachelor of Science in Management</option>
                                      <option value="bspsych">Bachelor of Science in Psychology</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="form-137">*Form 137</label>
                                    <input type="file" id="form-137" name="form-137">
                                </div>
                                <div class="form-group">
                                    <label for="form-138">*Form 138</label>
                                    <input type="file" id="form-138" name="form-138">
                                </div>
                                <div class="form-group">
                                    <label for="picture">*1x1 Picture</label>
                                    <input type="file" id="picture" name="picture">
                                </div>
                            </div>

                            <!-- Submit Section -->
                            <!-- <div class="form-actions"> -->
                           <button type="submit" name="submitReg">Submit</a></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  </main>


</body>
</html>
