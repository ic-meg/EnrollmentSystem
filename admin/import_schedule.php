<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../dbcon.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['import_file']['tmp_name'])) {
  $file = $_FILES['import_file']['tmp_name'];


  $spreadsheet = IOFactory::load($file);
  $sheet = $spreadsheet->getSheet(2);
  $data = $sheet->toArray();


  for ($i = 1; $i < count($data); $i++) {
    $row = $data[$i];

    $subID     = $row[0];
    $section   = $row[1];
    $day       = $row[2];
    $timeStart = $row[3];
    $timeEnd   = $row[4];
    $room      = $row[5];


    $stmt = $conn->prepare("INSERT INTO schedule (SubID, Section, Day, TimeStart, TimeEnd, Room) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $subID, $section, $day, $timeStart, $timeEnd, $room);
    $stmt->execute();
  }


  header("Location: ScheduleManagement.php?success=Schedule+imported+successfully");
  exit();
}
?>
<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
<?php endif; ?>