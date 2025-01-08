<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Enrollee | Admin Panel</title>
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
                    <h3><span style="color: #2db2ff;">Enrollee</span> <span style="color: #000000;">List</span>
                    <span style="color: #6941C6; font-size:17px; margin-left: 10px;"> 100 users</span>
                    </h3> 
                </div>
                        
        
                    <div class="box box-primary">
                        <div class="box-body">
                            <table width="100%" class="table table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Control Number</th>
                                        <th>Status</th>
                                        <th>Name</th>
                                        <th>Program</th>
                                        <th>Enrollment Type</th>
                                        <th class="text-center">Action</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>

                                <!------- ROW 1 ------>
                                    <tr>
                                        <td>CN-123456</td>
                                        <td><span style="color: green;">&#9679;</span> Active </td>
                                        <td>Giuliani Calais</td>
                                        
                                        <td>BS Information Technology</td>
                                        <td>Regular</td>
                                        <td class="text-end">
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            <!-- Delete Info -->
                                            <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveModal">
                                                <i class="fas fa-archive"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    <!------- ROW 2 ------>
                                        <tr>
                                        <td>CN-123456</td>
                                        <td><span style="color: #e8b931;">&#9679;</span> Inactive </td>
                                        <td>Jane Doe</td>
                                        
                                        <td>BS Psychology</td>
                                        <td>Transfer</td>
                                        <td class="text-end">
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            <!-- Archive Info -->
                                            <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveModal">
                                                <i class="fas fa-archive"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    <!------- ROW 3 ------>
                                     <tr>
                                        <td>CN-123456</td>
                                        <td><span style="color: green;">&#9679;</span> Active </td>
                                        <td>Giuliani Calais</td>
                                        
                                        <td>BS Information Technology</td>
                                        <td>Regular</td>
                                        <td class="text-end">
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            <!-- Delete Info -->
                                            <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveModal">
                                                <i class="fas fa-archive"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    <!------- ROW 4 ------>
                                        <tr>
                                        <td>CN-123456</td>
                                        <td><span style="color: #e8b931;">&#9679;</span> Inactive </td>
                                        <td>Jane Doe</td>
                                        
                                        <td>BS Psychology</td>
                                        <td>Transfer</td>
                                        <td class="text-end">
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            <!-- Archive Info -->
                                            <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveModal">
                                                <i class="fas fa-archive"></i>
                                            </button>

                                        </td>
                                    </tr>
                                <!------- ROW 5 ------>
                                    <tr>
                                        <td>CN-123456</td>
                                        <td><span style="color: green;">&#9679;</span> Active </td>
                                        <td>Giuliani Calais</td>
                                        
                                        <td>BS Information Technology</td>
                                        <td>Regular</td>
                                        <td class="text-end">
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            <!-- Delete Info -->
                                            <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveModal">
                                                <i class="fas fa-archive"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    <!------- ROW 6 ------>
                                        <tr>
                                        <td>CN-123456</td>
                                        <td><span style="color: #e8b931;">&#9679;</span> Inactive </td>
                                        <td>Jane Doe</td>
                                        
                                        <td>BS Psychology</td>
                                        <td>Transfer</td>
                                        <td class="text-end">
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            <!-- Archive Info -->
                                            <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveModal">
                                                <i class="fas fa-archive"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    <!------- ROW 7 ------>
                                    <tr>
                                        <td>CN-123456</td>
                                        <td><span style="color: #e8b931;">&#9679;</span> Inactive </td>
                                        <td>Jane Doe</td>
                                        
                                        <td>BS Psychology</td>
                                        <td>Transfer</td>
                                        <td class="text-end">
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            <!-- Archive Info -->
                                            <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveModal">
                                                <i class="fas fa-archive"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    <!------- ROW 8 ------>
                                    <tr>
                                        <td>CN-123456</td>
                                        <td><span style="color: #e8b931;">&#9679;</span> Inactive </td>
                                        <td>Jane Doe</td>
                                        
                                        <td>BS Psychology</td>
                                        <td>Transfer</td>
                                        <td class="text-end">
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            <!-- Archive Info -->
                                            <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveModal">
                                                <i class="fas fa-archive"></i>
                                            </button>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                                                                
                                    <!-- Edit Modal --> 
                                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form>
                                                        <div class="mb-3">
                                                            <!-- Edit Status Dropdown -->
                                                            <label for="recipient-status" class="col-form-label">Status</label>
                                                            <select class="form-control" id="recipient-status">
                                                                <option value="active">Active</option>
                                                                <option value="inactive">Inactive</option>
                                                            </select>
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
                                    <!-- DELETE Modal -->     
                                    <div class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Archive User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    Are you sure you want to archive this user? This action will remove them from the active list, but their data will still be accessible in the archive.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No, Cancel</button>
                                                    <button type="button" class="btn btn-info" id="archiveBtn">Yes, Archive</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

</html>