<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Sign-Up</title>
    <link rel="stylesheet" href="sign-up.css">
</head>
<style>
    body{
        background-color: #2148c0;
    }

    .welcome-section{
        background-color: #2148c0;
    }
</style>
<body>  
    
    <div class="container">
        
        <div class="welcome-section">
            <h1>WELCOME<br>STUDENTS!</h1>
        </div>
        <div class="form-section">
            <div class="icon">
                <img src="signuplogo.png" alt="logo">
            </div>
            <form>
                <label for="control-number">Control Number</label>
                <input type="text" id="control-number" required>

                <label for="email">Email</label>
                <input type="email" id="email" required>

                <label for="password">Password</label>
                <input type="password" id="password" required>

                <label for="re-password">Re-enter Password</label>
                <input type="password" id="re-password" required>

                <p class="signin-link">Already have an account? <a href="signin.php">Sign in</a></p>

                <button type="submit" class="signup-btn">Sign Up</button>
            </form>
        </div>
    </div>
</body>
</html>
