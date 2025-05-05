<?php
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
  <link rel="stylesheet" href="enrollment-regular.css">
  <title>Oxford Academe | Enrollment Form - Freshmen </title>
</head>
<style>
  #onboarding-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
  }
  .onboarding-backdrop {
    background: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100%;
    position: absolute;
  }
  .onboarding-tooltip {
    position: absolute;
    background: #fff;
    padding: 16px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    max-width: 300px;
    z-index: 10000;
  }
  #onboarding-next {
    margin-top: 10px;
    background: #2db2ff;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 5px;
    cursor: pointer;
  }
  .onboarding-tooltip::after {
    content: "";
    position: absolute;
    top: -10px; 
    left: 50%;
    transform: translateX(-50%);
    border-width: 0 10px 10px 10px;
    border-style: solid;
    border-color: transparent transparent #fff transparent;
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
                            <p class="<?= basename($_SERVER['PHP_SELF']) == 'enrollment-regular.php' ? 'active' : '' ?>">Freshmen</p>
                            <a href="transferee.php"><p>Transferee</p></a>
                            <a href="returnee.php"><p>Returnee</p></a>
                            <a href="non-sequential.php"><p>Non-sequential </p></a>
                        </div>
                        </div>

                        <!-- Main Form -->
                        <div class="Form-regular" style="background-color: #f9f9f9;">
                        <p class="description">Regular Application</p>
                        <p class="description--1">
                            Please complete the application form below to apply as a regular student at our institution. Thank you! <br>
                           
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
                                    <input type="text" id="first-name" name="first-name" placeholder="<?php echo htmlspecialchars($profile['first_name']); ?>" readonly  disabled required>
                                </div>
                                <div class="form-group">
                                    <label for="middle-initial">Middle Initial</label>
                                    <input type="text" id="middle-initial" name="middle-initial" placeholder="Enter your middle initial">
                                </div>
                                <div class="form-group">
                                    <label for="last-name">*Last Name</label>
                                    <input type="text" id="last-name" name="last-name" placeholder="<?php echo htmlspecialchars($profile['last_name']); ?>"  readonly disabled required>
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
                                    <input type="date" id="dob" name="dob"   value="<?= isset($profile['birthdate']) ? htmlspecialchars($profile['birthdate']) : '' ?>"  readonly disabled required>
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
                                <label for="phone">*Phone Number</label>
                                <input type="tel" id="phone" name="phone" placeholder="<?php echo htmlspecialchars($profile['phone']); ?>" maxlength="11" readonly disabled required />

                                <script>
                                document.getElementById("phone").addEventListener("input", function (e) {
                                    this.value = this.value.replace(/\D/g, ''); // Remove non-numeric characters
                                    if (this.value.length > 11) {
                                        this.value = this.value.slice(0, 11); // Ensure max length of 11
                                    }
                                });
                                </script>

                                </div>
                                <div class="form-group">
                                    <label for="email">*Email</label>
                                    <input type="email" id="email" name="email" placeholder="<?php echo htmlspecialchars($email); ?>" disabled required>
                                </div>
                            </div>

                            <!-- Address Section -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="address">*Street Address</label>
                                    <input type="text" id="address" name="address" placeholder="Enter your street address" required>
                                </div>
                                <div class="form-group">
                                    <label for="city">*City</label>
                                    <input type="text" id="city" name="city" placeholder="Enter your city" required>
                                </div>
                                <div class="form-group">
                                    <label for="province">*Province</label>
                                    <input type="text" id="province" name="province" placeholder="Enter your province" required>
                                </div>
                                <div class="form-group">
                                    <label for="zip-code">*Zip Code</label>
                                    <input type="text" id="zip-code" name="zip-code" placeholder="Enter your zip code"  required>
                                </div>
                            </div>

                            <!-- Program Section -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="program">*Program</label>
                                    <select id="program" name="program">
                                      <option value="">Select a program</option>
                                      <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                                      <option value="Bachelor of Science in Information Systems">Bachelor of Science in Information Systems</option>
                                      <option value="Bachelor of Science in Computer Science">Bachelor of Science in Computer Science</option>
                                      <option value="Bachelor of Science in Business Administration">Bachelor of Science in Business Administration</option>
                                      <option value="Bachelor of Science in Accountancy">Bachelor of Science in Accountancy</option>
                                      <option value="Bachelor of Secondary Education">Bachelor of Secondary Education</option>
                                      <option value="Bachelor of Elementary Education">Bachelor of Elementary Education</option>
                                      <option value="Bachelor of Science in Nursing">Bachelor of Science in Nursing</option>
                                      <option value="Bachelor of Science in Civil Engineering">Bachelor of Science in Civil Engineering</option>
                                      <option value="Bachelor of Science in Electrical Engineering">Bachelor of Science in Electrical Engineering</option>
                                      <option value="Bachelor of Science in Management">Bachelor of Science in Management</option>
                                      <option value="Bachelor of Science in Psychology">Bachelor of Science in Psychology</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="form-137">*Form 137</label>
                                    <input type="file" id="form-137" name="form-137">
                                    <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                                </div>
                                <div class="form-group">
                                    <label for="form-138">*Form 138</label>
                                    <input type="file" id="form-138" name="form-138">
                                    <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG, PDF | Max size: 5MB</p>
                                </div>
                                <div class="form-group">
                                    <label for="picture">*1x1 Picture</label>
                                    <input type="file" id="picture" name="picture">
                                    <p style="font-size: 12px; color: #666;">Accepted formats: JPG, PNG | Max size: 5MB</p>
                                </div>

                            </div>

                            <!-- Submit Section -->
                            <!-- <div class="form-actions"> -->
                           <button type="submit" name="submitReg" class="button-submit">Submit</a></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  </main>

  <script>
        document.addEventListener('DOMContentLoaded', () => {
            const steps = [
                {
                selector: '.regular p:first-child',
                message: 'Welcome! If you are a new student enrolling for the first time, click here to begin your Freshmen application.',
                },
                {
                selector: '.regular a:nth-child(2) p',
                message: 'Previously enrolled at another school? Select this to apply as a Transferee.',
                },
                {
                selector: '.regular a:nth-child(3) p',
                message: 'Returning after a break from Oxford Academe? This is the Returnee application.',
                },
                {
                selector: '.regular a:nth-child(4) p',
                message: 'For students who didn’t follow the regular curriculum sequence, choose this Non-Sequential option.',
                }
            ];

        let currentStep = 0;
        const tooltip = document.getElementById('onboarding-tooltip');
        const text = document.getElementById('onboarding-text');
        const overlay = document.getElementById('onboarding-overlay');

        function showStep(index) {
            const step = steps[index];
            const target = document.querySelector(step.selector);
            if (!target) return;

            const rect = target.getBoundingClientRect();
            tooltip.style.top = `${rect.bottom + window.scrollY + 10}px`;
            tooltip.style.left = `${rect.left + window.scrollX}px`;
            text.textContent = step.message;
        }

        document.getElementById('onboarding-next').addEventListener('click', () => {
            currentStep++;
            if (currentStep >= steps.length) {
            overlay.style.display = 'none';
            } else {
            showStep(currentStep);
            }
        });

        overlay.style.display = 'block';
        showStep(currentStep);
        });
    </script>

    <div id="onboarding-overlay" style="display: none;">
        <div class="onboarding-backdrop"></div>
            <div id="onboarding-tooltip" class="onboarding-tooltip">
                <p id="onboarding-text">Welcome! Let’s guide you through enrollment.</p>
                <button id="onboarding-next">Next</button>
            </div>
    </div>

</body>

</html>
