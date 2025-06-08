<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../dbcon.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['import_file']['tmp_name'])) {
    $file = $_FILES['import_file']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getSheet(1); 
    $data = $sheet->toArray();

    for ($i = 1; $i < count($data); $i++) {
        $row = $data[$i];
        $courseID = $row[0];
        $Year = $row[1]; 
        $subCode = $row[2];
        $subName = $row[3];
        $units = $row[4];
        $preReq = $row[5];
        $fee = $row[6];

        $stmt = $conn->prepare("INSERT INTO subject (CourseID, Year, SubCode, SubName, Units, PreRequisites, Fee) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissisd", $courseID, $Year, $subCode, $subName, $units, $preReq, $fee);
        $stmt->execute();
    }

    header("Location: Subject_management.php?success=Subjects+imported+successfully");
    exit();
}
?>
<?php if (isset($_GET['success'])): ?>
  <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
<?php endif; ?>
