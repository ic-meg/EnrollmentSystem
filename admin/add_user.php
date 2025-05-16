<?php
include "session_check.php";
include '../dbcon.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../vendor/autoload.php';
$mailConfig = require __DIR__ . '/../mail_config.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$emailUsername = $_ENV['MAIL_USERNAME'];
$emailPassword = $_ENV['MAIL_PASSWORD'];
$emailFrom = $_ENV['MAIL_FROM'];

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
            $mail->Username = $emailUsername;
            $mail->Password = $emailPassword;
            $mail->SMTPSecure = 'ssl'; 
            $mail->Port       = 465;

            $mail->setFrom($emailFrom, 'Oxford Academe - Online Enrollment System');
            $mail->addAddress($email, $firstname . ' ' . $lastname);

            //Login URL
            $loginUrl = "http://" . $_SERVER['HTTP_HOST'] . "http://localhost/EnrollmentSystem/main/index.php#";

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
                <p><em>Please change your password in Forgot Password page after first login.</em></p>
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