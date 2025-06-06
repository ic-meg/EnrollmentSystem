<?php
include "session_check.php";
include '../dbcon.php';
include "permissions.php";
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

    /* Style for view-only mode */
    .view-only-btn {
        cursor: not-allowed;
        opacity: 0.6;
    }

    .view-only-btn:hover {
        background-color: transparent !important;
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
                            <!-- Tabs -->
                            <ul class="nav nav-tabs mb-1" id="enrollmentTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link " id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">Pending</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">Approved</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab">Rejected</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="enrollmentTabsContent">

                                <div class="box-body">
                                    <table width="100%" class="table table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th class="text-center">Application Status</th>
                                                <th class="text-center">Documents Uploaded</th>
                                                <?php if (canEdit()): ?>
                                                    <th class="text-center">Action</th>
                                                <?php endif; ?>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $sql = "SELECT * FROM enrollee";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $modalID1 = "deleteModal" . $row['user_id'];

                                                    $modalID = preg_replace('/\s+/', '', $row['name']);
                                                    $userID = $row['user_id'];
                                                    $_SESSION['selected_user_id'] = $userID;

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

                                                    $tor = isset($extraDetails['TOR']) ? $extraDetails['TOR'] : null;
                                                    $clearance = isset($extraDetails['MedCert']) ? $extraDetails['MedCert'] : null;
                                                    $idPhoto = isset($extraDetails['IDPhoto']) ? $extraDetails['IDPhoto'] : null;

                                                    $tor = isset($extraDetails['TOR']) ? $extraDetails['TOR'] : null;
                                                    $goodMoral = isset($extraDetails['GoodMoral']) ? $extraDetails['GoodMoral'] : null;


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

                                                        <?php if (canEdit()): ?>
                                                            <td class="text-center">
                                                                <button class='btn btn-outline-primary btn-rounded' data-bs-toggle='modal' data-bs-target='#infoModal<?php echo $modalID; ?>'>
                                                                    <i class='fa fa-info-circle'></i>
                                                                </button>

                                                                <?php if (strtolower($row['Status']) !== 'approved' && strtolower($row['Status']) !== 'rejected'): ?>
                                                                    <button type="button" class="btn btn-outline-danger btn-rounded reject-btn"
                                                                        data-userid="<?php echo $userID; ?>"
                                                                        data-username="<?php echo $row['name']; ?>"
                                                                        data-status="<?php echo $row['Status']; ?>">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>

                                                    <!-- Info Modal -->
                                                    <div class="modal fade" id="infoModal<?php echo $modalID; ?>" tabindex="-1" aria-labelledby="infoModalLabel<?php echo $modalID; ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary text-white">
                                                                    <h5 class="modal-title" id="infoModalLabel<?php echo $modalID; ?>">
                                                                        Application ID: <?php echo $row['EnrolleeID']; ?>
                                                                    </h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-start">
                                                                    <p><strong>Applicant Name:</strong> <?php echo $row['name']; ?></p>
                                                                    <p><strong>Enrollment Type:</strong> <?php echo $row['enrollment_type']; ?></p>


                                                                    <?php
                                                                    if (strtolower($row['enrollment_type']) === 'freshmen') {
                                                                        echo '<p><strong>Year Level:</strong> 1st Year</p>';
                                                                    } elseif (!empty($extraDetails['yearLevel'])) {
                                                                        echo '<p><strong>Year Level:</strong> ' . htmlspecialchars($extraDetails['yearLevel']) . '</p>';
                                                                    }
                                                                    ?>


                                                                    <?php if (!empty($extraDetails)): ?>
                                                                        <p><strong>Details Provided by Applicant:</strong></p>

                                                                        <?php if ($enrollmentType == "Freshmen"): ?>
                                                                            <ul>
                                                                                <li>Program: <?php echo $row['program']; ?></li>
                                                                                <li>Email: <?php echo $extraDetails['Email']; ?></li>
                                                                                <li>Address: <?php echo $extraDetails['StreetAddress']; ?>, <?php echo $extraDetails['City']; ?>, <?php echo $extraDetails['Province']; ?> - <?php echo $extraDetails['ZipCode']; ?></li>
                                                                            </ul>
                                                                            <p><strong>Submitted Documents:</strong></p>
                                                                            <ul>
                                                                                <li>Form 137:
                                                                                    <?php if ($form137): ?>
                                                                                        <a href="../student/uploads/<?php echo htmlspecialchars($form137); ?>" target="_blank">View</a>
                                                                                    <?php else: ?>
                                                                                        No file uploaded
                                                                                    <?php endif; ?>
                                                                                </li>
                                                                                <li>Form 138:
                                                                                    <?php if ($form138): ?>
                                                                                        <a href="../student/uploads/<?php echo htmlspecialchars($form138); ?>" target="_blank">View</a>
                                                                                    <?php else: ?>
                                                                                        No file uploaded
                                                                                    <?php endif; ?>
                                                                                </li>
                                                                                <li>Picture:
                                                                                    <?php if ($pic): ?>
                                                                                        <a href="../student/uploads/<?php echo htmlspecialchars($pic); ?>" target="_blank">View</a>
                                                                                    <?php else: ?>
                                                                                        No file uploaded
                                                                                    <?php endif; ?>
                                                                                </li>
                                                                            </ul>
                                                                        <?php elseif ($enrollmentType == "Nonsequential"): ?>
                                                                            <ul>
                                                                                <li>Last Attended School: <?php echo $extraDetails['LastAttendedSchool']; ?></li>
                                                                                <li>Year Graduated: <?php echo $extraDetails['YearGraduatedLeft']; ?></li>
                                                                                <li>Intended Course: <?php echo $extraDetails['IntendedCourse']; ?></li>
                                                                            </ul>
                                                                            <p><strong>Submitted Documents:</strong></p>
                                                                            <ul>
                                                                                <li>Transcript of Records:
                                                                                    <?php if ($tor): ?>
                                                                                        <a href="../student/uploads/<?php echo htmlspecialchars($tor); ?>" target="_blank">View</a>
                                                                                    <?php else: ?>
                                                                                        No file uploaded
                                                                                    <?php endif; ?>
                                                                                </li>
                                                                                <li>Good Moral:
                                                                                    <?php if ($goodMoral): ?>
                                                                                        <a href="../student/uploads/<?php echo htmlspecialchars($goodMoral); ?>" target="_blank">View</a>
                                                                                    <?php else: ?>
                                                                                        No file uploaded
                                                                                    <?php endif; ?>
                                                                                </li>

                                                                            </ul>
                                                                        <?php elseif ($enrollmentType == "Returnee"): ?>
                                                                            <ul>
                                                                                <li>Previous Program: <?php echo $extraDetails['PreviousProgram']; ?></li>
                                                                                <li>Expected Graduation Date: <?php echo $extraDetails['ExpectedGraduationDate']; ?></li>
                                                                                <li>Reason for Returning: <?php echo $extraDetails['ReasonForReturning']; ?></li>
                                                                            </ul>
                                                                            <p><strong>Submitted Documents:</strong></p>
                                                                            <ul>
                                                                                <li>Transcript of Records:
                                                                                    <?php if ($tor): ?>
                                                                                        <a href="../student/uploads/<?php echo htmlspecialchars($tor); ?>" target="_blank">View</a>
                                                                                    <?php else: ?>
                                                                                        No file uploaded
                                                                                    <?php endif; ?>
                                                                                </li>
                                                                                <li>Medical Clearance:
                                                                                    <?php if ($clearance): ?>
                                                                                        <a href="../student/uploads/<?php echo htmlspecialchars($clearance); ?>" target="_blank">View</a>
                                                                                    <?php else: ?>
                                                                                        No file uploaded
                                                                                    <?php endif; ?>
                                                                                </li>
                                                                                <li>ID Picture:
                                                                                    <?php if ($idPhoto): ?>
                                                                                        <a href="../student/uploads/<?php echo htmlspecialchars($idPhoto); ?>" target="_blank">View</a>
                                                                                    <?php else: ?>
                                                                                        No file uploaded
                                                                                    <?php endif; ?>
                                                                                </li>
                                                                            </ul>
                                                                        <?php elseif ($enrollmentType == "Transferee"): ?>
                                                                            <ul>
                                                                                <li>Previous School: <?php echo $extraDetails['PreviousSchool']; ?></li>
                                                                                <li>Previous Program: <?php echo $extraDetails['PreviousProgram']; ?></li>
                                                                                <li>Intended Course: <?php echo $extraDetails['IntendedCourse']; ?></li>
                                                                            </ul>
                                                                            <p><strong>Submitted Documents:</strong></p>
                                                                            <ul>
                                                                                <li>Transcript of Records:
                                                                                    <?php if (!empty($extraDetails['TOR'])): ?>
                                                                                        <a href="../student/uploads/<?php echo htmlspecialchars($extraDetails['TOR']); ?>" target="_blank">View</a>
                                                                                    <?php else: ?>
                                                                                        No file uploaded
                                                                                    <?php endif; ?>
                                                                                </li>
                                                                                <li>Certificate of Good Moral:
                                                                                    <?php if (!empty($extraDetails['GoodMoral'])): ?>
                                                                                        <a href="../student/uploads/<?php echo htmlspecialchars($extraDetails['GoodMoral']); ?>" target="_blank">View</a>
                                                                                    <?php else: ?>
                                                                                        No file uploaded
                                                                                    <?php endif; ?>
                                                                                </li>
                                                                            </ul>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <?php if (canEdit() && strtolower($row['Status']) !== 'approved' && strtolower($row['Status']) !== 'rejected'): ?>
                                                                    <div class="modal-footer">

                                                                        <a href="creditSubject.php?user_id=<?= $row['user_id'] ?>" class="btn btn-success">Approve</a>

                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Rejection Modal (only shown for admins) -->
                                                    <?php if (canEdit()): ?>
                                                        <div class="modal fade" id="deleteModal<?php echo $userID; ?>" tabindex="-1" aria-labelledby="deleteLabel<?php echo $userID; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteLabel<?php echo $userID; ?>">Reject Applicant <?php echo $userID; ?></h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        This action will reject <?php echo $row['name']; ?>'s application. Do you want to continue?
                                                                        <form action="reject.php" method="POST" onsubmit="return confirmAndSetReason(event, <?php echo $userID; ?>);">

                                                                            <!-- hidden fields that actually get submitted -->
                                                                            <input type="hidden" name="user_id" value="<?php echo $userID; ?>">
                                                                            <input type="hidden" name="reason" id="reasonField<?php echo $userID; ?>">

                                                                            <div class="mb-3">
                                                                                <label for="message-text<?php echo $userID; ?>" class="col-form-label">Reason:</label>
                                                                                <textarea required class="form-control" id="message-text<?php echo $userID; ?>"></textarea>
                                                                                <div class="suggested-reasons mt-2">
                                                                                    <button type="button" class="btn btn-outline-secondary btn-sm reason-btn">Incomplete application</button>
                                                                                    <button type="button" class="btn btn-outline-secondary btn-sm reason-btn">Does not meet qualifications</button>
                                                                                    <button type="button" class="btn btn-outline-secondary btn-sm reason-btn">Failed background check</button>
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
                                                                                <button type="submit" class="btn btn-danger">Yes</button>
                                                                            </div>
                                                                        </form>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('#enrollmentTabs button');
            const tableBody = document.querySelector('#dataTables-example tbody');

            function filterTable(status) {
                const rows = tableBody.querySelectorAll('tr');
                let visibleCount = 0;

                rows.forEach(row => {
                    // Skip no-data-message rows
                    if (row.classList.contains('no-data-message')) {
                        row.remove();
                        return;
                    }

                    const statusCell = row.querySelector('td:nth-child(3)');
                    if (!statusCell) return;
                    const rowStatus = statusCell.textContent.trim();

                    const isArchived = rowStatus.toLowerCase() === "archived";

                    if (
                        (status === 'All' && !isArchived) ||
                        (status !== 'All' && rowStatus === status)
                    ) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (visibleCount === 0) {
                    const messageRow = document.createElement('tr');
                    messageRow.className = 'no-data-message';
                    messageRow.innerHTML = `
      <td colspan="6" class="text-center text-muted">
        No ${status.toLowerCase()} applications found.
      </td>
    `;
                    tableBody.appendChild(messageRow);
                }
            }


            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const target = this.getAttribute('data-bs-target').substring(1);
                    if (target === 'pending') filterTable('Pending');
                    else if (target === 'approved') filterTable('Approved');
                    else if (target === 'rejected') filterTable('Rejected');
                    else filterTable('All');
                });
            });


            filterTable('Pending');
        });
        document.querySelectorAll('.confirm-reject-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-userid');
                const reason = document.querySelector(`#message-text${userId}`).value;
                const hiddenField = document.querySelector(`input#reasonField${userId}`);
                if (hiddenField) hiddenField.value = reason;
            });
        });

        function confirmAndSetReason(event, userId) {
            const textarea = document.getElementById(`message-text${userId}`);
            const hidden = document.getElementById(`reasonField${userId}`);

            if (!textarea || !hidden) {
                alert("Missing reason fields.");
                return false;
            }

            const value = textarea.value.trim();
            if (value === "") {
                alert("Please provide a reason.");
                event.preventDefault();
                return false;
            }

            // Set the reason field 
            hidden.value = value;

            //  confirmation 
            const confirmed = confirm("Are you sure you want to reject this applicant?");
            if (!confirmed) {
                event.preventDefault();
                return false;
            }

            return true;
        }
    </script>

</body>

</html>