<?php
session_start();
include '../dbcon.php';
include 'sessioncheck.php';

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, program FROM enrollee WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

$studentName = $student['name'];
$program = $student['program'];

$tuition = isset($_SESSION['tuition']) ? $_SESSION['tuition'] : 0;
$misc = isset($_SESSION['misc']) ? $_SESSION['misc'] : 0;
$method = isset($_SESSION['payment_method']) ? $_SESSION['payment_method'] : "Unknown";

$total = $tuition + $misc;
$amountPaid = $total;
$status = "Paid";
$date = date('Y-m-d H:i:s');

$insert = $conn->prepare("INSERT INTO paymentinfo (user_id, Name, Program, TuitionFee, MiscellanousFee, TotalFees, AmountPaid, PaymentDate, PaymentMethod, PaymentStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$insert->bind_param("issddddsss", $user_id, $studentName, $program, $tuition, $misc, $total, $amountPaid, $date, $method, $status);
$insert->execute();
$insert->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Payment Successful</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f8ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .toast {
      background: #ffffff;
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      animation: fadeIn 0.5s ease-out;
      max-width: 400px;
      width: 90%;
    }

    .toast i {
      font-size: 48px;
      color: #28c76f;
      margin-bottom: 15px;
      animation: popIn 0.4s ease;
    }

    .toast span {
      font-size: 18px;
      color: #333;
      margin-bottom: 10px;
    }

    .toast .redirect-note {
      font-size: 14px;
      color: #888;
    }

    .toast .close {
      position: absolute;
      top: 16px;
      right: 20px;
      font-weight: bold;
      color: #aaa;
      cursor: pointer;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes popIn {
      0% {
        transform: scale(0.6);
        opacity: 0;
      }

      100% {
        transform: scale(1);
        opacity: 1;
      }
    }
  </style>
</head>

<body>
  <div class="toast" id="successToast">
    <i>✔️</i>
    <span>Your payment has been successfully received.</span>
    <div class="redirect-note">You will be redirected to your enrollment summary shortly.</div>
    <span class="close" onclick="document.getElementById('successToast').style.display='none'">×</span>
  </div>

  <script>
    setTimeout(() => {
      window.location.href = 'final-report.php';
    }, 3000);
  </script>
</body>

</html>