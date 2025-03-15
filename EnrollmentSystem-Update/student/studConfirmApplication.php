<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }
        .notice-container {
            width: 600px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            text-align: center;
            overflow: hidden;
        }
        .notice-header {
            background: #3F83E6;
            color: white;
            padding: 15px;
            font-size: 22px;
            font-weight: bold;
        }
        .notice-content {
            padding: 30px;
        }
        .notice-content img {
            width: 120px;
        }
        .notice-text {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <?php include "stud-sidebar.php"; ?>
    <main>
        <div class="container">
            <div class="notice-container">
                <div class="notice-header">Submission Status</div>
                <div class="notice-content">
                    <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" alt="Success Icon">
                    <p class="notice-text">
                        You've successfully passed your requirements. Please wait for an update.
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
