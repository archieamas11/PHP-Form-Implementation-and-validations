<?php
require_once "config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $sql = "DELETE FROM tbl_users WHERE user_id='$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: table.php?delete=success");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
