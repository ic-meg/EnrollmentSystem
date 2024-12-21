<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile | Admin Panel</title>
  <link rel="stylesheet" href="adminProfile-style.css">
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
        <h1>Giuliani Calais</h1>
        <p>giulianicalais@example.com - Administrator</p>
        <a href="adminProfileEdit.php"><button class="edit-btn">EDIT</button></a>
      </header>
      <!--------------- PROFILE INFORMATION ------------------->
      <div class="profile-info">
        <div class="account-info">
        <h3>Account</h3>
        <form action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="gil" disabled>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="giulianicalais@example.com" disabled>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" value="********" disabled>

            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="Giuliani Calais" disabled>

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" value="0912 345 6789" disabled>
          </form>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
