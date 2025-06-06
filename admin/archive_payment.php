<?php
include "../dbcon.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userID = intval($_POST['user_id']);

    $stmt = $conn->prepare("UPDATE paymentinfo SET isArchived = 1 WHERE user_id = ?");
    $stmt->bind_param("i", $userID);
    if ($stmt->execute()) {
        header("Location: adminFeeManagement.php?archived=success");
    } else {
        echo "Failed to archive.";
    }
    $stmt->close();
}
