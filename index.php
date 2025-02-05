<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP-Form</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <ul class="StepProgress">
            <li class="StepProgress-item current" data-step="1"></li>
            <li class="StepProgress-item" data-step="2"></li>
            <li class="StepProgress-item" data-step="3"></li>
        </ul>

        <div class="content-panels">
            <div class="content content-active">
                <h1 class="title">Personal Information</h1>
                <div class="personal-info">
                    <div class="form">
                        <label for="lname">Last Name <span class="text-danger">*</span></label> <br>
                        <input type="text" name="lname" id="lname" placeholder="Enter last name" required>
                        <span class="error" id="lastNameError"></span>
                    </div>
                    <div class="form">
                        <label for="lname">First Name <span class="text-danger">*</span></label> <br>
                        <input type="text" name="fname" id="fname" placeholder="Enter first name" required>
                    </div>
                    <div class="form">
                        <label for="lname">Middle Initial</label> <br>
                        <input type="text" name="mname" id="mname" placeholder="M.I.">
                    </div>
                    <div class="form">
                        <label for="dob">Date of Birth <span class="text-danger">*</span></label> <br>
                        <input type="date" name="dob" id="dob" required>
                    </div>
                    <div class="form">
                        <label for="religion">Place of Birth <span class="text-danger">*</span></label> <br>
                        <input type="text" name="pob" id="pob" placeholder="Enter place of birth" required>
                    </div>
                    <div class="form">
                        <label>Sex <span class="text-danger">*</span></label> <br>
                        <div class="radio-group">
                            <input type="radio" name="sex" id="male" value="male" required>
                            <label for="male">Male</label>
                            <input type="radio" name="sex" id="female" value="female">
                            <label for="female">Female</label>
                            <input type="radio" name="sex" id="other" value="other">
                            <label for="other">Other</label>
                        </div>
                    </div>
                    <div class="form">
                        <label for="status">Civil Status <span class="text-danger">*</span></label> <br>
                        <div class="form-group-radio">
                            <select name="status" id="status" onchange="toggleOtherStatus()" required>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="widowed">Widowed</option>
                                <option value="divorced">Legally Separated</option>
                                <option value="others">Others</option>
                            </select>
                            <input type="text" id="otherStatus" name="otherStatus" placeholder="Enter civil status"
                                style="display: none;" onblur="resetDropdown()" />
                        </div>
                    </div>
                    <div class="form">
                        <label for="tax">Tax Identification Number</label> <br>
                        <input type="text" name="tax" id="tax" placeholder="Enter TIN">
                    </div>
                    <div class="form">
                        <label for="nationality">Nationality <span class="text-danger">*</span></label> <br>
                        <input type="text" name="nationality" id="nationality" placeholder="Enter nationality" required>
                    </div>
                    <div class="form">
                        <label for="religion">Religion</label> <br>
                        <input type="text" name="religion" id="religion" placeholder="Enter religion">
                    </div>

                    <div class="form">
                        <label for="email-address">E-mail Address</label> <br>
                        <input type="email" name="email-address" id="email-address" placeholder="Enter email">
                    </div>

                    <div class="form">
                        <label for="phone-number">Phone Number <span class="text-danger">*</span></label> <br>
                        <input type="tel" name="phone-number" id="phone-number" placeholder="Enter phone number" required>
                    </div>

                </div>
            </div>
            <div class="content">
                <h1>Location Details</h1>
                <div class="location-info">
                    <div class="form">
                        <label for="region">Region <span class="text-danger">*</span></label> <br>
                        <select id="region" required>
                            <option value="">Select Region</option>
                        </select>
                    </div>
                    <div class="form">
                        <label for="province">Province <span class="text-danger">*</span></label> <br>
                        <select id="province" disabled  required>
                            <option value="">Select Province</option>
                        </select>
                    </div>
                    <div class="form">
                        <label for="city">City/Municipality <span class="text-danger">*</span></label> <br>
                        <select id="city" disabled required>
                            <option value="">Select City/Municipality</option>
                        </select>
                    </div>
                    <div class="form">

                        <label for="barangay">Barangay <span class="text-danger">*</span></label> <br>
                        <select id="barangay" disabled required>
                            <option value="">Select Barangay</option>
                        </select>
                    </div>

                    <div class="form">
                        <label for="zip">Zip Code <span class="text-danger">*</span></label> <br>
                        <input type="text" name="zip" id="zip" placeholder="Enter zip code" required>
                    </div>

                    <div class="form">
                        <label for="complete-address">Home Address <span class="text-danger">*</span></label> <br>
                        <input type="text" name="complete-address" id="complete-address" placeholder="Street Name, Building, House No." required>
                    </div>
                </div>
            </div>
            <div class="content">
                <h1>Parent Information</h1>
                <p>Father's Name</p>
                <div class="father-info">
                    <div class="form">
                        <label for="flname">Last Name</label> <br>
                        <input type="text" name="flname" id="flname" placeholder="Enter last name">
                        <span class="error" id="lastNameError"></span>
                    </div>
                    <div class="form">
                        <label for="ffname">First Name</label> <br>
                        <input type="text" name="ffname" id="ffname" placeholder="Enter first name">
                    </div>
                    <div class="form">
                        <label for="flname">Middle Initial</label> <br>
                        <input type="text" name="fmname" id="fmname" placeholder="M.I.">
                    </div>
                </div>
                <p>Mother's Maiden Name</p>
                <div class="mother-info">
                    <div class="form">
                        <label for="mlname">Last Name</label> <br>
                        <input type="text" name="mlname" id="mlname" placeholder="Enter last name">
                        <span class="error" id="lastNameError"></span>
                    </div>
                    <div class="form">
                        <label for="mfname">First Name</label> <br>
                        <input type="text" name="mfname" id="mfname" placeholder="Enter first name">
                    </div>
                    <div class="form">
                        <label for="mmname">Middle Initial</label> <br>
                        <input type="text" name="mmname" id="mmname" placeholder="M.I.">
                    </div>
                </div>
            </div>
            <div class="content">
                <h1>Step 4</h1>
                <div>Step 4 content</div>
            </div>
            <div class="content">
                <h1>Step 5</h1>
                <div>Step 5 content</div>
            </div>
        </div>

        <div class="submit-btn">
            <button class="prev">Previous</button>
            <button class="next">Next</button>
        </div>
    </div>
