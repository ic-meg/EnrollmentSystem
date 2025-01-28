<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student - Template</title>
  <link rel="stylesheet" href="stud-payment.css">
</head>
<body>
<?php include "stud-sidebar.php"; ?>


<main>
    
    <!-- WAG TANGGALIN MAIN AT CONTAINER-->
    <div class="container">
      <!--Content here-->
      <div class="main--container">
        <!-- Left Section -->
        <div class="payment-section">
        <h1>Payment</h1>

        <!-- Payment Methods -->
        <div class="payment-method">
            <h2>Choose payment method</h2>
            <div class="methods">
            <img src="paypal.jpg" alt="PayPal">
            <img src="gcash.png" alt="GCash">
            <span>Cash</span>
            </div>
        </div>

        <!-- Credit/Debit Card Section -->
        <div class="card-payment">
            <h2>Credit/Debit Card</h2>
            <div class="card-icons">
            <img src="visa-logo.png" alt="Visa">
            <img src="master-card.jpg" alt="MasterCard">
            <img src="apple-pay.png" alt="Apple Pay">
            </div>
            <form>
            <div class="form-row">
                <input type="email" placeholder="Email">
                <input type="text" placeholder="Card Holder Name">
            </div>
            <div class="form-row">
                <input type="text" placeholder="Expiration">
                <input type="text" placeholder="CVV code">
            </div>
            <input type="text" placeholder="Amount">
            </form>
        </div>
        </div>

        <!-- Right Section -->
        <div class="summary-section">
        <h2>Payment setting</h2>
        <p><strong>Type of transaction</strong></p>
        <p class="transaction-type"><img src="mastercard-logo.png" alt="MasterCard"> Debit Card</p>
        <hr>
        <p><strong>Transaction date</strong>: 04-21-2020</p>
        <p><strong>Transaction number</strong>: 0000-0000-000</p>
        <p><strong>Account Balance</strong>: 987,654.32</p>
        <p><strong>Total paid</strong>: 123,456.78</p>
        <hr>
        <button class="confirm-btn">CONFIRM</button>
        </div>
    </div>
    </div>   
    
  </main>

</body>
</html>