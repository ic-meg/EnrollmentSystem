<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../dbcon.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['import_file']['tmp_name'])) {
  error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

  $file = $_FILES['import_file']['tmp_name'];
  $spreadsheet = IOFactory::load($file);
  $sheet = $spreadsheet->getSheet(1);
  $data = $sheet->toArray();

  for ($i = 1; $i < count($data); $i++) {
    $row = $data[$i];

    if (!is_array($row) || count($row) < 8 || empty($row[0])) {
      continue;
    }

    $courseID = $row[0];
    $subCode = $row[2];
    $subName = $row[3];
    $units = $row[4];
    $preReq = $row[5];
    $fee = $row[6];
    $year = $row[7];

    $stmt = $conn->prepare("
      INSERT INTO subject (CourseID, SubCode, SubName, Units, PreRequisites, Fee, Year)
      VALUES (?, ?, ?, ?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE 
        SubName = VALUES(SubName),
        Units = VALUES(Units),
        PreRequisites = VALUES(PreRequisites),
        Fee = VALUES(Fee),
        Year = VALUES(Year)
    ");

    $stmt->bind_param("issisds", $courseID, $subCode, $subName, $units, $preReq, $fee, $year);
    $stmt->execute();
  }


  header("Location: Subject_management.php?success=Subjects+imported+successfully");
  exit();
}

?>
<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
<?php endif; ?>