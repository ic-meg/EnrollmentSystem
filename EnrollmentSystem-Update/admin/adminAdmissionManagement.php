<?php 
    include "session_check.php";

?>


<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admission Management | Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">

    <!-- Custom Master Styles -->
    <link href="assets/css/master.css" rel="stylesheet">
 
</head>
<style>
    .reason-btn {
        margin-right: 5px;
        margin-top: 5px;
        border: 1px solid #dee2e6;
        color: #000;
        background-color: #fff;
    }

    .reason-btn:hover {
        background-color: #e9ecef;
        color: #000;
    }

    .reason-btn.selected {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    .reason-btn.selected:hover {
        background-color: #0056b3;
        color: white;
    }

</style>
<body>
    <?php include "admin-sidebar.php"; ?>
    
    <main>

    </div>
    </div>
    <div class="wrapper">
        <div class="container">
            <div class="content">
                <div class="container">
                <div class="page-title">
                    <h3>Admission Management</h3>
                </div>
                            <div class="box box-primary">
                                <div class="box-body">
                                    <table width="100%" class="table table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                
                                                <th class="text-center">Application Status</th>
                                                <th class="text-center">Documents Uploaded</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                    <?php 
                                        include '../dbcon.php'; 

                                        $sql = "SELECT * FROM enrollee";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                            $modalID = preg_replace('/\s+/', '', $row['name']); // Remove spaces for valid IDs
        
                                                // color for application_status
                                                $statusColor = "";
                                                if ($row['Status'] == "Pending") {
                                                    $statusColor = "color: rgb(255, 199, 0);"; 
                                                    $documentStatus = "1/4"; // Auto-set document status for Pending
                                                    $documentStatus = "2/4";
                                                    $documentStatus = "3/4";
                                                    $documentColor = "color: rgb(255, 199, 0);"; 
                                                } elseif ($row['application_status'] == "Approved") {
                                                    $statusColor = "color: rgb(7, 255, 0);"; 
                                                    $documentStatus = "4/4"; // Auto-set document status for Approved
                                                    $documentColor = "color: rgb(0, 127, 201);"; 
                                                } elseif ($row['application_status'] == "Reject") {
                                                    $statusColor = "color: rgb(241, 0, 0);"; 
                                                    $documentStatus = $row['document_status']; 
                                                    $documentColor = "color: black;"; 
                                                } else {
                                                    $documentStatus = $row['document_status']; 
                                                    $documentColor = "color: black;"; 
                                                }
                                                // main
                                                echo "<tr>";
                                                echo "<td>" . $row['EnrolleeID'] . "</td>";
                                                echo "<td>" . $row['name'] . "</td>";
                                                echo "<td class='text-center' style='$statusColor'>" . $row['Status'] . "</td>"; 
                                                echo "<td class='text-center' style='$documentColor'>" .  $row['documents_uploaded'] ."</td>"; 
                                                echo "<td class='text-center'>
                                                        <button class='btn btn-outline-primary btn-rounded' data-bs-toggle='modal' data-bs-target='#infoModal$modalID'>
                                                            <i class='fa fa-info-circle'></i>
                                                        </button>
                                                        <button class='btn btn-outline-danger btn-rounded' data-bs-toggle='modal' data-bs-target='#deleteModal$modalID'>
                                                            <i class='fas fa-times'></i>
                                                        </button>
                                                        </td>";
                                                echo "</tr>";
                                                // Info Modal (dito muna yan)
                                                echo "<div class='modal fade' id='infoModal$modalID' tabindex='-1' aria-labelledby='infoModalLabel$modalID' aria-hidden='true'>
                                                <div class='modal-dialog modal-dialog-centered'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header'>
                                                            <h5 class='modal-title' id='infoModalLabel$modalID'>Info for " . $row['name'] . "</h5>
                                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                        </div>
                                                        <div class='modal-body'>
                                                            <p><strong>Name:</strong> " . $row['name'] . "</p>
                                                            <p><strong>Application Status:</strong> " . $row['Status'] . "</p>
                                                            <p><strong>Documents Uploaded:</strong> " . $row['documents_uploaded'] . "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";

                                            // Delete Modal (eto din dito muna)
                                            echo "<div class='modal fade' id='deleteModal$modalID' tabindex='-1' aria-labelledby='deleteModalLabel$modalID' aria-hidden='true'>
                                                    <div class='modal-dialog modal-dialog-centered'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title' id='deleteModalLabel$modalID'>Delete " . $row['name'] . "?</h5>
                                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                Are you sure you want to delete <strong>" . $row['name'] . "</strong>?
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                                <a href='delete_admission.php?id=" . $row['EnrolleeID'] . "' class='btn btn-danger'>Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                                        }
                                        $conn->close(); 
                                        ?>
                                <!------- GIULIANI CALAIS ------>
                                    <tr>
                                        <td>001</td>
                                        <td>Giuliani Calais</td>
                                        
                                        <td class="text-center" style="color: rgb(255, 199, 0);">Pending</td>
                                        <td class="text-center" style="color: rgb(255, 199, 0);">1/4</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalGiuliani" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="infoModalGiuliani">Application ID: 001</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                        <b>Applicant Name:</b> Giuliani Calais <br><br>
                                                        <b>Applicant Type:</b> Freshmen<br><br>
                                                        <b>Date of Submission:</b> November 10, 2024 <br><br>
                                                        <b>Status:</b> Pending <br><br>
                                                        <b>Details Provided by Applicant:</b> <br><br>
                                                        &nbsp;&nbsp;•Address: 123 Main Street, Cityville <br>
                                                        &nbsp;&nbsp;•Phone: 09341658632 <br>
                                                        &nbsp;&nbsp;•Qualifications: Bachelor’s Degree in Information Technology <br><br>
                                                        <b>Submitted Documents:</b> <br><br>
                                                        &nbsp;&nbsp;•Application form.pdf <a href="#">[View Document]</a> <br>
                                                        &nbsp;&nbsp;•Form 137 <a href="#">[View Document]</a> <br>
                                                        &nbsp;&nbsp;•Birth Certificate <a href="#">[View Document]</a> <br><br>
                                                        <b>Comments:</b> to be followed na lang po ang report card
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="creditSubject.php"><button type="button" class="btn btn-success">Approved</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalGiuliani">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalGiuliani" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Reject applicant</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body text-start">
                                                                This action will reject the applicant. Do you want to continue?
                                                                <form>
                                                                    <div class="mb-3">
                                                                        <label for="message-text" class="col-form-label">Reason:</label>
                                                                        <textarea class="form-control" id="message-text"></textarea>
                                                                        <div class="suggested-reasons mt-2">
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm reason-btn">Incomplete application</button>
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm reason-btn">Does not meet qualifications</button>
                                                                            <button type="button" class="btn btn-outline-secondary btn-sm reason-btn">Failed background check</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
                                                                <button type="button" class="btn btn-danger">Yes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                        </td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script>
