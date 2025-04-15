<?php
include "../dbcon.php";
include "session_check.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin_id = $_POST['admin_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    
    $query = "UPDATE adminaccount SET 
              FirstName = ?, 
              LastName = ?, 
              email = ?, 
              username = ?,
              PhoneNumber = ?,
              Role = ? 
              WHERE admin_id = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $firstname, $lastname, $email, $username, $phone, $role, $admin_id);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: adminUsers.php?success=User updated successfully");
    } else {
        header("Location: adminUsers.php?error=Error updating user: " . mysqli_error($conn));
    }
    exit();
} else {
    header("Location: adminUsers.php");
    exit();
}
?>