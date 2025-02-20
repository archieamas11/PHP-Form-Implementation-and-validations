<?php
class FormValidator {
    private $errors = [];
    private $formData = [];

    public function validateNameFields(array $fields) {
        foreach ($fields as $field => $field_name) {
            $value = trim($this->formData[$field] ?? '');
            $is_middle_name = in_array($field, ['mname', 'mmname', 'fmname']);
            
            if (empty($value)) {
                if (!$is_middle_name) {
                    $this->errors[$field] = "Please enter your $field_name.";
                }
            } elseif (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/", $value)) {
                $this->errors[$field] = "$field_name can only contain letters and spaces.";
            } elseif (!$is_middle_name && (strlen($value) < 2 || strlen($value) > 50)) {
                $this->errors[$field] = "$field_name must be between 2 and 50 characters.";
            }
        }
    }

    public function validateNoWhiteSpaces(array $no_space_fields) {
        foreach ($no_space_fields as $field => $field_label) {
            if (!empty($this->formData[$field]) && preg_match("/\s{2,}/", $this->formData[$field])) {
                $this->errors[$field] = "$field_label should not contain 2 or more consecutive spaces.";
            }
        }
    }

    public function validateDateOfBirth($dob) {
        if (empty($dob)) {
            $this->errors['dob'] = "Please enter your Date of Birth.";
            return;
        }

        $date = DateTime::createFromFormat('Y-m-d', $dob);
        $today = new DateTime();
        $age = $today->diff($date)->y;

        if ($age < 18) {
            $this->errors['dob'] = "You must be at least 18 years old.";
        }
    }

    public function validateRequiredFields(array $required_fields) {
        foreach ($required_fields as $field => $label) {
            if (empty(trim($this->formData[$field] ?? ''))) {
                $this->errors[$field] = "Please enter/select your $label.";
            }
        }
    }

    public function validateOptionalFields() {
        // TIN validation
        if (!empty($this->formData['tax']) && !preg_match("/^\d{9,12}$/", $this->formData['tax'])) {
            $this->errors['tax'] = "TIN must be 9-12 digits only.";
        }

        // Email validation
        if (!empty($this->formData['email-address']) && !filter_var($this->formData['email-address'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email-address'] = "Please enter a valid email address.";
        }

        // Phone number validation
        if (!empty($this->formData['phone-number']) && !preg_match("/^09[0-9]{9}$/", $this->formData['phone-number'])) {
            $this->errors['phone-number'] = "Phone number must be a valid PH number (09XXXXXXXXX).";
        }

        // Telephone validation
        if (!empty($this->formData['tel']) && !preg_match("/^(0[2-9]\d{1,2}-?\d{6,7})$/", $this->formData['tel'])) {
            $this->errors['tel'] = "Telephone number must be a valid PH landline.";
        }

        // Zip code validation
        if (!empty($this->formData['zip']) && !preg_match("/^\d{4}$/", $this->formData['zip'])) {
            $this->errors['zip'] = "Zip Code must be exactly 4 digits.";
        }
    }

    public function setFormData(array $data) {
        $this->formData = $data;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function isValid() {
        return empty($this->errors);
    }
}