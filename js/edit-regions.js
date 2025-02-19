// Load initial regions
document.addEventListener('DOMContentLoaded', function() {
    loadRegions();
});

async function loadRegions() {
    try {
        const response = await fetch('https://psgc.cloud/api/regions');
        const regions = await response.json();
        const regionSelect = document.getElementById('edit-region');
        
        regionSelect.innerHTML = '<option value="">Select Region</option>';
        regions.forEach(region => {
            regionSelect.innerHTML += `
                <option value="${region.code}">${region.name}</option>
            `;
        });
    } catch (error) {
        console.error('Error loading regions:', error);
    }
}

async function loadProvinces(regionCode) {
    try {
        const response = await fetch(`https://psgc.cloud/api/regions/${regionCode}/provinces`);
        const provinces = await response.json();
        const provinceSelect = document.getElementById('edit-province');
        
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        provinces.forEach(province => {
            provinceSelect.innerHTML += `
                <option value="${province.code}">${province.name}</option>
            `;
        });
    } catch (error) {
        console.error('Error loading provinces:', error);
    }
}

async function loadMunicipalities(provinceCode) {
    try {
        const response = await fetch(`https://psgc.cloud/api/provinces/${provinceCode}/municipalities`);
        const municipalities = await response.json();
        const municipalitySelect = document.getElementById('edit-municipality');
        
        municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
        municipalities.forEach(municipality => {
            municipalitySelect.innerHTML += `
                <option value="${municipality.code}">${municipality.name}</option>
            `;
        });
    } catch (error) {
        console.error('Error loading municipalities:', error);
    }
}

async function loadBarangays(municipalityCode) {
    try {
        const response = await fetch(`https://psgc.cloud/api/municipalities/${municipalityCode}/barangays`);
        const barangays = await response.json();
        const barangaySelect = document.getElementById('edit-barangay');
        
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';
        barangays.forEach(barangay => {
            barangaySelect.innerHTML += `
                <option value="${barangay.code}">${barangay.name}</option>
            `;
        });
    } catch (error) {
        console.error('Error loading barangays:', error);
    }
}

function loadBarangays(municipalityId, callback) {
    fetch(`https://psgc.cloud/api/municipalities/${municipalityId}/barangays`)
        .then(response => response.json())
        .then(data => {
            const barangaySelect = document.getElementById("edit-barangay");
            barangaySelect.innerHTML = '<option value="">Select a barangay</option>';
            data.forEach(barangay => {
                const option = document.createElement("option");
                option.value = barangay.code;
                option.textContent = barangay.name;
                barangaySelect.appendChild(option);
            });
            if (callback) callback();
        })
        .catch(error => console.error("Error loading barangays:", error));
}