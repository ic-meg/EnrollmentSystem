<?php
include "../dbcon.php";
include "sessioncheck.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$name = "";
$email = "";

// Fetch user details from useraccount table
if ($user_id) {
    $query = "SELECT username, email FROM useraccount WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $name = htmlspecialchars($row['username']); // Escape for security
        $email = htmlspecialchars($row['email']);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $topic = mysqli_real_escape_string($conn, $_POST['topic']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (!$user_id) {
        echo "<script>alert('You need to be logged in to submit a support request.'); window.location.href='login.php';</script>";
        exit();
    }

    $sql = "INSERT INTO supportpage (user_id, Name, Email, Topic, userMessage, DateSubmitted, status) 
            VALUES ('$user_id', '$name', '$email', '$topic', '$message', NOW(), 'Pending')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Support request submitted successfully!'); window.location.href='studentSupport.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oxford Academe | Support Page</title>
  <link rel="stylesheet" href="support.css">
</head>
<body>
  <?php include "stud-sidebar.php"; ?>
  
  <main> 
    <div class="container">
      <section class="faq">
        <h2>Need some help?</h2>
        <div class="faq-item">
          <h3>How to Apply?</h3>
          <p class="faq-answer">Visit the Admissions page and follow the step-by-step guide to complete your application.</p>
        </div>
        <div class="faq-item">
          <h3>Can I edit my application after submission?</h3>
          <p class="faq-answer">Yes, you can edit your application until the submission deadline.</p>
        </div>
        <div class="faq-item">
          <h3>What documents do I need to apply?</h3>
          <p class="faq-answer">You will need your academic transcripts, a personal statement, letters of recommendation, and any standardized test scores required by the program.</p>
        </div>
        <div class="faq-item">
          <h3>Can I schedule a call with an admissions counselor?</h3>
          <p class="faq-answer">Yes, you can schedule a call with an admissions counselor through our contact page or by emailing us directly.</p>
        </div>
      </section>

      <section class="contact-form">
        <h2>Contact Support</h2>
        <form method="POST" action="">
        <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Name" disabled required>
        <input type="email" name="email" value="<?php echo $email; ?>" placeholder="Email" disabled required>

          <select name="topic" required>
            <option value="">Select Topic</option>
            <option value="Application Inquiry">Application Inquiry</option>
            <option value="Admissions Requirements">Admissions Requirements</option>
            <option value="Program Information">Program Information</option>
            <option value="Technical Support">Technical Support</option>
          </select>
          <textarea name="message" placeholder="Message" required></textarea>
          <button type="submit">Submit</button>
        </form>
      </section>
    </div>
  </main>

  <script>
    document.querySelectorAll('.faq-item h3').forEach(item => {
      item.addEventListener('click', () => {
        const answer = item.nextElementSibling;
        answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
      });
    });
  </script>
</body>
</html>