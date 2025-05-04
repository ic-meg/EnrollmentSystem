<?php
    include "../dbcon.php";

    if(isset($_POST['userID']) && isset($_POST['reason'])) {
        $userID = $_POST['userID'];
        $reason = $_POST['reason'];


        $query = "UPDATE enrollee SET Status='Rejected', rejectReason=? WHERE EnrolleeID=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $reason, $userID);

        if($stmt->execute()) {
            echo "success";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid request.";
    }
?>
