<?php
class UserCreator {
    private $conn;
    private $validator;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->validator = new FormValidator();
    }

    public function processForm(array $formData) {
        $this->validator->setFormData($formData);

        // Validate name fields
        $nameFields = [
            "lname"  => "last name",
            "fname"  => "first name",
            "mname"  => "middle name",
            "flname" => "father's last name",
            "ffname" => "father's first name",
            "fmname" => "father's middle name",
            "mlname" => "mother's last name",
            "mfname" => "mother's first name",
            "mmname" => "mother's middle name",
        ];
        $this->validator->validateNameFields($nameFields);

        // Validate no white spaces
        $noSpaceFields = [
            "lname"            => "Last Name",
            "fname"            => "First Name",
            "mname"            => "Middle Name",
            "flname"           => "Father's Last Name",
            "ffname"           => "Father's First Name",
            "fmname"           => "Father's Middle Name",
            "mlname"           => "Mother's Last Name",
            "mfname"           => "Mother's First Name",
            "mmname"           => "Mother's Middle Name",
            "otherStatus"      => "Civil Status",
            "pob"              => "Place of Birth",
            "nationality"      => "Nationality",
            "complete-address" => "Home Address",
            "region"           => "Region",
            "province"         => "Province",
            "city"             => "City",
            "barangay"         => "Barangay",
            "zip"              => "Zip Code",
            "email-address"    => "Email Address",
            "phone-number"     => "Phone Number",
            "tel"              => "Telephone Number",
        ];
        $this->validator->validateNoWhiteSpaces($noSpaceFields);

        // Validate date of birth
        $this->validator->validateDateOfBirth($formData['dob']);

        // Validate required fields
        $requiredFields = [
            "pob" => "Place of Birth",
            "sex" => "Gender",
            "status" => "Civil Status",
            "nationality" => "Nationality",
            "complete-address" => "Home Address",
            "region" => "Region",
            "province" => "Province",
            "city" => "City",
            "barangay" => "Barangay",
            "zip" => "Zip Code"
        ];
        $this->validator->validateRequiredFields($requiredFields);

        // Validate optional fields
        $this->validator->validateOptionalFields();

        if ($this->validator->isValid()) {
            return $this->saveUser($formData);
        }

        return ['success' => false, 'errors' => $this->validator->getErrors()];
    }

    private function saveUser(array $formData) {
        $stmt = $this->conn->prepare("INSERT INTO tbl_users (
            user_full_name, date_of_birth, sex, civil_status, 
            tax_identification_number, nationality, religion, 
            place_of_birth, phone_number, email_address, 
            telephone_number, region, region_code, province, 
            province_code, municipality, municipality_code, 
            barangay, barangay_code, home_address, zip_code, 
            fathers_full_name, mothers_full_name, date_created
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        $user_full_name = $formData['fname'] . ' ' . $formData['mname'] . ' ' . $formData['lname'];
        $fathers_full_name = $formData['ffname'] . ' ' . $formData['fmname'] . ' ' . $formData['flname'];
        $mothers_full_name = $formData['mfname'] . ' ' . $formData['mmname'] . ' ' . $formData['mlname'];

        $stmt->bind_param("sssssssssssssssssssssss", 
            $user_full_name, $formData['dob'], $formData['sex'], $formData['status'],
            $formData['tax'], $formData['nationality'], $formData['religion'],
            $formData['pob'], $formData['phone-number'], $formData['email-address'],
            $formData['tel'], $formData['region_name'], $formData['region'],
            $formData['province_name'], $formData['province'], $formData['city_name'],
            $formData['city'], $formData['barangay_name'], $formData['barangay'],
            $formData['complete-address'], $formData['zip'], $fathers_full_name,
            $mothers_full_name
        );

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'User created successfully'];
        }

        return ['success' => false, 'error' => 'Database error: ' . $stmt->error];
    }
}