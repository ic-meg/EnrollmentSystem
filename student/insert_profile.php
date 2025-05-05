<?php
session_start();
include "../dbcon.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $first = $_POST['firstName'];
    $middle = $_POST['middleName'];
    $last = $_POST['lastName'];
    $birthdate = $_POST['birthdate'];
    $birthplace = $_POST['birthplace'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $guardian = $_POST['guardianName'];
    $guardianContact = $_POST['guardianContact'];
    $relationship = $_POST['relationship'];

    $stmt = $conn->prepare("INSERT INTO studentprofile 
        (user_id, first_name, middle_name, last_name, birthdate, birthplace, age, phone, guardian_name, guardian_contact, relationship) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssissss", 
        $user_id, $first, $middle, $last, $birthdate, $birthplace, $age, $phone, $guardian, $guardianContact, $relationship
    );

    if ($stmt->execute()) {
        echo "Student profile saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
