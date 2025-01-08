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
                                                <th class="text-center">Control Number</th>
                                                <th class="text-center">Application Status</th>
                                                <th class="text-center">Document Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                    <tbody>

                                <!------- GIULIANI CALAIS ------>
                                    <tr>
                                        <td>001</td>
                                        <td>Giuliani Calais</td>
                                        <td class="text-center">202412345</td>
                                        <td class="text-center" style="color: rgb(255, 199, 0);">Pending</td>
                                        <td class="text-center" style="color: rgb(255, 199, 0);">Pending</td>
                                        
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
                                                            <button type="button" class="btn btn-success">Approved</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalGiuliani">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalGiuliani" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered ">
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
                                <!------- MEG ANGELINE FABIAN ------>
                                    <tr>
                                        <td>002</td>
                                        <td>Meg Angeline Fabian</td>
                                        <td class="text-center">202412346</td>
                                        <td class="text-center" style="color: rgb(7, 255, 0);">Approved</td>
                                        <td class="text-center" style="color: rgb(0, 127, 201);">Verified</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalMeg">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalMeg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="infoModalMeg">Application ID: 002</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                        <b>Applicant Name:</b> Meg Angeline Fabian<br><br>
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
                                                            <button type="button" class="btn btn-success">Approved</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalMeg">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalMeg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered ">
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
                                <!------- SHANLEY GALO ------>
                                    <tr>
                                        <td>003</td>
                                        <td>Shanley Galo</td>
                                        <td class="text-center">202412347</td>
                                        <td class="text-center" style="color: rgb(241, 0, 0);">Reject</td>
                                        <td class="text-center" style="color: rgb(0, 127, 201);">Verified</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalLey">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalLey" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="infoModalLey">Application ID: 003</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                        <b>Applicant Name:</b> Shanley Galo <br><br>
                                                        <b>Date of Submission:</b> November 12, 2024 <br><br>
                                                        <b>Status:</b> Reject <br><br>
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
                                                            <button type="button" class="btn btn-success">Approved</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalLey">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalLey" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered ">
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
                                <!------- PAMELA MURILLO ------>
                                    <tr>
                                        <td>004</td>
                                        <td>Pamela Murillo</td>
                                        <td class="text-center">202412348</td>
                                        <td class="text-center" style="color: rgb(255, 199, 0);">Pending</td>
                                        <td class="text-center" style="color: rgb(255, 199, 0);">Pending</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalPam">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalPam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="infoModalPam">Application ID: 004</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                        <b>Applicant Name:</b> Pamela Murillo <br><br>
                                                        <b>Date of Submission:</b> November 13, 2024 <br><br>
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
                                                            <button type="button" class="btn btn-success">Approved</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalPam">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalPam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <!------- KATE SERRANO ------>    
                                    <tr>
                                        <td>005</td>
                                        <td>Kate Serrano</td>
                                        <td class="text-center">202412349</td>
                                        <td class="text-center" style="color: rgb(255, 199, 0);">Pending</td>
                                        <td class="text-center" style="color: rgb(255, 199, 0);">Pending</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalKate">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalKate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="infoModalKate">Application ID: 005</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                        <b>Applicant Name:</b> Kate Serrano <br><br>
                                                        <b>Date of Submission:</b> November 14, 2024 <br><br>
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
                                                            <button type="button" class="btn btn-success">Approved</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalKate">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalKate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                     <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Archive course</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            This action will reject the applicant. Do you want to continue?
                                                            <form>
                                                            <div class="mb-3">
                                                                <label for="message-text" class="col-form-label">Reason:</label>
                                                                <textarea class="form-control" id="message-text"></textarea>
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

   
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>
    
</body>

</html>