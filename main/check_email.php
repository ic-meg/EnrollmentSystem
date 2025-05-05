<?php
include '../dbcon.php';

header('Content-Type: application/json');

$email = isset($_GET['email']) ? $_GET['email'] : '';

$response = ['exists' => false];

if (!empty($email)) {
    $safe_email = mysqli_real_escape_string($conn, $email);

    $user_query = "SELECT 1 FROM useraccount WHERE email = '$safe_email' LIMIT 1";
    $admin_query = "SELECT 1 FROM adminaccount WHERE email = '$safe_email' LIMIT 1";

    $user_result = mysqli_query($conn, $user_query);
    $admin_result = mysqli_query($conn, $admin_query);

    if (mysqli_num_rows($user_result) > 0 || mysqli_num_rows($admin_result) > 0) {
        $response['exists'] = true;
    }
}

echo json_encode($response);
?>
