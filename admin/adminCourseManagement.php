<?php 
include "session_check.php";
include '../dbcon.php';

// Clear success message from URL if present
if (isset($_GET['success'])) {
    echo '<script>history.replaceState({}, document.title, window.location.pathname);</script>';
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_course'])) {
        // Add new course
        $courseName = $_POST['course_name'];
        $linkSubject = $_POST['link_subject'];
        $totalUnits = $_POST['total_units'];
        $description = $_POST['description'];
        
        $stmt = $conn->prepare("INSERT INTO course (CourseName, LinkSubject, TotalUnits, Description, is_archived) VALUES (?, ?, ?, ?, FALSE)");
        $stmt->bind_param("ssis", $courseName, $linkSubject, $totalUnits, $description);
        $stmt->execute();
        $stmt->close();
        
        header("Location: adminCourseManagement.php?success=Course+added+successfully");
        exit();
    } elseif (isset($_POST['edit_course'])) {
        // Update course
        $courseID = $_POST['course_id'];
        $courseName = $_POST['course_name'];
        $linkSubject = $_POST['link_subject'];
        $totalUnits = $_POST['total_units'];
        $description = $_POST['description'];
        
        $stmt = $conn->prepare("UPDATE course SET CourseName = ?, LinkSubject = ?, TotalUnits = ?, Description = ? WHERE CourseID = ?");
        $stmt->bind_param("ssisi", $courseName, $linkSubject, $totalUnits, $description, $courseID);
        $stmt->execute();
        $stmt->close();
        
        header("Location: adminCourseManagement.php?success=Course+updated+successfully");
        exit();
    } elseif (isset($_POST['archive_course'])) {
        // Archive course
        $courseID = $_POST['course_id'];
        
        $stmt = $conn->prepare("UPDATE course SET is_archived = TRUE WHERE CourseID = ?");
        $stmt->bind_param("i", $courseID);
        $stmt->execute();
        $stmt->close();
        
        header("Location: adminCourseManagement.php?success=Course+archived+successfully");
        exit();
    } elseif (isset($_POST['restore_course'])) {
        // Restore course
        $courseID = $_POST['course_id'];
        
        $stmt = $conn->prepare("UPDATE course SET is_archived = FALSE WHERE CourseID = ?");
        $stmt->bind_param("i", $courseID);
        $stmt->execute();
        $stmt->close();
        
        header("Location: adminCourseManagement.php?success=Course+restored+successfully");
        exit();
    }
}

// Determine whether to show active or archived courses
$viewArchived = isset($_GET['view']) && $_GET['view'] === 'archived';

