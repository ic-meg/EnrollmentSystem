<?php
session_start();
include "../dbcon.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailOrUsername = trim($_POST['emailOrUsername']);
    $password = trim($_POST['password']);
    $errors = [];

    if (empty($emailOrUsername) || empty($password)) {
        $errors[] = "All fields are required.";
    } else {
        // Check if user is an admin first
        $stmt = $conn->prepare("SELECT * FROM adminaccount WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
        $stmt->execute();
        $adminResult = $stmt->get_result();

        if ($adminResult->num_rows === 1) {
            $admin = $adminResult->fetch_assoc();

            if (password_verify($password, $admin['password'])) {
                // Set admin session
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['email'] = $admin['email'];
                $_SESSION['Role'] = $admin['Role']; // <-- Use the Role from the database

                header("Location: http://localhost/EnrollmentSystem/admin/adminDashboard.php");
                exit();
            } else {
                $errors[] = "Incorrect password.";
            }
        } else {
            // If not an admin, check student/user accounts
            $stmt = $conn->prepare("SELECT * FROM useraccount WHERE email = ? OR username = ?");
            $stmt->bind_param("ss", $emailOrUsername, $emailOrUsername);
            $stmt->execute();
            $userResult = $stmt->get_result();

            if ($userResult->num_rows === 1) {
                $user = $userResult->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    // Set user session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];

                    header("Location: http://localhost/EnrollmentSystem/student/studDashboard.php");
                    exit();
                } else {
                    $errors[] = "Incorrect password.";
                }
            } else {
                $errors[] = "No account found with that email or username.";
            }
        }
    }

    $_SESSION['errors'] = $errors;
    header("Location: signin.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oxford Academe | Sign in</title>
  <link rel="stylesheet" href="vars.css">
  <link rel="stylesheet" href="resetPass-style.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
  .input-field {
    position: relative;
    display: flex;
    align-items: center;
}

.eye-icon {
    position: absolute;
    right: 10px;
    cursor: pointer;
    color: #888;
}

.eye-icon:hover {
    color: #000;
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
  <a href="index.php"><img class="bg" src="./adminPic/image 1.png" alt="Background Image"/> </a>
  <h2>Welcome to  <span style="color: #2DB2FF;">oxfo</span><span style="color: black;">rd</span> Academe</h2>
  </div>

  <!-- Email Box -->
  <div class="container">
  <form method="POST" action="signin.php">
    <div class="input-group">
        <div class="input-field">
            <input type="text" name="emailOrUsername" placeholder="Email or Username" required />
            <img class="icon" src="./adminPic/people-10.png" alt="People Icon" />
        </div>

        <div class="input-field">
            <input type="password" id="password" name="password" placeholder="Password" required />
            <!-- <img class="icon" src="./adminPic/lock.png" alt="Lock Icon" /> -->
            <div class="eye-icon" id="togglePassword">
                <i class="fas fa-eye" id="eyeOpen"></i>
                <i class="fas fa-eye-slash" id="eyeClosed" style="display: none;"></i>
        </div>



</div>

    </div>

    <button type="submit" name="signin" style="background-color: #00008B; color: white; padding: 10px 20px; border-radius: 5px; cursor: pointer;" onmouseover="this.style.backgroundColor='#0000CD'" onmouseout="this.style.backgroundColor='#00008B'">
        Sign in
    </button>
    <br><br>

    <div class="forgot" style="text-align: right;">
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        <p><a href="forgotPass.php" style="color: white;">Forgot password</a></p>
    </div>
<br>

    <?php
    // Display error messages
    if (isset($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        unset($_SESSION['errors']);
    }
    ?>
</form>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const passwordField = document.getElementById('password');
    const eyeIcon = document.getElementById('togglePassword');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');

 
    passwordField.addEventListener('input', function () {
        if (passwordField.value.length > 0) {
            eyeIcon.style.display = 'block';  
        } else {
            eyeIcon.style.display = 'none';   
        }
    });

 
    eyeIcon.addEventListener('click', function () {
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeOpen.style.display = 'none';
            eyeClosed.style.display = 'inline';
        } else {
            passwordField.type = 'password';
            eyeOpen.style.display = 'inline';
            eyeClosed.style.display = 'none';
        }
    });
});

</script>
  </div>
</body>
</html>