
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Admission Information</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700&display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,900;1,500&display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400&display=swap"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montagu+Slab:wght@700&display=swap"/>
    
</head>

<body>
<?php 
include 'Header.php';
include 'dbconn.php'; 
session_start();

$email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';

if ($email) {
    $entry = $type = $applicant = $strand = $LRN = $ProgramName = '';
    $isReadOnly = false;
    $buttonText = "Save Admission Information";
    $buttonClass = "btn-success";
    $formError = '';

    if (isset($_POST['saveAdmission'])) {
        
        if ($_POST['saveAdmission'] === "Reset Admission Information") {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var resetModal = new bootstrap.Modal(document.getElementById('resetModal'));
                resetModal.show();
            });
            </script>";
        } else {
           
            $entry = isset($_POST['entry']) ? $_POST['entry'] : '';
            $type = isset($_POST['typeOfStud']) ? $_POST['typeOfStud'] : '';
            $applicant = isset($_POST['applicantType']) ? $_POST['applicantType'] : '';
            $strand = isset($_POST['SHSStrand']) ? $_POST['SHSStrand'] : '';
            $LRN = isset($_POST['LRN']) ? $_POST['LRN'] : '';
            $ProgramName = isset($_POST['ProgramName']) ? $_POST['ProgramName'] : '';

            
            if (empty($entry) || empty($type) || empty($applicant) || empty($strand) || empty($LRN) || empty($ProgramName)) {
                $formError = 'Please fill out all required fields.';
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                    errorModal.show();
                });
                </script>";
            } else {
                
                $stmt = $conn->prepare("SELECT userID FROM useraccount WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $userID = $row['userID'];

                    $stmt = $conn->prepare("INSERT INTO admissioninfo (userID, Entry, TypeOfStud, ApplicantType, SHSstrand, LRN, ProgramName) VALUES (?, ?, ?, ?, ?, ?, ?)
                        ON DUPLICATE KEY UPDATE Entry = VALUES(Entry), TypeOfStud = VALUES(TypeOfStud), ApplicantType = VALUES(ApplicantType), SHSstrand = VALUES(SHSstrand), LRN = VALUES(LRN), ProgramName = VALUES(ProgramName)");
                    $stmt->bind_param("issssss", $userID, $entry, $type, $applicant, $strand, $LRN, $ProgramName);

                    if ($stmt->execute()) {
                        echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                            successModal.show();
                            successModal.addEventListener('hidden.bs.modal', function () {
                                window.location.href = 'applicationform.php';
                            });
                        });
                        </script>";
                    } else {
                        echo "<script>alert('Error saving admission information: " . $stmt->error . "');</script>";
                    }
                } else {
                    echo "<script>alert('User not found.');</script>";
                }
            }
        }
    } else {
        
        $stmt = $conn->prepare("SELECT * FROM admissioninfo WHERE userID = (SELECT userID FROM useraccount WHERE email = ?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $entry = $row['Entry'];
            $type = $row['TypeOfStud'];
            $applicant = $row['ApplicantType'];
            $strand = $row['SHSstrand'];
            $LRN = $row['LRN'];
            $ProgramName = $row['ProgramName'];
            $isReadOnly = true;
            $buttonText = "Reset Admission Information"; 
            $buttonClass = "btn-danger"; 
        }
    }
}
?>




            <div class="content" id="content">
                <div class="container"><br><br>

                    <p style="color: red;"><b>* -required fields</b></p>
                    <p style="font-size: 20px;"><b>Admission Information</b></p>
                    <form class="row g-3" method="POST" id="admissionForm"> 
                    <div class="col-12">
                    <label for="inputState" class="form-label">Change Branch</label>
                    <select id="inputState" class="form-control" disabled>
                        <option value="Cavite State University - Imus Campus" selected>
                            Cavite State University - Imus Campus
                        </option>
                    </select>
                </div>


            <div class="col-md-4">
                <label for="inputState" class="form-label">*Entry</label>
                <select id="inputState" class="form-control" name="entry" <?= $isReadOnly ? 'disabled' : 'required' ?>>
                    <option value="" <?= $entry == '' ? 'selected' : '' ?>></option>
                    <option value="New" <?= $entry == 'New' ? 'selected' : '' ?>>New</option>
                    <option value="Transferee" <?= $entry == 'Transferee' ? 'selected' : '' ?>>Transferee</option>
                    <option value="2nd Courser" <?= $entry == '2nd Courser' ? 'selected' : '' ?>>2nd Courser</option>
                    <option value="TCP" <?= $entry == 'TCP' ? 'selected' : '' ?>>TCP</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="inputState" class="form-label">*Type of New Student</label>
                <select id="inputState" class="form-control" name="typeOfStud" <?= $isReadOnly ? 'disabled' : 'required' ?>>
                    <option value="" <?= $type == '' ? 'selected' : '' ?>></option>
                    <option value="Grade 12 student" <?= $type == 'Grade 12 student' ? 'selected' : '' ?>>Grade 12 student</option>
                    <option value="SHS Graduate" <?= $type == 'SHS Graduate' ? 'selected' : '' ?>>SHS Graduate</option>
                    <option value="ALS Passer" <?= $type == 'ALS Passer' ? 'selected' : '' ?>>ALS Passer</option>
                    <option value="Associate, Certificate, Vocational or Diploma Degree Holder" <?= $type == 'Associate, Certificate, Vocational or Diploma Degree Holder' ? 'selected' : '' ?>>Associate, Certificate, Vocational or Diploma Degree Holder</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="inputState" class="form-label">*Applicant Type</label>
                <select id="inputState" class="form-control" name="applicantType" <?= $isReadOnly ? 'disabled' : 'required' ?>>
                    <option value="" <?= $applicant == '' ? 'selected' : '' ?>></option>
                    <option value="Filipino Applicant" <?= $applicant == 'Filipino Applicant' ? 'selected' : '' ?>>Filipino Applicant</option>
                    <option value="Foreign Applicant" <?= $applicant == 'Foreign Applicant' ? 'selected' : '' ?>>Foreign Applicant</option>
                </select>
            </div>

            <div class="col-md-4">
                <label for="inputStrand" class="form-label">*SHS Strand</label>
                <select id="inputStrand" class="form-control" name="SHSStrand" onchange="updatePrograms()" <?= $isReadOnly ? 'disabled' : 'required' ?>>
                <option value="" disabled <?= empty($strand) ? 'selected' : '' ?>></option>
                    <option value="ABM" <?= $strand == 'ABM' ? 'selected' : '' ?>>ABM</option>
                    <option value="GAS" <?= $strand == 'GAS' ? 'selected' : '' ?>>GAS</option>
                    <option value="HUMSS" <?= $strand == 'HUMSS' ? 'selected' : '' ?>>HUMSS</option>
                    <option value="STEM" <?= $strand == 'STEM' ? 'selected' : '' ?>>STEM</option>
                    <option value="TVL" <?= $strand == 'TVL' ? 'selected' : '' ?>>TVL</option>
                </select>
            </div>
           
            <div class="col-md-4">
                <label for="inputZip" class="form-label">Learner's Reference Number</label>
                <input type="text" class="form-control" id="inputZip" name="LRN" value="<?= htmlspecialchars($LRN) ?>" <?= $isReadOnly ? 'disabled' : '' ?>>
                <p style="font-size: 11px;">Optional for those who do not have it yet.</p>
            </div>
            <hr>

            <h5>Preferred Course</h5>
            <div class="col-md-4">
                <label for="inputProgram" class="form-label">*Program Name</label>
                <select id="inputProgram" class="form-control" name="ProgramName" <?= $isReadOnly ? 'disabled' : 'required' ?>>
                    <option value="" <?= $ProgramName == '' ? 'selected' : '' ?>></option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn <?= htmlspecialchars($buttonClass) ?>" name="saveAdmission" value="<?= htmlspecialchars($buttonText) ?>"><?= htmlspecialchars($buttonText) ?></button>
            </div>



                    </form>
                </div>
            </div>
        </div>
