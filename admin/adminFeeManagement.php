<?php 
    include "session_check.php";

?>


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
                    <br><br>
                    <h3>Recent Payments</h3>
                </div>
                            <div class="box box-primary">
                                <div class="box-body">
                                    <table width="100%" class="table table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th class="text-center">Payment Methods</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                    <tbody>

                                <!------- GIULIANI CALAIS ------>
                                    <tr>
                                        <td>1</td>
                                        <td>Oct 3, 2024 11:00 AM</td>
                                        <td class="text-center">Bank</td>
                                        <td class="text-center" style="color: (black);">Serrano, Kate</td>
                                        <td class="text-center" style="color: (blacck);">Paid in full</td>
                                        
                                        <td class="text-center">
                                    <!-- Modal Info Trigger Button -->
                                    <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                        <i class="fa fa-info-circle"></i>
                                    </button>

                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="infoModalGiuliani" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="infoModalGiuliani">Payment Information</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="text-align: left;">
                                                    <h6><strong>Student Details</strong></h6>
                                                    <ul>
                                                        <li><strong>Name:</strong> Serrano, Kate</li>
                                                        <li><strong>Program:</strong> BSIT</li>
                                                    </ul>
                                                    
                                                    <h6 class="mt-4"><strong>Fee Breakdown</strong></h6>
                                                    <ul>
                                                        <li><strong>Tuition Fee:</strong> PHP 10,000.00</li>
                                                        <li><strong>Miscellaneous Fee:</strong> PHP 3,000.00</li>
                                                        <li><strong>Total Fees:</strong> PHP 13,000.00</li>
                                                    </ul>
                                                    
                                                    <h6 class="mt-4"><strong>Payment Details</strong></h6>
                                                    <ul>
                                                        <li><strong>Amount Paid:</strong> PHP 10,000.00</li>
                                                        <li><strong>Payment Date:</strong> 11/15/24</li>
                                                        <li><strong>Payment Method:</strong> Cash</li>
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <!-- <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button> -->
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Edit Info -->
                                <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#paymentStatusModal">
                                <i class="fas fa-pen"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="paymentStatusModal" tabindex="-1" aria-labelledby="paymentStatusModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="paymentStatusModalLabel">Payment Status</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                        <div class="mb-3">
                                            <label for="paymentStatusSelect" class="form-label">Status of payment:</label>
                                            <select class="form-select" id="paymentStatusSelect">
                                            <option selected>Choose...</option>
                                            <option value="complete">Paid in full</option>
                                            <option value="pending">Pending Balance</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                                </div>

                                <!-- Archive Button -->
                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveConfirmationModal">
                                    <i class="fas fa-archive"></i>
                                </button>

                                <!-- Confirmation Modal -->
                                <div class="modal fade" id="archiveConfirmationModal" tabindex="-1" aria-labelledby="archiveConfirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="archiveConfirmationModalLabel">Confirm Archive</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to archive this item?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger" onclick="archiveItem()">Archive</button>
                                    </div>
                                    </div>
                                </div>
                                </div>


                                        </td>
                                    </tr>
                                <!------- MEG ANGELINE FABIAN ------>
                                    <tr>
                                        <td>2</td>
                                        <td>Oct 10, 2024 3:00PM</td>
                                        <td class="text-center">Cash</td>
                                        <td class="text-center" style="color: (black);">Galo, Shanley</td>
                                        <td class="text-center" style="color: (black);">Pending Balance</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                            <div class="modal fade" id="infoModalMeg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            </div>
                                             <!-- Edit Info -->
                                             <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#paymentStatusModal">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                                <!-- Delete Info -->
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveConfirmationModal">
                                                    <i class="fas fa-archive"></i>
                                                </button>

                                        
                                                </div> 
                                        </td>
                                    </tr>
                                <!------- SHANLEY GALO ------>
                                    <tr>
                                        <td>3</td>
                                        <td>Sept 22, 2024 7:00 AM</td>
                                        <td class="text-center">E-Wallet</td>
                                        <td class="text-center" style="color: (black);">Fabian, Meg</td>
                                        <td class="text-center" style="color: (black);">Paid in full</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                                    
                                            </div>
                                                <!-- Edit Info -->
                                                <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#paymentStatusModal">
                                                 <i class="fas fa-pen"></i>
                                                </button>
                                                <!-- Archive Info -->
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveConfirmationModal">
                                                    <i class="fas fa-archive"></i>
                                                </button>

                                                </div> 
                                        </td>
                                    </tr>
                                <!------- PAMELA MURILLO ------>
                                    <tr>
                                        <td>4</td>
                                        <td>Aug 13, 2024 9:00 PM</td>
                                        <td class="text-center">Online Payment</td>
                                        <td class="text-center" style="color: (black);">Calais, Giuliani</td>
                                        <td class="text-center" style="color: (black);">Pending Balance</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                           
                                                </div>
                                            </div>
                                                <!-- Edit Info -->
                                                <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#paymentStatusModal">
                                                <i class="fas fa-pen"></i>
                                                </button>
                                                <!-- Archive Info -->
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveConfirmationModal">
                                                    <i class="fas fa-archive"></i>
                                                </button>


                                            
                                                </div> 
                                        </td>
                                    </tr>
                                <!------- KATE SERRANO ------>    
                                    <tr>
                                        <td>5</td>
                                        <td>Aug 28, 2024 12:00 PM</td>
                                        <td class="text-center">Bank Transfer</td>
                                        <td class="text-center" style="color: (black);">Murillo, Pamela</td>
                                        <td class="text-center" style="color: (black);">Paid in full</td>
                                        
                                        <td class="text-center">
                                            <!-- Modal Info -->
                                            <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModalGiuliani">
                                                <i class="fa fa-info-circle"></i>
                                            </button>

                                            </div>
                                                <!-- Edit Info -->
                                                <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#paymentStatusModal">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <!-- Archive Info -->
                                            <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#archiveConfirmationModal">
                                                <i class="fas fa-archive"></i>
                                            </button>

                                            
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