<?php
function showEnrolleesByStatus($status, $conn)
{
    $stmt = $conn->prepare("SELECT * FROM enrollee WHERE Status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div class="box-body"><table class="table table-hover" width="100%"><thead><tr>
        <th>ID</th>
        <th>Name</th>
        <th class="text-center">Application Status</th>
        <th class="text-center">Documents Uploaded</th>
        <th class="text-center">Action</th>
    </tr></thead><tbody>';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['EnrolleeID'] . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td class="text-center" style="color:' . ($status === "Approved" ? "green" : ($status === "Rejected" ? "red" : "orange")) . ';">' . $status . '</td>';
            echo '<td class="text-center">' . htmlspecialchars($row['documents_uploaded']) . '</td>';
            echo '<td class="text-center">';
            echo '<a href="creditSubject.php?user_id=' . $row['user_id'] . '" class="btn btn-outline-primary btn-sm"><i class="fa fa-info-circle"></i></a>';
            if ($status !== "Approved") {
                echo ' <button type="button" class="btn btn-outline-danger btn-sm reject-btn" data-userid="' . $row['user_id'] . '" data-username="' . $row['name'] . '" data-status="' . $status . '"><i class="fas fa-times"></i></button>';
            }
            echo '</td></tr>';
        }
    } else {
        echo '<tr><td colspan="5" class="text-center">No ' . $status . ' applications found.</td></tr>';
    }

    echo '</tbody></table></div>';
    $stmt->close();
}
