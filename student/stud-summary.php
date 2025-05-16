<?php
include '../dbcon.php';
include 'sessioncheck.php';

$user_id = $_SESSION['user_id'];

// Fetch enrollee info
$enrolleeStmt = $conn->prepare("SELECT * FROM enrollee WHERE user_id = ?");
$enrolleeStmt->bind_param("i", $user_id);
$enrolleeStmt->execute();
$enrolleeResult = $enrolleeStmt->get_result();

$paymentCheck = $conn->prepare("SELECT * FROM paymentinfo WHERE user_id = ? AND PaymentStatus = 'Paid'");
$paymentCheck->bind_param("i", $user_id);
$paymentCheck->execute();
$paymentResult = $paymentCheck->get_result();

if ($paymentResult->num_rows > 0) {
  header("Location: final-report.php");
  exit();
}
$paymentCheck->close();


$studentName = "Unknown";
$program = "Not set";
$academicYear = "N/A";
$status = "N/A";

if ($enrolleeResult && $enrolleeResult->num_rows > 0) {
  $student = $enrolleeResult->fetch_assoc();
  $studentName = $student['name'];
  $program = $student['program'];
  if (!empty($student['dateSubmitted'])) {
    $addedYear = date('Y', strtotime($student['dateSubmitted']));
    $academicYear = $addedYear . '-' . ($addedYear + 1);
  }
  $status = $student['enrollment_type'];
}
$enrolleeStmt->close();

// Fetch subjects
$subjectsStmt = $conn->prepare("SELECT * FROM enrolled_subjects WHERE enrollee_id = (SELECT EnrolleeID FROM enrollee WHERE user_id = ?)");
$subjectsStmt->bind_param("i", $user_id);
$subjectsStmt->execute();
$subjectsResult = $subjectsStmt->get_result();

$subjects = [];
$totalUnits = 0;
$totalFees = 0;
$miscFee = 3000;
$perUnitFee = 1000;
$section = 'N/A';


while ($row = $subjectsResult->fetch_assoc()) {
  $subjects[] = $row;
  $totalUnits += (int)$row['units'];
  $totalFees += (int)$row['units'] * $perUnitFee;
  $section = $row['section'];
}

$subjectsStmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="stud-summary.css">
  <title>Student - Enrollment Summary</title>
</head>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f8fc;
    margin: 0;
    padding: 0;
  }

  .container {
    max-width: 1000px;
    margin: 2rem auto;
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
  }

  .enrollmentHeader h1 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 1rem;
  }

  .content .info {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 2rem;
    gap: 1rem;
  }

  .info p {
    margin: 0.3rem 0;
    font-size: 0.95rem;
  }

  .table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 2rem;
    font-size: 0.95rem;
  }

  .table th {
    background-color: #2db2ff;
    color: white;
    padding: 12px;
    text-align: left;
    font-weight: 600;
  }

  .table td {
    padding: 12px;
    background-color: white;
    border-bottom: 1px solid #eee;
  }

  .fees {
    margin-top: 1rem;
    font-size: 0.95rem;
  }

  .fees p {
    margin: 0.5rem 0;
  }

  .total-units {
    margin-top: 1.5rem;
    font-weight: bold;
    font-size: 1rem;
    color: #333;
  }

  .payment-button {
    margin-top: 2rem;
    text-align: center;
  }

  .payment-button button {
    background-color: #2db2ff;
    color: white;
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease;
  }

  .payment-button button:hover {
    background-color: #1c9edc;
  }

  @media screen and (max-width: 768px) {
    .content .info {
      flex-direction: column;
    }

    .table th,
    .table td {
      font-size: 0.9rem;
    }

    .payment-button button {
      width: 100%;
    }
  }
</style>

</style>

<body>
  <?php include "stud-sidebar.php"; ?>

  <main>
    <!-- WAG TANGGALIN MAIN AT CONTAINER-->
    <div class="container">
      <div class="enrollmentHeader">
        <h1><span style="color: #2db2ff;">Enrollment</span> Summary</h1>
      </div>
      <div class="content">
        <div class="info">
          <div>
            <p><strong>Student Name:</strong> <?= htmlspecialchars($studentName) ?></p>
            <p><strong>Program:</strong> <?= htmlspecialchars($program) ?></p>
          </div>
          <div>
            <p><strong>Status:</strong> <?= htmlspecialchars($status) ?></p>
            <p><strong>Section:</strong> <?= htmlspecialchars($section) ?></p>
            <p><strong>Academic Year:</strong> <?= htmlspecialchars($academicYear) ?></p>
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
            <?php foreach ($subjects as $subject): ?>
              <tr>
                <td><?= htmlspecialchars($subject['subj_id']) ?></td>
                <td><?= htmlspecialchars($subject['sub_name']) ?></td>
                <td><?= htmlspecialchars($subject['sub_code']) ?></td>
                <td><?= htmlspecialchars($subject['units']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <div class="fees">
          <p><strong>Tuition Fees:</strong> PHP <?= number_format($totalFees, 2) ?></p>
          <p><strong>Miscellaneous Fee:</strong> PHP <?= number_format($miscFee, 2) ?></p>
          <p><strong>Total Fees:</strong> PHP <?= number_format($totalFees + $miscFee, 2) ?></p>
        </div>

        <div class="total-units">
          TOTAL UNITS: <?= $totalUnits ?>
        </div>

        <div class="payment-button">
          <form id="paymentForm" action="create_payment_link.php" method="POST">
            <input type="hidden" name="amount" value="<?= ($totalFees + $miscFee) * 100 ?>">
            <input type="hidden" name="student_name" value="<?= htmlspecialchars($studentName) ?>">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <input type="hidden" name="program" value="<?= htmlspecialchars($program) ?>">
            <input type="hidden" name="tuition" value="<?= $totalFees ?>">
            <input type="hidden" name="misc" value="<?= $miscFee ?>">
            <input type="hidden" name="method" value="Card (Test)">
            <button id="proceedBtn" type="submit" name="submit">Proceed to payment</button>
          </form>


        </div>
      </div>
    </div>

  </main>

  <script>
    document.getElementById("paymentForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const form = e.target;
      const formData = new FormData(form);

      fetch("save_session.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          tuition: formData.get("tuition"),
          misc: formData.get("misc"),
          method: formData.get("method")
        })
      }).then(() => {
        const tempForm = document.createElement("form");
        tempForm.action = form.action;
        tempForm.method = "POST";
        tempForm.target = "_blank";

        for (let [key, value] of formData.entries()) {
          const input = document.createElement("input");
          input.type = "hidden";
          input.name = key;
          input.value = value;
          tempForm.appendChild(input);
        }

        document.body.appendChild(tempForm);
        tempForm.submit();


        const proceedBtn = document.getElementById("proceedBtn");
        proceedBtn.textContent = "Finalize Enrollment";
        proceedBtn.style.backgroundColor = "#28a745";
        proceedBtn.onclick = function() {
          window.location.href = 'payment_success.php';
        };
      });
    });
  </script>


</body>

</html>