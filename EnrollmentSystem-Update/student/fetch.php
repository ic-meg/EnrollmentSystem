<?php

include "../dbcon.php";
include "sessioncheck.php";
$user_id = $_SESSION['user_id']; 

// Fetch the file names from the database
$query = "SELECT Form137, Form138, Picture FROM freshmen WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($form137, $form138, $pic);
$stmt->fetch();
$stmt->close();
?>

<table border="1">
    <tr>
        <th>Form 137</th>
        <th>Form 138</th>
    </tr>
    <tr>
        <td>
            <?php if ($form137): ?>
                <a href="uploads/<?php echo htmlspecialchars($form137); ?>" target="_blank">View Form 137</a>
            <?php else: ?>
                No file uploaded
            <?php endif; ?>
        </td>
        <td>
            <?php if ($form138): ?>
                <a href="uploads/<?php echo htmlspecialchars($form138); ?>" target="_blank">View Form 138</a>
            <?php else: ?>
                No file uploaded
            <?php endif; ?>
        </td>
        <td>
            <?php if ($pic): ?>
                <a href="uploads/<?php echo htmlspecialchars($pic); ?>" target="_blank">View Picture</a>
            <?php else: ?>
                No file uploaded
            <?php endif; ?>
        </td>
    </tr>
</table>
