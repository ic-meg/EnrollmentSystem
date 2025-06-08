<?php
session_start();


include "../dbcon.php";
include "stud-sidebar.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

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

$enrollmentType = null;
$documents = [];

$enrolleeStmt = $conn->prepare("SELECT enrollment_type FROM enrollee WHERE user_id = ?");
$enrolleeStmt->bind_param("i", $user_id);
$enrolleeStmt->execute();
$enrolleeResult = $enrolleeStmt->get_result();
if ($enrolleeResult->num_rows > 0) {
  $enrollmentType = strtolower($enrolleeResult->fetch_assoc()['enrollment_type']);

  $validTables = ['freshmen', 'transferee', 'returnee', 'nonsequential'];
  if (in_array($enrollmentType, $validTables)) {
    $query = "SELECT * FROM `$enrollmentType` WHERE user_id = ?";
    $docStmt = $conn->prepare($query);
    $docStmt->bind_param("i", $user_id);
    $docStmt->execute();
    $docResult = $docStmt->get_result();
    if ($docResult->num_rows > 0) {
      $documents = $docResult->fetch_assoc();
    }
    $docStmt->close();
  }
}
$enrolleeStmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Oxford Academe | Student Profile</title>
  <link rel="stylesheet" href="Profile.css">
</head>
<style>
  .doc-button {
    display: block;
    width: 100%;
    background-color: #eeeeee;
    color: #000;
    text-align: left;
    padding: 12px 16px;
    margin-bottom: 8px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s ease;
  }

  .doc-button:hover {
    background-color: #e0e0e0;
  }
</style>

<body>
  <main>
    <div class="container">
      <div class="layout-left">
        <div class="section profile">
          <img src="../main/images/Profile.png" alt="Profile Picture">
          <div class="profile-info">
            <h2><?php echo htmlspecialchars((isset($profile['first_name']) ? $profile['first_name'] : '') . ' ' . (isset($profile['last_name']) ? $profile['last_name'] : '')); ?></h2>
          </div>
        </div>

        <div class="section upload-section">
          <h3>Uploaded Documents</h3>

          <?php if (!$enrollmentType): ?>
            <p style="color: gray;">No enrollment record found.</p>
          <?php elseif ($enrollmentType === 'freshmen'): ?>
            <?php if (!empty($documents['Form137'])): ?>
              <a href="../uploads/<?= $documents['Form137'] ?>" class="doc-button" target="_blank">Form 137</a>
            <?php endif; ?>
            <?php if (!empty($documents['Form138'])): ?>
              <a href="../uploads/<?= $documents['Form138'] ?>" class="doc-button" target="_blank">Form 138</a>
            <?php endif; ?>
            <?php if (!empty($documents['Picture'])): ?>
              <a href="../uploads/<?= $documents['Picture'] ?>" class="doc-button" target="_blank">1x1 Picture</a>
            <?php endif; ?>
          <?php elseif ($enrollmentType === 'transferee' || $enrollmentType === 'nonsequential'): ?>
            <?php if (!empty($documents['TOR'])): ?>
              <a href="../uploads/<?= $documents['TOR'] ?>" class="doc-button" target="_blank">TOR</a>
            <?php endif; ?>
            <?php if (!empty($documents['GoodMoral'])): ?>
              <a href="../uploads/<?= $documents['GoodMoral'] ?>" class="doc-button" target="_blank">Good Moral</a>
            <?php endif; ?>
          <?php elseif ($enrollmentType === 'returnee'): ?>
            <?php if (!empty($documents['TOR'])): ?>
              <a href="../uploads/<?= $documents['TOR'] ?>" class="doc-button" target="_blank">TOR</a>
            <?php endif; ?>
            <?php if (!empty($documents['MedCert'])): ?>
              <a href="../uploads/<?= $documents['MedCert'] ?>" class="doc-button" target="_blank">Medical Certificate</a>
            <?php endif; ?>
            <?php if (!empty($documents['IDPhoto'])): ?>
              <a href="../uploads/<?= $documents['IDPhoto'] ?>" class="doc-button" target="_blank">1x1 Picture</a>
            <?php endif; ?>
          <?php endif; ?>
        </div>


      </div>

      <div class="layout-right">
        <div class="section">
          <h3>Personal Information</h3>
          <hr><br>
          <div class="info-grid">
            <div><strong>Last Name:</strong> <?= htmlspecialchars(isset($profile['last_name']) ? $profile['last_name'] : '') ?></div>
            <div><strong>First Name:</strong> <?= htmlspecialchars(isset($profile['first_name']) ? $profile['first_name'] : '') ?></div>
            <div><strong>Middle Name:</strong> <?= htmlspecialchars(isset($profile['middle_name']) ? $profile['middle_name'] : '') ?></div>
            <div><strong>Suffix:</strong> -</div>
            <div><strong>Username:</strong> <?= htmlspecialchars(isset($_SESSION['username']) ? $_SESSION['username'] : 'N/A') ?></div>
            <div><strong>Birthdate:</strong> <?= htmlspecialchars(isset($profile['birthdate']) ? $profile['birthdate'] : '') ?></div>
            <div><strong>Place of Birth:</strong> <?= htmlspecialchars(isset($profile['birthplace']) ? $profile['birthplace'] : '') ?></div>
            <div><strong>Age:</strong> <?= htmlspecialchars(isset($profile['age']) ? $profile['age'] : '') ?></div>
            <div><strong>Email:</strong> <?= htmlspecialchars(isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A') ?></div>
            <div><strong>Phone:</strong> <?= htmlspecialchars(isset($profile['phone']) ? $profile['phone'] : '') ?></div>
          </div>
        </div>

        <div class="section">
          <h3>Emergency Information</h3>
          <div class="info-grid">
            <div><strong>Guardian Name:</strong> <?= htmlspecialchars(isset($profile['guardian_name']) ? $profile['guardian_name'] : '') ?></div>
            <div><strong>Contact No:</strong> <?= htmlspecialchars(isset($profile['guardian_contact']) ? $profile['guardian_contact'] : '') ?></div>
            <div><strong>Relationship:</strong> <?= htmlspecialchars(isset($profile['relationship']) ? $profile['relationship'] : '') ?></div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>

</html>