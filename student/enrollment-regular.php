<?php
error_reporting(E_ALL & ~E_NOTICE);
include "../dbcon.php";
include "sessioncheck.php";

require_once 'getProfile.php';

$user_id = $_SESSION['user_id'];
$profile = getStudentProfile($conn, $user_id);

function safe_value($array, $key, $fallback = '')
{
    return isset($array[$key]) ? htmlspecialchars($array[$key]) : $fallback;
}



// echo "<pre>";
// print_r($profile);
// echo "</pre>";


$email = null;
$stmt4 = $conn->prepare("SELECT email FROM useraccount WHERE user_id = ?");
$stmt4->bind_param("i", $user_id);
$stmt4->execute();
$result2 = $stmt4->get_result();
if ($result2 && $result2->num_rows > 0) {
    $email = $result2->fetch_assoc()['email'];
}
$stmt4->close();



if (isset($_POST["submitReg"])) {
    $missingFields = [];

    $firstName = isset($_POST["first-name"]) ? $_POST["first-name"] : null;
    if (!$firstName) $missingFields[] = "First Name";

    $middleInitial = isset($_POST["middle-initial"]) ? $_POST["middle-initial"] : null;

    $lastName = isset($_POST["last-name"]) ? $_POST["last-name"] : null;
    if (!$lastName) $missingFields[] = "Last Name";

    $suffix = isset($_POST["suffix"]) ? $_POST["suffix"] : null;

    $dob = isset($_POST["dob"]) ? $_POST["dob"] : null;
    if (!$dob) $missingFields[] = "Date of Birth";

    $sex = isset($_POST["sex"]) ? $_POST["sex"] : null;
    if (!$sex) $missingFields[] = "Sex";

    $phone = isset($_POST["phone"]) ? $_POST["phone"] : null;
    if (!$phone) $missingFields[] = "Phone";

    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    if (!$email) $missingFields[] = "Email";

    $streetAddress = isset($_POST["address"]) ? $_POST["address"] : null;
    if (!$streetAddress) $missingFields[] = "Street Address";

    $city = isset($_POST["city"]) ? $_POST["city"] : null;
    if (!$city) $missingFields[] = "City";

    $province = isset($_POST["province"]) ? $_POST["province"] : null;
    if (!$province) $missingFields[] = "Province";

    $zipCode = isset($_POST["zip-code"]) ? $_POST["zip-code"] : null;
    if (!$zipCode) $missingFields[] = "Zip Code";

    $program = isset($_POST["program"]) ? $_POST["program"] : null;
    if (!$program) $missingFields[] = "Program";

    if (!empty($missingFields)) {
        $fieldList = implode(", ", $missingFields);
        echo "<script>alert('Please complete all required fields: $fieldList');</script>";
        return;
    }

    $fullName = $firstName . " " . $lastName;
    $status = "Pending";
    $enrollmentType = "Freshmen";
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    function uploadFile($fileInput, $uploadDir)
    {
        if (!isset($_FILES[$fileInput]) || $_FILES[$fileInput]["error"] == UPLOAD_ERR_NO_FILE) return null;

        $fileName = $_FILES[$fileInput]["name"];
        $fileTmp = $_FILES[$fileInput]["tmp_name"];
        $fileSize = $_FILES[$fileInput]["size"];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedTypes = ["jpg", "jpeg", "png", "pdf"];

        if (!in_array($fileExt, $allowedTypes) || $fileSize > 5 * 1024 * 1024) return null;

        $newFileName = uniqid() . "-" . basename($fileName);
        $targetFilePath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmp, $targetFilePath)) return $newFileName;
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
            $stmt1 = $conn->prepare("INSERT INTO freshmen (user_id, FirstName, MiddleInitial, LastName, Suffix, DateOfBirth, Sex, Phone, Email, StreetAddress, City, Province, ZipCode, Program, Form137, Form138, Picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt1) {
                throw new Exception("Prepare statement for freshmen table failed: " . $conn->error);
            }
            $stmt1->bind_param(
                "issssssssssssssss",
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

            $documents_uploaded = ($form137 ? 1 : 0) + ($form138 ? 1 : 0) + ($picture ? 1 : 0);

            if ($stmt1->execute()) {
                $stmt2 = $conn->prepare("INSERT INTO enrollee (user_id, name, Status, enrollment_type, program, documents_uploaded) VALUES (?, ?, ?, ?, ?, ?)");
                if (!$stmt2) {
                    throw new Exception("Prepare statement for enrollee table failed: " . $conn->error);
                }
                $stmt2->bind_param("issssi", $user_id, $fullName, $status, $enrollmentType, $program, $documents_uploaded);

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
                    throw new Exception("Failed to insert into enrollee table: " . $stmt2->error);
                }
                $stmt2->close();
            } else {
                throw new Exception("Failed to insert into freshmen table: " . $stmt1->error);
            }
            $stmt1->close();
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>alert('Database Error: " . htmlspecialchars($e->getMessage()) . "');</script>";
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
    <!-- Bootstrap CSS (in <head>) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (before </body>) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

    .preview-img {
        max-height: 100px;
        margin-top: 10px;
        display: block;
    }
