<?php 
include "session_check.php";
include '../dbcon.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
  header("Location: signin.php");
  exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $admin_id = $_SESSION['admin_id'];
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
  $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  
  // Handle file upload
  if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
      $uploadDir = 'adminPic/';
      if (!file_exists($uploadDir)) {
          mkdir($uploadDir, 0777, true);
      }
      
      $fileName = basename($_FILES['profile_pic']['name']);
      $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
      
      if (in_array($fileExt, $allowedExts)) {
          $newFileName = 'admin_' . $admin_id . '_' . time() . '.' . $fileExt;
          $uploadPath = $uploadDir . $newFileName;
          
          if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadPath)) {
              // Update profile picture in database
              $updatePicQuery = "UPDATE adminaccount SET profile_pic = '$uploadPath' WHERE admin_id = '$admin_id'";
              mysqli_query($conn, $updatePicQuery);
          }
      }
  }
  
  // Update other profile information
  $updateQuery = "UPDATE adminaccount SET 
                  username = '$username', 
                  email = '$email', 
                  FirstName = '$firstName', 
                  LastName = '$lastName', 
                  PhoneNumber = '$phone' 
                  WHERE admin_id = '$admin_id'";
  
  if (mysqli_query($conn, $updateQuery)) {
      header("Location: adminProfile.php");
      exit();
  } else {
      $error = "Error updating profile: " . mysqli_error($conn);
  }
}

// Fetch admin data
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM adminaccount WHERE admin_id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Profile - Edit</title>
  <link rel="stylesheet" href="adminProfileEdit-style.css">
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
    .upload-btn-wrapper {
      text-align: center;
    }
    .upload-btn {
      background-color: #ffffff;
      color:rgb(85, 138, 243);
      border: none;
      padding: 8px 15px;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }
 
    .edit-btn {
      background-color: rgb(85, 138, 243);
      color: #ffffff;
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
  <div class="container">
    <?php if (isset($error)): ?>
      <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <!--------------- HEADER BOX ------------------->
<header class="linear-header">
  <form method="POST" enctype="multipart/form-data" id="profileForm">
    <img src="<?php echo !empty($admin['profile_pic']) ? $admin['profile_pic'] : './adminPic/default.png'; ?>" alt="profile" class="profile-img" id="profileImage">
    <div style="margin-top: 10px; text-align: center;">
      <label for="profile_pic" class="upload-btn" style="cursor: pointer; display: inline-block; padding: 8px 12px; border-radius: 4px;">
        + Upload Photo
      </label>
      <input type="file" id="profile_pic" name="profile_pic" accept="image/*" style="display: none;" onchange="previewImage(this)">
    </div>
    <h1><?php echo htmlspecialchars($admin['FirstName'] . ' ' . $admin['LastName']); ?></h1>
    <p style="margin-top: 30px;"><?php echo htmlspecialchars($admin['email']); ?> - <?php echo htmlspecialchars($admin['Role']); ?></p>
</header>

<!--------------- PROFILE INFORMATION ------------------->
<div class="profile-info">
  <div class="account-info">
    <h3>Account</h3>
      <!-- Other Profile Fields -->
      <label for="username">Username</label>
      <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>

      <label for="firstName">First Name</label>
      <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($admin['FirstName']); ?>" required>

      <label for="lastName">Last Name</label>
      <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($admin['LastName']); ?>" required>

      <label for="phone">Phone Number</label>
      <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($admin['PhoneNumber']); ?>" maxlength="11" pattern="\d{11}" required>
      
      <button type="submit" class="edit-btn">Save Changes</button>
    </form>
  </div>
</div>
  </div>
</main>

<script>
// Preview image before upload
function previewImage(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('profileImage').src = e.target.result;
    }
    reader.readAsDataURL(input.files[0]);
  }
}

// Phone number validation
document.getElementById('phone').addEventListener('input', function (e) {
  this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11); 
});
</script>
</body>
</html>