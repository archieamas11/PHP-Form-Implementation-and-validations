document.addEventListener('DOMContentLoaded', () => {
    const cache = new Map();
    const selects = {
        region: document.getElementById('edit-region'),
        province: document.getElementById('edit-province'),
        municipality: document.getElementById('edit-municipality'),
        barangay: document.getElementById('edit-barangay')
    };

    // PHP-injected values
    // const initialValues = {
    //     region: '<?= addslashes($submittedData['region']) ?>',
    //     province: '<?= addslashes($submittedData['province']) ?>',
    //     municipality: '<?= addslashes($submittedData['municipality']) ?>',
    //     barangay: '<?= addslashes($submittedData['barangay']) ?>'
    // };

    async function loadData(url, target, resetChain = [], selectedValue = '') {
        try {
            target.disabled = true;
            target.innerHTML = '<option value="">Loading...</option>';
            
            if (!cache.has(url)) {
                const response = await fetch(url);
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                cache.set(url, await response.json());
            }

            const data = cache.get(url);
            const fragment = document.createDocumentFragment();
            
            // Create default option
            const defaultOption = new Option(`Select ${target.id.replace('edit-', '')}`, '');
            fragment.appendChild(defaultOption);

            // Add data options
            data.forEach(item => {
                const option = new Option(item.name, item.code);
                if (item.code === selectedValue) option.selected = true;
                fragment.appendChild(option);
            });

            // Clear and update select
            target.innerHTML = '';
            target.appendChild(fragment);
            target.disabled = false;

            // Reset dependent selects
            resetChain.forEach(select => {
                selects[select].innerHTML = `<option value="">Select ${select}</option>`;
                selects[select].disabled = true;
            });
        } catch (error) {
            console.error(`Failed to load ${url}:`, error);
            target.innerHTML = `<option value="">Error loading data</option>`;
            target.disabled = false;
        }
    }

    // Initialize form with any previously selected values
    async function initializeSelections() {
        if (initialValues.region) {
            await loadData(
                'https://psgc.cloud/api/regions',
                selects.region,
                ['province', 'municipality', 'barangay'],
                initialValues.region
            );
            
            if (initialValues.province) {
                await loadData(
                    `https://psgc.cloud/api/regions/${initialValues.region}/provinces`,
                    selects.province,
                    ['municipality', 'barangay'],
                    initialValues.province
                );
                
                if (initialValues.municipality) {
                    await loadData(
                        `https://psgc.cloud/api/provinces/${initialValues.province}/municipalities`,
                        selects.municipality,
                        ['barangay'],
                        initialValues.municipality
                    );
                    
                    if (initialValues.barangay) {
                        await loadData(
                            `https://psgc.cloud/api/municipalities/${initialValues.municipality}/barangays`,
                            selects.barangay,
                            [],
                            initialValues.barangay
                        );
                    }
                }
            }
        } else {
            // Initial load without preselections
            loadData('https://psgc.cloud/api/regions', selects.region, 
                    ['province', 'municipality', 'barangay']);
        }
    }

    // Event listeners
    selects.region.addEventListener('change', () => {
        loadData(
            `https://psgc.cloud/api/regions/${selects.region.value}/provinces`,
            selects.province,
            ['municipality', 'barangay']
        );
    });

    selects.province.addEventListener('change', () => {
        loadData(
            `https://psgc.cloud/api/provinces/${selects.province.value}/municipalities`,
            selects.municipality,
            ['barangay']
        );
    });

    selects.municipality.addEventListener('change', () => {
        loadData(
            `https://psgc.cloud/api/municipalities/${selects.municipality.value}/barangays`,
            selects.barangay
        );
    });

    // Start initialization
    initializeSelections();
});