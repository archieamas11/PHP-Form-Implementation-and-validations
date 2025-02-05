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
        otherStatusInput.style.display = "none";
        statusDropdown.style.display = "inline-block";
        statusDropdown.value = "single"; // Reset to default
    }
}