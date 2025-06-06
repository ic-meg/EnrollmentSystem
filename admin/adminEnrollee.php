<?php
include "session_check.php";
include "../dbcon.php";
include "permissions.php"; // Include the permissions file for isAdmin()

// Fetch total students enrolled
$approvedQuery = "SELECT COUNT(*) as total FROM enrollee WHERE Status = 'Approved'";
$approvedResult = mysqli_query($conn, $approvedQuery);
$approvedApplications = mysqli_fetch_assoc($approvedResult)['total'];



// --- Server-side restriction for Admin actions ---
if (isAdmin()) { // Only allow these actions if the user is an Admin
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['archive_enrollee'])) {
        $enrolleeID = intval($_POST['enrollee_id']);

        $stmt = $conn->prepare("UPDATE enrollee SET Status = 'Archived' WHERE EnrolleeID = ?");
        $stmt->bind_param("i", $enrolleeID);

        if ($stmt->execute()) {
            echo "<script>window.location.href = 'adminEnrollee.php?success=Enrollee+archived+successfully';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to archive enrollee.');</script>";
        }
        $stmt->close();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['restore_enrollee'])) {
        $enrolleeID = intval($_POST['enrollee_id']);

        $stmt = $conn->prepare("UPDATE enrollee SET Status = 'Approved' WHERE EnrolleeID = ?");
        $stmt->bind_param("i", $enrolleeID);

        if ($stmt->execute()) {
            echo "<script>window.location.href = 'adminEnrollee.php?view=archived&success=Enrollee+restored+successfully';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to restore enrollee.');</script>";
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Enrollee | Admin Panel</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">

    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">

    <link href="assets/css/master.css" rel="stylesheet">

</head>
<style>

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
                            <h3><span style="color: #2db2ff;">Enrollee</span> <span style="color: #000000;">List</span>
                                <span style="color: #6941C6; font-size:17px; margin-left: 10px;"> <?php echo number_format($approvedApplications); ?> users</span>
                            </h3>
                            <?php
                            $isArchivedView = isset($_GET['view']) && $_GET['view'] === 'archived';
                            ?>

                            <div class="d-flex justify-content-end mb-3">
                                <a href="adminEnrollee.php<?= $isArchivedView ? '' : '?view=archived' ?>" class="btn btn-outline-<?= $isArchivedView ? 'primary' : 'secondary' ?>">
                                    <i class="fas fa-archive me-1"></i>
                                    <?= $isArchivedView ? 'View Active Enrollees' : 'View Archived Enrollees' ?>
                                </a>
                            </div>

                        </div>


                        <div class="box box-primary">
                            <ul class="nav nav-tabs mb-1" id="typeTabs" role="tablist">
                                <li class="nav-item"><button class="nav-link active filter-tab" data-type="Freshmen">Freshmen</button></li>
                                <li class="nav-item"><button class="nav-link filter-tab" data-type="Transferee">Transferee</button></li>
                                <li class="nav-item"><button class="nav-link filter-tab" data-type="Returnee">Returnee</button></li>
                                <li class="nav-item"><button class="nav-link filter-tab" data-type="Nonsequential">Nonsequential</button></li>
                            </ul>

                            <div class="box-body">

                                <table width="100%" class="table table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Enrollee ID</th>
                                            <th>Section</th>
                                            <th>Name</th>
                                            <th>Program</th>
                                            <th>Enrollment Type</th>
                                            <?php if (isAdmin()): // Only show Action column for Admins 
                                            ?>
                                                <th class="text-center">Action</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody id="enrollee-tbody">

                                        <?php
                                        // dbcon.php is already included at the top
                                        $statusFilter = $isArchivedView ? "Archived" : "Approved";

                                        $query = "SELECT EnrolleeID, name, program, enrollment_type, section
                                                FROM enrollee
                                                WHERE Status = '$statusFilter'
                                                ORDER BY EnrolleeID DESC";


                                        $result = $conn->query($query);

                                        if ($result && $result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $enrolleeID = htmlspecialchars($row['EnrolleeID']);
                                                $name = htmlspecialchars($row['name']);
                                                $program = htmlspecialchars($row['program']);
                                                $type = htmlspecialchars($row['enrollment_type']);
                                                $section = !empty($row['section']) ? htmlspecialchars($row['section']) : 'Not Assigned';
                                                $html = "
                                                    <tr data-type='$type'>
                                                        <td>CN-$enrolleeID</td>
                                                        <td>$section</td>
                                                        <td>$name</td>
                                                        <td>$program</td>
                                                        <td>$type</td>";

                                                if (isAdmin()) { // Only show action buttons if user is Admin
                                                    $html .= "<td class='text-center'>";
                                                    if (!$isArchivedView) {
                                                        $html .= "
                                                            <button type='button' class='btn btn-outline-danger btn-rounded archive-btn'
                                                                    data-id='$enrolleeID' data-bs-toggle='modal' data-bs-target='#archiveModal'>
                                                                <i class='fas fa-archive'></i>
                                                            </button>";
                                                    } else {
                                                        $html .= "
                                                            <form method='POST' action='' style='display:inline;'>
                                                                <input type='hidden' name='enrollee_id' value='$enrolleeID'>
                                                                <button type='submit' class='btn btn-outline-success btn-rounded' name='restore_enrollee'>
                                                                    <i class='fas fa-undo'></i>
                                                                </button>
                                                            </form>";
                                                    }
                                                    $html .= "</td>";
                                                }
                                                $html .= "</tr>";

                                                echo $html;
                                            }
                                        } else {
                                            echo "<tr><td colspan='" . (isAdmin() ? '6' : '5') . "' class='text-center text-muted'>No enrollees found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>

                                </table>

                                <?php if (isAdmin()): ?>
                                    <div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Archive User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="">
                                                    <div class="modal-body text-start">
                                                        <input type="hidden" name="enrollee_id" id="archive-enrollee-id">
                                                        Are you sure you want to archive this user? This action will remove them from the active list, but their data will still be accessible in the archive.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No, Cancel</button>
                                                        <button type="submit" name="archive_enrollee" class="btn btn-info">Yes, Archive</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/datatables/datatables.min.js"></script>
        <script src="assets/js/initiate-datatables.js?v=1.1"></script>
        <script src="assets/js/script.js"></script>
</body>
<script>
    // This script should only be active for Admins
    <?php if (isAdmin()): ?>
        $(document).on('click', '.archive-btn', function() {
            const enrolleeID = $(this).data('id');
            $('#archive-enrollee-id').val(enrolleeID);
        });
    <?php endif; ?>
</script>
<script>
    $(document).ready(function() {
        $('.filter-tab').on('click', function() {
            const selectedType = $(this).data('type');
            const $rows = $('#enrollee-tbody tr');
            let visibleCount = 0;


            $('#enrollee-tbody .no-result-row').remove();

            // Update tab UI
            $('.filter-tab').removeClass('active');
            $(this).addClass('active');


            $rows.each(function() {
                const rowType = $(this).data('type');
                if (rowType === selectedType) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });


            if (visibleCount === 0) {
                const noRow = `
                    <tr class="no-result-row">
                        <td colspan="<?= isAdmin() ? '6' : '5' ?>" class="text-center text-muted">No ${selectedType} found.</td>
                    </tr>
                `;
                $('#enrollee-tbody').append(noRow);
            }
        });

        // Trigger default tab on load
        $('.filter-tab.active').trigger('click');
    });
</script>



</html>