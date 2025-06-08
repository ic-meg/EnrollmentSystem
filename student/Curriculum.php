<?php
function getYearLabel($num)
{
    switch ($num) {
        case 1:
            return '1st Year';
        case 2:
            return '2nd Year';
        case 3:
            return '3rd Year';
        case 4:
            return '4th Year';
        default:
            return $num . 'th Year';
    }
}
?>


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'sessioncheck.php';
include '../dbcon.php';

$user_id = $_SESSION['user_id'];
$courseID = null;
$studentType = null;
$enrollee_id = null;

// Get data from the main enrollee table
$stmt = $conn->prepare("SELECT EnrolleeID, program, enrollment_type FROM enrollee WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $courseID = $row['program'];
    $studentType = strtolower($row['enrollment_type']); 
    $enrollee_id = $row['EnrolleeID'];
}
$stmt->close();

if (!$courseID || !$enrollee_id) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>No curriculum found. Please complete your enrollment info.</div></div>";
    return;
}
// Convert program name to course ID
$course_id_resolved = null;
$stmt = $conn->prepare("SELECT CourseID FROM course WHERE CourseName = ?");
$stmt->bind_param("s", $courseID); 
$stmt->execute();
$courseResult = $stmt->get_result();
if ($courseResult->num_rows > 0) {
    $course_id_resolved = $courseResult->fetch_assoc()['CourseID'];
}
$stmt->close();

if (!$course_id_resolved) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>No course ID found for program name: $courseID</div></div>";
    return;
}


$first_year_subjects = [];


$stmt = $conn->prepare("SELECT * FROM enrolled_subjects WHERE enrollee_id = ?");
$stmt->bind_param("i", $enrollee_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $first_year_subjects[] = $row;
}

$stmt->close();
$enrolled_ids = array_column($first_year_subjects, 'subj_id');

$curriculum_subjects_by_year = [];
$stmt = $conn->prepare("SELECT * FROM subject WHERE CourseID = ? ORDER BY Year ASC, SubCode ASC");

$stmt->bind_param("i", $course_id_resolved);

$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $year = $row['Year'];
    if (!isset($curriculum_subjects_by_year[$year])) {
        $curriculum_subjects_by_year[$year] = [];
    }
    $curriculum_subjects_by_year[$year][] = $row;
}
$stmt->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Checklist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            color: white;
        }

        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: black;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            color: black;
        }

        th {
            background-color: #555;
        }

        .semester-header {
            background-color: #2DB2FF;
            /* Darker section for semester */
            padding: 10px;
            font-weight: bold;
            color: white;
            text-align: center;
        }

        .btn {
            cursor: pointer;
            color: white;
            background-color: #666;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            margin: 2px;
        }

        .btn:hover {
            background-color: #777;
        }

        .passed-btn {
            background-color: #4CAF50;
            /* Green for passed */
        }

        .delete-btn {
            background-color: #d9534f;
            /* Red for delete or fail */
        }

        .download-btn {
            float: right;
            background-color: #2DB2FF;
            /* Green for download */
        }

        #sidebar ul {
            padding: 0;
            list-style-type: none;
        }
    </style>
</head>

<body>
    <?php include "stud-sidebar.php"; ?>

    <main>
        </div>
        </div>
        <div class="container">

            <?php if (!empty($first_year_subjects)): ?>
                <div class="table-container">
                    <div class="semester-header">1ST YEAR - ENROLLED SUBJECTS</div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Subject Code</th>
                                <th>Subject Title</th>
                                <th>Units</th>
                                <th>Schedule</th>
                                <th>Room</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($first_year_subjects as $subj): ?>
                                <tr>
                                    <td><?php echo $subj['sub_code']; ?></td>
                                    <td><?php echo $subj['sub_name']; ?></td>
                                    <td><?php echo $subj['units']; ?></td>
                                    <td><?php echo $subj['schedule_day'] . ' ' . $subj['schedule_time']; ?></td>
                                    <td><?php echo $subj['room']; ?></td>
                                    <td><button type="button" class="btn delete-btn">X</button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            <?php foreach ($curriculum_subjects_by_year as $year => $subjects): ?>
                <?php
                if ((int)$year === 1) {
                    continue;
                }
                ?>
                <div class="table-container">
                    <div class="semester-header"><?php echo getYearLabel($year); ?></div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Subject Code</th>
                                <th>Subject Title</th>
                                <th>Units</th>
                                <th>Pre-Requisite</th>
                                <th>Grade</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($subjects as $subject): ?>
                                <?php if (!in_array((int)$subject['SubjID'], array_map('intval', $enrolled_ids))): ?>
                                    <tr>
                                        <td><?php echo $subject['SubCode']; ?></td>
                                        <td><?php echo $subject['SubName']; ?></td>
                                        <td><?php echo $subject['Units']; ?></td>
                                        <td><?php echo $subject['PreRequisites'] ?: '-'; ?></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td><button type="button" class="btn delete-btn">X</button></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>


        </div>
    </main>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>