if ($viewArchived) {
    // Get archived courses
    $courses = [];
    $result = $conn->query("SELECT * FROM course WHERE is_archived = TRUE");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }
    }
} else {
    // Get active courses
    $courses = [];
    $result = $conn->query("SELECT * FROM course WHERE is_archived = FALSE");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Course Management | Admin Panel</title>
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
    <style>
        .archive-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        .archived-course {
            background-color: #f8f9fa;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <?php include "admin-sidebar.php"; ?>
	</div>
	</div>
    <main>
        <div class="wrapper">
            <div class="container">
                <div class="content">
                    <div class="container">
                        <div class="page-title">
                            <h3>Course Management
                                <button type="button" class="btn btn-sm btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#addModal">
                                    <i class="fas fa-user-shield"></i> Add New Course
                                </button>
                            </h3>
                            <?php if (isset($_GET['success'])): ?>
                                <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Add Course Modal -->
                        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addModalLabel">Add New Course</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="adminCourseManagement.php">
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="col-form-label">Course name:</label>
                                                <input type="text" class="form-control" name="course_name" required>
                                                <label class="col-form-label">Link Subject:</label>
                                                <input type="text" class="form-control" name="link_subject" required>
                                                <label class="col-form-label">Units:</label>
                                                <input type="number" class="form-control" name="total_units" required>
                                                <label class="col-form-label">Description:</label>
                                                <textarea class="form-control" name="description"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="add_course">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box box-primary">
                            <div class="box-body">
                                <table width="100%" class="table table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>Link Subject</th>
                                            <th class="text-center">Total Units</th>
                                            <th class="text-center">No. of Students</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($courses as $course): ?>
                                        <tr class="<?php echo $viewArchived ? 'archived-course' : ''; ?>">
                                            <td><?php echo htmlspecialchars($course['CourseName']); ?></td>
                                            <td><?php echo htmlspecialchars($course['LinkSubject']); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($course['TotalUnits']); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($course['NumOfStudents']); ?></td>
                                            <td class="text-center">
                                                <?php if (!$viewArchived): ?>
                                                    <!-- Info Button -->
                                                    <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModal<?php echo $course['CourseID']; ?>">
                                                        <i class="fa fa-info-circle"></i>
                                                    </button>

                                                    <!-- Edit Button -->
                                                    <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $course['CourseID']; ?>">
                                                        <i class="fas fa-pen"></i>
                                                    </button>

                                                    <!-- Archive Button -->
                                                    <button type="button" class="btn btn-outline-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveModal<?php echo $course['CourseID']; ?>">
                                                        <i class="fas fa-archive"></i>
                                                    </button>
                                                <?php else: ?>
                                                    <!-- Restore Button -->
                                                    <form method="POST" action="adminCourseManagement.php" style="display:inline;">
                                                        <input type="hidden" name="course_id" value="<?php echo $course['CourseID']; ?>">
                                                        <button type="submit" class="btn btn-outline-success btn-rounded" name="restore_course">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <!-- Info Modal -->
                                        <div class="modal fade" id="infoModal<?php echo $course['CourseID']; ?>" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="infoModalLabel">Course Information</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Course Name:</strong> <?php echo htmlspecialchars($course['CourseName']); ?></p>
                                                        <p><strong>Link Subject:</strong> <?php echo htmlspecialchars($course['LinkSubject']); ?></p>
                                                        <p><strong>Total Units:</strong> <?php echo htmlspecialchars($course['TotalUnits']); ?></p>
                                                        <p><strong>Description:</strong> <?php echo htmlspecialchars($course['Description']); ?></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal<?php echo $course['CourseID']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Course</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="adminCourseManagement.php">
                                                        <input type="hidden" name="course_id" value="<?php echo $course['CourseID']; ?>">
                                                        <div class="modal-body text-start">
                                                            <div class="mb-3">
                                                                <label class="col-form-label">Course Name:</label>
                                                                <input type="text" class="form-control" name="course_name" value="<?php echo htmlspecialchars($course['CourseName']); ?>" required>
                                                                <label class="col-form-label">Link Subject:</label>
                                                                <input type="text" class="form-control" name="link_subject" value="<?php echo htmlspecialchars($course['LinkSubject']); ?>" required>
                                                                <label class="col-form-label">Total Units:</label>
                                                                <input type="number" class="form-control" name="total_units" value="<?php echo htmlspecialchars($course['TotalUnits']); ?>" required>
                                                                <label class="col-form-label">Description:</label>
                                                                <textarea class="form-control" name="description"><?php echo htmlspecialchars($course['Description']); ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" name="edit_course">Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Archive Modal -->
                                        <div class="modal fade" id="archiveModal<?php echo $course['CourseID']; ?>" tabindex="-1" aria-labelledby="archiveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="archiveModalLabel">Archive Course</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="adminCourseManagement.php">
                                                        <input type="hidden" name="course_id" value="<?php echo $course['CourseID']; ?>">
                                                        <div class="modal-body text-start">
                                                            Are you sure you want to archive this course? This action can be undone.
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-warning" name="archive_course">Archive</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Floating button to toggle between active and archived courses -->
                        <?php if ($viewArchived): ?>
                            <a href="adminCourseManagement.php" class="btn btn-outline-secondary archive-btn">
                                <i class="fas fa-arrow-left"></i> Back to Active Courses
                            </a>
                        <?php else: ?>
                            <a href="?view=archived" class="btn btn-outline-secondary archive-btn">
                                <i class="fas fa-archive"></i> View Archived Courses
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
