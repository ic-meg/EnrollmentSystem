<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile | Admin Panel</title>
  <link rel="stylesheet" href="adminProfile-style.css">
  <style>
    .success-message {
      color: green;
      padding: 10px;
      margin-bottom: 15px;
      background-color: #eeffee;
      border-radius: 4px;
    }

    .error-message {
      color: red;
      padding: 10px;
      margin-bottom: 15px;
      background-color: #ffeeee;
      border-radius: 4px;
    }

    .profile-img-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 20px;
    }

    .profile-img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid white;
      margin-bottom: 10px;
    }

    .edit-btn {
      background-color: #ffffff;
      color: rgb(85, 138, 243);
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 15px;
    }
  </style>
</head>

<body>
  <?php include "admin-sidebar.php"; ?>

  <main>
    </div>
    </div>
    <?php
    include "session_check.php";
    include '../dbcon.php';

    $admin_id = $_SESSION['admin_id'];


    $stmt = $conn->prepare("SELECT * FROM adminaccount WHERE admin_id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();


    if (!$result || $result->num_rows === 0) {
      die("No admin record found for ID: " . htmlspecialchars($admin_id));
    }

    $admin = $result->fetch_assoc();
    ?>
    <div class="container">
      <?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
        <div class="success-message">Profile updated successfully!</div>
      <?php endif; ?>

      <!--------------- HEADER BOX ------------------->
      <header class="linear-header">
        <img src="<?php echo !empty($admin['profile_pic']) ? $admin['profile_pic'] : './adminPic/default.png'; ?>" alt="profile" class="profile-img">
        <h1><?php echo htmlspecialchars($admin['FirstName'] . ' ' . $admin['LastName']); ?></h1>
        <p><?php echo htmlspecialchars($admin['email']); ?> - <?php echo htmlspecialchars($admin['Role']); ?></p>
        <a href="adminProfileEdit.php"><button class="edit-btn">Edit Profile</button></a>
      </header>

      <!--------------- PROFILE INFORMATION ------------------->
      <div class="profile-info">
        <div class="account-info">
          <h3>Account Information</h3>
          <form action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" disabled>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" disabled>

            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($admin['FirstName'] . ' ' . $admin['LastName']); ?>" disabled>

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($admin['PhoneNumber']); ?>" disabled>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>

</html>