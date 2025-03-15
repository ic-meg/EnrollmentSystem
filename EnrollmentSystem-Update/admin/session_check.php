<?php
include "../dbcon.php";
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: http://localhost/EnrollmentSystem/main/signin.php");
    exit();
}

// echo "Welcome, " . $_SESSION['username'] . "!";
?>
