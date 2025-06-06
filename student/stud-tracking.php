<?php
include "../dbcon.php";
include "sessioncheck.php";

$userId = $_SESSION['user_id'];

$completedPayments = [];
$pendingPayments = [];

$query = "SELECT Name, Program, PaymentDate, AmountPaid, PaymentMethod, PaymentStatus FROM paymentinfo WHERE user_id = ? ORDER BY PaymentDate DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    if (strtolower($row['PaymentStatus']) === 'paid') {
        $completedPayments[] = $row;
    } else {
        $pendingPayments[] = $row;
    }
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oxford Academe | Payment Tracking </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eaf4fc;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: left;
            margin-bottom: 20px;
            color: #2a5d9f;
        }

        .tabs {
            display: flex;
            margin-bottom: 20px;
        }

        .tab {
            flex: 1;
            text-align: center;
            padding: 10px 0;
            background-color: #f0f0f0;
            cursor: pointer;
            border-radius: 8px 8px 0 0;
        }

        .tab.active {
            background-color: #2DB2FF;
            color: #fff;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table thead {
            background-color: #FFFFFF;
            color: rgb(16, 16, 16);
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table td {
            position: relative;
        }

        table td .action-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            border: 2px solid #000;
            border-radius: 50%;
            background-color: white;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
        }

        table td .action-btn:hover {
            background-color: #f0f0f0;
            transform: scale(1.1);
        }

        table td .action-btn:active {
            transform: scale(0.9);
        }

        table td .action-btn svg {
            width: 24px;
            height: 24px;
            fill: black;
        }

        @media (max-width: 768px) {
            table thead {
                display: none;
            }

            table tr {
                display: block;
                margin-bottom: 10px;
            }

            table td {
                display: block;
                text-align: right;
                border: none;
                padding-left: 50%;
                position: relative;
            }

            table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                text-align: left;
                font-weight: bold;
            }
        }

        .tabs {
            display: flex;
            justify-content: center;
            background-color: #f8fbff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .tab {
            flex: 1;
            padding: 12px 0;
            text-align: center;
            background: #f1f5f9;
            font-weight: 600;
            color: #555;
            cursor: pointer;
            border: none;
            outline: none;
            transition: all 0.3s ease;
        }

        .tab:hover {
            background-color: #e2e8f0;
            color: #1d4ed8;
        }

        .tab.active {
            background-color: #2DB2FF;
            color: white;
            font-weight: bold;
            border-bottom: 3px solid #1d4ed8;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
        }

        .badge-paid {
            background-color: #d1f7dc;
            color: #218838;
        }

        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>

<body>
    <?php include "stud-sidebar.php"; ?>

    <br><br>
    <main>
        <br><br><br>
        <div class="container">
            <h1>Payment <span style="color: #007BFF;">Tracking</span></h1>


            <div class="tabs">
                <button class="tab active" onclick="switchTab('pending')">Pending Payments</button>
                <button class="tab" onclick="switchTab('completed')">Completed Payments</button>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Program</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <!-- Pending Payments First -->
                    <tbody id="pending" class="tab-content">
                        <?php if (count($pendingPayments) > 0): ?>
                            <?php foreach ($pendingPayments as $row): ?>
                                <tr>
                                    <td data-label="Name"><?= htmlspecialchars($row['Name']) ?></td>
                                    <td data-label="Program"><?= htmlspecialchars($row['Program']) ?></td>
                                    <td data-label="Date"><?= htmlspecialchars($row['PaymentDate']) ?></td>
                                    <td data-label="Amount">₱<?= number_format($row['AmountPaid'], 2) ?></td>
                                    <td data-label="Method"><?= htmlspecialchars($row['PaymentMethod']) ?></td>
                                    <td data-label="Status"><span class="badge badge-pending">Pending</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No pending payments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                    <!-- Completed Payments -->
                    <tbody id="completed" class="tab-content" style="display: none;">
                        <?php if (count($completedPayments) > 0): ?>
                            <?php foreach ($completedPayments as $row): ?>
                                <tr>
                                    <td data-label="Name"><?= htmlspecialchars($row['Name']) ?></td>
                                    <td data-label="Program"><?= htmlspecialchars($row['Program']) ?></td>
                                    <td data-label="Date"><?= htmlspecialchars($row['PaymentDate']) ?></td>
                                    <td data-label="Amount">₱<?= number_format($row['AmountPaid'], 2) ?></td>
                                    <td data-label="Method"><?= htmlspecialchars($row['PaymentMethod']) ?></td>
                                    <td data-label="Status"><span class="badge badge-paid">Paid</span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No completed payments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>




            <script>
                function switchTab(tabId) {
                    document.querySelectorAll('.tab').forEach(btn => btn.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');

                    document.querySelector(`#${tabId}`).style.display = 'table-row-group';
                    event.target.classList.add('active');
                }

    
            </script>

</body>

</html>