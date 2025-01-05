<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stud-summary.css">
  <title>Student - Template</title>
</head>
<body>
<?php include "stud-sidebar.php"; ?>

<main>
    <!-- WAG TANGGALIN MAIN AT CONTAINER-->
    <div class="container">
      <div class="header">
          <h1>Enrollment Summary</h1>
      </div>
      <div class="content">
          <div class="info">
              <div>
                  <p><strong>Student Name:</strong> Giuliani Calais</p>
                  <p><strong>Program:</strong> Bachelor of Science in Information Technology</p>
                  <p><strong>Address:</strong> 742 Evergreen Terrace, Springfield, IL 62704, USA</p>
              </div>
              <div>
                  <p><strong>Status:</strong> IRREGULAR</p>
                  <p><strong>Year:</strong> 1st</p>
                  <p><strong>Academic Year:</strong> 2024-2025</p>
              </div>
          </div>

          <table class="table">
              <thead>
                  <tr>
                      <th>Id</th>
                      <th>Description</th>
                      <th>Subject</th>
                      <th>Unit</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>IT101</td>
                      <td>Introduction to Programming</td>
                      <td>ITP101</td>
                      <td>3</td>
                  </tr>
                  <tr>
                      <td>HM201</td>
                      <td>Fundamentals of Hospitality</td>
                      <td>FOP101</td>
                      <td>3</td>
                  </tr>
                  <tr>
                      <td>BM102</td>
                      <td>Principles of Management</td>
                      <td>POM111</td>
                      <td>3</td>
                  </tr>
                  <tr>
                      <td>ENT203</td>
                      <td>Entrepreneurial Mindset</td>
                      <td>EM1</td>
                      <td>3</td>
                  </tr>
                  <tr>
                      <td>OA101</td>
                      <td>Office Productivity Tools</td>
                      <td>OPT1</td>
                      <td>3</td>
                  </tr>
              </tbody>
          </table>

          <div class="fees">
              <p><strong>Tuition Fees:</strong> PHP 5,000.00</p>
              <p><strong>Miscellaneous Fee:</strong> PHP 3,000.00</p>
              <p><strong>Total Fees:</strong> PHP 8,000.00</p>
          </div>

          <div class="total-units">
              TOTAL UNITS: 26
          </div>

          <div class="payment-button">
              <button>Proceed to payment</button>
          </div>
      </div>
    </div>   
  </main>

</body>
</html>
