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
 @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');

:root {
  --primary: #3F83E6;
  --secondary: #5C83AD;
  --white: #ffffff;
  --light-blue: #dcecff;
  --gray: #f5f5f5;
  --black: #000;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Montserrat', sans-serif;
}

body {
  background-color: var(--light-blue);
}

.container {
  padding: 20px;
}

.main--header h3 {
  font-size: 26px;
  background: var(--secondary);
  color: var(--white);
  text-align: center;
  padding: 12px;
  border-radius: 6px;
  margin-bottom: 20px;
}

/* Table Style */
.program-table {
  width: 100%;
  border-collapse: collapse;
  background-color: var(--white);
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.program-table td {
  text-align: center;
  padding: 20px;
  transition: 0.3s;
  border: 1px solid #e0e0e0;
  cursor: pointer;
  border-radius: 12px;
}

.program-table td:hover {
  background-color: var(--light-blue);
  transform: scale(1.03);
}

.program-table img {
  width: 60px;
  height: 60px;
  object-fit: contain;
  display: block;
  margin: 0 auto;
}

.program-name {
  font-weight: 600;
  margin-top: 10px;
}

/* Description Panel */

}

aside h2 {
  font-size: 20px;
  margin-bottom: 10px;
  font-weight: 700;
}

#description-text {
  font-size: 14px;
  color: #333;
  line-height: 1.6;
}

/* Apply Button */
.apply-container {
  margin-top: 20px;
  text-align: left;
}

.apply-button {
  background-color: var(--secondary);
  color: var(--white);
  border: none;
  padding: 10px 20px;
  font-size: 15px;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.3s;
}

.apply-button:hover {
  background-color: var(--primary);
  transform: scale(1.05);
}

.apply-button a {
  text-decoration: none;
  color: var(--white);
}

/* Responsive Design */
@media (max-width: 992px) {
  .program-table td {
    padding: 12px;
  }

  .program-table img {
    width: 50px;
    height: 50px;
  }

  .program-name {
    font-size: 13px;
  }

  aside h2 {
    font-size: 18px;
  }

  #description-text {
    font-size: 13px;
  }
}

@media (max-width: 600px) {
  .program-table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
  }

  .program-table tr {
    display: flex;
    flex-wrap: nowrap;
  }

  .program-table td {
    min-width: 150px;
    display: inline-block;
    border: none;
    margin: 5px;
  }

  .apply-container {
    text-align: center;
  }
}
.content-wrapper-horizontal {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
}

.programs-container {
  flex: 2;
}

aside {
  flex: 1;
  min-width: 250px;
}

@media (max-width: 992px) {
  .content-wrapper-horizontal {
    flex-direction: column;
  }


}

</style>
<body>
<?php include "stud-sidebar.php"; ?>


