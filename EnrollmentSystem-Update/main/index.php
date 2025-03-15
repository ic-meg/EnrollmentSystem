<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oxford Academe</title>
  <link rel="stylesheet" href="guest.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<style>
.hero-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    color: white;
    background: url('images/campus1.png') no-repeat center center;
    background-size: cover;
    position: relative;
}

.hero-section::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.15);  /* Adjust the alpha value (0.15 here) to control opacity */
    z-index: -1;
}

</style>
</style>
</style>
<header>
    <h1>
        <span class="oxfo">oxfo</span><span class="rd">rd.</span>
    </h1>  
    <nav>
    <a href="signup.php">Sign Up</a>
    <a href="signin.php" style="text-decoration: none; "><button class="button">Sign In</button></a>
  </nav>
</header>

<div class="hero-section">
    <div class="image-container">
      <img class="hero-image" src="images/walkinggirl.png" alt="College Campus">
    </div>
    <div class="hero-content">
    <h2>Online Enrollment For College Ongoing!</h2>
    <p>Live Your Vision & Create Your Tomorrow!<br>
       Accepting freshmen, transferees, ALS passers, and foreign students.</p>
         <button class="button"><a href="signin.php" style="color: white; text-decoration: none;">Enroll Now!</a></button>
    </div>
</div>

<section class="about-section">
  <h2>About Oxford Academe</h2>
  <p>Oxford is a pioneer in innovative education, offering a range of programs designed to prepare students for success in a rapidly evolving world.</p>
</section>

<section class="mission-section">
    <div class="image-container">
        <div class="image-item">
            <img class="mission-image" src="images/mission.png" alt="Mission">
            <h2>Mission</h2>
            <p>Our mission is to create a nurturing 
                and inclusive environment that 
                empowers students to reach their 
                full potential and fosters a lifelong 
                love of learning.</p>
        </div>
        <div class="image-item">
            <img class="mission-image" src="images/vision.png" alt="Vision">
            <h2>Vision</h2>
            <p>Our vision is to be a leading educational institution that inspires innovation, promotes excellence, and cultivates responsible global citizens.</p>
        </div>
        <div class="image-item">
            <img class="mission-image" src="images/quality.png" alt="Quality Policy">
            <h2>Quality Policy</h2>
            <p>We are dedicated to providing high-quality education and support services, continuously improving our methods and engaging with the community to ensure student success.</p>
        </div>
    </div>
</section>

<section class="programs-section">
    <h2>PROGRAMS OFFERED</h2>
    <div class="image-container">
        <div class="programs-item">
            <img class="programs-image" src="images/computer.png" alt="Program 2">
            <h5>College of Computer Studies</h5>
            <p>BSIT, BSCS</p>
        </div>
        <div class="programs-item">
            <img class="programs-image" src="images/education.png" alt="Program 2">
            <h5>College of Education</h5>
            <p>BEED, BSEd, BECEd</p>
        </div>
        <div class="programs-item">
            <img class="programs-image" src="images/business.png" alt="Program 3">
            <h5>College of Business Administration</h5>
            <p>Business Administration, Acountancy</p>
        </div>
        <div class="programs-item">
            <img class="programs-image" src="images/sciences.png" alt="Program 3">
            <h5>College of Arts and Sciences</h5>
            <p>Psychology, Mass Comm</p>
        </div>
    </div>
</section>

<section class="guide-section">
    <h2>Step-by-step Guide for Online Enrollment</h2>
    <div class="image-container">
        <div class="guide-item">
            <img class="guide-image" src="images/first.png" alt="Program 1">
            <h5>Create an Account</h5>
        </div>
        <div class="guide-item">
            <img class="guide-next" src="images/next.png">
        </div>
        <div class="guide-item">
            <img class="guide-image" src="images/second.png" alt="Program 1">
            <h5>Complete the Application</h5>
        </div>
        <div class="guide-item">
            <img class="guide-next" src="images/next.png">
        </div>
        <div class="guide-item">
            <img class="guide-image" src="images/third.png" alt="Program 1">
            <h5>Upload Documents</h5>
        </div>
        <div class="guide-item">
            <img class="guide-next" src="images/next.png">
        </div>
        <div class="guide-item">
            <img class="guide-image" src="images/fourth.png" alt="Program 1">
            <h5>Submit Application</h5>
        </div>
        <div class="guide-item">
            <img class="guide-next" src="images/next.png">
        </div>
        <div class="guide-item">
            <img class="guide-image" src="images/fifth.png" alt="Program 1">
            <h5>Confirm Enrollment</h5>
        </div>
    </div>
