<?php
session_start();
include "../dbcon.php";

header('Content-Type: application/json');

// Check for required fields
if (!isset($_POST['supportId'], $_POST['adminResponse'])) {
    echo json_encode(["error" => "Missing required fields."]);
    exit;
}

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["error" => "Unauthorized: admin not logged in."]);
    exit;
}

$supportId = intval($_POST['supportId']);
$adminResponse = trim($_POST['adminResponse']);
$adminId = $_SESSION['admin_id'];
$responseDate = date('Y-m-d'); 

$query = "UPDATE supportpage SET 
    adminResponse = ?, 
    status = 'Resolved', 
    responseDate = ?, 
    admin_id = ?
    WHERE SupportID = ?";

$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode(["error" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("ssii", $adminResponse, $responseDate, $adminId, $supportId);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Database error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
