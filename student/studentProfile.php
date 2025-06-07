<?php
session_start();


include "../dbcon.php"; 
include "stud-sidebar.php";

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo "<p style='color: red;'>User not logged in.</p>";
    exit;
}

$sql = "SELECT * FROM studentprofile WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

if (!$profile) {
    echo "<p style='color: red;'>No student profile found for this user.</p>";
    $profile = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Oxford Academe | Student Profile</title>
  <link rel="stylesheet" href="Profile.css">
</head>
<body>
<main>
  <div class="container">
    <div class="layout-left">
      <div class="section profile">
        <img src="../main/images/Profile.png" alt="Profile Picture">
        <div class="profile-info">
          <h2><?= htmlspecialchars(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')) ?></h2>
        </div>
      </div>

      <div class="section upload-section">
        <h3>Uploaded Documents</h3>
        <button class="doc-button">Application Form</button>
        <button class="doc-button">Form 137</button>
        <button class="doc-button">Birth Certificate</button>
        <button class="doc-button">1x1 Picture</button>
        <button class="submit-button">Edit</button>
      </div>
    </div>

    <div class="layout-right">
      <div class="section">
        <h3>Personal Information</h3>
        <hr><br>
        <div class="info-grid">
          <div><strong>Last Name:</strong> <?= htmlspecialchars($profile['last_name'] ?? '') ?></div>
          <div><strong>First Name:</strong> <?= htmlspecialchars($profile['first_name'] ?? '') ?></div>
          <div><strong>Middle Name:</strong> <?= htmlspecialchars($profile['middle_name'] ?? '') ?></div>
          <div><strong>Suffix:</strong> -</div>
          <div><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username'] ?? 'N/A') ?></div>
          <div><strong>Birthdate:</strong> <?= htmlspecialchars($profile['birthdate'] ?? '') ?></div>
          <div><strong>Place of Birth:</strong> <?= htmlspecialchars($profile['birthplace'] ?? '') ?></div>
          <div><strong>Age:</strong> <?= htmlspecialchars($profile['age'] ?? '') ?></div>
          <div><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email'] ?? 'N/A') ?></div>
          <div><strong>Phone:</strong> <?= htmlspecialchars($profile['phone'] ?? '') ?></div>
        </div>
      </div>

      <div class="section">
        <h3>Emergency Information</h3>
        <div class="info-grid">
          <div><strong>Guardian Name:</strong> <?= htmlspecialchars($profile['guardian_name'] ?? '') ?></div>
          <div><strong>Contact No:</strong> <?= htmlspecialchars($profile['guardian_contact'] ?? '') ?></div>
          <div><strong>Relationship:</strong> <?= htmlspecialchars($profile['relationship'] ?? '') ?></div>
        </div>
      </div>
    </div>
  </div>
</main>
</body>
</html>
