<?php
function getStudentProfile($conn, $user_id)
{
    $stmt = $conn->prepare("SELECT * FROM studentprofile WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $profile = $result->fetch_assoc();
    $stmt->close();
    return $profile;
}
