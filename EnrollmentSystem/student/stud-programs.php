<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student - Template</title>
  <link rel="stylesheet" href="stud-programs.css">
  <script src="programs.js"></script>
</head>
<body>
<?php include "stud-sidebar.php"; ?>


<main>
    
    <!-- WAG TANGGALIN MAIN AT CONTAINER-->
    <div class="container">
      <!-- content-->
       <div class="main--header">
            <h3>Available Programs</h3>
            <div class="content-wrapper">
                <table class="program-table" border="1px">
                    <tr>
                        <td data-description="Learn about cutting-edge technology in the Information Technology program.">
                            <img src="studPic/program1.png" alt="Program 1">
                            <p class="program-name">Information Technology</p>
                        </td>
                        <td>
                            <img src="studPic/program2.png" alt="Program 2">
                            <p class="program-name">Psychology</p>
                        </td>
                        <td>
                            <img src="studPic/program3.png" alt="Program 3">
                            <p class="program-name">Education</p>
                        </td>
                        <td>
                            <img src="studPic/program4.png" alt="Program 4">
                            <p class="program-name">Human Resource</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="studPic/program5.png" alt="Program 5">
                            <p class="program-name">Nursing</p>
                        </td>
                        <td>
                            <img src="studPic/program6.png" alt="Program 6">
                            <p class="program-name">Law</p>
                        </td>
                        <td>
                            <img src="studPic/program7.png" alt="Program 7">
                            <p class="program-name">Criminology</p>
                        </td>
                        <td>
                            <img src="studPic/program8.png" alt="Program 8">
                            <p class="program-name">Tourism</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="studPic/program1.png" alt="Program 1">
                            <p class="program-name">Information Technology</p>
                        </td>
                        <td>
                            <img src="studPic/program2.png" alt="Program 2">
                            <p class="program-name">Psychology</p>
                        </td>
                        <td>
                            <img src="studPic/program3.png" alt="Program 3">
                            <p class="program-name">Education</p>
                        </td>
                        <td>
                            <img src="studPic/program4.png" alt="Program 4">
                            <p class="program-name">Human Resource</p>
                        </td>
                    </tr>
                </table>

                <aside>
                    <h2>Description</h2>
                    <p>
                       Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quo nisi harum voluptates saepe. Dignissimos quae ullam non voluptatum facilis maxime dicta laboriosam, quo nostrum veritatis iusto ipsa voluptates officiis natus.
                    </p>

                    <div class="apply-container">
                      <button class="apply-button"><a href="enrollment-regular.php" style="color: white;">Apply Now</a></button>
                    </div>
                </aside>
            </div>
        </div>
      
    </div>   
  </main>

</body>
</html>