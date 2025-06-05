<?php 
include "session_check.php";
include '../dbcon.php';
include "permissions.php";

// Debug: Check current session role
// Remove or comment this out after testing!
echo '<!-- SESSION ROLE: ' . (isset($_SESSION['Role']) ? $_SESSION['Role'] : 'NOT SET') . ' -->';

$query = "SELECT * FROM adminaccount";
$result = mysqli_query($conn, $query);
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User Roles | Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">

    <!-- Custom Master Styles -->
    <link href="assets/css/master.css" rel="stylesheet">
    <script>
        // JavaScript function to generate a random password
        function generatePassword() {
            const length = 12;
            const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
            let password = "";
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * charset.length);
                password += charset[randomIndex];
            }
            document.getElementById("passwordOutput").value = password;
        }

        // Auto-hide success and error messages after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.querySelector('.alert-success');
            const errorAlert = document.querySelector('.alert-danger');

            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s';
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 500);
                }, 3000); // 3 seconds
            }

            if (errorAlert) {
                setTimeout(() => {
                    errorAlert.style.transition = 'opacity 0.5s';
                    errorAlert.style.opacity = '0';
                    setTimeout(() => errorAlert.remove(), 500);
                }, 3000); // 3 seconds
            }
        });
    </script>
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
                            <h3>Users
                                <?php if (canCreate()): ?>
                                <button type="button" class="btn btn-sm btn-outline-primary float-end" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fas fa-user-shield"></i> Add New User
                                </button>
                                <?php endif; ?>
                            </h3>
                        </div>

                        <!-- Display success/error messages -->
                        <?php if ($success): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $success; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Add New User Modal -->
                        <?php if (canCreate()): ?>
                        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="add_user.php" method="POST">
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label for="firstname" class="col-form-label">First name:</label>
                                                <input type="text" class="form-control" name="firstname" required>
                                                <label for="lastname" class="col-form-label">Last name:</label>
                                                <input type="text" class="form-control" name="lastname" required>
                                                <label for="email" class="col-form-label">Email:</label>
                                                <input type="email" class="form-control" name="email" required>
                                                <label for="username" class="col-form-label">Username:</label>
                                                <input type="text" class="form-control" name="username" required>
                                                <label for="phone" class="col-form-label">Phone Number:</label>
                                                <input type="text" class="form-control" name="phone" required>
                                                <label for="role" class="col-form-label">Role:</label>
                                                <select class="form-control" name="role" required>
                                                    <option value="Admin">Admin</option>
                                                    <option value="Staff">Staff</option>
                                                </select>
                                                <label for="password" class="col-form-label">Password:</label>
                                                <div class="input-group mb-3">
                                                    <input type="text" id="passwordOutput" name="password" class="form-control" placeholder="Generated Password" readonly required>
                                                    <button type="button" class="btn btn-primary" onclick="generatePassword()">Generate</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="box box-primary">
                            <div class="box-body">
                                <table width="100%" class="table table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo $user['admin_id']; ?></td>
                                            <td><?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                                            <td><?php echo htmlspecialchars($user['Role']); ?></td>
                                            <td class="text-center">
                                                <!-- Info Button (always visible) -->
                                                <button type="button" class="btn btn-outline-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#infoModal<?php echo $user['admin_id']; ?>">
                                                    <i class="fa fa-info-circle"></i>
                                                </button>
                                                
                                                <!-- Edit Button (Admin only) -->
                                                <?php if (canEdit()): ?>
                                                <button type="button" class="btn btn-outline-info btn-rounded" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $user['admin_id']; ?>">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                                <?php endif; ?>
                                                
                                                <!-- Delete Button (Admin only) -->
                                                <?php if (canDelete()): ?>
                                                <button type="button" class="btn btn-outline-danger btn-rounded" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $user['admin_id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
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


    <?php foreach ($users as $user): ?>
    <!-- Info Modal (always visible) -->
    <div class="modal fade" id="infoModal<?php echo $user['admin_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content text-center"> 
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title" id="infoModalLabel">User Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <?php
                    $profilePicPath = !empty($user['profile_pic']) ? htmlspecialchars($user['profile_pic']) : 'adminPic/default.png';
                ?>
                <img src="<?php echo $profilePicPath; ?>" alt="User Image" class="img-fluid mb-3" style="max-width: 120px; border-radius: 50%;">


                    <h5 class="mb-1"><b><?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?></b></h5>
                    <p class="text-muted mb-1"><?php echo htmlspecialchars($user['email']); ?></p>
                    <p class="mt-2"><span class="badge bg-<?php echo $user['Role'] === 'Admin' ? 'primary' : 'secondary'; ?>">
                        <?php echo htmlspecialchars($user['Role']); ?>
                    </span></p>
                    <p class="mt-2">
                        <?php echo $user['Role'] === 'Admin' ? 
                            'Full access to all administrative features and settings.' : 
                            'Limited access to specific administrative functions.'; ?>
                    </p>
                    <div style="border-top: 1px solid #e0e0e0; margin-top: 20px; padding-top: 15px;">
                        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 5px;">
                            <span class="text-muted">Phone</span>
                            <span><strong><?php echo htmlspecialchars($user['PhoneNumber']); ?></strong></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 14px;">
                            <span class="text-muted">Username</span>
                            <span><strong><?php echo htmlspecialchars($user['username']); ?></strong></span>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal (Admin only) -->
    <?php if (canEdit()): ?>
    <div class="modal fade" id="editModal<?php echo $user['admin_id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="update_user.php" method="POST">
                    <div class="modal-body text-start">
                        <input type="hidden" name="admin_id" value="<?php echo $user['admin_id']; ?>">
                        <div class="mb-3">
                            <label class="col-form-label">First name:</label>
                            <input type="text" class="form-control" name="firstname" value="<?php echo htmlspecialchars($user['FirstName']); ?>" required>
                            
                            <label class="col-form-label">Last name:</label>
                            <input type="text" class="form-control" name="lastname" value="<?php echo htmlspecialchars($user['LastName']); ?>" required>
                            
                            <label class="col-form-label">Email:</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            
                            <label class="col-form-label">Username:</label>
                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            
                            <label class="col-form-label">Phone Number:</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['PhoneNumber']); ?>" required>
                            
                            <label class="col-form-label">Role:</label>
                            <select class="form-control" name="role" required>
                                <option value="Admin" <?php echo $user['Role'] === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="Staff" <?php echo $user['Role'] === 'Staff' ? 'selected' : ''; ?>>Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Delete Modal (Admin only) -->
    <?php if (canDelete()): ?>
    <div class="modal fade" id="deleteModal<?php echo $user['admin_id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="delete_user.php" method="POST">
                    <input type="hidden" name="admin_id" value="<?php echo $user['admin_id']; ?>">
                    <div class="modal-body text-center">
                        <p>Are you sure you want to delete this user?</p>
                        <p><strong><?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?></strong></p>
                        <p class="text-muted">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/datatables/datatables.min.js"></script>
    <script src="assets/js/initiate-datatables.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>