<?php
$password = "Shanshan"; // Your plain-text password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: " . $hashedPassword;
?>
