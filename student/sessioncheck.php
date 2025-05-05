<?php
include "../dbcon.php";



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/EnrollmentSystem/main/signin.php");
    exit();
}

// echo "Welcome, " . $_SESSION['username'] . "!";
?>
