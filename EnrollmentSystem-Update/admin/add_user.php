<?php
include "session_check.php";
include '../dbcon.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/EnrollmentSystem/PHPMailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/EnrollmentSystem/PHPMailer/src/Exception.php';
require 'C:/xampp/htdocs/EnrollmentSystem/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO adminaccount (FirstName, LastName, email, username, PhoneNumber, Role, password) 
              VALUES ('$firstname', '$lastname', '$email', '$username', '$phone', '$role', '$hashedPassword')";

    if (mysqli_query($conn, $query)) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'shanleygalo0000@gmail.com'; 
            $mail->Password   = 'kuzc puuo ufyk rwxt'; 
            $mail->SMTPSecure = 'ssl'; 
            $mail->Port       = 465; 
            $mail->setFrom('shanleygalo0000@gmail.com', 'Oxford Academe - Online Enrollment System');
            $mail->addAddress($email, $firstname . ' ' . $lastname);

            //Login URL
            $loginUrl = "http://" . $_SERVER['HTTP_HOST'] . "/main/signin.php";

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to the Oxford Academe Admin Panel';
            $mail->Body    = "
                <h2>Account Created Successfully</h2>
                <p>Hi $firstname $lastname,</p>
                <p>Your admin account has been created with the following details:</p>
                <p><strong>Username:</strong> $username<br>
                <strong>Password:</strong> $password<br>
                <strong>Role:</strong> $role</p>
                <p><a href='$loginUrl'>Click here to login</a></p>
                <p><em>Please change your password after first login.</em></p>
            ";
            $mail->AltBody = "Hi $firstname $lastname,\n\nYour admin account is ready.\n\nUsername: $username\nPassword: $password\nRole: $role\n\nLogin at: $loginUrl\n\nChange your password after login.";
            $mail->send();
            header("Location: adminUsers.php?success=User added successfully. Email sent!");
        } catch (Exception $e) {
            error_log("Email Error: " . $mail->ErrorInfo);
            header("Location: adminUsers.php?error=User added, but email failed: " . htmlspecialchars($e->getMessage()));
        }
    } else {
        error_log("Database Error: " . mysqli_error($conn));
        header("Location: adminUsers.php?error=An error occurred while adding the user.");
    }
}
?>