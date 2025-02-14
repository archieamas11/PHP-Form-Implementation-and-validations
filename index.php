<?php
    $debug = true;
    session_start();
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        function validate_name_fields(array $fields) {
            global $errors;
            foreach ($fields as $field => $field_name) {
                $value = trim($_POST[$field] ?? '');
                $is_middle_name = in_array($field, ['mname', 'mmname', 'fmname']);   
                if (empty($value)) {
                    if (!$is_middle_name) {
                        $errors[$field] = "Please enter your $field_name.";
                    }
                } elseif (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/", $value)) {
                    $errors[$field] = "$field_name can only contain letters and spaces.";
                } elseif (!$is_middle_name && (strlen($value) < 2 || strlen($value) > 50)) {
                    $errors[$field] = "$field_name must be between 2 and 50 characters.";
                }
            }
        }
    
        // Validate multiple name fields at once
        validate_name_fields([
            "lname"  => "last name",
            "fname"  => "first name",
            "mname"  => "middle name",
            "flname" => "father's last name",
            "ffname" => "father's first name",
            "fmname" => "father's middle name",
            "mlname" => "mother's last name",
            "mfname" => "mother's first name",
            "mmname" => "mother's middle name"
        ]);

        function no_white_spaces(array $no_space_fields) {
            global $errors; // Access the global $errors array
        
            foreach ($no_space_fields as $field => $field_label) {
                if (!empty($_POST[$field]) && preg_match("/\s{2,}/", $_POST[$field])) {
                    $errors[$field] = "$field_label should not contain 2 or more consecutive spaces."; // Use field label instead of field name
                }
            }
        }
        
        // Call the function with field names as keys and labels as values
        no_white_spaces([
            "lname" => "Last Name",
            "fname" => "First Name",
            "mname" => "Middle Name",
            "flname" => "Father's Last Name",
            "ffname" => "Father's First Name",
            "fmname" => "Father's Middle Name",
            "mlname" => "Mother's Last Name",
            "mfname" => "Mother's First Name",
            "mmname" => "Mother's Middle Name",
            "otherStatus" => "Civil Status",
            "pob" => "Place of Birth",
            "nationality" => "Nationality",
            "complete-address" => "Home Address",
            "region" => "Region",
            "province" => "Province",
            "city" => "City",
            "barangay" => "Barangay",
            "zip" => "Zip Code",
            "email-address" => "Email Address",
            "phone-number" => "Phone Number",
            "tel" => "Telephone Number"
        ]);
         
       
        // Validate Date of Birth (must be at least 18 years old)
    if (empty($_POST["dob"])) {
        $errors["dob"] = "Please enter your Date of Birth.";
    } else {
        $dob = DateTime::createFromFormat('Y-m-d', $_POST["dob"]);
        $today = new DateTime();
        $age = $today->diff($dob)->y;
        if ($age < 18) {
            $errors["dob"] = "You must be at least 18 years old.";
        }
    }

    // Validate required fields
    $required_fields = ["pob" => "Place of Birth", "sex" => "Gender", "status" => "Civil Status", "nationality" => "Nationality", "complete-address" => "Home Address", "region" => "Region", "province" => "Province", "city" => "City", "barangay" => "Barangay", "zip" => "Zip Code"];
    
    foreach ($required_fields as $field => $label) {
        if (empty(trim($_POST[$field] ?? ''))) {
            $errors[$field] = "Please enter/select your $label.";
        }
    }

    // Validate Tax Identification Number (TIN) (optional)
    if (!empty($_POST["tax"]) && !preg_match("/^\d{9,12}$/", $_POST["tax"])) {
        $errors["tax"] = "TIN must be 9-12 digits only.";
    }

    // Validate Email (optional)
    if (!empty($_POST["email-address"]) && !filter_var($_POST["email-address"], FILTER_VALIDATE_EMAIL)) {
        $errors["email-address"] = "Please enter a valid email address.";
    }

    // Validate Phone Number (optional, PH format 09XXXXXXXXX)
    if (!empty($_POST["phone-number"]) && !preg_match("/^09[0-9]{9}$/", $_POST["phone-number"])) {
        $errors["phone-number"] = "Phone number must be a valid PH number (09XXXXXXXXX).";
    } else if (empty($_POST["phone-number"])) {
        $errors["phone-number"] = "Please enter your Phone Number.";
    }

    if (!empty($_POST["tel"]) && !preg_match("/^(0[2-9]\d{1,2}-?\d{6,7})$/", $_POST["tel"])) {
        $errors["tel"] = "Telephone number must be a valid PH landline.";
    }
    

    // Validate Zip Code (optional, exactly 4 digits)
    if (!empty($_POST["zip"]) && !preg_match("/^\d{4}$/", $_POST["zip"])) {
        $errors["zip"] = "Zip Code must be exactly 4 digits.";
    }
    

    // If no errors, store data in session and redirect
    if (empty($errors)) {
        $_SESSION["form_data"] = array_map("htmlspecialchars", $_POST);
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
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <section class="page-1">
        <!-- personal information details -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="center">
                <div class="title">
                    <h1>Personal Data Form</h1>
                </div>
                <?php 
            if ($debug): ?>
                <div class="test-buttons">
                    <button class="test-btn filled" type="button" onclick="fillForm()">Fill All Fields</button>
                </div>
                <?php endif; ?>
                <div class="container">
                    <h1>Personal Data</h1>
                    <div class="personal-info">
                        <div class="form">
                            <label for="lname">Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="lname" id="lname" placeholder="Enter last name"
                                value="<?php echo $_POST['lname'] ?? ''; ?>"
                                class="<?php echo isset($errors['lname']) ? 'error' : '' ?>" >
                            <span class="error-feedback text-danger"><?php echo $errors['lname'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="fname">First Name <span class="text-danger">*</span></label> <br>
                            <input type="text" name="fname" id="fname" placeholder="Enter first name"
                                value="<?php echo $_POST['fname'] ?? ''; ?>"
                                class="<?php echo isset($errors['fname']) ? 'error' : '' ?>" >
                            <span class="error-feedback text-danger"><?php echo $errors['fname'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="mname">Middle Initial</label>
                            <input type="text" name="mname" id="mname" placeholder="M.I."
                                value="<?php echo htmlspecialchars($_POST['mname'] ?? '') ?>"
                                class="<?php echo isset($errors['mname']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['mname'] ?? '' ?></span>
                        </div>
                        <div class="form">
                            <label for="dob">Date of Birth <span class="text-danger">*</span></label> <br>
                            <input type="date" name="dob" id="dob"
                                value="<?php echo htmlspecialchars($_POST['dob'] ?? '') ?>"
                                class="<?php echo isset($errors['dob']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['dob'] ?? '' ?></span>
                        </div>   

                        <div class="form">
                            <label>Sex <span class="text-danger">*</span></label> <br>
                            <div class="radio-group">
                                <input type="radio" name="sex" id="male" value="male"
                                    <?php if (isset($_POST['sex']) && $_POST['sex'] == 'male') echo 'checked'; ?>
                                    >
                                <label for="male">Male</label>
                                <input type="radio" name="sex" id="female" value="female"
                                    <?php if (isset($_POST['sex']) && $_POST['sex'] == 'female') echo 'checked'; ?>>
                                <label for="female">Female</label>
                                <input type="radio" name="sex" id="other" value="other"
                                    <?php if (isset($_POST['sex']) && $_POST['sex'] == 'other') echo 'checked'; ?>>
                                <label for="other">Other</label>
                            </div>
                            <span class="error-feedback text-danger"><?php echo $errors['sex'] ?? ''; ?></span>
                        </div>
                        <div class="form">
                            <label for="status">Civil Status <span class="text-danger">*</span></label> <br>
                            <div class="form-group-radio">
                                <select name="status" id="status" onchange="toggleOtherStatus()" >
                                    <option value="single"
                                        <?php if (isset($_POST['status']) && $_POST['status'] == 'single') echo 'selected'; ?>>
                                        Single</option>
                                    <option value="married"
                                        <?php if (isset($_POST['status']) && $_POST['status'] == 'married') echo 'selected'; ?>>
                                        Married</option>
                                    <option value="widowed"
                                        <?php if (isset($_POST['status']) && $_POST['status'] == 'widowed') echo 'selected'; ?>>
                                        Widowed</option>
                                    <option value="divorced"
                                        <?php if (isset($_POST['status']) && $_POST['status'] == 'divorced') echo 'selected'; ?>>
                                        Legally Separated</option>
                                    <option value="others"
                                        <?php if (isset($_POST['status']) && $_POST['status'] == 'others') echo 'selected'; ?>>
                                        Others</option>
                                </select>
                                <input type="text" id="otherStatus" name="otherStatus" placeholder="Enter civil status"
                                    class="<?php echo isset($errors['otherStatus']) ? 'error' : '' ?>"
                                    value="<?php echo isset($_POST['otherStatus']) ? htmlspecialchars($_POST['otherStatus']) : ''; ?>"
                                    style="display: none;" onblur="resetDropdown()" />
                                <span
                                    class="error-feedback text-danger"><?php echo $errors['otherStatus'] ?? ''; ?></span>
                            </div>
                        </div>

                        <div class="form">
                            <label for="tax">Tax Identification Number</label> <br>
                            <input type="number" name="tax" id="tax" placeholder="Enter TIN"
                                value="<?php echo htmlspecialchars($_POST['tax'] ?? '') ?>"
                                class="<?php echo isset($errors['tax']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['tax'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="nationality">Nationality <span class="text-danger">*</span></label> <br>
                            <input type="text" name="nationality" id="nationality" placeholder="Enter nationality"
                                value="<?php echo htmlspecialchars($_POST['nationality'] ?? '') ?>" 
                                class="<?php echo isset($errors['nationality']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['nationality'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="religion">Religion</label> <br>
                            <input type="text" name="religion" id="religion" placeholder="Enter religion"
                                value="<?php echo htmlspecialchars($_POST['religion'] ?? '') ?>"
                                class="<?php echo isset($errors['religion']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['religion'] ?? ''; ?></span>
                        </div>   
                        <div class="long">
                            <div class="form">
                                <label for="pob">Place of Birth <span class="text-danger">*</span></label> <br>
                                <input type="text" name="pob" id="pob" placeholder="Enter place of birth"
                                    value="<?php echo htmlspecialchars($_POST['pob'] ?? '') ?>"
                                    class="<?php echo isset($errors['pob']) ? 'error' : '' ?>" >
                                <span class="error-feedback text-danger"><?php echo $errors['pob'] ?? ''; ?></span>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <!-- location details -->
                <div class=" container">
                    <h1>Home Address</h1>
                    <div class="location-info">
                        <div class="form">
                            <label for="region">Region <span class="text-danger">*</span></label> <br>
                            <select id="region" name="region"
                                class="<?php echo isset($errors['region']) ? 'error' : ''; ?>" >
                                <option value="">Select Region</option>
                            </select>
                            <input type="hidden" name="region_name" id="region_name"
                                value="<?php echo $_POST['region_name'] ?? ''; ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['region'] ?? ''; ?></span>
                        </div>
                        <div class="form">
                            <label for="province">Province <span class="text-danger">*</span></label> <br>
                            <select id="province" name="province"
                                class="<?php echo isset($errors['province']) ? 'error' : ''; ?>" disabled >
                                <option value="">Select Province</option>
                            </select>
                            <input type="hidden" name="province_name" id="province_name"
                                value="<?php echo $_POST['province_name'] ?? ''; ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['province'] ?? ''; ?></span>
                        </div>
                        <div class="form">
                            <label for="city">City/Municipality <span class="text-danger">*</span></label> <br>
                            <select id="city" name="city" disabled 
                                class="<?php echo isset($errors['city']) ? 'error' : ''; ?>">
                                <option value="">Select City/Municipality</option>
                            </select>
                            <input type="hidden" name="city_name" id="city_name"
                                value="<?php echo $_POST['city_name'] ?? ''; ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['city'] ?? ''; ?></span>
                        </div>
                        <div class="form">
                            <label for="barangay">Barangay <span class="text-danger">*</span></label> <br>
                            <select id="barangay" name="barangay" disabled 
                                class="<?php echo isset($errors['barangay']) ? 'error' : ''; ?>">
                                <option value="">Select Barangay</option>
                            </select>
                            <input type="hidden" name="barangay_name" id="barangay_name"
                                value="<?php echo $_POST['barangay_name'] ?? ''; ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['barangay'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="zip">Zip Code <span class="text-danger">*</span></label> <br>
                            <input type="text" name="zip" id="zip" placeholder="Enter zip code"
                                value="<?php echo $_POST['zip'] ?? ''; ?>" 
                                class="<?php echo isset($errors['zip']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['zip'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="complete-address">Home Address <span class="text-danger">*</span></label> <br>
                            <input type="text" name="complete-address" id="complete-address"
                                placeholder="Street Name, Building, House No."
                                value="<?php echo $_POST['complete-address'] ?? ''; ?>" 
                                class="<?php echo isset($errors['complete-address']) ? 'error' : '' ?>">
                            <span
                                class="error-feedback text-danger"><?php echo $errors['complete-address'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="email-address">E-mail Address</label> <br>
                            <input type="email" name="email-address" id="email-address" placeholder="Enter email"
                                value="<?php echo $_POST['email-address'] ?? ''; ?>"
                                class="<?php echo isset($errors['email-address']) ? 'error' : '' ?>">
                            <span
                                class="error-feedback text-danger"><?php echo $errors['email-address'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="phone-number">Phone Number <span class="text-danger">*</span></label> <br>
                            <input type="number" name="phone-number" id="phone-number" placeholder="Enter phone number"
                                 value="<?php echo $_POST['phone-number'] ?? ''; ?>"
                                class="<?php echo isset($errors['phone-number']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['phone-number'] ?? ''; ?></span>
                        </div>

                        <div class="form">
                            <label for="tel">Telephone Number</label> <br>
                            <input type="tel" name="tel" id="tel" placeholder="Enter telephone number"
                                value="<?php echo $_POST['tel'] ?? ''; ?>"
                                class="<?php echo isset($errors['tel']) ? 'error' : '' ?>">
                            <span class="error-feedback text-danger"><?php echo $errors['tel'] ?? ''; ?></span>
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
                                <input type="text" name="flname" id="flname" placeholder="Enter last name"
                                    value="<?php echo $_POST['flname'] ?? ''; ?>"
                                    class="<?php echo isset($errors['flname']) ? 'error' : '' ?>">
                                <span class="error-feedback text-danger"><?php echo $errors['flname'] ?? ''; ?></span>
                            </div>
                            <div class="form">
                                <label for="ffname">First Name</label> <br>
                                <input type="text" name="ffname" id="ffname" placeholder="Enter first name"
                                    value="<?php echo $_POST['ffname'] ?? ''; ?>"
                                    class="<?php echo isset($errors['ffname']) ? 'error' : '' ?>">
                                <span class="error-feedback text-danger"><?php echo $errors['ffname'] ?? ''; ?></span>
                            </div>
                            <div class="form">
                                <label for="flname">Middle Initial</label> <br>
                                <input type="text" name="fmname" id="fmname" placeholder="M.I."
                                    value="<?php echo $_POST['fmname'] ?? ''; ?>"
                                    class="<?php echo isset($errors['fmname']) ? 'error' : '' ?>">
                                <span class="error-feedback text-danger"><?php echo $errors['fmname'] ?? ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <h1>Mother's Maiden Name</h1>
                        <div class="parent-info">
                            <div class="form">
                                <label for="mlname">Last Name</label> <br>
                                <input type="text" name="mlname" id="mlname" placeholder="Enter last name"
                                    value="<?php echo $_POST['mlname'] ?? ''; ?>"
                                    class="<?php echo isset($errors['mlname']) ? 'error' : '' ?>">
                                <span class="error-feedback text-danger"><?php echo $errors['mlname'] ?? ''; ?></span>
                            </div>
                            <div class="form">
                                <label for="mfname">First Name</label> <br>
                                <input type="text" name="mfname" id="mfname" placeholder="Enter first name"
                                    value="<?php echo $_POST['mfname'] ?? ''; ?>"
                                    class="<?php echo isset($errors['mfname']) ? 'error' : '' ?>">
                                <span class="error-feedback text-danger"><?php echo $errors['mfname'] ?? ''; ?></span>
                            </div>
                            <div class="form">
                                <label for="mmname">Middle Initial</label> <br>
                                <input type="text" name="mmname" id="mmname" placeholder="M.I."
                                    value="<?php echo $_POST['mmname'] ?? ''; ?>"
                                    class="<?php echo isset($errors['mmname']) ? 'error' : '' ?>">
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
<script src="js/fill.js"></script>
<script src="js/regions.js"></script>
<script src="js/civil-status.js"></script>
<script>if (window.history.replaceState) { window.history.replaceState(null, null, window.location.href)}</script>
</html>