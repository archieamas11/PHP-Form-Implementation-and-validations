function fillForm() {
    // Pre-defined values to be filled in the form
    const formData = {
        lname: "albarico",
        fname: "archie",
        mname: "a",
        dob: "1990-01-01",
        pob: "New York",
        sex: "male", // Make sure radio button values are properly set
        status: "single", // Civil status
        tax: "123456789",
        region: "",
        province: "0103300000",
        city: "0802611000",
        barangay: "0802611015",
        nationality: "American",
        religion: "Oten",
        "email-address": "john.doe@example.com",
        "phone-number": "09123456789",
        zip: "6046",
        "complete-address": "123 Street, Building 4, House No. 7",
        flname: "Doe",
        ffname: "Richard",
        fmname: "B",
        mlname: "Smith",
        mfname: "Jane",
        mmname: "C"
    };

    // Loop through all form fields and set their values
    for (const key in formData) {
        if (formData.hasOwnProperty(key)) {
            const inputField = document.querySelector(`[name=${key}]`);
            if (inputField) {
                // If the field is a radio button
                if (inputField.type === "radio") {
                    const radioButton = document.querySelector(`[name=${key}][value=${formData[key]}]`);
                    if (radioButton) {
                        radioButton.checked = true;
                    }
                } else {
                    inputField.value = formData[key]; // For all other input types
                }
            }
        }
    }
}