<!-- Reset Button in the Main Form -->


<!-- Modal HTML -->
<div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetModalLabel">Confirm Reset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to reset the admission information? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <form method="POST" id="resetForm">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="saveAdmission" value="Reset Admission Information" class="btn btn-danger">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Success Modal HTML -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your admission information has been saved successfully.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="goToApplicationForm">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Reset Success Modal HTML -->
<div class="modal fade" id="resetSuccessModal" tabindex="-1" aria-labelledby="resetSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetSuccessModalLabel">Reset Successful</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Your admission information has been successfully reset.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="goToApplicationFormAfterReset">OK</button>
            </div>
        </div>
    </div>
</div>


<script>
   function updatePrograms() {
    const strand = document.getElementById('inputStrand').value;
    const programSelect = document.getElementById('inputProgram');
    let programs = [];

    if (strand === 'TVL') {
        programs = ['Bachelor of Science in Computer Science', 'Bachelor of Science In Hospitality Management', 'Bachelor of Science In Information Technology'];
    } else if (strand === 'STEM') {
        programs = [
            'Bachelor of Early Childhood Education',
            'Bachelor of Elementary Education',
            'Bachelor of Science In Business Administration',
            'Bachelor of Science In Computer Science',
            'Bachelor of Science In Psychology',
            'Bachelor of Secondary Education Major In English',
            'Bachelor of Secondary Education Major In Mathematics'
        ];
    } else if (strand === 'HUMSS') {
        programs = [
            'Bachelor of Arts In Journalism',
            'Bachelor of Early Childhood Education',
            'Bachelor of Elementary Education',
            'Bachelor of Science In Psychology',
            'Bachelor of Secondary Education Major In English',
            'Bachelor of Secondary Education Major In Mathematics'
        ];
    } else if (strand === 'GAS') {
        programs = [
            'Bachelor of Arts In Journalism',
            'Bachelor of Early Childhood Education',
            'Bachelor of Elementary Education',
            'Bachelor of Science In Psychology',
            'Bachelor of Secondary Education Major In English',
            'Bachelor of Secondary Education Major In Mathematics',
            'Bachelor of Science In Entrepreneurship',
            'Bachelor of Science In Office Administration'
        ];
    } else if (strand === 'ABM') {
        programs = [
            'Bachelor of Science In Business Administration',
            'Bachelor of Science In Entrepreneurship',
            'Bachelor of Science In Hospitality Management',
            'Bachelor of Science In Office Administration'
        ];
    }

    programSelect.innerHTML = '<option value="" selected></option>';
    programs.forEach(function(program) {
        const option = document.createElement('option');
        option.value = program;
        option.text = program;
        programSelect.add(option);
    });

    // Set the pre-selected value if available
    const selectedProgram = "<?= htmlspecialchars($ProgramName) ?>";
    if (selectedProgram) {
        programSelect.value = selectedProgram;
    }
}