document.querySelectorAll('.reason-btn').forEach(button => {
    button.addEventListener('click', function() {
        const textarea = document.getElementById('message-text');
        const newReason = this.innerText;
        let currentTextArray = textarea.value.split(", ").filter(reason => reason.trim() !== ""); // Convert to array and remove any empty values
        const index = currentTextArray.indexOf(newReason);

        if (index > -1) {
            // Reason is already included, remove it
            currentTextArray.splice(index, 1);
            this.classList.remove('selected');
        } else {
            // Reason is not included, add it
            currentTextArray.push(newReason);
            this.classList.add('selected');
        }

        // Update the textarea with the new list of reasons
        textarea.value = currentTextArray.join(", ");
    });
});

function checkAndUpdateReasons() {
    const textarea = document.getElementById('message-text');
    const currentTextArray = textarea.value.split(", ").filter(reason => reason.trim() !== "");

    document.querySelectorAll('.reason-btn').forEach(button => {
        if (currentTextArray.includes(button.innerText)) {
            button.classList.add('selected');
        } else {
            button.classList.remove('selected');
        }
    });
}

// Optionally, call this function on modal show and page load if necessary
$('#deleteModalGiuliani').on('shown.bs.modal', checkAndUpdateReasons);
window.addEventListener('load', checkAndUpdateReasons);


   </script>
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>
    
</body>

</html>