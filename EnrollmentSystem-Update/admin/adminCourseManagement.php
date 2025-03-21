<?php 
    include "session_check.php";

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
                    <h3>Course Management
                        <button type="button" class="btn btn-sm btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="fas fa-user-shield"></i> Add New Course
                        </button>
                    </h3>
                </div>
                            <div class="modal fade" id="editModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add New Course</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <form>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Course name:</label>
                                                    <input type="text" class="form-control">
                                                    <label class="col-form-label">Link Subject:</label>
                                                    <input type="text" class="form-control">
                                                    <label class="col-form-label">Units:</label>
                                                    <input type="text" class="form-control">
                                                    <label class="col-form-label">Description:</label>
                                                    <input type="text" class="form-control">
                                                    
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save</button>
                                         </div>
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

                                <!------- GIULIANI CALAIS ------>
                                    <tr>
                                        <td>BSIT</td>
                                        <td>ITEC90</td>
                                        <td class="text-center">3</td>
                                        <td class="text-center">2053</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalGiuliani" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content text-start"> 
                                                        <div class="modal-header justify-content-center">
                                                            <h5 class="modal-title" id="infoModalLabel">Course Info</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5 class="mb-1"><b>Introduction to Programming</b></h5>
                                                            <p>Covers basic programming concepts, including coding syntax, algorithms, and problem-solving skills. Suitable for IT-related programs.</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModalGiuliani">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <div class="modal fade" id="editModalGiuliani" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Course Info</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form>
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Edit Course name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Link Subject:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Units:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary">Save</button>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalGiuliani">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalGiuliani" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered ">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Archive course</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            This action will move item to the archive. Do you want to continue?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
                                                            <button type="button" class="btn btn-dark">Yes</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                        </td>
                                    </tr>
                                <!------- MEG ANGELINE FABIAN ------>
                                    <tr>
                                        <td>BSHM</td>
                                        <td>GNED9</td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">1731</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModalGiuliani">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                    
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalGiuliani">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                               
                                        </td>
                                    </tr>
                                <!------- SHANLEY GALO ------>
                                    <tr>
                                        <td>Principles of Management</td>
                                        <td>BSBM, BSENTREP</td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">1563</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>

                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModalGiuliani">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                        
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalGiuliani">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                              
                                        </td>
                                    </tr>
                                <!------- PAMELA MURILLO ------>
                                    <tr>
                                        <td>Entrepreneurial Mindset</td>
                                        <td>BSENTREP, BSBM</td>
                                        <td class="text-center">3</td>
                                        <td class="text-center">2421</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                           
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModalGiuliani">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                           
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalGiuliani">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                               
                                    </tr>
                                <!------- KATE SERRANO ------>    
                                    <tr>
                                        <td>General Psychology</td>
                                        <td>BS Psychology</td>
                                        <td class="text-center">2</td>
                                        <td class="text-center">963</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                           
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModalGiuliani">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                           
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-warning btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalGiuliani">
                                                    <i class="fas fa-archive"></i>
                                                </button>
                                             
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