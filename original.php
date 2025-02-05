<?php
    session_start();
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        function validate_name_fields(array $fields) {
            global $errors;
            foreach ($fields as $field => $field_name) {
                if (empty(trim($_POST[$field] ?? ''))) {
                    $errors[$field] = "Please enter your $field_name.";
                } elseif (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/", $_POST[$field])) {
                    $errors[$field] = "$field_name can only contain letters and spaces.";
                } elseif (strlen($_POST[$field]) < 2 || strlen($_POST[$field]) > 50) {
                    $errors[$field] = "$field_name must be between 2 and 50 characters.";
                }
            }
        }
        
        // Call function for multiple fields at once
        validate_name_fields([
            "lname"  => "Last Name",
            "fname"  => "First Name",
            "flname" => "Father's Last Name",
            "ffname" => "Father's First Name",
            "mlname" => "Mother's Last Name",
            "mfname" => "Mother's First Name"
        ]);
        

        // Validate Date of Birth
        if (empty($_POST["dob"])) {
            $errors["dob"] = "Please enter your Date of Birth.";
        }

        // Validate Place of Birth
        if (empty(trim($_POST["pob"]))) {
            $errors["pob"] = "Please enter your Place of Birth.";
        }

        // Validate Gender
        if (empty($_POST["sex"])) {
            $errors["sex"] = "Please select your Gender.";
        }

        // Validate Civil Status
        if (empty($_POST["status"])) {
            $errors["status"] = "Please select your Civil Status.";
        }

        // Validate TIN
        if (! empty($_POST["tax"]) && ! preg_match("/^[0-9]{9,12}$/", $_POST["tax"])) {
            $errors["tax"] = "TIN must be 9-12 digits.";
        }

        // Validate Nationality
        if (empty($_POST["nationality"])) {
            $errors["nationality"] = "Please enter your Nationality.";
        }

        // Validate Email
        if (! empty($_POST["email-address"]) && ! filter_var($_POST["email-address"], FILTER_VALIDATE_EMAIL)) {
            $errors["email-address"] = "Please enter a valid email address.";
        }

        // Validate Phone Number
        if (! empty($_POST["phone-number"]) && ! preg_match("/^09[0-9]{9}$/", $_POST["phone-number"])) {
            $errors["phone-number"] = "Phone number must be a valid PH number (09XXXXXXXXX).";
        }

        // Validate Zip Code
        if (! empty($_POST["zip"]) && ! preg_match("/^[0-9]{4}$/", $_POST["zip"])) {
            $errors["zip"] = "Zip Code must be exactly 4 digits.";
        }

        // Validate Middle Name (optional)
        if (!empty($_POST["mname"]) && !preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/", $_POST["mname"])) {
            $errors["mname"] = "Middle name can only contain letters.";
        }

        if (!empty($_POST["mmname"]) && !preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/", $_POST["mmname"])) {
            $errors["mname"] = "Middle name can only contain letters.";
        }

        if (!empty($_POST["fmname"]) && !preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/", $_POST["fmname"])) {
            $errors["mname"] = "Middle name can only contain letters.";
        }

        // Validate Home Address
        if (empty(trim($_POST["complete-address"]))) {
            $errors["complete-address"] = "Please enter your Home Address.";
        }

                // Validate Region
        if (empty($_POST["region"])) {
            $errors["region"] = "Please select a Region.";
        }

        // Validate Province
        if (empty($_POST["province"])) {
            $errors["province"] = "Please select a Province.";
        }

        // Validate City
        if (empty($_POST["city"])) {
            $errors["city"] = "Please select a City.";
        }

        // Validate Barangay
        if (empty($_POST["barangay"])) {
            $errors["barangay"] = "Please select a Barangay.";
        }


        // If no errors, store data in session and redirect
        if (empty($errors)) {
            $_SESSION["form_data"] = [
                "lname"            => $_POST["lname"],
                "fname"            => $_POST["fname"],
                "mname"            => $_POST["mname"],
                "dob"              => $_POST["dob"],
                "pob"              => $_POST["pob"],
                "sex"              => $_POST["sex"],
                "status"           => $_POST["status"],
                "nationality"      => $_POST["nationality"],
                "email-address"    => $_POST["email-address"] ?? '',
                "phone-number"     => $_POST["phone-number"] ?? '',
                "complete-address" => $_POST["complete-address"],
                "region"           => $_POST["region"],
                "province"         => $_POST["province"],
                "city"             => $_POST["city"],
                "barangay"         => $_POST["barangay"],
                "region_name"      => $_POST["region_name"],
                "province_name"    => $_POST["province_name"],
                "city_name"        => $_POST["city_name"],
                "barangay_name"    => $_POST["barangay_name"],
            ];
            header("Location: result.php");
            exit();
        }
    }
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP-Form</title>
    <link rel="stylesheet" href="original.css">
