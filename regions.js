document.addEventListener("DOMContentLoaded", function () {
    const regionSelect = document.getElementById("region");
    const provinceSelect = document.getElementById("province");
    const citySelect = document.getElementById("city");
    const barangaySelect = document.getElementById("barangay");

    const selectedRegion = document.getElementById("region_name").value;
    const selectedProvince = document.getElementById("province_name").value;
    const selectedCity = document.getElementById("city_name").value;
    const selectedBarangay = document.getElementById("barangay_name").value;

    // Fetch and populate regions
    fetch("https://psgc.cloud/api/regions")
        .then(response => response.json())
        .then(data => {
            data.forEach(region => {
                const option = document.createElement("option");
                option.value = region.code;
                option.textContent = region.name;
                if (region.name === selectedRegion) {
                    option.selected = true;
                }
                regionSelect.appendChild(option);
            });
        });

    // Handle province fetch after region is selected
    regionSelect.addEventListener("change", function () {
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        provinceSelect.disabled = true;
        if (this.value) {
            fetch(`https://psgc.cloud/api/regions/${this.value}/provinces`)
                .then(response => response.json())
                .then(data => {
                    provinceSelect.disabled = false;
                    data.forEach(province => {
                        const option = document.createElement("option");
                        option.value = province.code;
                        option.textContent = province.name;
                        if (province.name === selectedProvince) {
                            option.selected = true;
                        }
                        provinceSelect.appendChild(option);
                    });
                });
        }
    });

    // Handle city fetch after province is selected
    provinceSelect.addEventListener("change", function () {
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        citySelect.disabled = true;
        if (this.value) {
            fetch(`https://psgc.cloud/api/provinces/${this.value}/cities-municipalities`)
                .then(response => response.json())
                .then(data => {
                    citySelect.disabled = false;
                    data.forEach(city => {
                        const option = document.createElement("option");
                        option.value = city.code;
                        option.textContent = city.name;
                        if (city.name === selectedCity) {
                            option.selected = true;
                        }
                        citySelect.appendChild(option);
                    });
                });
        }
    });

    // Handle barangay fetch after city is selected
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
                        if (barangay.name === selectedBarangay) {
                            option.selected = true;
                        }
                        barangaySelect.appendChild(option);
                    });
                });
        }
    });

    // If region is already selected, trigger change to load province
    if (selectedRegion) {
        regionSelect.dispatchEvent(new Event("change"));
    }
});
