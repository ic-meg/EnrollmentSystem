<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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

        <div class="container">
            <!--------------- BOXES ------------------->
            <div class="box-container">
                <div class="box box1">
                    <div class="text">
                        <h2 class="topic-heading">10.5k</h2>
                        <h2 class="topic">Total Students Enrolled</h2>
                    </div>
                    <img src="./adminPic/people.png" alt="Views">
                </div>

                <div class="box box2">
                    <div class="text">
                        <h2 class="topic-heading">150</h2>
                        <h2 class="topic">Approved Applications</h2>
                    </div>
                    <img src="./adminPic/like.png" alt="Likes">
                </div>

                <div class="box box3">
                    <div class="text">
                        <h2 class="topic-heading">320</h2>
                        <h2 class="topic">Messages from Applicants</h2>
                    </div>
                    <img src="./adminPic/chat.png" alt="Comments">
                </div>

                <div class="box box4">
                    <div class="text">
                        <h2 class="topic-heading">70</h2>
                        <h2 class="topic">Completed Enrollments</h2>
                    </div>
                    <img src="./adminPic/check.png" alt="Published">
                </div>
            </div>

            <!--------------- RECENT APPLICANTS ------------------->
            <div class="report-container">
                <div class="report-header">
                    <h1 class="recent-Articles">Recent Applicants</h1>
                    <button class="view">View All</button>
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
                        <!-- Data Items -->
                        <div class="item1">
                            <h3 class="t-op-nextlvl">Giuliani Calais</h3>
                            <h3 class="t-op-nextlvl du-red">Incomplete</h3>
                            <h3 class="t-op-nextlvl underline-text">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">View</a>
                            </h3>
                            <h3 class="t-op-nextlvl label-tag1">Pending</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Meg Angeline Fabian</h3>
                            <h3 class="t-op-nextlvl du-green">Complete</h3>
                            <h3 class="t-op-nextlvl underline-text">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2">View</a>
                            </h3>
                            <h3 class="t-op-nextlvl label-tag2">Approved</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Shanley Galo</h3>
                            <h3 class="t-op-nextlvl du-red">Incomplete</h3>
                            <h3 class="t-op-nextlvl underline-text">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal3">View</a>
                            </h3>
                            <h3 class="t-op-nextlvl label-tag1">Pending</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Pamela Murillo</h3>
                            <h3 class="t-op-nextlvl du-green">Complete</h3>
                            <h3 class="t-op-nextlvl underline-text">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal4">View</a>
                            </h3>
                            <h3 class="t-op-nextlvl label-tag2">Approved</h3>
                        </div>

                        <div class="item1">
                            <h3 class="t-op-nextlvl">Kate Serrano</h3>
                            <h3 class="t-op-nextlvl du-green">Complete</h3>
                            <h3 class="t-op-nextlvl underline-text">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal5">View</a>
                            </h3>
                            <h3 class="t-op-nextlvl label-tag2">Approved</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--------------- MODALS ------------------->
            <!-- Giul Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Application ID: 001</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <b>Applicant Name:</b> Giuliani Calais <br><br>
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
                            <button type="button" class="btn btn-primary">View full details</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meg Modal -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Application ID: 002</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <b>Applicant Name:</b> Meg Angeline Fabian <br><br>
                        <b>Date of Submission:</b> November 11, 2024 <br><br>
                        <b>Status:</b> Approved <br><br>
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
                            <button type="button" class="btn btn-primary">View full details</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ley Modal -->
            <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Application ID: 003</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <b>Applicant Name:</b> Shanley Galo <br><br>
                        <b>Date of Submission:</b> November 12, 2024 <br><br>
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
                            <button type="button" class="btn btn-primary">View full details</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pam Modal -->
            <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Application ID: 004</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <b>Applicant Name:</b> Pamela Murillo <br><br>
                        <b>Date of Submission:</b> November 13, 2024 <br><br>
                        <b>Status:</b> Approved <br><br>
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
                            <button type="button" class="btn btn-primary">View full details</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kate Modal -->
            <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Application ID: 005</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <b>Applicant Name:</b> Kate Serrano <br><br>
                        <b>Date of Submission:</b> November 14, 2024 <br><br>
                        <b>Status:</b> Approved <br><br>
                        <b>Details Provided by Applicant:</b> <br><br>
                        &nbsp;&nbsp;•Address: 123 Main Street, Cityville <br>
                        &nbsp;&nbsp;•Phone: 09341658632 <br>
                        &nbsp;&nbsp;•Qualifications: Bachelor’s Degree in Information Technology <br><br>
                        <b>Submitted Documents:</b> <br><br>
                        &nbsp;&nbsp;•Application form.pdf [View Document] <br>
                        &nbsp;&nbsp;•Form 137 [View Document] <br>
                        &nbsp;&nbsp;•Birth Certificate [View Document] <br><br>
                        <b>Comments:</b> to be followed na lang po ang report card
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">View full details</button>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
