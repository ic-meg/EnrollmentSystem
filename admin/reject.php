<?php
include '../dbcon.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '[No reason provided]';

require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_rejection_email($EmailAddress, $applicantName, $reason)
{
    $emailUsername = $_ENV['MAIL_USERNAME'];
    $emailPassword = $_ENV['MAIL_PASSWORD'];
    $emailFrom = $_ENV['MAIL_FROM'];

    $subject = "Application Status - Rejected";
    $message = "Dear $applicantName,<br><br>";
    $message .= "We regret to inform you that your application has been <strong>rejected</strong>.<br><br>";
    $message .= "<strong>Reason:</strong> $reason<br><br>";
    $message .= "If you believe this was a mistake or have questions, feel free to contact the admissions office.<br><br>";
    $message .= "Sincerely,<br>Oxford Academe - Online Enrollment System";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $emailUsername;
        $mail->Password = $emailPassword;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($emailFrom, 'Oxford Academe - Online Enrollment System');
        $mail->addAddress($EmailAddress);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_POST['user_id'];
    $reason = $_POST['reason'];

    // Update rejection status 
    $stmt = $conn->prepare("UPDATE enrollee SET Status = 'Rejected', rejectReason = ? WHERE user_id = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $reason, $userID);

    if ($stmt->execute()) {
        // Fetch email and name to notify
        $query = $conn->prepare("
        SELECT useraccount.email, enrollee.name 
        FROM enrollee 
        JOIN useraccount ON enrollee.user_id = useraccount.user_id 
        WHERE enrollee.user_id = ?
    ");
        if (!$query) {
            die("Prepare failed for SELECT JOIN: " . $conn->error);
        }

        $query->bind_param("i", $userID);
        $query->execute();
        $result = $query->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            send_rejection_email($user['email'], $user['name'], $reason);
        }

        header("Location: adminAdmissionManagement.php?rejected=success");
        exit();
    } else {
        echo "Failed to reject applicant.";
    }

    $stmt->close();
    $conn->close();
}
