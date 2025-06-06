<?php

include "../dbcon.php";
      require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
      require_once __DIR__ . '/../PHPMailer/src/SMTP.php';
      require_once __DIR__ . '/../PHPMailer/src/Exception.php';
      require_once __DIR__ . '/../vendor/autoload.php';
      $mailConfig = require __DIR__ . '/../mail_config.php';


      $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
      $dotenv->load();


      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\SMTP;
      use PHPMailer\PHPMailer\Exception;

function sendemail_verify($EmailAddress, $verification_code)
{
  $emailUsername = $_ENV['MAIL_USERNAME'];
  $emailPassword = $_ENV['MAIL_PASSWORD'];
  $emailFrom = $_ENV['MAIL_FROM'];
  $subject = "Password Reset OTP";
  $message = "Hi,<br><br>";
  $message .= "Your password reset OTP code is:<br>";
  $message .= "<strong>$verification_code</strong><br><br>";
  $message .= "If you did not request a password reset, please ignore this email.<br><br>";
  $message .= "Best regards,<br>Oxford Academe";

  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $emailUsername;
    $mail->Password = $emailPassword;
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom($emailFrom, 'Oxford Academe - Online Enrollment System');
    $mail->addAddress($EmailAddress);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sendCode'])) {
  $EmailAddress = $_POST['EmailAddress'];

  // First, check useraccount
  $check_user_query = "SELECT * FROM useraccount WHERE email = '$EmailAddress'";
  $check_user_result = mysqli_query($conn, $check_user_query);

  if (mysqli_num_rows($check_user_result) > 0) {
    $table = 'useraccount';
  } else {
    // Then check adminaccount
    $check_admin_query = "SELECT * FROM adminaccount WHERE email = '$EmailAddress'";
    $check_admin_result = mysqli_query($conn, $check_admin_query);

    if (mysqli_num_rows($check_admin_result) > 0) {
      $table = 'adminaccount';
    } else {
      $message = "<p class='error-message'>No account is associated with this email.</p>";
    }
  }

  if (isset($table)) {
    $verification_code = rand(100000, 999999);
    $update_query = "UPDATE $table SET OTP='$verification_code' WHERE email='$EmailAddress'";
    $update_run = mysqli_query($conn, $update_query);

    if ($update_run) {
      session_start();
      $_SESSION['verification_email'] = $EmailAddress;
      $_SESSION['account_type'] = $table;

      sendemail_verify($EmailAddress, $verification_code);

      $message = "<p class='success-message'>A verification code has been sent to your email.</p>";
      header("Refresh: 2; URL=otp.php");
    } else {
      $message = "<p class='error-message'>Failed to generate OTP. Please try again.</p>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Verify your email</title>
  <link rel="stylesheet" href="vars.css">
  <link rel="stylesheet" href="forgotPass-style.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <style>
    a,
    button,
    input,
    select,
    h1,
    h2,
    h3,
    h4,
    h5,
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      border: none;
      text-decoration: none;
      background: none;
      -webkit-font-smoothing: antialiased;
    }

    menu,
    ol,
    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }

    .continue-button {
      background-color: #00008B;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: not-allowed;
      opacity: 0.6;
      transition: background-color 0.3s ease, opacity 0.3s ease;
    }

    .continue-button:hover {
      background-color: #0000CD;
    }


    .continue-button:enabled {
      cursor: pointer;
      opacity: 1;
    }

    .continue-button:disabled:hover {
      background-color: #00008B;
      cursor: not-allowed;
    }
  </style>
</head>

<body>
  <!-- Vector -->
  <div class="vector-image-container">
    <img class="vector-image" src="./adminPic/Vector.png" alt="Vector Image" />
  </div>
  <!-- Ellipses -->
  <div class="ellipses">
    <img class="ellipse" src="./adminPic/Ellipse.png" alt="Ellipse " />
    <img class="ellipse2" src="./adminPic/Ellipse2.png" alt="Ellipse " />
  </div>
  <!-- Icon and Text -->
  <div class="icon-text">
    <a href="index.php"><img class="bg" src="./adminPic/image 1.png" alt="Background Image" /> </a>
    <h2>Verify Your Email</h2>
  </div>
  <!-- Email Box -->
  <div class="container">
    <form method="POST" action="">
      <div class="input-group">
        <input type="email" name="EmailAddress" id="email" placeholder="Email" required />
        <img class="icon" src="./adminPic/people-10.png" alt="People Icon" />
      </div>
      <button type="submit" name="sendCode" id="continueBtn" class="continue-button" disabled>
        Continue
      </button> <br><br>
      <?php echo $message; ?>
  </div>


  <script>
    const emailInput = document.getElementById('email');
    const continueBtn = document.getElementById('continueBtn');

    emailInput.addEventListener('input', () => {
      const email = emailInput.value;


      const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

      if (!isValidEmail) {
        continueBtn.disabled = true;
        return;
      }


      fetch('check_email.php?email=' + encodeURIComponent(email))
        .then(response => response.json())
        .then(data => {
          continueBtn.disabled = !data.exists;
        })
        .catch(() => {
          continueBtn.disabled = true;
        });
    });
  </script>

</body>

</html>