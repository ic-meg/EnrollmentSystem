<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['tuition'] = isset($_POST['tuition']) ? (float)$_POST['tuition'] : 0;
    $_SESSION['misc'] = isset($_POST['misc']) ? (float)$_POST['misc'] : 0;
    $_SESSION['payment_method'] = isset($_POST['method']) ? $_POST['method'] : 'Unknown';
    echo json_encode(['status' => 'saved']);
} else {
    echo json_encode(['error' => 'Invalid request']);
}
