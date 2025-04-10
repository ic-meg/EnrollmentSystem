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
        
        $stmt = $conn->prepare("INSERT INTO course (CourseName, LinkSubject, TotalUnits, Description) VALUES (?, ?, ?, ?)");
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
        
        $stmt = $conn->prepare("UPDATE course SET CourseName = ?, LinkSubject = ?, TotalUnits = ? WHERE CourseID = ?");
        $stmt->bind_param("ssii", $courseName, $linkSubject, $totalUnits, $courseID);
        $stmt->execute();
        $stmt->close();
        
        header("Location: adminCourseManagement.php?success=Course+updated+successfully");
        exit();
    } elseif (isset($_POST['delete_course'])) {
        // Delete course
        $courseID = $_POST['course_id'];
        
        $stmt = $conn->prepare("DELETE FROM course WHERE CourseID = ?");
        $stmt->bind_param("i", $courseID);
        $stmt->execute();
        $stmt->close();
        
        header("Location: adminCourseManagement.php?success=Course+deleted+successfully");
        exit();
    }
}

// Fetch all courses
$courses = [];
$result = $conn->query("SELECT * FROM course");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
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
</head>
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
                                        <tr>
                                            <td><?php echo htmlspecialchars($course['CourseName']); ?></td>
                                            <td><?php echo htmlspecialchars($course['LinkSubject']); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($course['TotalUnits']); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($course['NumOfStudents']); ?></td>
                                            <td class="text-center">
                                                <!-- Info Modal -->
                                                <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModal<?php echo $course['CourseID']; ?>">
                                                    <i class="fa fa-info-circle"></i>
                                                </button>
                                                
                                                <!-- Edit Modal -->
                                                <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $course['CourseID']; ?>">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                
                                                <!-- Delete Modal -->
                                                <button type="button" class="btn btn-outline-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $course['CourseID']; ?>">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        
                                        <!-- Info Modal for each course -->
                                        <div class="modal fade" id="infoModal<?php echo $course['CourseID']; ?>" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                <div class="modal-content text-start"> 
                                                    <div class="modal-header justify-content-center">
                                                        <h5 class="modal-title" id="infoModalLabel">Course Info</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5 class="mb-1"><b><?php echo htmlspecialchars($course['CourseName']); ?></b></h5>
                                                        <p><?php echo htmlspecialchars($course['Description']); ?></p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Edit Modal for each course -->
                                        <div class="modal fade" id="editModal<?php echo $course['CourseID']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Course Info</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="adminCourseManagement.php">
                                                        <div class="modal-body text-start">
                                                            <input type="hidden" name="course_id" value="<?php echo $course['CourseID']; ?>">
                                                            <div class="mb-3">
                                                                <label class="col-form-label">Course name:</label>
                                                                <input type="text" class="form-control" name="course_name" value="<?php echo htmlspecialchars($course['CourseName']); ?>" required>
                                                                <label class="col-form-label">Link Subject:</label>
                                                                <input type="text" class="form-control" name="link_subject" value="<?php echo htmlspecialchars($course['LinkSubject']); ?>" required>
                                                                <label class="col-form-label">Units:</label>
                                                                <input type="number" class="form-control" name="total_units" value="<?php echo htmlspecialchars($course['TotalUnits']); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" name="edit_course">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Delete Modal for each course -->
                                        <div class="modal fade" id="deleteModal<?php echo $course['CourseID']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Archive course</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="adminCourseManagement.php">
                                                        <input type="hidden" name="course_id" value="<?php echo $course['CourseID']; ?>">
                                                        <div class="modal-body text-start">
                                                            This action will move to the archive. Do you want to continue?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
                                                            <button type="submit" class="btn btn-dark" name="delete_course">Yes</button>
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
