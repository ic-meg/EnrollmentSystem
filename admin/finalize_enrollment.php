<?php
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../vendor/autoload.php';
$mailConfig = require __DIR__ . '/../mail_config.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$emailUsername = $_ENV['MAIL_USERNAME'];
$emailPassword = $_ENV['MAIL_PASSWORD'];
$emailFrom = $_ENV['MAIL_FROM'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Debug
// file_put_contents("debug.txt", "RAW: " . file_get_contents("php://input") . PHP_EOL, FILE_APPEND);
// file_put_contents("email_log.txt", "Email sent to $email\n", FILE_APPEND);

ob_clean();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include "../dbcon.php";


$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['enrollee_id'], $data['section'], $data['subjects'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$enrolleeId = (int)$data['enrollee_id'];
$section = $data['section'];
$subjects = $data['subjects'];


if (empty($subjects)) {
    echo json_encode(['success' => false, 'message' => 'No subjects submitted']);
    exit;
}


foreach ($subjects as $subject) {
    // Validate required values
    if (!isset($subject['SubjID'], $subject['SubCode'], $subject['SubName'], $subject['Fee'], $subject['Units'])) {
        echo json_encode(['success' => false, 'message' => 'Incomplete subject data']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO enrolled_subjects 
        (enrollee_id, subj_id, sub_code, sub_name, fee, units, section, schedule_day, schedule_time, room) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param(
        "iissdissss",
        $enrolleeId,
        $subject['SubjID'],
        $subject['SubCode'],
        $subject['SubName'],
        $subject['Fee'],
        $subject['Units'],
        $section,
        $subject['Schedule'],
        $subject['Time'],
        $subject['Room']
    );

    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Insert failed: ' . $stmt->error]);
        exit;
    }

    $stmt->close();
}

// Update enrollee status
$update = $conn->prepare("UPDATE enrollee SET Status = 'Approved', section = ? WHERE EnrolleeID = ?");
$update->bind_param("si", $section, $enrolleeId);

$update->execute();
$update->close();
// Calculate totals
$tuitionFee = 0;
$miscFee = 300.00;
$totalUnits = 0;

foreach ($subjects as $subject) {
    $tuitionFee += floatval($subject['Fee']);
    $totalUnits += intval($subject['Units']);
}

$totalFee = $tuitionFee + $miscFee;

// Fetch name and program again (or reuse if already stored)
$infoQuery = $conn->prepare("SELECT name, program, user_id FROM enrollee WHERE EnrolleeID = ?");
$infoQuery->bind_param("i", $enrolleeId);
$infoQuery->execute();
$infoResult = $infoQuery->get_result();

if ($infoResult && $infoResult->num_rows > 0) {
    $info = $infoResult->fetch_assoc();

    // Insert into paymentinfo
    $insertPayment = $conn->prepare("INSERT INTO paymentinfo 
        (user_id, Name, Program, TuitionFee, MiscellanousFee, TotalFees, PaymentStatus) 
        VALUES (?, ?, ?, ?, ?, ?, 'Pending')");

    $insertPayment->bind_param(
        "issddd",
        $info['user_id'],
        $info['name'],
        $info['program'],
        $tuitionFee,
        $miscFee,
        $totalFee
    );

    $insertPayment->execute();
    $insertPayment->close();
}

$infoQuery->close();


// Fetch email from useraccount
$userQuery = $conn->prepare("
    SELECT ua.email, e.name 
    FROM useraccount ua 
    JOIN enrollee e ON ua.user_id = e.user_id 
    WHERE e.EnrolleeID = ?
");
$userQuery->bind_param("i", $enrolleeId);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userResult && $userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $email = $userData['email'];
    $name = $userData['name'];


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $emailUsername;
        $mail->Password = $emailPassword;
        $mail->setFrom($emailFrom, 'Oxford Academe - Online Enrollment System');
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'Enrollment Approved!';
        $mail->Body = "
            Hi $name,<br><br>
            Your enrollment has been <strong>approved</strong>! 🎉<br><br>
            You can now visit the <a href='http://localhost/EnrollmentSystem/main/index.php#'>Programs Page</a> to view your enlisted subjects and payment details.<br><br>
            Best regards,<br>
            Oxford Academe Enrollment Team
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
    }
}
echo json_encode(['success' => true]);
