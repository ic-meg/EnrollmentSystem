<?php
include "session_check.php";
include "../dbcon.php";

// Fetch total students enrolled
$totalStudentsQuery = "SELECT COUNT(DISTINCT e.user_id) as total FROM enrollee e JOIN useraccount u ON e.user_id = u.user_id";
$totalStudentsResult = mysqli_query($conn, $totalStudentsQuery);
$totalStudents = mysqli_fetch_assoc($totalStudentsResult)['total'];

// Fetch approved applications (assuming status is stored in enrollee table)
$approvedQuery = "SELECT COUNT(*) as total FROM enrollee WHERE Status = 'Approved'";
$approvedResult = mysqli_query($conn, $approvedQuery);
$approvedApplications = mysqli_fetch_assoc($approvedResult)['total'];

// Fetch pending applications (assuming status is stored in enrollee table)
$pendingQuery = "SELECT COUNT(*) as total FROM enrollee WHERE Status = 'Pending'";
$pendingResult = mysqli_query($conn, $pendingQuery);
$pendingApplicant = mysqli_fetch_assoc($pendingResult)['total'];


// Fetch completed enrollments (assuming this means approved and payment completed)
$completedQuery = "SELECT COUNT(*) as total FROM enrollee e 
                  JOIN paymentinfo p ON e.user_id = p.user_id 
                  WHERE e.Status = 'Approved' AND p.PaymentStatus = 'Paid'";
$completedResult = mysqli_query($conn, $completedQuery);
$completedEnrollments = mysqli_fetch_assoc($completedResult)['total'];

// Fetch recent applicants (last 5)
$recentQuery = "SELECT e.*, u.email 
               FROM enrollee e 
               JOIN useraccount u ON e.user_id = u.user_id 
               WHERE e.Status = 'Pending'
               ORDER BY e.dateSubmitted DESC 
               LIMIT 5";
$recentResult = mysqli_query($conn, $recentQuery);
$recentApplicants = [];
while ($row = mysqli_fetch_assoc($recentResult)) {
    $recentApplicants[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="adminDashboard-style.css">
    <link rel="stylesheet" href="adminDashboard-responsive.css">
</head>

<body>

    <?php include "admin-sidebar.php"; ?>

    <main>
        </div>
        </div>
        <div class="wrapper">
            <div class="container">
                <!--------------- BOXES ------------------->
                <div class="box-container">
                    <div class="box box1">
                        <div class="text">
                            <h2 class="topic-heading"><?php echo number_format($totalStudents); ?></h2>
                            <h2 class="topic">Total Applicants</h2>
                        </div>
                        <img src="./adminPic/people.png" alt="Views">
                    </div>

                    <div class="box box2">
                        <div class="text">
                            <h2 class="topic-heading"><?php echo number_format($approvedApplications); ?></h2>
                            <h2 class="topic">Approved Applications</h2>
                        </div>
                        <img src="./adminPic/like.png" alt="Likes">
                    </div>

                    <div class="box box3">
                        <div class="text">
                            <h2 class="topic-heading"><?php echo number_format($pendingApplicant); ?></h2>
                            <h2 class="topic">Pending Applications</h2>
                        </div>
                        <img src="./adminPic/chat.png" alt="Comments">
                    </div>

                    <div class="box box4">
                        <div class="text">
                            <h2 class="topic-heading"><?php echo number_format($completedEnrollments); ?></h2>
                            <h2 class="topic">Completed Enrollments</h2>
                        </div>
                        <img src="./adminPic/check.png" alt="Published">
                    </div>
                </div>

                <!--------------- RECENT APPLICANTS ------------------->
                <div class="report-container">
                    <div class="report-header">
                        <h1 class="recent-Articles">Recent Applicants</h1>
                        <button class="view"><a href="adminEnrollee.php" style="text-decoration: none; color: white; ">View All</a></button>
                    </div>

                    <div class="report-body">
                        <!-- Data Titles -->
                        <div class="report-topic-heading">
                            <h3 class="t-op">Student Name</h3>
                            <h3 class="t-op-nextlvl">Documents uploads</h3>
                            <h3 class="t-op-nextlvl">View Application</h3>
                            <h3 class="t-op">Status</h3>
                        </div>

                        <div class="items">
                            <?php if (!empty($recentApplicants)): ?>
                                <?php foreach ($recentApplicants as $index => $applicant): ?>
                                    <?php
                                    // Determine document status
                                    $docStatus = ($applicant['documents_uploaded'] >= 3) ? 'Complete' : 'Incomplete';
                                    $docClass = ($docStatus == 'Complete') ? 'du-green' : 'du-red';
                                    $statusClass = ($applicant['Status'] == 'Approved') ? 'label-tag2' : 'label-tag1';
                                    ?>
                                    <div class="item1">
                                        <h3 class="t-op-nextlvl"><?php echo htmlspecialchars($applicant['name']); ?></h3>
                                        <h3 class="t-op-nextlvl <?php echo $docClass; ?>"><?php echo $docStatus; ?></h3>
                                        <h3 class="t-op-nextlvl underline-text">
                                            <a href="adminAdmissionManagement.php?id=<?php echo urlencode($applicant['EnrolleeID']); ?>">View</a>
                                        </h3>
                                        <h3 class="t-op-nextlvl <?php echo $statusClass; ?>"><?php echo htmlspecialchars($applicant['Status']); ?></h3>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="item1">
                                    <h3 class="t-op-nextlvl">No recent applicants found</h3>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

    </main>



</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</html>