function toggleOtherStatus() {
    let statusDropdown = document.getElementById("status");
    let otherStatusInput = document.getElementById("otherStatus");

    if (statusDropdown.value === "others") {
        statusDropdown.style.display = "none";
        otherStatusInput.style.display = "inline-block";
        otherStatusInput.focus();
    }
}

function resetDropdown() {
    let statusDropdown = document.getElementById("status");
    let otherStatusInput = document.getElementById("otherStatus");

    if (otherStatusInput.value.trim() === "") {
        // Hide the "others" input field and show the dropdown
        otherStatusInput.style.display = "none";
        statusDropdown.style.display = "inline-block";

        // Reset the dropdown value to "single" (the first option)
        statusDropdown.value = "single"; // Force value reset to 'single'

        // Clear the "otherStatus" input value
        otherStatusInput.value = ""; 

        // Ensure the "Single" option is selected (removes conflicting selected attributes)
        const options = statusDropdown.querySelectorAll('option');
        options.forEach(option => {
            option.removeAttribute('selected'); // Remove selected from all options
        });

        // Now mark the "Single" option as selected
        const singleOption = statusDropdown.querySelector('option[value="single"]');
        if (singleOption) {
            singleOption.setAttribute('selected', 'selected');
        }
    }
}

document.querySelector('form').addEventListener('submit', function(event) {
    let statusDropdown = document.getElementById("status");
    let otherStatusInput = document.getElementById("otherStatus");

    // If the user typed something in the "Other" input field, set the value of the dropdown to that
    if (statusDropdown.value === "others" && otherStatusInput.value.trim() !== "") {
        let otherStatusValue = otherStatusInput.value.trim();
        let otherStatusHiddenField = document.createElement('input');
        otherStatusHiddenField.type = 'hidden';
        otherStatusHiddenField.name = 'status';
        otherStatusHiddenField.value = otherStatusValue;

        // Append the hidden field to the form so it gets submitted
        this.appendChild(otherStatusHiddenField);
    }
});
