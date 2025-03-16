<?php 
    include "session_check.php";
    include '../dbcon.php'; 
                                        
    $sql = "SELECT * FROM enrollee";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $modalID1 = "deleteModal" . $row['user_id'];

            $modalID = preg_replace('/\s+/', '', $row['name']); // Remove spaces for valid IDs
            $userID = $row['user_id'];
            $enrollmentType = $row['enrollment_type'];

            // Determine the correct table
            $tableMap = [
                "Freshmen" => "freshmen",
                "Nonsequential" => "nonsequential",
                "Returnee" => "returnee",
                "Transferee" => "transferee"
            ];

            $table = isset($tableMap[$enrollmentType]) ? $tableMap[$enrollmentType] : null;
            $extraDetails = [];

            if ($table) {
                $query = "SELECT * FROM $table WHERE user_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $userID);
                $stmt->execute();
                $resultDetails = $stmt->get_result();
                if ($resultDetails->num_rows > 0) {
                    $extraDetails = $resultDetails->fetch_assoc();
                }
                $stmt->close();
            }

            // File paths
            $form137 = isset($extraDetails['Form137']) ? $extraDetails['Form137'] : null;
            $form138 = isset($extraDetails['Form138']) ? $extraDetails['Form138'] : null;
            $pic = isset($extraDetails['Picture']) ? $extraDetails['Picture'] : null;
            
            // Default colors
            $statusColor = "color: black;";
            $documentColor = "color: black;";

            // Determine status color
            if ($row['Status'] == "Pending") {
                $statusColor = "color: rgb(255, 199, 0);"; // Yellow
                $documentStatus = "3/4"; // Auto-set document status for Pending
                $documentColor = "color: rgb(255, 199, 0);"; // Yellow
            } elseif ($row['Status'] == "Approved") {
                $statusColor = "color: rgb(7, 255, 0);"; // Green
                $documentStatus = "4/4"; // Auto-set document status for Approved
                $documentColor = "color: rgb(0, 127, 201);"; // Blue
            } elseif ($row['Status'] == "Rejected") {
                $statusColor = "color: rgb(241, 0, 0);"; // Red
                $documentStatus = $row['documents_uploaded'];
            } else {
                $documentStatus = $row['documents_uploaded'];
            }
            $requiredDocs = [
                "Freshmen" => 3,
                "Transferee" => 2,
                "Returnee" => 3,
                "Nonsequential" => 2
            ];
            
            if (isset($requiredDocs[$row['enrollment_type']]) && $row['documents_uploaded'] == $requiredDocs[$row['enrollment_type']]) {
                $documentColor = "color: rgb(7, 255, 0);"; // Green
            }
            

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

                                    <tr>
                                        <td><?php echo $row['EnrolleeID']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td class="text-center" style="<?php echo $statusColor; ?>"><?php echo $row['Status']; ?></td>
                                        <td class="text-center" style="<?php echo $documentColor; ?>">
                                            <?php 
                                                // Display document progress
                                                if ($row['enrollment_type'] == "Freshmen") {
                                                    echo $row['documents_uploaded'] . "/3";
                                                } elseif ($row['enrollment_type'] == "Transferee") {
                                                    echo $row['documents_uploaded'] . "/2";
                                                } elseif ($row['enrollment_type'] == "Returnee") {
                                                    echo $row['documents_uploaded'] . "/3";
                                                } elseif ($row['enrollment_type'] == "Nonsequential") {
                                                    echo $row['documents_uploaded'] . "/2";
                                                } else {
                                                    echo $row['documents_uploaded']; 
                                                }
                                            ?>
                                        </td>

                                        <td class="text-center">
                                            <button class='btn btn-outline-primary btn-rounded' data-bs-toggle='modal' data-bs-target='#infoModal<?php echo $modalID; ?>'>
                                                <i class='fa fa-info-circle'></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-rounded reject-btn"
                                                data-userid="<?php echo $userID; ?>"
                                                data-username="<?php echo $row['name']; ?>"
                                                data-status="<?php echo $row['Status']; ?>">  
                                                <i class="fas fa-times"></i>
                                            </button>

                                        </td>
                                    </tr>

                                    <!-- Info Modal -->
                                    <div class="modal fade" id="infoModal<?php echo $modalID; ?>" tabindex="-1" aria-labelledby="infoModalLabel<?php echo $modalID; ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="infoModalLabel<?php echo $modalID; ?>">Application ID: <?php echo $row['EnrolleeID']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <b>Applicant Name:</b> <?php echo $row['name']; ?> <br><br>
                                                    <b>Applicant Type:</b> <?php echo $row['enrollment_type']; ?> <br><br>

                                                    <?php if (!empty($extraDetails)) { ?>
                                                        <b>Details Provided by Applicant:</b> <br>   

                                                        <?php if ($enrollmentType == "Freshmen") { ?>
                                                            • Program: <?php echo $row['program']; ?> <br>
                                                            • Email: <?php echo $extraDetails['Email']; ?><br>
                                                            • Address: <?php echo $extraDetails['StreetAddress']; ?><br>
                                                            • City: <?php echo $extraDetails['City']; ?><br>
                                                            • Province: <?php echo $extraDetails['Province']; ?><br>
                                                            • Zip Code: <?php echo $extraDetails['ZipCode']; ?><br><br>
                                                            <b>Submitted Documents:</b><br>
                                                                <?php if ($form137): ?>
                                                                    <a href="../student/uploads/<?php echo htmlspecialchars($form137); ?>" target="_blank">[View Form 137]</a><br>
                                                                    <?php else: ?>
                                                                        No file uploaded
                                                                    <?php endif; ?>

                                                                <?php if ($form138): ?>
                                                                    <a href="../student/uploads/<?php echo htmlspecialchars($form138); ?>" target="_blank">[View Form 138]</a><br>
                                                                    <?php else: ?>
                                                                        No file uploaded
                                                                    <?php endif; ?>

                                                                <?php if ($pic): ?>
                                                                    <a href="../student/uploads/<?php echo htmlspecialchars($pic); ?>" target="_blank">[View Picture]</a>
                                                                    <?php else: ?>
                                                                        No file uploaded
                                                                    <?php endif; ?>
                                                            <?php } elseif ($enrollmentType == "Nonsequential") { ?>
                                                                <b>Last Attended School:</b> <?php echo $extraDetails['LastAttendedSchool']; ?><br>
                                                                <b>Year Graduated:</b> <?php echo $extraDetails['YearGraduatedLeft']; ?><br>
                                                                <b>Intended Course:</b> <?php echo $extraDetails['IntendedCourse']; ?><br>
                                                            <?php } elseif ($enrollmentType == "Returnee") { ?>
                                                                <b>Previous Program:</b> <?php echo $extraDetails['PreviousProgram']; ?><br>
                                                                <b>Expected Graduation Date:</b> <?php echo $extraDetails['ExpectedGraduationDate']; ?><br>
                                                                <b>Reason for Returning:</b> <?php echo $extraDetails['ReasonForReturning']; ?><br>
                                                            <?php } elseif ($enrollmentType == "Transferee") { ?>
                                                                <b>Previous School:</b> <?php echo $extraDetails['PreviousSchool']; ?><br>
                                                                <b>Previous Program:</b> <?php echo $extraDetails['PreviousProgram']; ?><br>
                                                                <b>Intended Course:</b> <?php echo $extraDetails['IntendedCourse']; ?><br>
                                                            <?php } ?>
                                                        <?php } ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="creditSubject.php"><button type="button" class="btn btn-success">Approved</button></a>
                                                </button>
                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                               <!-- Rejection Modal -->
                                               <div class="modal fade" id="deleteModal<?php echo $userID; ?>" tabindex="-1" aria-labelledby="deleteLabel<?php echo $userID; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteLabel<?php echo $userID; ?>">Reject Applicant <?php echo $userID; ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                This action will reject <?php echo $row['name']; ?>'s application. Do you want to continue?
                                                                <form>
                                                                    <div class="mb-3">
                                                                        <label for="message-text<?php echo $userID; ?>" class="col-form-label">Reason:</label>
                                                                        <textarea class="form-control" id="message-text<?php echo $userID; ?>"></textarea>
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
                                                                <button type="button" class="btn btn-danger confirm-reject-btn" data-userid="<?php echo $userID; ?>">Yes</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                           
                                            <!-- Already Rejected Modal -->
                                                <div class="modal fade" id="alreadyRejectedModal" tabindex="-1" aria-labelledby="alreadyRejectedLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="alreadyRejectedLabel">Applicant Already Rejected</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p id="alreadyRejectedText"></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                         
                                    <?php 
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
                                        }
                                        $conn->close(); 
                                    ?>

                                

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="admission.js"></script>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>
    
</body>

</html>
