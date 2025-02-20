<?php include 'edit_modal.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern DataTable</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="table.css"/>
    <link rel="stylesheet" href="index.css"/>
</head>

<body>
    <div class="table-container">
        <!-- this is for menu -->
        <div class="sidebar">
        </div>
        <div class="content-wrapper">
            <table id="myTable" class="display">
                <?php
        require_once "config/database.php";
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
                                <!-- Edit Button (Triggers Modal) -->
                                <button class="btn icon edit-btn" data-id="<?php echo $row['user_id']; ?>">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Delete Button -->
                                <form action="delete_user.php" method="POST"
                                    onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="user_id" value="<?php echo $row["user_id"]; ?>">
                                    <button type="submit" class="btn icon delete-btn"><i
                                            class="fas fa-trash"></i></button>
                                </form>

                                <!-- View Button -->
                                <button class="btn icon edit-btn" data-id="<?php echo $row['user_id']; ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>


                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="js/edit-regions.js"></script>
<script src="js/modal.js"></script>

</html>