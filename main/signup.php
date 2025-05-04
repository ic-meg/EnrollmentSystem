<?php 
    session_start();
    include "../dbcon.php";

    if(isset($_POST['signup'])) {
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['re-password'];
        $errors = [];

        if(empty($email) || empty($username) || empty($password) || empty($confirmPassword)) {
            $errors[] = "All fields are required.";
        }

        if($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            $errors[] = "Password must be at least 8 characters long and include at least one uppercase letter, a lowercase letter, a number, and a special character.";
        }
        
        $stmt = $conn->prepare("SELECT * FROM useraccount WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $errors[] = "Email or Username already exists. Try a different one.";
        }

        if(empty($errors)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("INSERT INTO useraccount (email, username, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $username, $hashedPassword);

            if($stmt->execute()) {
                $_SESSION['success'] = "Registration successful! You can now Sign in</a>";
                header("Location: signup.php");
                exit();
            } else {
                $errors[] = "Error: " . $stmt->error;
            }
        }

        $_SESSION['errors'] = $errors;
        header("Location: signup.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oxford Academe | Sign Up</title>
    <link rel="stylesheet" href="sign-up.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="signup.js"></script>
</head>
<style>
    body {
        background-color: #2148c0;
    }

    #password-criteria {
        font-size: 14px;
    }

    .criteria-item {
        padding: 5px;
        margin: 5px 0;
        font-weight: bold;
        border-radius: 5px;
        transition: 0.3s ease;
    }

    .valid-criteria {
        color: #27ae60; /* Green */
        background-color: rgba(39, 174, 96, 0.2);
    }

    .invalid-criteria {
        color: #e74c3c; /* Red */
        background-color: rgba(231, 76, 60, 0.2);
    }

    .valid-icon {
        font-size: 16px;
        font-weight: bold;
        margin-left: 8px;
    }

    .valid {
        color: green;
    }

    .invalid {
        color: red;
    }

    .disabled-btn {
        background-color: gray !important;
        cursor: not-allowed;
    }

    .error-message {
        color: red; 
        font-size: 14px;
        margin-top: 10px;
        text-align: center;
        font-weight: bold;
        padding: 8px;
        display: inline-block; 
    }

    .success-message {
        color: green;
        font-size: 14px;
        margin-top: 10px;
        text-align: center;
    }
    .input-field {
        position: relative;
        display: flex;
        align-items: center;
    }

    .eye-icon {
        position: absolute;
        right: 10px;
        top: 10px;
        cursor: pointer;
        color: #888;
        display: none; 
    }

    .eye-icon:hover {
        color: #000;
    }

    #password {
        padding-right: 30px;
    }
    .valid-icon {
    font-size: 1rem;
    margin-left: 5px;
}

</style>

<body>  
    <div class="container">
        <div class="welcome-section">

        <h1>WELCOME<br>STUDENTS!</h1>

        </div>

        <div class="form-section">
            <div class="icon">
                <a href="index.php"><img src="signuplogo.png" alt="logo"></a>
            </div>
            <form action="signup.php" method="POST">
            <label for="email">*Email <span id="email-icon" class="valid-icon"></span></label>
            <input type="email" name="email" id="email" required>

            <label for="username">*Username <span id="username-icon" class="valid-icon"></span></label>
            <input type="text" name="username" id="username" required>

            <div id="password-criteria">    
            <label for="password">*Password</label>
            <div class="input-field">
                <input type="password" name="password" id="password" required>
                <span class="eye-icon" id="togglePassword">
                    <i class="fas fa-eye" id="eyeOpen"></i>
                    <i class="fas fa-eye-slash" id="eyeClosed" style="display: none;"></i>
                </span>
            </div>
            <p>Criteria</p>
            <p class="criteria-item" id="length-criteria">🔴 at least 8 characters</p>
            <p class="criteria-item" id="letter-criteria">🔴 at least one letter</p>
            <p class="criteria-item" id="number-criteria">🔴 at least one number or special character</p>
        </div> 

        <div id="confirm-password-container">    
            <label for="re-password">*Confirm Password <span id="confirm-password-icon" class="valid-icon"></span></label>
            
            <div class="input-field">
                <input type="password" name="re-password" id="re-password" required>
                <span class="eye-icon" id="toggleConfirmPassword">
                    <i class="fas fa-eye" id="eyeOpenConfirm"></i>
                    <i class="fas fa-eye-slash" id="eyeClosedConfirm" style="display: none;"></i>
                </span>
            </div>

        </div>

                <!-- <small style="text-align: justify;">
                    Note: Please use a strong password with at least 8 characters, including uppercase, lowercase, numbers, and special characters.
                </small> -->

                <p class="signin-link">Already have an account? <a href="signin.php">Sign in</a></p>

                <button type="submit" class="signup-btn disabled-btn" name="signup" id="signup-btn" disabled>Sign Up</button>

            <?php 
                 
                 if(isset($_SESSION['errors'])) {
                     foreach($_SESSION['errors'] as $error) {
                         echo "<p class='error-message'>$error</p>";
                     }
                     unset($_SESSION['errors']);
                 }

                 if(isset($_SESSION['success'])) {
                     echo "<p class='success-message'>".$_SESSION['success']."</p>";
                     unset($_SESSION['success']);
                 }
             ?>
 
            </form>
        </div>
    </div>
</body>
</html>



