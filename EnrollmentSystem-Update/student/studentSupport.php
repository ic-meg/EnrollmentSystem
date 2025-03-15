<?php
include "../dbcon.php";
include "sessioncheck.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oxford Academe | Support Page</title>
  <link rel="stylesheet" href="Support.css">
</head>
<body>
  <?php include "stud-sidebar.php"; ?>
  <main> 
  </div>
  </div>
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
        <form>
          <input type="text" name="name" placeholder="Name">
          <input type="email" name="email" placeholder="Email">
          <select name="topic">
            <option value="">Select Topic</option>
            <option value="">Application Inquiry</option>
            <option value="">Admissions Requirements</option>
            <option value="">Program Information</option>
            <option value="">Technical Support</option>
          </select>
          <textarea name="message" placeholder="Message"></textarea>
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