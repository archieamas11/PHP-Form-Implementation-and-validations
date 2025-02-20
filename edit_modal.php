<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="content-wrapper">
            <div class="modal-title">
                <h1>Edit User</h1>
                <p>Update user information. Click save when you're done.</p>
            </div>
            <span class="close">&times;</span>
            <form action="update_user.php" method="POST">
                <input type="hidden" name="user_id" id="edit-user-id">
                <div class="personal-info">
                    <div class="form">
                        <label>Full Name</label> <br>
                        <input type="text" name="name" id="edit-name" required>
                    </div>

                    <div class="form">
                        <label>Date of Birth</label> <br>
                        <input type="date" name="dob" id="edit-dob" required>
                    </div>

                    <div class="form">
                        <label>Place of Birth</label> <br>
                        <input type="text" name="birth_place" id="edit-birth-place" required>
                    </div>

                    <div class="form">
                        <label>Nationality</label> <br>
                        <input type="text" name="nationality" id="edit-nationality" required>
                    </div>

                    <div class="form">
                        <label>Tax Number</label> <br>
                        <input type="text" name="tax_number" id="edit-tax-number" required>
                    </div>

                    <div class="form">
                        <label>Sex</label> <br>
                        <div class="radio-group">
                            <input type="radio" name="sex" value="Male" id="edit-sex-male" required>
                            <label for="edit-sex-male">Male</label>
                            <input type="radio" name="sex" value="Female" id="edit-sex-female" required>
                            <label for="edit-sex-female">Female</label>
                        </div>
                    </div>

                    <div class="form">
                        <label>Civil Status</label> <br>
                        <select name="status" id="edit-status" required>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="widowed">Widowed</option>
                            <option value="divorced">Divorced</option>
                            <option value="others">Others</option>
                        </select>
                        <input type="text" id="otherStatus" name="otherStatus" placeholder="Enter civil status"
                            style="display: none;" onblur="resetDropdown()" />
                    </div>

                    <div class="form">
                        <label>Phone Number</label> <br>
                        <input type="text" name="phone" id="edit-phone" required>
                    </div>

                    <div class="form">
                        <label>Telephone Number</label> <br>
                        <input type="text" name="telephone" id="edit-telephone" placeholder="Empty">
                    </div>

                    <div class="form">
                        <label>Email Address</label> <br>
                        <input type="email" name="email" id="edit-email" required>
                    </div>

                    <!-- Address Section -->
                    <div class="form">
                        <label>Region</label>
                        <select id="edit-region" name="region_code" class="form-control" required
                            onchange="loadProvinces(this.value)">
                            <option value="">Loading regions...</option>
                        </select>
                    </div>

                    <div class="form">
                        <label>Province</label>
                        <select id="edit-province" name="province_code" class="form-control" required
                            onchange="loadMunicipalities(this.value)">
                            <option value="">Select region first</option>
                        </select>
                    </div>

                    <div class="form">
                        <label>Municipality</label>
                        <select id="edit-municipality" name="municipality_code" class="form-control" required
                            onchange="loadBarangays(this.value)">
                            <option value="">Select province first</option>
                        </select>
                    </div>

                    <div class="form">
                        <label>Barangay</label>
                        <select id="edit-barangay" name="barangay_code" class="form-control" required>
                            <option value="">Select municipality first</option>
                        </select>
                    </div>

                    <div class="form">
                        <label>Home Address</label> <br>
                        <input type="text" name="home_address" id="edit-home-address" required>
                    </div>

                    <div class="form">
                        <label>Zip Code</label> <br>
                        <input type="text" name="zipcode" id="edit-zipcode" required>
                    </div>

                    <div class="form">
                        <label>Father's Full Name</label> <br>
                        <input type="text" name="father_name" id="edit-father-name" required>
                    </div>

                    <div class="form">
                        <label>Mother's Full Name</label> <br>
                        <input type="text" name="mother_name" id="edit-mother-name" required>
                    </div>
                </div>
                <div class="submit-btn close-btn">
                    <button type="button" class="close closeBtn">Cancel</button>
                    <button type="submit">Save Changes</button>
                </div>
            </form>
        </div>

    </div>
</div>