document.addEventListener("DOMContentLoaded", async function () {
    const regionSelect = document.getElementById("region");
    const provinceSelect = document.getElementById("province");
    const citySelect = document.getElementById("city");
    const barangaySelect = document.getElementById("barangay");

    const selectedRegion = document.getElementById("region_name").value;
    const selectedProvince = document.getElementById("province_name").value;
    const selectedCity = document.getElementById("city_name").value;
    const selectedBarangay = document.getElementById("barangay_name").value;

    const cache = { regions: {}, provinces: {}, cities: {}, barangays: {} };

    // Helper function to populate select options
    function populateSelect(select, data, selectedValue) {
        const fragment = document.createDocumentFragment();
        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = `Select ${select.id.charAt(0).toUpperCase() + select.id.slice(1)}`;
        fragment.appendChild(defaultOption);

        data.forEach(item => {
            const option = document.createElement("option");
            option.value = item.code;
            option.textContent = item.name;
            if (item.name === selectedValue) option.selected = true;
            fragment.appendChild(option);
        });

        select.innerHTML = "";
        select.appendChild(fragment);
        select.disabled = data.length === 0;
    }

    // Fetch and populate regions
    async function fetchRegions() {
        if (!cache.regions.list) {
            const response = await fetch("https://psgc.cloud/api/regions");
            cache.regions.list = await response.json();
        }
        populateSelect(regionSelect, cache.regions.list, selectedRegion);
    }

    // Fetch and populate provinces
    async function fetchProvinces(regionCode) {
        if (!cache.provinces[regionCode]) {
            const response = await fetch(`https://psgc.cloud/api/regions/${regionCode}/provinces`);
            cache.provinces[regionCode] = await response.json();
        }
        populateSelect(provinceSelect, cache.provinces[regionCode], selectedProvince);
    }

    // Fetch and populate cities
    async function fetchCities(provinceCode) {
        if (!cache.cities[provinceCode]) {
            const response = await fetch(`https://psgc.cloud/api/provinces/${provinceCode}/cities-municipalities`);
            cache.cities[provinceCode] = await response.json();
        }
        populateSelect(citySelect, cache.cities[provinceCode], selectedCity);
    }

    // Fetch and populate barangays
    async function fetchBarangays(cityCode) {
        if (!cache.barangays[cityCode]) {
            const response = await fetch(`https://psgc.cloud/api/cities-municipalities/${cityCode}/barangays`);
            cache.barangays[cityCode] = await response.json();
        }
        populateSelect(barangaySelect, cache.barangays[cityCode], selectedBarangay);
    }

    // Event Listeners for cascading selections
    regionSelect.addEventListener("change", async function () {
        provinceSelect.innerHTML = '<option value="">Loading...</option>';
        await fetchProvinces(this.value);
    });

    provinceSelect.addEventListener("change", async function () {
        citySelect.innerHTML = '<option value="">Loading...</option>';
        await fetchCities(this.value);
    });

    citySelect.addEventListener("change", async function () {
        barangaySelect.innerHTML = '<option value="">Loading...</option>';
        await fetchBarangays(this.value);
    });

    // Initialize region list
    await fetchRegions();

    // If region is preselected, auto-trigger next steps
    if (selectedRegion) {
        await fetchProvinces(regionSelect.value);
        if (selectedProvince) {
            await fetchCities(provinceSelect.value);
            if (selectedCity) {
                await fetchBarangays(citySelect.value);
            }
        }
    }
});
