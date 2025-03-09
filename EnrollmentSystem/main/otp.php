<?php 
session_start();
include "../dbcon.php";


if (!isset($_SESSION['verification_email'])) {
    header("Location: forgotpass.php");
    exit();
}

$email = $_SESSION['verification_email'];
$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verifyOTP'])) {
    $entered_otp = $_POST['otp'];

   
    $query = "SELECT OTP FROM useraccount WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_otp = $row['OTP'];

        if ($entered_otp == $stored_otp) {
            
            $_SESSION['otp_verified'] = true;
            header("Location: resetPass.php");
            exit();
        } else {
            $message = "<p class='error-message'>Invalid OTP. Please try again.</p>";
        }
    } else {
        $message = "<p class='error-message'>An error occurred. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Enter One-Time Pin</title>
  <link rel="stylesheet" href="vars.css">
  <link rel="stylesheet" href="otp-style.css">
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
    menu, ol, ul { 
      list-style-type: none; 
      margin: 0; 
      padding: 0; 
    }
    .error-message {
      color: red;
      font-size: 14px;
      margin-top: 10px;
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
    <img class="bg" src="./adminPic/image 1.png" alt="Background Image"/> 
    <h2>Enter One-Time Pin</h2>
  </div>
  <!-- OTP Box -->
  <div class="container">
    <form method="POST" action="">
      <div class="input-group"> 
        <input type="text" name="otp" id="otp" placeholder="Enter OTP" maxlength="6" required />
        <script>
          document.getElementById("otp").addEventListener("input", function (e) {
              this.value = this.value.replace(/\D/g, ''); 
          });
        </script>
        <img class="icon" src="./adminPic/otp.png" alt="OTP Icon" />
      </div> 

      <button type="submit" name="verifyOTP" style="background-color: #00008B; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer;" onmouseover="this.style.backgroundColor='#0000CD'" onmouseout="this.style.backgroundColor='#00008B'">
        Continue 
    </button>
      <?php echo $message; ?> 
    </form>
  </div>
</body>
</html>
<?php 
session_start();
include "../dbcon.php";


if (!isset($_SESSION['verification_email'])) {
    header("Location: forgotpass.php");
    exit();
}

$email = $_SESSION['verification_email'];
$message = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verifyOTP'])) {
    $entered_otp = $_POST['otp'];

   
    $query = "SELECT OTP FROM useraccount WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $stored_otp = $row['OTP'];

        if ($entered_otp == $stored_otp) {
            
            $_SESSION['otp_verified'] = true;
            header("Location: resetPass.php");
            exit();
        } else {
            $message = "<p class='error-message'>Invalid OTP. Please try again.</p>";
        }
    } else {
        $message = "<p class='error-message'>An error occurred. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Enter One-Time Pin</title>
  <link rel="stylesheet" href="vars.css">
  <link rel="stylesheet" href="otp-style.css">
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
    menu, ol, ul { 
      list-style-type: none; 
      margin: 0; 
      padding: 0; 
    }
    .error-message {
      color: red;
      font-size: 14px;
      margin-top: 10px;
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
    <img class="bg" src="./adminPic/image 1.png" alt="Background Image"/> 
    <h2>Enter One-Time Pin</h2>
  </div>
  <!-- OTP Box -->
  <div class="container">
    <form method="POST" action="">
      <div class="input-group"> 
        <input type="text" name="otp" id="otp" placeholder="Enter OTP" maxlength="6" required />
        <script>
          document.getElementById("otp").addEventListener("input", function (e) {
              this.value = this.value.replace(/\D/g, ''); 
          });
        </script>
        <img class="icon" src="./adminPic/otp.png" alt="OTP Icon" />
      </div> 

      <button type="submit" name="verifyOTP" style="background-color: #00008B; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer;" onmouseover="this.style.backgroundColor='#0000CD'" onmouseout="this.style.backgroundColor='#00008B'">
        Continue 
    </button>
      <?php echo $message; ?> 
    </form>
  </div>
</body>
</html>
