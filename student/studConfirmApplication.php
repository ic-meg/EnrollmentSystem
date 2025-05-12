<?php
    include "../dbcon.php";
    include "sessioncheck.php";

    $user_id = $_SESSION['user_id'];
    $referenceNo = null;
    $referenceLabel = null;

    $tables = [
        'freshmen' => 'FreshID',
        'transferee' => 'TransID',
        'returnee' => 'ReturneeID',
        'nonsequential' => 'NonID'
    ];

    // Check each table
    foreach ($tables as $table => $column) {
        $stmt = $conn->prepare("SELECT $column FROM $table WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $referenceNo = $row[$column];
            $referenceLabel = $column;
            $stmt->close();
            break; 
        }

        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Status</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f4fb;
        }
        .notice-container {
            width: 100%;
            max-width: 600px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        .notice-header {
            background: #3F83E6;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .notice-content {
            text-align: center;
            padding: 40px 30px;
        }
        .notice-content img {
            width: 100px;
            margin-bottom: 20px;
        }
        .notice-text {
            font-size: 18px;
            color: #333;
            margin-bottom: 15px;
        }
        .reference {
            background-color: #f1f5ff;
            border-left: 5px solid #3F83E6;
            padding: 15px;
            margin: 20px 0;
            font-size: 16px;
            color: #1a1a1a;
            border-radius: 8px;
        }
        .estimate {
            font-size: 15px;
            color: #777;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php include "stud-sidebar.php"; ?>
    <main style="display: flex; justify-content: center; align-items: center; height: calc(100vh - 60px);">
        <div class="notice-container">
            <div class="notice-header">Submission Status</div>
            <div class="notice-content">
                <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" alt="Success">
                <p class="notice-text">You've successfully passed your requirements.</p>

                <?php if ($referenceNo): ?>
                <div class="reference">
                    Reference Number: <strong><?php echo htmlspecialchars($referenceNo); ?></strong>
                    <div class="estimate">Please allow up to 3 working days for verification and approval.</div>
                </div>
                <?php else: ?>
                <div class="reference" style="color: #e53935;">
                    Unable to retrieve reference number. Please contact support.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
