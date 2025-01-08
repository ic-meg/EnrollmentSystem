<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Roles | Admin Panel</title>
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
                    <h3>Users
                        <button type="button" class="btn btn-sm btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#editModal">
                            <i class="fas fa-user-shield"></i> Add New User
                        </button>
                    </h3>
                </div>
                            <div class="modal fade" id="editModal" tabindex="-1"  aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <form>
                                                <div class="mb-3">
                                                    <label for="email" class="col-form-label">Email:</label>
                                                    <input type="text" class="form-control" id="email">
                                                    <label for="firstname" class="col-form-label">First name:</label>
                                                    <input type="text" class="form-control" id="firstname">
                                                    <label for="lastname" class="col-form-label">Last name:</label>
                                                    <input type="text" class="form-control" id="lastname">
                                                    <label for="role" class="col-form-label">Role:</label>
                                                    <input type="text" class="form-control" id="role">
                                                    <label for="type" class="col-form-label">Type:</label>
                                                    <input type="text" class="form-control" id="type">
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Type</th>
                                        <th class="text-center">Action</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>

                                <!------- GIULIANI CALAIS ------>
                                    <tr>
                                        <td>001</td>
                                        <td>Giuliani Calais</td>
                                        <td>giulianicalais@example.com</td>
                                        <td>Manager</td>
                                        <td>Admin</td>
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalGiuliani" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content text-center"> 
                                                        <div class="modal-header justify-content-center">
                                                            <h5 class="modal-title" id="infoModalLabel">User Info</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="./adminPic/giulinfo.png" alt="Comments" class="img-fluid">
                                                            <h5 class="mb-1"><b>Giuliani Calais</b></h5>
                                                            <p class="mt-0">Manager/Admin</p>
                                                            <p>You have the ability to make changes, update content, and modify information.</p>
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
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit User Info</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form>
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Type the ID:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit First name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Last name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Role:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Type:</label>
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
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalGiuliani">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalGiuliani" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered ">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            Are you sure you want to delete this?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No, Cancel</button>
                                                            <button type="button" class="btn btn-danger">Yes, Delete</button>
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
                                        <td>megfabian@example.com</td>
                                        <td>IT Support</td>
                                        <td>Admin</td>
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalMeg">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalMeg" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered  modal-sm" role="document">
                                                    <div class="modal-content text-center"> 
                                                        <div class="modal-header justify-content-center">
                                                            <h5 class="modal-title" id="infoModalLabel">User Info</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="./adminPic/meginfo.png" alt="Comments" class="img-fluid">
                                                            <h5 class="mb-1"><b>Meg Angeline Fabian</b></h5>
                                                            <p class="mt-0">IT Support/Admin</p>
                                                            <p>You have the ability to make changes, update content, and modify information.</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModalMeg">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <div class="modal fade" id="editModalMeg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered ">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit User Info</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form>
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Type the ID:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit First name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Last name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Role:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Type:</label>
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
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalMeg">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalMeg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered ">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            Are you sure you want to delete this?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No, Cancel</button>
                                                            <button type="button" class="btn btn-danger">Yes, Delete</button>
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
                                        <td>shanleygalo@example.com</td>
                                        <td>Registrar</td>
                                        <td>Staff</td>
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalLey">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalLey" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered  modal-sm" role="document">
                                                    <div class="modal-content text-center"> 
                                                        <div class="modal-header justify-content-center">
                                                            <h5 class="modal-title" id="infoModalLabel">User Info</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="./adminPic/leyinfo.png" alt="Comments" class="img-fluid">
                                                            <h5 class="mb-1"><b>Shanley Galo</b></h5>
                                                            <p class="mt-0">Registrar/Staff</p>
                                                            <p>You manage student records, handle enrollments, and update information but do not have access to system settings or admin features.</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModalLey">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <div class="modal fade" id="editModalLey" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered ">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit User Info</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form>
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Type the ID:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit First name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Last name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Role:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Type:</label>
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
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalLey">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalLey" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered ">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            Are you sure you want to delete this?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No, Cancel</button>
                                                            <button type="button" class="btn btn-danger">Yes, Delete</button>
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
                                        <td>pamelamurillo@example.com</td>
                                        <td>Financial Officer</td>
                                        <td>Admin</td>
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalPam">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalPam" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                                    <div class="modal-content text-center"> 
                                                        <div class="modal-header justify-content-center">
                                                            <h5 class="modal-title" id="infoModalLabel">User Info</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="./adminPic/paminfo.png" alt="Comments" class="img-fluid">
                                                            <h5 class="mb-1"><b>Pamela Murillo</b></h5>
                                                            <p class="mt-0">Financial Officer/Admin</p>
                                                            <p>You have the ability to make changes, update content, and modify information.</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModalPam">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <div class="modal fade" id="editModalPam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit User Info</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form>
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Type the ID:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit First name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Last name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Role:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Type:</label>
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
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalPam">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalPam" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            Are you sure you want to delete this?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No, Cancel</button>
                                                            <button type="button" class="btn btn-danger">Yes, Delete</button>
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
                                        <td>kateserrano@example.com</td>
                                        <td>Instructor</td>
                                        <td>Staff</td>
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalKate">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalKate" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered  modal-sm" role="document">
                                                    <div class="modal-content text-center"> 
                                                        <div class="modal-header justify-content-center">
                                                            <h5 class="modal-title" id="infoModalLabel">User Info</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="./adminPic/kateinfo.png" alt="Comments" class="img-fluid">
                                                            <h5 class="mb-1"><b>Kate Serrano</b></h5>
                                                            <p class="mt-0">Instructor/Staff</p>
                                                            <p>You manage student records, handle enrollments, and update information but do not have access to system settings or admin features.</p>
                                                        </div>
                                                        <div class="modal-footer justify-content-center">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Edit Info -->
                                            <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModalKate">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <div class="modal fade" id="editModalKate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered ">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit User Info</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <form>
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Type the ID:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit First name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Last name:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Role:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                            <label for="recipient-name" class="col-form-label">Edit Type:</label>
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
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModalKate">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <div class="modal fade" id="deleteModalKate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                     <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            Are you sure you want to delete this?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No, Cancel</button>
                                                            <button type="button" class="btn btn-danger">Yes, Delete</button>
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