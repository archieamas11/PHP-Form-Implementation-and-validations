function validateForm() {
    let isValid = true;

    // Clear previous error messages
    document.querySelectorAll('.error').forEach(error => error.textContent = '');

    // First Name Validation
    const firstName = document.getElementById('lname').value.trim();
    if (firstName === '') {
        document.getElementById('lastNameError').textContent = 'Last Name is required.';
        isValid = false;
    }
    return isValid;
}

