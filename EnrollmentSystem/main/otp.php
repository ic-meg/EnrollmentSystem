<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password - Enter one time pin</title>
  <link rel="stylesheet" href="vars.css">
  <link rel="stylesheet" href="otp-style.css">
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
    <h2>Enter one time pin</h2>
  </div>
  <!-- OTP Box -->
  <div class="container">
    <div class="input-group"> 
      <input type="text" id="otp" placeholder="Enter OTP" maxlength="6" required />
      <script>
        document.getElementById("otp").addEventListener("input", function (e) {
            // Remove any non-digit character
            this.value = this.value.replace(/\D/g, '');
        });
        </script>
      <img class="icon" src="./adminPic/otp.png" alt="People Icon" />
    </div> 

    <a href="resetPass.php"><button>CONTINUE</button></a>
  </div>
</body>
</html>