</style>

<body>

    <?php require_once "stud-sidebar.php"; ?>


    <main>
        </div>
        </div>
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
                        <a href="transferee.php">
                            <p>Transferee</p>
                        </a>
                        <a href="returnee.php">
                            <p>Returnee</p>
                        </a>
                        <a href="non-sequential.php">
                            <p>Non-sequential </p>
                        </a>
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
                                <!-- Name Section -->
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="first-name">*First Name</label>
                                        <input type="text" id="first-name" name="first-name"
                                            value="<?= safe_value($profile, 'last_name') ?>" readonly required />
                                    </div>

                                    <div class="form-group">
                                        <label for="middle-initial">Middle Initial</label>
                                        <input type="text" id="middle-initial" name="middle-initial"
                                            value="<?= safe_value($profile, 'middle_name') ?>" readonly />
                                    </div>

                                    <div class="form-group">
                                        <label for="last-name">*Last Name</label>
                                        <input type="text" id="last-name" name="last-name"
                                            value="<?= safe_value($profile, 'first_name') ?>" readonly required />
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
                                        <input type="date" id="dob" name="dob"
                                            value="<?= safe_value($profile, 'birthdate') ?>" readonly required />
                                    </div>

                                    <div class="form-group">
                                        <label for="sex">*Sex</label>
                                        <select id="sex" name="sex" required>
                                            <option value="" disabled hidden <?= empty($_POST['sex']) ? 'selected' : '' ?>>Select</option>
                                            <option value="male" <?= (isset($_POST['sex']) && $_POST['sex'] == 'male') ? 'selected' : '' ?>>Male</option>
                                            <option value="female" <?= (isset($_POST['sex']) && $_POST['sex'] == 'female') ? 'selected' : '' ?>>Female</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">*Phone Number</label>
                                        <input type="tel" id="phone" name="phone"
                                            value="<?= safe_value($profile, 'phone') ?>" maxlength="11" readonly required />
                                    </div>

                                    <div class="form-group">
                                        <label for="email">*Email</label>
                                        <input type="email" id="email" name="email"
                                            value="<?= htmlspecialchars($email) ?>" readonly required />
                                    </div>
                                </div>

                            </div>

                            <!-- Address Section -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="province">*Province</label>
                                    <select id="province" name="province" required>
                                        <option value="" disabled selected hidden>Select a province</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="city">*City</label>
                                    <select id="city" name="city" required>
                                        <option value="" disabled selected hidden>Select a city</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="zip-code">*Zip Code</label>
                                    <input type="text" id="zip-code" name="zip-code" placeholder="Auto-filled based on city" readonly required />
                                </div>
                                <div class="form-group">
                                    <label for="address">*Street Address</label>
                                    <input type="text" id="address" name="address" placeholder="Enter your street address" required>

                                </div>

                                <!-- Program Section -->
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="program">*Program</label>
                                        <select id="program" name="program">
                                            <option value="" disabled selected hidden>Select a program</option>
                                            <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                                            <option value="Bachelor of Science in Psychology">Bachelor of Science in Psychology</option>
                                            <option value="Bachelor of Science in Education">Bachelor of Science in Education</option>
                                            <option value="Bachelor of Science in Human Resource">Bachelor of Science in Human Resource</option>
                                            <option value="Bachelor of Science in Nursing">Bachelor of Science in Nursing</option>
                                            <option value="Bachelor of Science in Law">Bachelor of Science in Law</option>
                                            <option value="Bachelor of Science in Criminology">Bachelor of Science in Criminology</option>
                                            <option value="Bachelor of Science in Tourism">Bachelor of Science in Tourism</option>



                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-137">*Form 137</label>
                                        <input type="file" id="form-137" name="form-137" accept=".jpg,.jpeg,.png,.pdf">
                                        <div id="preview-form-137"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="form-138">*Form 138</label>
                                        <input type="file" id="form-138" name="form-138" accept=".jpg,.jpeg,.png,.pdf">
                                        <div id="preview-form-138"></div>
                                    </div>

                                    <div class="form-group">
                                        <label for="picture">*1x1 Picture</label>
                                        <input type="file" id="picture" name="picture" accept=".jpg,.jpeg,.png">
                                        <div id="preview-picture"></div>
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

    <script src="regular.js">

    </script>

    <div id="onboarding-overlay" style="display: none;">
        <div class="onboarding-backdrop"></div>
        <div id="onboarding-tooltip" class="onboarding-tooltip">
            <p id="onboarding-text">Welcome! Let’s guide you through enrollment.</p>
            <button id="onboarding-next">Next</button>
        </div>
    </div>
    <!-- Fullscreen Preview Modal -->
    <div id="file-preview-modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background-color:rgba(0,0,0,0.8); justify-content:center; align-items:center; z-index:10000;">
        <div style="max-width:90%; max-height:90%; position:relative;">
            <span onclick="closePreview()" style="position:absolute; top:-30px; right:0; color:white; font-size:24px; cursor:pointer;">&times;</span>
            <div id="file-preview-content"></div>
        </div>
    </div>
</body>

</html>