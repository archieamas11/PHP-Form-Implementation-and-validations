<?php
require_once "config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $sql = "SELECT * FROM tbl_users WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
} else {
    header("Location: index.php"); // Redirect if accessed directly
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>
    <form action="update_user.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $user['user_full_name']; ?>" required><br>

        <label>Date of Birth:</label>
        <input type="date" name="dob" value="<?php echo $user['date_of_birth']; ?>" required><br>

        <label>Sex:</label>
        <select name="sex" required>
            <option value="Male" <?php echo ($user['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?php echo ($user['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
        </select><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
