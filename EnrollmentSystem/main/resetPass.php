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
    <h2>you can now update your password!</h2>
  </div>
  <!-- Email & Pass Box -->
  <div class="container">
      <div class="input-group"> 
          <div class="input-field">
              <input type="email" placeholder="Email" required />
              <img class="icon" src="./adminPic/people-10.png" alt="People Icon" />
          </div>
          <div class="input-field">
              <input type="password" placeholder="Password" required />
              <img class="icon" src="./adminPic/lock.png" alt="Lock Icon" />
          </div>
      </div> 
    <!-- Button -->
    <a href="signin.php"><button>UPDATE PASSWORD</button></a>
  </div>
</body>
</html>