// Run on page load
document.addEventListener('DOMContentLoaded', updatePrograms);

//Reset and Success Modal
document.addEventListener('DOMContentLoaded', function() {
    const resetForm = document.getElementById('resetForm');
    const resetModal = new bootstrap.Modal(document.getElementById('resetModal'));
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    const resetSuccessModal = new bootstrap.Modal(document.getElementById('resetSuccessModal'));

    // Handle showing the reset modal
    const resetButton = document.querySelector('button[name="saveAdmission"][value="Reset Admission Information"]');
    resetButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default button action
        resetModal.show();
    });

    // Handle reset form submission
    resetForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission
        
        // Create a new XMLHttpRequest to handle the reset operation
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'reset_admission.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Close the reset modal
                    resetModal.hide();
                    // Clear the form fields
                    document.getElementById('admissionForm').reset();
                    // Show the reset success modal
                    resetSuccessModal.show();
                } else {
                    alert('Error resetting admission information: ' + xhr.responseText);
                }
            }
        };
        
        // Send the AJAX request
        xhr.send('email=' + encodeURIComponent('<?= $email ?>'));
    });

    // Handle redirect after reset success modal
    document.getElementById('goToApplicationFormAfterReset').addEventListener('click', function() {
        window.location.href = 'applicationform.php';
    });

    // Handle form save
    document.querySelector('button[name="saveAdmission"][value="Save Admission Information"]').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default button action
        
        // Validate required fields
        const form = document.querySelector('form:not(#resetForm)');
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(function(field) {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {

            showAlert();
            return;
        }

        // Create a new XMLHttpRequest to handle the save operation
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_admission.php', true);
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Show the success modal
                    successModal.show();
                } else {
                    alert('Error saving admission information: ' + xhr.responseText);
                }
            }
        };
        
        // Send the AJAX request
        xhr.send(formData);
    });

    // Handle redirect after success modal
    document.getElementById('goToApplicationForm').addEventListener('click', function() {
        window.location.href = 'applicationform.php';
    });
});

function showAlert() {
Swal.fire({
    title: "Missing Information",
    text: "Please fill out all required fields",
    icon: "warning",
    confirmButtonColor: "#448b4f",
    confirmButtonText: "OK"
});
}



</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    </body>
    </html>
    
