<?php
session_start();

if (!isset($_SESSION["form_data"])) {
    header("Location: index.php"); // Redirect back if no data
    exit();
}

$form_data = $_SESSION["form_data"];
$dob = new DateTime($form_data["dob"]);
$today = new DateTime();
$age = $dob->diff($today)->y;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Results</title>
</head>
<body>
    <h1>Submitted Data</h1>
    <p><strong>Name:</strong> <?php echo ucwords(htmlspecialchars($form_data["lname"])); ?>, <?php echo ucwords(htmlspecialchars($form_data["fname"])); ?> <?php echo ucwords(htmlspecialchars($form_data["mname"])); ?>.</p>
    <p><strong>Age:</strong> <?php echo $age; ?></p>
    <p><strong>Date of Birth:</strong> <?php echo ucwords(htmlspecialchars($form_data["dob"])); ?></p>
    <p><strong>Place of Birth:</strong> <?php echo ucwords(htmlspecialchars($form_data["pob"])); ?></p>
    <p><strong>Gender:</strong> <?php echo ucwords(htmlspecialchars($form_data["sex"])); ?></p>
    <p><strong>Civil Status:</strong> <?php echo ucwords(htmlspecialchars($form_data["status"])); ?></p>
    <p><strong>Region:</strong> <?php echo ucwords(htmlspecialchars($form_data["region_name"] ?? "N/A")); ?></p>
    <p><strong>Province:</strong> <?php echo ucwords(htmlspecialchars($form_data["province_name"] ?? "N/A")); ?></p>
    <p><strong>City:</strong> <?php echo ucwords(htmlspecialchars($form_data["city_name"] ?? "N/A")); ?></p>
    <p><strong>Barangay:</strong> <?php echo ucwords(htmlspecialchars($form_data["barangay_name"] ?? "N/A")); ?></p>
    <p><strong>Nationality:</strong> <?php echo ucwords(htmlspecialchars($form_data["nationality"])); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($form_data["email-address"] ?? 'N/A'); ?></p>
    <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($form_data["phone-number"] ?? 'N/A'); ?></p>
    <p><strong>Home Address:</strong> <?php echo ucwords(htmlspecialchars($form_data["complete-address"])); ?></p>

    <a href="index.php">Go Back</a>
</body>
</html>
