<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$secretKey = $_ENV['SECRET_KEY'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentName = $_POST['student_name'];
    $amount = (int) $_POST['amount'];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.paymongo.com/v1/links",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            'data' => [
                'attributes' => [
                    'amount' => $amount,
                    'description' => "Enrollment Payment for $studentName",
                    'remarks' => 'Student enrollment fee',
                    'redirect' => [
                        'success' => 'http://localhost/EnrollmentSystem/student/payment_success.php',
                        'failed' => 'http://localhost/EnrollmentSystem/student/payment_failed.php'
                    ]
                ]
            ]
        ]),
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authorization: Basic " . base64_encode($secretKey . ":"),
            "content-type: application/json"
        ]
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "Error creating payment link: $err";
    } else {
        $responseData = json_decode($response, true);
        if (isset($responseData['data']['attributes']['checkout_url'])) {
            $checkoutUrl = $responseData['data']['attributes']['checkout_url'];
            header("Location: $checkoutUrl");
            exit;
        } else {
            echo "Failed to get checkout URL. Check PayMongo API response:";
            print_r($responseData);
        }
    }
} else {
    echo "Invalid request method";
}
