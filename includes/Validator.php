<?php
class Validator {
    private $errors = [];
    
    public function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Invalid email format";
            return false;
        }
        return true;
    }
    
    public function validatePassword($password) {
        if (strlen($password) < 8) {
            $this->errors['password'] = "Password must be at least 8 characters";
            return false;
        }
        return true;
    }
    
    public function validateRequired($field, $value) {
        if (empty($value)) {
            $this->errors[$field] = "This field is required";
            return false;
        }
        return true;
    }
    
    public function getErrors() {
        return $this->errors;
    }
}

