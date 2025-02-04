document.addEventListener("DOMContentLoaded", function () {
    const regionSelect = document.getElementById("region");
    const provinceSelect = document.getElementById("province");
    const citySelect = document.getElementById("city");
    const barangaySelect = document.getElementById("barangay");

    // Fetch regions
    fetch("https://psgc.cloud/api/regions")
        .then(response => response.json())
        .then(data => {
            data.forEach(region => {
                const option = document.createElement("option");
                option.value = region.code;
                option.textContent = region.name;
                regionSelect.appendChild(option);
            });
        });

    // Handle region change
    regionSelect.addEventListener("change", function () {
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        provinceSelect.disabled = true;
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        citySelect.disabled = true;
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        barangaySelect.disabled = true;

        if (this.value) {
            fetch(`https://psgc.cloud/api/regions/${this.value}/provinces`)
                .then(response => response.json())
                .then(data => {
                    provinceSelect.disabled = false;
                    data.forEach(province => {
                        const option = document.createElement("option");
                        option.value = province.code;
                        option.textContent = province.name;
                        provinceSelect.appendChild(option);
                    });
                });
        }
    });

    // Handle province change
    provinceSelect.addEventListener("change", function () {
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        citySelect.disabled = true;
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        barangaySelect.disabled = true;

        if (this.value) {
            fetch(`https://psgc.cloud/api/provinces/${this.value}/cities-municipalities`)
                .then(response => response.json())
                .then(data => {
                    citySelect.disabled = false;
                    data.forEach(city => {
                        const option = document.createElement("option");
                        option.value = city.code;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                });
        }
    });

    // Handle city change
    citySelect.addEventListener("change", function () {
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        barangaySelect.disabled = true;

        if (this.value) {
            fetch(`https://psgc.cloud/api/cities-municipalities/${this.value}/barangays`)
                .then(response => response.json())
                .then(data => {
                    barangaySelect.disabled = false;
                    data.forEach(barangay => {
                        const option = document.createElement("option");
                        option.value = barangay.code;
                        option.textContent = barangay.name;
                        barangaySelect.appendChild(option);
                    });
                });
        }
    });
});