</body>
<script>
    const steps = document.querySelectorAll('.StepProgress-item');
    const contents = document.querySelectorAll('.content');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    let currentIndex = 0;

    function updateProgress() {
        steps.forEach((step, index) => {
            step.classList.remove('is-done', 'current');
            if (index < currentIndex) step.classList.add('is-done');
            if (index === currentIndex) step.classList.add('current');
        });

        // Update progress line
        const progressLine = document.querySelector('.StepProgress');
        const progressPercentage = (currentIndex / (steps.length - 1)) * 100;
        progressLine.style.setProperty('--progress', `${progressPercentage}%`);
    }

    function updateContent() {
        contents.forEach((content, index) => {
            content.classList.toggle('content-active', index === currentIndex);
        });
        checkRequiredFields();
    }

    nextBtn.addEventListener('click', () => {
        if (currentIndex < steps.length - 1) {
            currentIndex++;
            updateProgress();
            updateContent();
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            updateProgress();
            updateContent();
        }
    });

    function checkRequiredFields() {
        // Get the active content panel
        const activePanel = document.querySelector('.content-active');
        // Get all inputs in this panel that have the required attribute
        const requiredFields = activePanel.querySelectorAll('input[required], select[required]');
        // Assume all fields are filled
        let allFilled = true;
        // Loop over each field
        requiredFields.forEach(field => {
            if (!field.value) {
                allFilled = false;
            }
        });
        // Enable or disable the next button
        if (allFilled) {
            nextBtn.disabled = false;
            nextBtn.style.backgroundColor = '#4a90e2';
            nextBtn.style.cursor = 'pointer';
        } else {
            nextBtn.disabled = true;
            nextBtn.style.backgroundColor = 'gray';
            nextBtn.style.cursor = 'not-allowed';
        }
    }

    // Add event listeners for input changes on the active panel
    document.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('input', checkRequiredFields);
        input.addEventListener('change', checkRequiredFields);
    });

    // Call the function on page load to set the initial state
    checkRequiredFields();
</script>
<script src="validation.js"></script>
<script src="regions.js"></script>
<script src="civil-status.js"></script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</html>