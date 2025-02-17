<?php
require_once "include/database.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
</head>

<body>
    <table id="myTable" class="display">
        <?php
            $sql    = "SELECT * FROM tbl_users";
            $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0): ?>
        <thead>
            <tr>
                <th>ID #</th>
                <th>Name</th>
                <th>Date of Birth</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Home Address</th>
                <th>Contacts</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($result)):

                    $nametrim     = str_replace(",", "</br>", $row["user_full_name"]);
                    $birthtrim    = str_replace(",", "</br>", $row["date_of_birth"]);
                    $current_year = date("Y");
                    $birth_year   = date("Y", strtotime($row["date_of_birth"]));
                    $age          = $current_year - $birth_year;
                    $home_address =
                        $row["region"] .
                        ", " .
                        $row["province"] .
                        ",</br> " .
                        $row["municipality"] .
                        ", " .
                        $row["barangay"] .
                        ",</br> " .
                        $row["zip_code"];
                    $contact_information =
                        $row["phone_number"] .
                        ",</br> " .
                        $row["email_address"] .
                        ",</br> " .
                        $row["telephone_number"];
                ?>
	            <tr>
	                <td><?php echo $row["user_id"]; ?></td>
	                <td><?php echo ucwords($nametrim); ?></td>
	                <td><?php echo $birthtrim; ?></td>
	                <td><?php echo $age; ?></td>
	                <td><?php echo ucwords($row["sex"]); ?></td>
	                <td><?php echo ucwords($home_address); ?></td>
	                <td><?php echo ucwords($contact_information); ?></td>
	                <td>
	                    <div class="buttons">
	                        <a href="#" class="btn icon"><i class="bi bi-pencil-square"></i></a>
	                        <a href="#" class="btn icon"><i class="bi bi-trash3"></i></a>
	                        <a href="#" class="btn icon"><i class="bi bi-eye"></i></a>
	                    </div>
	                </td>
	            </tr>
	            <?php
                endwhile; ?>
        </tbody>
        <?php endif;
        ?>
    </table>

</body>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script>
$(document).ready(function() {
    $('#myTable').DataTable();
});
</script>

</html>