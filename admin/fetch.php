<?php
// DEBUGGING
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../dbcon.php";

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No ID provided"]);
    exit;
}

$supportId = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM supportpage WHERE SupportID = ?");
if (!$stmt) {
    echo json_encode(["error" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("i", $supportId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "No data found for ID $supportId"]);
}

$stmt->close();
$conn->close();
?>
