<?php
include "../dbcon.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['admin_id'])) {
    header("Location: http://localhost/EnrollmentSystem/main/signin.php");
    exit();
}
?>
