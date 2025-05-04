<?php
include "../dbcon.php";
include "session_check.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_POST['admin_id'];
    
    // Prevent deleting the current logged-in admin
    if ($admin_id == $_SESSION['admin_id']) {
        header("Location: adminUsers.php?error=Cannot delete currently logged-in user");
        exit();
    }
    
    $query = "DELETE FROM adminaccount WHERE admin_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $admin_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: adminUsers.php?success=User deleted successfully");
    } else {
        header("Location: adminUsers.php?error=Error deleting user: " . mysqli_error($conn));
    }
    exit();
} else {
    header("Location: adminUsers.php");
    exit();
}
?>