</section>

<section class="frequently-section">
    <h2>FREQUENTLY ASKED QUESTIONS</h2>
    <hr>
    <div class="faq-container">
        <div class="faq-item">
            <div class="faq-question">
                <span>How do I start the online enrollment process?</span>
                <button class="faq-toggle">+</button>
            </div>
            <div class="faq-answer">
                <p>Begin by creating an account on the Oxford Academe admissions portal, completing your personal details, and following the steps to submit required documents.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span>Are there scholarships available?</span>
                <button class="faq-toggle">+</button>
            </div>
            <div class="faq-answer">
                <p>Yes, we offer various scholarships for deserving students. Please contact the admissions office for more details.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span>What programs do you offer?</span>
                <button class="faq-toggle">+</button>
            </div>
            <div class="faq-answer">
                <p>We offer programs in Computer Studies, Education, Business Administration, Arts, and Sciences.</p>
            </div>
        </div>
        
        <!-- Hidden Questions -->
        <div class="hidden-questions">
            <div class="faq-item">
                <div class="faq-question">
                    <span>What is the enrollment deadline?</span>
                    <button class="faq-toggle">+</button>
                </div>
                <div class="faq-answer">
                    <p>The enrollment deadline varies by semester. Please check the admissions portal for exact dates.</p>
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question">
                    <span>Can I apply for multiple programs at once?</span>
                    <button class="faq-toggle">+</button>
                </div>
                <div class="faq-answer">
                    <p>Yes, you may apply for multiple programs, but additional requirements may apply.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- View More Button -->
    <button id="view-more" class="view-more-btn">View More</button>
</section>



<section class="footer-section">
    <footer>
        <div class="footer-container">
            <div class="footer-logo">
                <img src="images/logo.png" alt="Oxford Academe Logo" class="footer-logo-image">
            </div>
            <div class="footer-about">
                <br>
                <p>Oxford Academe is dedicated to providing top-notch education, preparing students for a successful future in a dynamic world.</p>
                <br>
                <p>Maximina St., Villa Arca Subdivision Proj. 8, Cavite City</p>
                <br>
                <p>Hotline: (02) 8656-0654 /  8844-3225</p>
            </div>
            <div class="footer-links">
                <h3>Programs</h3>
                <ul>
                    <li><a href="#">Main Programs</a></li>
                    <li><a href="#">College</a></li>
                    <li><a href="#">Graduate</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h3>Admissions</h3>
                <ul>
                    <li><a href="#">For Graduate Programs</a></li>
                    <li><a href="#">For College Programs</a></li>
                    <li><a href="#">Online Enrollment</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Oxford Academe. All Rights Reserved.</p>
        </div>
    </footer>
</section>

  



<script>
    document.querySelectorAll('.faq-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const faqItem = button.parentElement.parentElement;
            const answer = faqItem.querySelector('.faq-answer');

            if (answer.style.display === 'block') {
                answer.style.display = 'none';
                button.textContent = '+';
            } else {
                answer.style.display = 'block';
                button.textContent = '-';
            }
        });
    });

    document.getElementById('view-more').addEventListener('click', function () {
    const hiddenQuestions = document.querySelector('.hidden-questions');
    if (hiddenQuestions.style.display === 'none' || hiddenQuestions.style.display === '') {
        hiddenQuestions.style.display = 'block';
        this.textContent = 'View Less'; // Change button text to "View Less"
    } else {
        hiddenQuestions.style.display = 'none';
        this.textContent = 'View More'; // Change button text back to "View More"
    }
});

</script>





</body>
</html>