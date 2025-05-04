<?php
session_start();
include "../dbcon.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['verification_email'])) {
        $_SESSION['error'] = "Session expired. Please restart the password reset process.";
        header("Location: resetPass.php");
        exit;
    }

    $email = $_SESSION['verification_email'];
    $table = $_SESSION['account_type']; 
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $errors = [];

    if (empty($new_password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    }

    if ($new_password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $new_password)) {
        $errors[] = "Password must be at least 8 characters long and include at least one uppercase letter, a lowercase letter, a number, and a special character.";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_query = "UPDATE $table SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            unset($_SESSION['verification_email']);
            $_SESSION['success'] = "";
            header("Location: signin.php");
            exit;
        } else {
            $errors[] = "Failed to update password. Please try again.";
        }
    }

    $_SESSION['errors'] = $errors;
    header("Location: resetPass.php");
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Update your password</title>
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
    #password-criteria {
        text-align: left;
        font-size: 14px;
        margin-top: 10px;
    }

    .criteria-item {
        padding: 5px;
        font-weight: bold;
        border-radius: 5px;
        transition: 0.3s ease;
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
    <h2>Update your password!</h2> 
  </div>
  <!-- Email & Pass Box -->
  <div class="container">
    <form action="resetPass.php" method="POST">
        <div class="input-group"> 
            <div class="input-field">
                <input type="email" name="email" value="<?php echo $_SESSION['verification_email']; ?>" readonly required />
                <img class="icon" src="./adminPic/people-10.png" alt="People Icon" />
            </div>

            <!-- Password Field with Criteria -->
            <div id="password-criteria">
                <div class="input-field">
                    <input type="password" name="new_password" id="new_password" placeholder="New Password" required />
                    <span class="eye-icon" id="toggleNewPassword">
                        <i class="fas fa-eye" id="eyeOpenNew"></i>
                        <i class="fas fa-eye-slash" id="eyeClosedNew" style="display: none;"></i>
                    </span>
                </div>
                <div id="password-criteria-container" style="display: none;">
                    <p>Criteria</p>
                    <p class="criteria-item" id="length-criteria">🔴 At least 8 characters</p>
                    <p class="criteria-item" id="uppercase-criteria">🔴 At least one uppercase letter</p>
                    <p class="criteria-item" id="lowercase-criteria">🔴 At least one lowercase letter</p>
                    <p class="criteria-item" id="number-criteria">🔴 At least one number</p>
                    <p class="criteria-item" id="special-criteria">🔴 At least one special character (@$!%*?&)</p>
                </div>

            </div>

            <!-- Confirm Password -->
            <div class="input-field">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required />
                <span class="eye-icon" id="toggleConfirmPassword">
                    <i class="fas fa-eye" id="eyeOpenConfirm"></i>
                    <i class="fas fa-eye-slash" id="eyeClosedConfirm" style="display: none;"></i>
                </span>
            </div>
        </div> 

        <button type="submit" id="update-btn" class="disabled-btn" disabled>UPDATE PASSWORD</button>

       
        <?php
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<p class='error-message'>$error</p>";
            }
            unset($_SESSION['errors']);
        }

        if (isset($_SESSION['success'])) {
            echo "<p class='success-message'>{$_SESSION['success']}</p>";
            unset($_SESSION['success']);
        }
        ?>
    </form>
</div>

</body>
</html>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const passwordField = document.getElementById("new_password");
    const confirmPasswordField = document.getElementById("confirm_password");
    const updateButton = document.getElementById("update-btn");

    // Password criteria elements
    const lengthCriteria = document.getElementById("length-criteria");
    const uppercaseCriteria = document.getElementById("uppercase-criteria");
    const lowercaseCriteria = document.getElementById("lowercase-criteria");
    const numberCriteria = document.getElementById("number-criteria");
    const specialCriteria = document.getElementById("special-criteria");

    // Password visibility toggle
    document.getElementById("toggleNewPassword").addEventListener("click", function () {
        togglePasswordVisibility(passwordField, "eyeOpenNew", "eyeClosedNew");
    });

    document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
        togglePasswordVisibility(confirmPasswordField, "eyeOpenConfirm", "eyeClosedConfirm");
    });

    function togglePasswordVisibility(field, eyeOpenId, eyeClosedId) {
        const eyeOpen = document.getElementById(eyeOpenId);
        const eyeClosed = document.getElementById(eyeClosedId);

        if (field.type === "password") {
            field.type = "text";
            eyeOpen.style.display = "none";
            eyeClosed.style.display = "inline";
        } else {
            field.type = "password";
            eyeOpen.style.display = "inline";
            eyeClosed.style.display = "none";
        }
    }

    // Password validation logic
    passwordField.addEventListener("input", function () {
        const password = passwordField.value;

        validateCriteria(lengthCriteria, password.length >= 8);
        validateCriteria(uppercaseCriteria, /[A-Z]/.test(password));
        validateCriteria(lowercaseCriteria, /[a-z]/.test(password));
        validateCriteria(numberCriteria, /\d/.test(password));
        validateCriteria(specialCriteria, /[@$!%*?&]/.test(password));

        checkPasswordMatch();
    });

    confirmPasswordField.addEventListener("input", checkPasswordMatch);

    function checkPasswordMatch() {
        if (passwordField.value === confirmPasswordField.value && passwordField.value.length >= 8) {
            updateButton.classList.remove("disabled-btn");
            updateButton.removeAttribute("disabled");
        } else {
            updateButton.classList.add("disabled-btn");
            updateButton.setAttribute("disabled", "true");
        }
    }

    function validateCriteria(element, isValid) {
        if (isValid) {
            element.innerHTML = "✅ " + element.textContent.slice(2);
            element.classList.add("valid-criteria");
            element.classList.remove("invalid-criteria");
        } else {
            element.innerHTML = "🔴 " + element.textContent.slice(2);
            element.classList.add("invalid-criteria");
            element.classList.remove("valid-criteria");
        }
    }
});
document.addEventListener("DOMContentLoaded", function () {
  const passwordField = document.getElementById("new_password");
  const criteriaContainer = document.getElementById("password-criteria-container");

  // Show criteria when focused
  passwordField.addEventListener("focus", () => {
    criteriaContainer.style.display = "block";
  });

  // Hide criteria when unfocused
  passwordField.addEventListener("blur", () => {
    setTimeout(() => {
      criteriaContainer.style.display = "none";
    }, 200); // Delay to allow clicking inside container if needed
  });
});

</script>