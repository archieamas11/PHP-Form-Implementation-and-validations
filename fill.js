function fillForm() {
    const formData = {
        lname: "albarico",
        fname: "archie",
        mname: "amas",
        dob: "2000-10-24",
        pob: "vicente sotto memorial medical center",
        sex: "male",
        status: "single",
        tax: "123456789",
        region: "0700000000",
        province: "0702200000",
        city: "0702232000",
        barangay: "0702232013",
        nationality: "filipino",
        religion: "roman catholic",
        "email-address": "archiealbarico@gmail.com",
        "phone-number": "09123456789",
        zip: "6046",
        "complete-address": "Tunghaan, Minglanilla, Cebu",
        flname: "albarico",
        ffname: "mario",
        fmname: "beduya",
        mlname: "luna",
        mfname: "jessie",
        mmname: "amas"
    };

    for (const key in formData) {
        if (formData.hasOwnProperty(key)) {
            const inputField = document.querySelector(`[name=${key}]`);
            if (inputField) {
                if (inputField.type === "radio") {
                    document.querySelector(`[name=${key}][value=${formData[key]}]`).checked = true;
                } else {
                    inputField.value = formData[key];
                }
            }
        }
    }

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
