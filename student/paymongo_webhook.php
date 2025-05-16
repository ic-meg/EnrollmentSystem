<?php
require_once __DIR__ . '/../vendor/autoload.php';
include '../dbcon.php';

$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

if ($data['data']['attributes']['type'] === 'link.paid') {
    $attributes = $data['data']['attributes']['data']['attributes'];
    $amount = $attributes['amount'] / 100;
    $description = $attributes['description']; // Should contain student name
    preg_match('/Enrollment Payment for (.+)/', $description, $matches);
    $studentName = isset($matches[1]) ? $matches[1] : null;

    if (!$studentName) {
        http_response_code(400);
        echo json_encode(['error' => 'Student name not found in description.']);
        exit;
    }


    $stmt = $conn->prepare("SELECT user_id, program FROM enrollee WHERE name = ?");
    $stmt->bind_param("s", $studentName);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        $user_id = $user['user_id'];
        $program = $user['program'];
        $misc = 3000;
        $tuition = $amount - $misc;
        $method = ucfirst(isset($attributes['payment_method']) ? $attributes['payment_method'] : 'Unknown');
        $status = 'Paid';
        $date = date('Y-m-d H:i:s');

        $insert = $conn->prepare("INSERT INTO paymentinfo (user_id, Name, Program, TuitionFee, MiscellanousFee, TotalFees, AmountPaid, PaymentDate, PaymentMethod, PaymentStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("issddddsss", $user_id, $studentName, $program, $tuition, $misc, $amount, $amount, $date, $method, $status);
        $insert->execute();
        $insert->close();
    }
}

http_response_code(200);
echo json_encode(['status' => 'Received']);
