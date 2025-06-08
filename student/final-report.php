<?php
session_start();
include '../dbcon.php';
include 'sessioncheck.php';

$user_id = $_SESSION['user_id'];

// Fetch student info
$stmt = $conn->prepare("SELECT name, program, enrollment_type FROM enrollee WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

$studentName = isset($student['name']) ? $student['name'] : 'Unknown';
$program = isset($student['program']) ? $student['program'] : 'N/A';
$status = isset($student['enrollment_type']) ? $student['enrollment_type'] : 'N/A';

// Fetch enrolled subjects
$stmt = $conn->prepare("
    SELECT subj.SubCode, subj.SubName, subj.units, sched.schedule_day, sched.schedule_time, sched.room, sched.section
    FROM enrolled_subjects sched
    JOIN subject subj ON sched.subj_id = subj.SubjID
    WHERE sched.enrollee_id = (SELECT EnrolleeID FROM enrollee WHERE user_id = ?)
");
if (!$stmt) {
  die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$subjectsResult = $stmt->get_result();
$subjects = $subjectsResult->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Oxford Academe | Final Report</title>
  <link rel="stylesheet" href="final-report.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background: #f4f7fc;
      color: #333;
    }

    main {
      padding: 20px;
    }

    .container {
      max-width: 1100px;
      margin: auto;
      padding: 20px;
      background: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      box-sizing: border-box;
    }

    .profile {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 20px;
      margin-bottom: 30px;
      background-color: #eef6fb;
      padding: 20px;
      border-radius: 10px;
    }

    .profile img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #2db2ff;
    }

    .profile-details {
      flex: 1;
      min-width: 200px;
    }

    .profile-details h2 {
      font-size: 22px;
      margin-bottom: 5px;
    }

    .content h2 {
      font-size: 20px;
      margin-bottom: 15px;
      color: #2db2ff;
    }


    .table-responsive {
      width: 100%;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
      min-width: 700px;
    }

    th,
    td {
      padding: 12px 10px;
      border: 1px solid #ccc;
      text-align: center;
      font-size: 14px;
    }

    th {
      background-color: #2db2ff;
      color: white;
    }

    .action-buttons {
      text-align: right;
      margin-top: 10px;
    }

    .action-buttons button {
      background-color: #2db2ff;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 14px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .action-buttons button:hover {
      background-color: #1995d2;
    }


    @media (max-width: 768px) {
      main {
        padding: 10px;
      }

      .container {
        padding: 15px;
      }

      .profile {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .profile img {
        margin-bottom: 10px;
      }

      .profile-details h2 {
        font-size: 18px;
      }

      .profile-details span {
        font-size: 14px;
      }

      .action-buttons {
        text-align: center;
      }

      table {
        font-size: 12px;
      }

      @media (max-width: 768px) {
        table thead {
          display: none;
        }

        .table-body .table-row {
          display: block;
          background: #fff;
          margin-bottom: 10px;
          border: 1px solid #ccc;
          border-radius: 8px;
          padding: 10px;
        }

        .table-body .table-row td {
          display: flex;
          justify-content: space-between;
          padding: 8px 10px;
          border: none;
          border-bottom: 1px solid #eee;
          font-size: 14px;
        }

        .table-body .table-row td:last-child {
          border-bottom: none;
        }

        .table-body .table-row td::before {
          content: attr(data-label);
          font-weight: bold;
          flex-basis: 50%;
          color: #333;
        }

        .action-buttons {
          text-align: center;
        }
      }

      .pdf-profile {
        padding: 10px 0;
      }

      .subject-card {
        border: 1px solid #ccc;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        background: #f9f9f9;
        font-size: 14px;
      }

    }
  </style>
</head>

<body>
  <?php include "stud-sidebar.php"; ?>

  <main>
    <br /><br /><br /><br />
    <div class="container">
      <div id="pdf-output" style="display: none;"></div>

      <div class="main--container">
        <div class="profile">
          <img src="studPic/image1.png" alt="Profile Picture" />
          <div class="profile-details">
            <h2>Student Name: <?= htmlspecialchars($studentName) ?></h2>
            <span>Course: <?= htmlspecialchars($program) ?></span><br />
            <span>Status: <?= htmlspecialchars($status) ?></span>
          </div>
        </div>

        <div class="table-responsive">
          <h2>List of Subjects</h2>

          <table>
            <thead>
              <tr>
                <th>Subject</th>
                <th>Description</th>
                <th>Unit</th>
                <th>Schedule</th>
                <th>Time</th>
                <th>Room</th>
                <th>Section</th>
              </tr>
            </thead>
            <tbody class="table-body">
              <?php if (!empty($subjects)) : ?>
                <?php foreach ($subjects as $subject) : ?>
                  <tr class="table-row">
                    <td data-label="Subject"><?= htmlspecialchars($subject['SubCode']) ?></td>
                    <td data-label="Description"><?= htmlspecialchars($subject['SubName']) ?></td>
                    <td data-label="Unit"><?= htmlspecialchars($subject['units']) ?></td>
                    <td data-label="Schedule"><?= htmlspecialchars($subject['schedule_day']) ?></td>
                    <td data-label="Time"><?= htmlspecialchars($subject['schedule_time']) ?></td>
                    <td data-label="Room"><?= htmlspecialchars($subject['room']) ?></td>
                    <td data-label="Section"><?= htmlspecialchars($subject['section']) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7">No subjects enrolled.</td>
                </tr>
              <?php endif; ?>
            </tbody>

          </table>

          <div class="action-buttons" style="margin-top: 20px;">
            <a href="curriculum.php" class="btn-curriculum">View Curriculum</a>
            <button id="downloadPdf">Download PDF</button>
          </div>

        </div>
      </div>
    </div>
  </main>
  <script>
    document.getElementById('downloadPdf').addEventListener('click', function() {
      const container = document.getElementById('pdf-output');


      const name = document.querySelector('.profile-details h2').textContent;
      const course = document.querySelector('.profile-details span:nth-child(2)').textContent;
      const status = document.querySelector('.profile-details span:nth-child(4)').textContent;


      const subjectRows = document.querySelectorAll('.table-body .table-row');


      let html = `
    <style>
      body { font-family: Arial, sans-serif; }
      h2 { color: #2db2ff; }
      .pdf-profile { margin-bottom: 20px; }
      table.pdf-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
      }
      table.pdf-table th, table.pdf-table td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: center;
      }
      table.pdf-table th {
        background-color: #2db2ff;
        color: white;
      }
    </style>

    <div class="pdf-profile">
      <strong>${name}</strong><br/>
      ${course}<br/>
      ${status}
    </div>

    <h2>List of Subjects</h2>
    <table class="pdf-table">
      <thead>
        <tr>
          <th>Subject</th>
          <th>Description</th>
          <th>Unit</th>
          <th>Schedule</th>
          <th>Time</th>
          <th>Room</th>
          <th>Section</th>
        </tr>
      </thead>
      <tbody>
  `;

      subjectRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        html += `<tr>`;
        cells.forEach(cell => {
          html += `<td>${cell.textContent}</td>`;
        });
        html += `</tr>`;
      });

      html += `
      </tbody>
    </table>
  `;

      container.innerHTML = html;
      container.style.display = 'block';

      const opt = {
        margin: 0.5,
        filename: 'final-report.pdf',
        image: {
          type: 'jpeg',
          quality: 0.98
        },
        html2canvas: {
          scale: 2
        },
        jsPDF: {
          unit: 'in',
          format: 'a4',
          orientation: 'landscape'
        }
      };

      html2pdf().set(opt).from(container).save().then(() => {
        container.style.display = 'none';
        container.innerHTML = '';
      });
    });
  </script>


</body>

</html>