<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Profile - Edit</title>
  <link rel="stylesheet" href="adminProfileEdit-style.css">
</head>
<body>
<?php include "admin-sidebar.php"; ?>


<main>
    </div>
    </div>
    <div class="container">
      <!--------------- HEADER BOX ------------------->
      <header class="linear-header">
        <img src="./adminPic/giul.png" alt="profile" class="profile-img">
        <label for="fileInput" class="upload-btn" style="cursor: pointer;">
          + Upload Photo
        </label>
        <input type="file" id="fileInput" accept="image/*" style="display: none;">
        <script>
        const fileInput = document.getElementById('fileInput');
        fileInput.addEventListener('change', function() {
          if (fileInput.files.length > 0) {
            alert(`File selected: ${fileInput.files[0].name}`);
            // You can handle file upload here
          }
          });
        </script>
        <h1>Giuliani Calais</h1>
        <p>giulianicalais@example.com - Administrator</p>
      </header>
      <!--------------- PROFILE INFORMATION ------------------->
      <div class="profile-info">
        <div class="account-info">
        <h3>Account</h3>
        <form action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="gil">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="giulianicalais@example.com">

            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="Giuliani Calais">

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="0912 345 6789" maxlength="11" pattern="\d{11}" >
            <script>
            document.getElementById('phone').addEventListener('input', function (e) {
              this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11); 
            });
            </script>
            <button class="edit-btn">Save</button>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
