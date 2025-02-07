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
    <link rel="stylesheet" href="result.css">
</head>
<body>
    <div class="container">

    <div class="title">
    <h1>Submitted Data</h1>

    <a href="index.php" class="button">Go Back</a>

    </div>
        
        <div class="data-group">
            <!-- Personal Information -->
            <p><strong>Name:</strong> <?php echo ucwords(htmlspecialchars($form_data["lname"])); ?>, <?php echo ucwords(htmlspecialchars($form_data["fname"])); ?> <?php echo ucwords(htmlspecialchars($form_data["mname"])); ?></p>
            <p><strong>Age:</strong> <?php echo $age; ?></p>
            <p><strong>Date of Birth:</strong> <?php echo ucwords(htmlspecialchars($form_data["dob"])); ?></p>
            <p><strong>Place of Birth:</strong> <?php echo ucwords(htmlspecialchars($form_data["pob"])); ?></p>
            <p><strong>Religion:</strong> <?php echo ucwords(htmlspecialchars($form_data["religion"] ?? "N/A")); ?></p>
            <p><strong>Gender:</strong> <?php echo ucwords(htmlspecialchars($form_data["sex"])); ?></p>
            <p><strong>Civil Status:</strong> <?php echo ucwords(htmlspecialchars($form_data["status"])); ?></p>
        </div>

        <div class="data-group">
            <!-- Address Information -->
            <p><strong>Region:</strong> <?php echo ucwords(htmlspecialchars($form_data["region_name"] ?? "N/A")); ?></p>
            <p><strong>Province:</strong> <?php echo ucwords(htmlspecialchars($form_data["province_name"] ?? "N/A")); ?></p>
            <p><strong>City:</strong> <?php echo ucwords(htmlspecialchars($form_data["city_name"] ?? "N/A")); ?></p>
            <p><strong>Barangay:</strong> <?php echo ucwords(htmlspecialchars($form_data["barangay_name"] ?? "N/A")); ?></p>
            <p><strong>Home Address:</strong> <?php echo ucwords(htmlspecialchars($form_data["complete-address"])); ?></p>
        </div>

        <div class="data-group">
            <!-- Contact & Family -->
            <p><strong>Email:</strong> <?php echo htmlspecialchars($form_data["email-address"] ?? 'N/A'); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($form_data["phone-number"] ?? 'N/A'); ?></p>
            <p><strong>Telephone Number:</strong> <?php echo htmlspecialchars($form_data["tel"] ?? 'N/A'); ?></p>
            <p><strong>Father's Name:</strong> <?php echo ucwords(htmlspecialchars($form_data["flname"] ?? 'N/A')); ?>, <?php echo ucwords(htmlspecialchars($form_data["ffname"] ?? 'N/A')); ?> <?php echo ucwords(htmlspecialchars($form_data["fmname"] ?? 'N/A')); ?></p>
            <p><strong>Mother's Name:</strong> <?php echo ucwords(htmlspecialchars($form_data["mlname"] ?? 'N/A')); ?>, <?php echo ucwords(htmlspecialchars($form_data["mfname"] ?? 'N/A')); ?> <?php echo ucwords(htmlspecialchars($form_data["mmname"] ?? 'N/A')); ?></p>
        </div>
    </div>
</body>
</html>