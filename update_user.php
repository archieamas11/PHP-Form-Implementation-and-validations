<?php
require_once "config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $sex = $_POST['sex'];
    $status = $_POST['status'];


    $sql = "UPDATE tbl_users SET user_full_name='$name', date_of_birth='$dob', sex='$sex', civil_status='$status' WHERE user_id='$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: table.php?update=success");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
