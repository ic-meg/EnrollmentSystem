<?php
include "session_check.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../dbcon.php";

    if (isset($_POST['archive_user_id'])) {
        $userID = intval($_POST['archive_user_id']);
        $stmt = $conn->prepare("UPDATE paymentinfo SET isArchived = 1 WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->close();
    }

    if (isset($_POST['restore_user_id'])) {
        $userID = intval($_POST['restore_user_id']);
        $stmt = $conn->prepare("UPDATE paymentinfo SET isArchived = 0 WHERE user_id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $stmt->close();
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>


<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admission Management | Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link href="assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="assets/vendor/datatables/datatables.min.css" rel="stylesheet">

    <!-- Custom Master Styles -->
    <link href="assets/css/master.css" rel="stylesheet">

</head>
<style>

</style>

<body>
    <?php include "admin-sidebar.php"; ?>

    <main>

        </div>
        </div>
        <div class="wrapper">
            <div class="container">
                <div class="content">
                    <div class="container">
                        <div class="page-title d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="mb-0">Recent Payments</h3>
                            </div>
                            <button id="toggleArchived" class="btn btn-outline-secondary">
                                <i class="fas fa-archive me-1"></i> View Archived Payments
                            </button>

                        </div>

                        <div class="box box-primary">
                            <div class="box-body">
                                <!-- Tabs for filtering payment status -->
                                <ul class="nav nav-tabs mb-3" id="paymentTabs" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-status="All" id="all-tab">All</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-status="Paid" id="paid-tab">Paid</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-status="Pending" id="pending-tab">Pending Balance</button>
                                    </li>
                                </ul>

                                <table width="100%" class="table table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th class="text-center">Payment Method</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php
                                        include "../dbcon.php";

                                        $query = "SELECT user_id, Name, Program, PaymentStatus, PaymentMethod, PaymentDate, AmountPaid, TuitionFee, MiscellanousFee, TotalFees, isArchived FROM paymentinfo ORDER BY PaymentDate DESC";

                                        $result = mysqli_query($conn, $query);

                                        $count = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $statusClass = strtolower(str_replace(' ', '-', $row['PaymentStatus']));
                                            $archivedClass = $row['isArchived'] == 1 ? 'archived-row d-none' : '';
                                            echo "<tr class='status-{$statusClass} {$archivedClass}'>";


                                            echo "<td>" . $count++ . "</td>";
                                            echo "<td>" . date('M d, Y h:i A', strtotime($row['PaymentDate'])) . "</td>";
                                            echo "<td class='text-center'>" . htmlspecialchars($row['PaymentMethod']) . "</td>";
                                            echo "<td class='text-center'>" . htmlspecialchars($row['Name']) . "</td>";
                                            echo "<td class='text-center'>" . htmlspecialchars($row['PaymentStatus']) . "</td>";
                                            echo "<td class='text-center'>";

                                            // Info Button (modal to be defined later)
                                            echo "<button class='btn btn-outline-primary btn-rounded' data-bs-toggle='modal' data-bs-target='#infoModal_" . $row['user_id'] . "'>";
                                            echo "<i class='fa fa-info-circle'></i>";
                                            echo "</button>";


                                            if ($row['isArchived'] == 1) {
                                                // ✅ Restore button
                                                echo "<form method='POST' class='d-inline'>";
                                                echo "<input type='hidden' name='restore_user_id' value='{$row['user_id']}'>";
                                                echo "<button type='submit' class='btn btn-success btn-rounded ms-1' title='Restore'>";
                                                echo "<i class='fas fa-undo'></i>";
                                                echo "</button>";
                                                echo "</form>";
                                            } else {
                                                // 🗑 Archive button
                                                echo "<button class='btn btn-outline-danger btn-rounded ms-1' data-bs-toggle='modal' data-bs-target='#archiveModal_{$row['user_id']}'>";
                                                echo "<i class='fas fa-archive'></i>";
                                                echo "</button>";
                                            }


                                            echo "</td>";
                                            echo "</tr>";

                                            echo <<<MODAL
<div class="modal fade" id="infoModal_{$row['user_id']}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="text-align: left;">
        <h6><strong>Student Details</strong></h6>
        <ul>
          <li><strong>Name:</strong> {$row['Name']}</li>
          <li><strong>Program:</strong> {$row['Program']}</li>
        </ul>

        <h6 class="mt-4"><strong>Fee Breakdown</strong></h6>
        <ul>
          <li><strong>Tuition Fee:</strong> PHP {$row['TuitionFee']}</li>
          <li><strong>Miscellaneous Fee:</strong> PHP {$row['MiscellanousFee']}</li>
          <li><strong>Total Fees:</strong> PHP {$row['TotalFees']}</li>
        </ul>

        <h6 class="mt-4"><strong>Payment Details</strong></h6>
        <ul>
          <li><strong>Amount Paid:</strong> PHP {$row['AmountPaid']}</li>
          <li><strong>Payment Date:</strong> {$row['PaymentDate']}</li>
          <li><strong>Payment Method:</strong> {$row['PaymentMethod']}</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
MODAL;
                                            echo <<<ARCHIVEMODAL
<div class="modal fade" id="archiveModal_{$row['user_id']}" tabindex="-1" aria-labelledby="archiveModalLabel_{$row['user_id']}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="archiveModalLabel_{$row['user_id']}">Confirm Archive</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to archive the payment of <strong>{$row['Name']}</strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form method="POST" action="archive_payment.php" class="d-inline">
          <input type="hidden" name="user_id" value="{$row['user_id']}">
          <button type="submit" class="btn btn-danger">Archive</button>
        </form>
      </div>
    </div>
  </div>
</div>
ARCHIVEMODAL;
                                        }
                                        ?>



                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/datatables/datatables.min.js"></script>
        <script src="assets/js/initiate-datatables.js"></script>
        <script src="assets/js/script.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tabs = document.querySelectorAll('#paymentTabs button');
                const tableBody = document.querySelector('#dataTables-example tbody');

                function filterRows(status) {
                    const rows = tableBody.querySelectorAll('tr');
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const statusCell = row.querySelector('td:nth-child(5)');
                        if (!statusCell) return;
                        const rowStatus = statusCell.textContent.trim();

                        if (status === 'All' || rowStatus === status) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Remove existing message
                    const oldMessage = tableBody.querySelector('.no-data-message');
                    if (oldMessage) oldMessage.remove();

                    // If no rows match, show a message
                    if (visibleCount === 0) {
                        const messageRow = document.createElement('tr');
                        messageRow.className = 'no-data-message';
                        messageRow.innerHTML = `
        <td colspan="6" class="text-center text-muted">
          No ${status === 'All' ? '' : status.toLowerCase()} payments found.
        </td>
      `;
                        tableBody.appendChild(messageRow);
                    }
                }

                tabs.forEach(tab => {
                    tab.addEventListener('click', function() {
                        tabs.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        const selectedStatus = this.getAttribute('data-status');
                        filterRows(selectedStatus);
                    });
                });

                // Load default tab on first render
                filterRows('All');
            });
        </script>
        <script>
            document.getElementById("toggleArchived").addEventListener("click", function() {
                const archivedRows = document.querySelectorAll(".archived-row");
                const isHidden = archivedRows[0]?.classList.contains("d-none");

                archivedRows.forEach(row => {
                    row.classList.toggle("d-none", !isHidden);
                });

                // Change button text
                this.innerHTML = isHidden ?
                    '<i class="fas fa-archive me-1"></i> Hide Archived Payments' :
                    '<i class="fas fa-archive me-1"></i> View Archived Payments';
            });
        </script>


</body>

</html>