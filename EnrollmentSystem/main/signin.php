<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username == "admin" && $password == "admin") {
    header("Location: http://localhost/EnrollmentSystem/admin/adminDashboard.php");
    exit();
  } elseif ($username == "student" && $password == "student") {
    header("Location: http://localhost/EnrollmentSystem/student/studDashboard.php");
    exit();
  } else {
    $error = "Invalid credentials. Please try again.";
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
  <link rel="stylesheet" href="resetPass-style.css">
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
  <h2>Welcome to  <span style="color: #2DB2FF;">oxfo</span><span style="color: black;">rd</span> Academe</h2>
  </div>

  <!-- Email Box -->
  <div class="container">
  <form method="POST" action="">
    <div class="input-group"> 
    <div class="input-field">
      <input type="text" name="username" placeholder="Email or Control Number" required />
      <img class="icon" src="./adminPic/people-10.png" alt="People Icon" />
    </div>
    <div class="input-field">
      <input type="password" name="password" placeholder="Password" required />
      <img class="icon" src="./adminPic/lock.png" alt="Lock Icon" />
    </div>
    </div> 

    <button type="submit">Sign in</button> <br> <br>
    <div class="forgot" style="text-align: right;">
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    <p><a href="forgotPass.php" style="color: white;">Forgot password</a></p>
    </div>
    <?php if (isset($error)): ?>
    <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
  </form>
  </div>
</body>
</html>