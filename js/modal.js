document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("editModal");
    const closeBtn = document.querySelector(".close");

    // Define setSelectValue in the outer scope
    function setSelectValue(selectId, value) {
        const select = document.getElementById(selectId);
        if (!select) return;

        for (let i = 0; i < select.options.length; i++) {
            if (select.options[i].value === value) {
                select.selectedIndex = i;
                break;
            }
        }
        select.dispatchEvent(new Event('change'));
    }

    document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function() {
            const userId = this.dataset.id;

            fetch("http://localhost/php-form/fetch_user.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `user_id=${userId}`
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        alert("Error: " + data.error);
                    } else {
                        // Populate basic form fields
                        document.getElementById("edit-user-id").value = data.user_id;
                        document.getElementById("edit-name").value = data.user_full_name;
                        document.getElementById("edit-dob").value = data.date_of_birth;
                        document.getElementById("edit-birth-place").value = data
                            .place_of_birth;
                        document.getElementById("edit-nationality").value = data
                            .nationality;
                        document.getElementById("edit-tax-number").value = data
                            .tax_identification_number;
                        document.getElementById("edit-phone").value = data.phone_number;
                        document.getElementById("edit-telephone").value = data
                            .telephone_number;
                        document.getElementById("edit-email").value = data.email_address;
                        document.getElementById("edit-home-address").value = data
                            .home_address;
                        document.getElementById("edit-zipcode").value = data.zip_code;
                        document.getElementById("edit-father-name").value = data
                            .fathers_full_name;
                        document.getElementById("edit-mother-name").value = data
                            .mothers_full_name;

                        setSelectValue('edit-region', data.region_code);
                        setTimeout(() => {
                            setSelectValue('edit-province', data.province_code);
                            setTimeout(() => {
                                setSelectValue('edit-municipality', data
                                    .municipality_code);
                                setTimeout(() => {
                                    setSelectValue('edit-barangay',
                                        data.barangay_code);
                                }, 500);
                            }, 500);
                        }, 500);


                        // Handle radio button selection for sex
                        if (data.sex === "male") {
                            document.getElementById("edit-sex-male").checked = true;
                        } else if (data.sex === "female") {
                            document.getElementById("edit-sex-female").checked = true;
                        }

                        // Handle civil status selection
                        document.getElementById("edit-status").value = data.civil_status;
                        if (data.civil_status === "others") {
                            document.getElementById("otherStatus").style.display = "block";
                            document.getElementById("otherStatus").value = data
                                .other_status || "";
                        } else {
                            document.getElementById("otherStatus").style.display = "none";
                        }
                        modal.style.display = "block";
                    }
                })
                .catch(error => {
                    console.error("Error fetching data:", error);
                    alert("An error occurred while fetching user data.");
                });
        });
    });

    closeBtn.addEventListener("click", function() {
        modal.style.display = "none";
    });

    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});