</head>

<body>
    <section class="page-1">
        <!-- personal information details -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

        <div class="center">
            <div class="title">
            <button type="button" onclick="fillForm()">Fill All Fields</button>
            <button type="submit">Submit</button>

                <h1>Personal Data Form</h1>
            </div>
            <div class="container">
                <h1>Personal Information</h1>
                <div class="personal-info">
                        <div class="form">
                            <label for="lname">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="lname" id="lname" placeholder="Enter last name" value="<?php echo $_POST['lname'] ?? ''; ?>" class="<?php echo isset($errors['lname']) ? 'error' : '' ?>" required>
                            <span class="error-feedback text-danger"><?php echo $errors['lname'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="fname">First Name <span class="text-danger">*</span></label> <br>
                            <input type="text" name="fname" id="fname" placeholder="Enter first name"
                                value="<?php echo $_POST['fname'] ?? ''; ?>" 
                                class="<?php echo isset($errors['fname']) ? 'error' : '' ?>" required>
                            <span class="error-feedback text-danger"><?php echo $errors['fname'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="mname">Middle Initial</label>
                            <input type="text"
                                   name="mname"
                                   id="mname"
                                   placeholder="M.I."
                                   value="<?php echo htmlspecialchars($_POST['mname'] ?? '') ?>"
                                   class="<?php echo isset($errors['mname']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['mname'] ?? '' ?></span>
                        </div>
                        <div class="form">
                            <label for="dob">Date of Birth <span class="text-danger">*</span></label> <br>
                            <input type="date"
                                   name="dob"
                                   id="dob"
                                   value="<?php echo htmlspecialchars($_POST['dob'] ?? '') ?>"
                                   class="<?php echo isset($errors['dob']) ? 'error' : '' ?>">
                                   <span class="error-feedback text-danger"><?php echo $errors['dob'] ?? '' ?></span>                        
                        </div>
                        <div class="form">
                            <label for="pob">Place of Birth <span class="text-danger">*</span></label> <br>
                            <input type="text" name="pob" id="pob" placeholder="Enter place of birth" value="<?php echo htmlspecialchars($_POST['pob'] ?? '') ?>" class="<?php echo isset($errors['dob']) ? 'error' : '' ?>" required>
                            <span class="error-feedback text-danger"><?php echo $errors['pob'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label>Sex <span class="text-danger">*</span></label> <br>
                            <div class="radio-group">
                            <input type="radio" name="sex" id="male" value="male" <?php if (isset($_POST['sex']) && $_POST['sex'] == 'male') echo 'checked'; ?> required>
                            <label for="male">Male</label>
                            <input type="radio" name="sex" id="female" value="female" <?php if (isset($_POST['sex']) && $_POST['sex'] == 'female') echo 'checked'; ?>>
                            <label for="female">Female</label>
                            <input type="radio" name="sex" id="other" value="other" <?php if (isset($_POST['sex']) && $_POST['sex'] == 'other') echo 'checked'; ?>>
                            <label for="other">Other</label>
                            </div>
                        </div>

                        <div class="form">
                            <label for="status">Civil Status <span class="text-danger">*</span></label> <br>
                            <div class="form-group-radio">
                                <select name="status" id="status" onchange="toggleOtherStatus()" required>
                                <option value="single" <?php if (isset($_POST['status']) && $_POST['status'] == 'single') echo 'selected'; ?>>Single</option>
                                <option value="married" <?php if (isset($_POST['status']) && $_POST['status'] == 'married') echo 'selected'; ?>>Married</option>
                                <option value="widowed" <?php if (isset($_POST['status']) && $_POST['status'] == 'widowed') echo 'selected'; ?>>Widowed</option>
                                <option value="divorced" <?php if (isset($_POST['status']) && $_POST['status'] == 'divorced') echo 'selected'; ?>>Legally Separated</option>
                                <option value="others" <?php if (isset($_POST['status']) && $_POST['status'] == 'others') echo 'selected'; ?>>Others</option>
                                </select>
                                <input type="text" id="otherStatus" name="otherStatus" placeholder="Enter civil status"
                                    style="display: none;" onblur="resetDropdown()" />
                            </div>
                        </div>

                        <div class="form">
                            <label for="tax">Tax Identification Number</label> <br>
                            <input type="text" name="tax" id="tax" placeholder="Enter TIN" value="<?php echo htmlspecialchars($_POST['tax'] ?? '') ?>" class="<?php echo isset($errors['tax']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['tax'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="nationality">Nationality <span class="text-danger">*</span></label> <br>
                            <input type="text" name="nationality" id="nationality" placeholder="Enter nationality" value="<?php echo htmlspecialchars($_POST['nationality'] ?? '') ?>" required class="<?php echo isset($errors['nationality']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['nationality'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="religion">Religion</label> <br>
                            <input type="text" name="religion" id="religion" placeholder="Enter religion" value="<?php echo htmlspecialchars($_POST['religion'] ?? '') ?>" class="<?php echo isset($errors['religion']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['religion'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="email-address">E-mail Address</label> <br>
                            <input type="email" name="email-address" id="email-address" placeholder="Enter email" value="<?php echo $_POST['email-address'] ?? ''; ?>" class="<?php echo isset($errors['email-address']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['email-address'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="phone-number">Phone Number <span class="text-danger">*</span></label> <br>
                            <input type="tel" name="phone-number" id="phone-number" placeholder="Enter phone number"
                                required value="<?php echo $_POST['phone-number'] ?? ''; ?>" class="<?php echo isset($errors['phone-number']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['phone-number'] ?? ''; ?></span>
                        </div>
                </div>
            </div>
            <!-- location details -->
            <div class=" container">
                <h1>Location Details</h1>
                <div class="location-info">
                    <div class="form">
                        <label for="region">Region <span class="text-danger">*</span></label> <br>
                        <select id="region" name="region" class="<?php echo isset($errors['region']) ? 'error' : ''; ?>" required>
                            <option value="">Select Region</option>
                        </select>
                        <input type="hidden" name="region_name" id="region_name" value="<?php echo $_POST['region_name'] ?? ''; ?>">
                        <span class="error-feedback text-danger"><?php echo $errors['region'] ?? ''; ?></span>
                    </div>
                    <div class="form">
                        <label for="province">Province <span class="text-danger">*</span></label> <br>
                        <select id="province" name="province" class="<?php echo isset($errors['province']) ? 'error' : ''; ?>" disabled required>
                            <option value="">Select Province</option>
                        </select>
                        <input type="hidden" name="province_name" id="province_name" value="<?php echo $_POST['province_name'] ?? ''; ?>">
                        <span class="error-feedback text-danger"><?php echo $errors['province'] ?? ''; ?></span>
                        </div>
                    <div class="form">
                        <label for="city">City/Municipality <span class="text-danger">*</span></label> <br>
                        <select id="city" name="city" disabled required class="<?php echo isset($errors['city']) ? 'error' : ''; ?>">
                            <option value="">Select City/Municipality</option>
                        </select>
                        <input type="hidden" name="city_name" id="city_name" value="<?php echo $_POST['city_name'] ?? ''; ?>">
                        <span class="error-feedback text-danger"><?php echo $errors['city'] ?? ''; ?></span>
                    </div>
                    <div class="form">
                        <label for="barangay">Barangay <span class="text-danger">*</span></label> <br>
                        <select id="barangay" name="barangay" disabled required class="<?php echo isset($errors['barangay']) ? 'error' : ''; ?>">
                            <option value="">Select Barangay</option>
                        </select>
                        <input type="hidden" name="barangay_name" id="barangay_name" value="<?php echo $_POST['barangay_name'] ?? ''; ?>">
                        <span class="error-feedback text-danger"><?php echo $errors['barangay'] ?? ''; ?></span>
                    </div>

                    <div class="form">
                        <label for="zip">Zip Code <span class="text-danger">*</span></label> <br>
                        <input type="text" name="zip" id="zip" placeholder="Enter zip code" value="<?php echo $_POST['zip'] ?? ''; ?>" required class="<?php echo isset($errors['zip']) ? 'error' : '' ?>">
                        <span class="error-feedback text-danger"><?php echo $errors['zip'] ?? ''; ?></span>
                    </div>

                    <div class="form">
                        <label for="complete-address">Home Address <span class="text-danger">*</span></label> <br>
                        <input type="text" name="complete-address" id="complete-address" placeholder="Street Name, Building, House No." value="<?php echo $_POST['complete-address'] ?? ''; ?>" required class="<?php echo isset($errors['complete-address']) ? 'error' : '' ?>">
                        <span class="error-feedback text-danger"><?php echo $errors['complete-address'] ?? ''; ?></span>
                    </div>
                </div>
            </div>
            <!-- parent informatio details -->
            <div class="parent-container">
                <div class="container">
                    <h1>Father's Name</h1>
                    <div class="parent-info">
                        <div class="form">
                            <label for="flname">Last Name</label> <br>
                            <input type="text" name="flname" id="flname" placeholder="Enter last name" value="<?php echo $_POST['flname'] ?? ''; ?>" class="<?php echo isset($errors['flname']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['flname'] ?? ''; ?></span>
                        </div>
                        <div class="form">
                            <label for="ffname">First Name</label> <br>
                            <input type="text" name="ffname" id="ffname" placeholder="Enter first name" value="<?php echo $_POST['ffname'] ?? ''; ?>" class="<?php echo isset($errors['ffname']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['ffname'] ?? ''; ?></span>
                        </div>
                        <div class="form">
                            <label for="flname">Middle Initial</label> <br>
                            <input type="text" name="fmname" id="fmname" placeholder="M.I." value="<?php echo $_POST['fmname'] ?? ''; ?>" class="<?php echo isset($errors['fmname']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['fmname'] ?? ''; ?></span>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <h1>Mother's Maiden Name</h1>
                    <div class="parent-info">
                        <div class="form">
                            <label for="mlname">Last Name</label> <br>
                            <input type="text" name="mlname" id="mlname" placeholder="Enter last name" value="<?php echo $_POST['mlname'] ?? ''; ?>" class="<?php echo isset($errors['mlname']) ? 'error' : '' ?>"> 
                            <span class="error-feedback text-danger"><?php echo $errors['mlname'] ?? ''; ?></span>
                        </div>
                        <div class="form">
                            <label for="mfname">First Name</label> <br>
                            <input type="text" name="mfname" id="mfname" placeholder="Enter first name" value="<?php echo $_POST['mfname'] ?? ''; ?>" class="<?php echo isset($errors['mfname']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['mfname'] ?? ''; ?></span>
                        </div>
                        <div class="form">
                            <label for="mmname">Middle Initial</label> <br>
                            <input type="text" name="mmname" id="mmname" placeholder="M.I." value="<?php echo $_POST['mmname'] ?? ''; ?>" class="<?php echo isset($errors['mmname']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['mmname'] ?? ''; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="submit-btn">
                <button type="submit">Submit</button>
            </div>
            </form>
        </div>
    </section>
</body>
<script>
document.querySelector("form").addEventListener("submit", function () {
    const regionSelect = document.getElementById("region");
    const provinceSelect = document.getElementById("province");
    const citySelect = document.getElementById("city");
    const barangaySelect = document.getElementById("barangay");

    document.getElementById("region_name").value = regionSelect.options[regionSelect.selectedIndex].text;
    document.getElementById("province_name").value = provinceSelect.options[provinceSelect.selectedIndex].text;
    document.getElementById("city_name").value = citySelect.options[citySelect.selectedIndex].text;
    document.getElementById("barangay_name").value = barangaySelect.options[barangaySelect.selectedIndex].text;
});</script>
<script src="regions.js"></script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<script src="fill.js"></script>


</html>