<main>
    
    <!-- WAG TANGGALIN MAIN AT CONTAINER-->
    <div class="container">
      <!-- content--> <br><br>
      <div class="main--header">
         <h3>Available Programs</h3>
            <div class="content-wrapper-horizontal">
                <div class="programs-container">
                <table class="program-table">
                    <tr>
                        <td data-description="The Information Technology program equips students with advanced knowledge in software development, networking, cybersecurity, and database systems. It prepares future IT professionals to solve real-world problems through innovation and technology-driven solutions.">
                            <img src="studPic/program1.png" alt="Program 1">
                            <p class="program-name">Information Technology</p>
                        </td>
                        <td data-description="Psychology explores the human mind and behavior through scientific research and theory. Students gain a strong foundation in cognitive, developmental, clinical, and social psychology to prepare for careers in mental health, education, or human services.">
                            <img src="studPic/program2.png" alt="Program 2">
                            <p class="program-name">Psychology</p>
                        </td>
                        <td data-description="The Education program trains future educators with the principles of pedagogy, curriculum development, and student assessment. It focuses on nurturing competent and compassionate teachers who can inspire learners in diverse classroom settings.">
                            <img src="studPic/program3.png" alt="Program 3">
                            <p class="program-name">Education</p>
                        </td>
                        <td data-description="This program focuses on managing human capital and organizational behavior. Students learn about recruitment, labor laws, employee relations, and training strategies essential for thriving in modern human resource departments.">
                            <img src="studPic/program4.png" alt="Program 4">
                            <p class="program-name">Human Resource</p>
                        </td>
                    </tr>
                    <tr>
                        <td data-description="The Nursing program combines theory and hands-on clinical practice to prepare students for careers in healthcare. It emphasizes patient care, health assessment, pharmacology, and ethical responsibilities essential to becoming a licensed nurse.">
                            <img src="studPic/program5.png" alt="Program 5">
                            <p class="program-name">Nursing</p>
                        </td>
                        <td data-description="Law is a rigorous program designed for students interested in the legal profession. It provides a solid foundation in constitutional law, civil and criminal procedures, and legal ethics to prepare for law school or careers in legal services.">
                            <img src="studPic/program6.png" alt="Program 6">
                            <p class="program-name">Law</p>
                        </td>
                        <td data-description="Criminology delves into the causes and consequences of criminal behavior. Students gain insight into law enforcement, forensic science, corrections, and criminal justice policies, preparing them for careers in policing or investigation.">
                            <img src="studPic/program7.png" alt="Program 7">
                            <p class="program-name">Criminology</p>
                        </td>
                        <td data-description="Tourism Management develops skills in travel planning, destination marketing, and hospitality operations. The program prepares students to work in global tourism industries with strong customer service and business management foundations.">
                            <img src="studPic/program8.png" alt="Program 8">
                            <p class="program-name">Tourism</p>
                        </td>
                    </tr>
                    <tr>
                        <td data-description="The Nursing program combines theory and hands-on clinical practice to prepare students for careers in healthcare. It emphasizes patient care, health assessment, pharmacology, and ethical responsibilities essential to becoming a licensed nurse.">
                            <img src="studPic/program5.png" alt="Program 5">
                            <p class="program-name">Nursing</p>
                        </td>
                        <td data-description="Law is a rigorous program designed for students interested in the legal profession. It provides a solid foundation in constitutional law, civil and criminal procedures, and legal ethics to prepare for law school or careers in legal services.">
                            <img src="studPic/program6.png" alt="Program 6">
                            <p class="program-name">Law</p>
                        </td>
                        <td data-description="Criminology delves into the causes and consequences of criminal behavior. Students gain insight into law enforcement, forensic science, corrections, and criminal justice policies, preparing them for careers in policing or investigation.">
                            <img src="studPic/program7.png" alt="Program 7">
                            <p class="program-name">Criminology</p>
                        </td>
                        <td data-description="Tourism Management develops skills in travel planning, destination marketing, and hospitality operations. The program prepares students to work in global tourism industries with strong customer service and business management foundations.">
                            <img src="studPic/program8.png" alt="Program 8">
                            <p class="program-name">Tourism</p>
                        </td>
                    </tr>
                </table>

                </div>
        <aside>
            <h2 id="description-title">Description</h2>
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


    function showDetails(program) {
    const title = document.querySelector('.description-title');
    const desc = document.querySelector('.description-text');

    switch(program) {
        case 'BSIT':
        title.innerText = 'Bachelor of Science in Information Technology';
        desc.innerText = 'The BSIT program focuses on the study, development, and application of IT solutions...';
        break;
   
        default:
        title.innerText = 'Description';
        desc.innerText = 'Click on a program to see details here.';
    }

    document.querySelectorAll('.program-item').forEach(el => el.classList.remove('active'));
    event.currentTarget.classList.add('active');
    }
    document.addEventListener("DOMContentLoaded", function () {
    const programCells = document.querySelectorAll(".program-table td");
    const descriptionText = document.getElementById("description-text");
    const descriptionTitle = document.getElementById("description-title");

    programCells.forEach(cell => {
        cell.addEventListener("click", function () {
            const description = cell.getAttribute("data-description");
            const title = cell.querySelector(".program-name")?.textContent || "Description";

            // Update title and description
            descriptionTitle.textContent = title;
            descriptionText.textContent = description;
            });
        });
    });

</script>
      
    </div>   
  </main>

</body>
</html> 