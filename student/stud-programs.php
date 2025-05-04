<?php
    include "../dbcon.php";
    include "sessioncheck.php";
    $user_id = $_SESSION['user_id']; 

    
    $query = "SELECT * FROM enrollee WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If an enrollee record exists, redirect to confirmation page
        header("Location: studConfirmApplication.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Oxford Academe - Program</title>
  <link rel="stylesheet" href="stud-programs.css">
  <script src="programs.js"></script>

</head>
<style>
 img {
    cursor: pointer;
 }
</style>
<body>
<?php include "stud-sidebar.php"; ?>


<main>
    
    <!-- WAG TANGGALIN MAIN AT CONTAINER-->
    <div class="container">
      <!-- content-->
      <div class="main--header">
    <h3>Available Programs</h3>
    <div class="content-wrapper">
        <table class="program-table">
            <tr>
                <td data-description="Learn about cutting-edge technology in the Information Technology program.">
                    <img src="studPic/program1.png" alt="Program 1" style= "cursor: pointer;">
                    <p class="program-name">Information Technology</p>
                </td>
                <td data-description="Explore human behavior and the mind in Psychology.">
                    <img src="studPic/program2.png" alt="Program 2">
                    <p class="program-name">Psychology</p>
                </td>
                <td data-description="Become an educator and inspire the next generation in the Education program.">
                    <img src="studPic/program3.png" alt="Program 3">
                    <p class="program-name">Education</p>
                </td>
                <td data-description="Learn the skills to manage people and organizations in Human Resources.">
                    <img src="studPic/program4.png" alt="Program 4">
                    <p class="program-name">Human Resource</p>
                </td>
            </tr>
            <tr>
                <td data-description="Join the medical field and save lives with a Nursing degree.">
                    <img src="studPic/program5.png" alt="Program 5">
                    <p class="program-name">Nursing</p>
                </td>
                <td data-description="Pursue justice and legal studies in the Law program.">
                    <img src="studPic/program6.png" alt="Program 6">
                    <p class="program-name">Law</p>
                </td>
                <td data-description="Train to serve and protect communities with a Criminology degree.">
                    <img src="studPic/program7.png" alt="Program 7">
                    <p class="program-name">Criminology</p>
                </td>
                <td data-description="Discover the hospitality and tourism industry in this exciting program.">
                    <img src="studPic/program8.png" alt="Program 8">
                    <p class="program-name">Tourism</p>
                </td>
            </tr>

         
        </table>

        <aside>
            <h2>Description</h2>
            <p id="description-text">
                Click on a program to see details here.
            </p>
            <div class="apply-container">
                <button class="apply-button">
                    <a href="enrollment-regular.php" style="color: white;">Apply Now</a>
                </button>
            </div>
        </aside>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const programCells = document.querySelectorAll(".program-table td");
        const descriptionText = document.getElementById("description-text");

        programCells.forEach(cell => {
            cell.addEventListener("click", function () {
                const description = cell.getAttribute("data-description");
                if (description) {
                    descriptionText.textContent = description;
                }
            });
        });
    });
</script>
      
    </div>   
  </main>

</body>
</html>