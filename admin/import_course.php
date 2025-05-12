<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../dbcon.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['import_file']['tmp_name'])) {
    $spreadsheet = IOFactory::load($_FILES['import_file']['tmp_name']);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();

    // Skip headers
    for ($i = 1; $i < count($data); $i++) {
        $row = $data[$i];
        if (!empty($row[0])) { 
            $courseName = mysqli_real_escape_string($conn, $row[0]);
            $totalUnits = intval($row[1]);
            $description = mysqli_real_escape_string($conn, $row[2]);

            $query = "INSERT INTO course (CourseName, TotalUnits, NumOfStudents, description, is_archived) 
                      VALUES ('$courseName', $totalUnits, 0, '$description', 0)";
            mysqli_query($conn, $query);
        }
    }

    echo "<script>
        alert('Courses imported successfully!');
        window.location.href = 'adminCourseManagement.php';
    </script>";
} else {
    echo "<script>
        alert('No file selected.');
        window.location.href = 'adminCourseManagement.php';
    </script>";
}
?>
