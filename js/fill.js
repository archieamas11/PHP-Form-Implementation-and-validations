function fillForm() {
    const formData = {
        lname: "albarico",
        fname: "archie",
        mname: "amas",
        dob: "2000-10-24",
        pob: "vicente sotto memorial medical center",
        sex: "male",
        status: "married", // Ensure this matches the option value
        tax: "123456789",
        region: "0700000000",
        province: "0702200000",
        city: "0702232000",
        barangay: "0702232013",
        nationality: "filipino",
        religion: "roman catholic",
        "email-address": "archiealbarico@gmail.com",
        "phone-number": "09123456789",
        tel: "021234567",
        zip: "6046",
        "complete-address": "Tunghaan, Minglanilla, Cebu",
        flname: "albarico",
        ffname: "mario",
        fmname: "beduya",
        mlname: "luna",
        mfname: "jessie",
        mmname: "amas"
    };

    // Fill form fields
    for (const key in formData) {
        if (formData.hasOwnProperty(key)) {
            const inputField = document.querySelector(`[name=${key}]`);
            if (inputField) {
                if (inputField.type === "radio") {
                    document.querySelector(`[name="${key}"][value="${formData[key]}"]`).checked = true;
                } else if (inputField.tagName === "SELECT") {
                    inputField.value = formData[key];

                    // Manually dispatch change event if needed
                    inputField.dispatchEvent(new Event("change"));
                } else {
                    inputField.value = formData[key];
                }
            }
        }
    }

    // Manually handle 'status' select element (Civil Status dropdown)
    const statusSelect = document.querySelector('[name="status"]');
    if (statusSelect) {
        // Set the value of the 'status' dropdown to the correct value
        statusSelect.value = formData.status;

        // Trigger the change event to ensure any dependent logic is applied
        statusSelect.dispatchEvent(new Event("change"));

        // Show/hide the "others" text input based on the selected value
        const otherStatusInput = document.getElementById('otherStatus');
        if (formData.status === "others") {
            otherStatusInput.style.display = "inline-block"; // Show the input
        } else {
            otherStatusInput.style.display = "none"; // Hide the input
        }
    }

    // Continue with region, province, city, barangay as before
    const regionSelect = document.getElementById("region");
    regionSelect.value = formData.region;
    regionSelect.dispatchEvent(new Event("change"));

    setTimeout(() => {
        const provinceSelect = document.getElementById("province");
        provinceSelect.value = formData.province;
        provinceSelect.dispatchEvent(new Event("change"));

        setTimeout(() => {
            const citySelect = document.getElementById("city");
            citySelect.value = formData.city;
            citySelect.dispatchEvent(new Event("change"));

            setTimeout(() => {
                const barangaySelect = document.getElementById("barangay");
                barangaySelect.value = formData.barangay;
            }, 500);
        }, 500);
    }, 500);
}
