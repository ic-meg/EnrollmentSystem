<?php
session_start();
include "../dbcon.php";

$_SESSION['admin_read_notifications'] = [];

$notifList = [];

// 1. Enrollees
$res = $conn->query("SELECT name FROM enrollee WHERE Status IN ('Pending', 'Approved', 'Rejected')");
while ($row = $res->fetch_assoc()) {
    $notifList[] = "{$row['name']} submitted their application for review.";
    $notifList[] = "Application from {$row['name']} was approved.";
    $notifList[] = "Application from {$row['name']} was rejected.";
}

// 2. Payments
$res = $conn->query("SELECT name, amountPaid FROM paymentinfo WHERE PaymentStatus = 'Paid'");
while ($row = $res->fetch_assoc()) {
    $notifList[] = "Payment of ₱" . number_format($row['amountPaid'], 2) . " received from {$row['name']}.";
}

// Avoid duplicates
$_SESSION['admin_read_notifications'] = array_unique($notifList);

echo "success";
