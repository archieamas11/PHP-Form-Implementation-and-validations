<?php include 'edit_modal.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern DataTable</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="table.css" />
    <link rel="stylesheet" href="index.css" />


</head>

<body>
    <table id="myTable" class="display">
        <?php
        require_once "include/database.php";
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
                        <form action="delete_user.php" method="POST" onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="user_id" value="<?php echo $row["user_id"]; ?>">
                            <button type="submit" class="btn icon delete-btn"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>


                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        <?php endif; ?>
    </table>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("editModal");
    const closeBtn = document.querySelector(".close");

    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function() {
            const userId = this.dataset.id;

            fetch("http://localhost/php-form/fetch_user.php", { // Adjust the port if necessary
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `user_id=${userId}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    alert("Error: " + data.error);
                } else {
                    // Populate form fields
                    document.getElementById("edit-user-id").value = data.user_id;
                    document.getElementById("edit-name").value = data.user_full_name;
                    document.getElementById("edit-dob").value = data.date_of_birth;
                    document.getElementById("edit-birth-place").value = data.place_of_birth;
                    document.getElementById("edit-nationality").value = data.nationality;
                    document.getElementById("edit-tax-number").value = data.tax_identification_number;
                    document.getElementById("edit-phone").value = data.phone_number;
                    document.getElementById("edit-telephone").value = data.telephone_number;
                    document.getElementById("edit-email").value = data.email_address;
                    document.getElementById("edit-region").value = data.region;
                    document.getElementById("edit-province").value = data.province;
                    document.getElementById("edit-municipality").value = data.municipality;
                    document.getElementById("edit-barangay").value = data.barangay;
                    document.getElementById("edit-home-address").value = data.home_address;
                    document.getElementById("edit-zipcode").value = data.zip_code;
                    document.getElementById("edit-father-name").value = data.fathers_full_name;
                    document.getElementById("edit-mother-name").value = data.mothers_full_name;

                    // Handle radio button selection for sex
                    if (data.sex === "male") {
                        document.getElementById("edit-sex-male").checked = true;
                    } else if (data.sex === "female") {
                        document.getElementById("edit-sex-female").checked = true;
                    }

                    // Handle civil status selection
                    document.getElementById("edit-status").value = data.civil_status;
                    if (data.civil_status === "others") {
                        document.getElementById("otherStatus").style.display = "block";
                        document.getElementById("otherStatus").value = data.other_status || "";
                    } else {
                        document.getElementById("otherStatus").style.display = "none";
                    }

                    modal.style.display = "block";
                }
            })
            .catch(error => {
                console.error("Error fetching data:", error);
                alert("An error occurred while fetching user data.");
            });
        });
    });

    closeBtn.addEventListener("click", function() {
        modal.style.display = "none";
    });

    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
</script>


</body>

</html>