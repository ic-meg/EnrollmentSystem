<?php
session_start();
include "../dbcon.php";
include "sessioncheck.php";

$user_id = $_SESSION['user_id'];
$_SESSION['read_notifications'] = [];


// 1. Profile
$stmt = $conn->prepare("SELECT created_at FROM studentprofile WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $_SESSION['read_notifications'][] = "Thank you for completing your profile. You can now proceed to enroll.";
}
$stmt->close();

// 2. Enrollee
$stmt = $conn->prepare("SELECT Status FROM enrollee WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $status = $res->fetch_assoc()['Status'];
    if ($status === 'Pending') {
        $_SESSION['read_notifications'][] = "Thank you for submitting your application! It’s now under review, and we’ll update you soon.";
    } elseif ($status === 'Approved') {
        $_SESSION['read_notifications'][] = "Congratulations! Your application has been approved. You can now proceed with the next steps.";
    } elseif ($status === 'Rejected') {
        $_SESSION['read_notifications'][] = "We regret to inform you that your application has been rejected. Please contact the registrar for assistance.";
    }
}
$stmt->close();

// 3. Payment Info
$stmt = $conn->prepare("SELECT PaymentStatus FROM paymentinfo WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    if ($row['PaymentStatus'] === 'Unpaid') {
        $_SESSION['read_notifications'][] = "You have pending fees. Please complete your payment to proceed.";
    } elseif ($row['PaymentStatus'] === 'Paid') {
        $_SESSION['read_notifications'][] = "Your payment has been received successfully. Thank you!";
    }
}
$stmt->close();

echo "success";
