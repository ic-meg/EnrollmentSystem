<?php
    session_start();
    session_unset();
    session_destroy();
    header("Location: http://localhost/EnrollmentSystem/main/index.php");
    exit();
?>
