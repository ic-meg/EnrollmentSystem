document.addEventListener("DOMContentLoaded", function() {
    const emailInput = document.getElementById("email");
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("re-password");
    const signupBtn = document.getElementById("signup-btn");

    function validateInput(input, iconId, validationFn) {
        const icon = document.getElementById(iconId);
        if (validationFn(input.value)) {
            icon.innerHTML = "✔"; 
            icon.classList.add("valid");
            icon.classList.remove("invalid");
            return true;
        } else {
            icon.innerHTML = "❌"; // Cross
            icon.classList.add("invalid");
            icon.classList.remove("valid");
            return false;
        }
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validateUsername(username) {
        return username.length >= 3;
    }

    function validatePassword(password) {
        return /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(password);
    }

    function validateConfirmPassword() {
        return confirmPasswordInput.value === passwordInput.value && passwordInput.value !== "";
    }

    function checkFormValidity() {
        if (
            validateEmail(emailInput.value) &&
            validateUsername(usernameInput.value) &&
            validatePassword(passwordInput.value) &&
            validateConfirmPassword()
        ) {
            signupBtn.removeAttribute("disabled");
            signupBtn.classList.remove("disabled-btn");
        } else {
            signupBtn.setAttribute("disabled", "true");
            signupBtn.classList.add("disabled-btn");
        }
    }

    emailInput.addEventListener("input", () => {
        validateInput(emailInput, "email-icon", validateEmail);
        checkFormValidity();
    });

    usernameInput.addEventListener("input", () => {
        validateInput(usernameInput, "username-icon", validateUsername);
        checkFormValidity();
    });

    passwordInput.addEventListener("input", () => {
        validateInput(passwordInput, "password-icon", validatePassword);
        checkFormValidity();
    });

    confirmPasswordInput.addEventListener("input", () => {
        validateInput(confirmPasswordInput, "confirm-password-icon", validateConfirmPassword);
        checkFormValidity();
    });
});

document.addEventListener("DOMContentLoaded", function() {
const passwordInput = document.getElementById("password");
const lengthCriteria = document.getElementById("length-criteria");
const letterCriteria = document.getElementById("letter-criteria");
const numberCriteria = document.getElementById("number-criteria");
const uppercaseCriteria = document.createElement("p"); // Create a new element for uppercase criteria
uppercaseCriteria.classList.add("criteria-item");
uppercaseCriteria.id = "uppercase-criteria";
uppercaseCriteria.innerHTML = "🔴 at least one uppercase letter";
document.getElementById("password-criteria").appendChild(uppercaseCriteria);

passwordInput.addEventListener("input", function() {
    const password = passwordInput.value;

    // Check length
    if (password.length >= 8) {
        lengthCriteria.innerHTML = "🟢 at least 8 characters";
        lengthCriteria.classList.add("valid-criteria");
    } else {
        lengthCriteria.innerHTML = "🔴 at least 8 characters";
        lengthCriteria.classList.remove("valid-criteria");
    }

    // Check if it contains at least one letter
    if (/[A-Za-z]/.test(password)) {
        letterCriteria.innerHTML = "🟢 at least one letter";
        letterCriteria.classList.add("valid-criteria");
    } else {
        letterCriteria.innerHTML = "🔴 at least one letter";
        letterCriteria.classList.remove("valid-criteria");
    }

    // Check if it contains at least one number or special character
    if (/\d|[@$!%*?&]/.test(password)) {
        numberCriteria.innerHTML = "🟢 at least one number or special character";
        numberCriteria.classList.add("valid-criteria");
    } else {
        numberCriteria.innerHTML = "🔴 at least one number or special character";
        numberCriteria.classList.remove("valid-criteria");
    }

    // Check if it contains at least one uppercase letter
    if (/[A-Z]/.test(password)) {
        uppercaseCriteria.innerHTML = "🟢 at least one uppercase letter";
        uppercaseCriteria.classList.add("valid-criteria");
    } else {
        uppercaseCriteria.innerHTML = "🔴 at least one uppercase letter";
        uppercaseCriteria.classList.remove("valid-criteria");
    }
});
});
document.addEventListener("DOMContentLoaded", function () {
const passwordField = document.getElementById("password");
const eyeIcon = document.getElementById("togglePassword");
const eyeOpen = document.getElementById("eyeOpen");
const eyeClosed = document.getElementById("eyeClosed");

// Show eye icon only when the password field is focused or has content
passwordField.addEventListener("input", function () {
    if (passwordField.value.length > 0) {
        eyeIcon.style.display = "inline";
    } else {
        eyeIcon.style.display = "none";
    }
});

// Toggle password visibility
eyeIcon.addEventListener("click", function () {
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeOpen.style.display = "none";
        eyeClosed.style.display = "inline";
    } else {
        passwordField.type = "password";
        eyeOpen.style.display = "inline";
        eyeClosed.style.display = "none";
    }
});
});
document.addEventListener("DOMContentLoaded", function () {
const passwordField = document.getElementById("password");
const confirmPasswordField = document.getElementById("re-password");
const confirmPasswordIcon = document.getElementById("confirm-password-icon");
const passwordMatchMessage = document.getElementById("password-match-message");

const eyeConfirmIcon = document.getElementById("toggleConfirmPassword");
const eyeOpenConfirm = document.getElementById("eyeOpenConfirm");
const eyeClosedConfirm = document.getElementById("eyeClosedConfirm");

// Show eye icon only when the confirm password field has content
confirmPasswordField.addEventListener("input", function () {
    if (confirmPasswordField.value.length > 0) {
        eyeConfirmIcon.style.display = "inline";
    } else {
        eyeConfirmIcon.style.display = "none";
    }
});

// Toggle Confirm Password visibility
eyeConfirmIcon.addEventListener("click", function () {
    if (confirmPasswordField.type === "password") {
        confirmPasswordField.type = "text";
        eyeOpenConfirm.style.display = "none";
        eyeClosedConfirm.style.display = "inline";
    } else {
        confirmPasswordField.type = "password";
        eyeOpenConfirm.style.display = "inline";
        eyeClosedConfirm.style.display = "none";
    }
});

// Password Match Validation
function checkPasswordMatch() {
    if (confirmPasswordField.value === passwordField.value && confirmPasswordField.value !== "") {
        confirmPasswordIcon.textContent = "✔️"; // Match ✅
        confirmPasswordIcon.style.color = "green";
        passwordMatchMessage.style.display = "none";
    } else {
        confirmPasswordIcon.textContent = "❌"; // Not Match ❌
        confirmPasswordIcon.style.color = "red";
        passwordMatchMessage.style.display = confirmPasswordField.value.length > 0 ? "block" : "none";
    }
}

passwordField.addEventListener("input", checkPasswordMatch);
confirmPasswordField.addEventListener("input", checkPasswordMatch);
});