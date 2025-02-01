<?php

class Sanitize
{
    private $data;
    private $errors = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function register() 
    {
        if($this->data['name']){
            $this->nameValidation($this->data['name']);
        }

        if($this->data['email']){
            $this->emailValidation($this->data['email']);
        }

        if($this->data['password']){
            $this->passwordValidation($this->data['password']);
        }

        if($this->data['mobile']){
            $this->mobileValidation($this->data['mobile']);
        }

        if(count($this->errors) > 0){
            return $this->errors;
        }
        return true;
    }

    public function event()
    {
        if($this->data['name']){
            $this->eventNameValidation($this->data['name']);
        }
        if($this->data['description']){
            $this->eventDescriptionValidation($this->data['description']);
        }

        if(count($this->errors) > 0){
            return $this->errors;
        }
        return true;

    }

    private function nameValidation($name)
    {
        $pattern = '/^[a-zA-Z\s\-\'\.]+$/';
        $name = trim($name);

        if (!preg_match($pattern, $name)) {
            return $this->errors['error']["name_error"] = "Name can only contain letters, spaces, hyphens, apostrophes, or periods.";
        }

        if (strlen($name) < 2) {
            return $this->errors['error']['name_error'] = "Name must be at least 2 characters long.";
        }

        if (strlen($name) > 50) {
            return $this->errors['error']["name_error"] = "Name cannot be longer than 50 characters.";
        }
    }

    private function emailValidation($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->errors['error']['email_error'] = "Email is not valid";
        } 
    }

    private function passwordValidation($password)
    {
        $minLength = 8; 
        $isNotUpperCase = true;
        $isNotLowerCase = true;
        $isNotDigit = true;
        $isNotSpecialChar = true;
        

        if (strlen($password) < $minLength) {
            return $this->errors['error']['password_error'] = "Password must be at least $minLength characters long.";
        }

        foreach(str_split($password) as $char) {
            if (ctype_upper($char)) {
                $isNotUpperCase = false;
            }
            if (ctype_lower($char)) {
                $isNotLowerCase = false;
            }
        
            if (ctype_digit($char)) {
                $isNotDigit = false;
            }
            if (ctype_punct($char)) {
                $isNotSpecialChar = false;
            }
        }


        if($isNotUpperCase) {
            return $this->errors['error']['password_error'] = "Password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.";
        }
        if($isNotLowerCase) {
            return $this->errors['error']['password_error'] = "Password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.";
        }
        if($isNotDigit) {
            return $this->errors['error']['password_error'] = "Password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.";
        }
        if($isNotSpecialChar) {
            return $this->errors['error']['password_error'] = "Password must contain at least one uppercase letter, one lowercase letter, one digit and one special character.";
        }
       
    }

    private function mobileValidation($mobile)
    {
        if (substr($mobile, 0, 1) !== '0') {
             return $this->errors['error']['mobile_error'] = "Mobile number must start with '0'.";
        }
    
        // Check if the mobile number contains only digits
        if (!ctype_digit($mobile)) {
             return $this->errors['error']['mobile_error'] = "Mobile number must contain only digits.";
        }
    
        // Check the length of the mobile number
        $length = strlen($mobile);
        if ($length != 11) {
             return $this->errors['error']['mobile_error'] = "Mobile number must be  11 digits long.";
        }
    }

    public function eventNameValidation($name)
    {
        $name = trim($name);

        if (empty($name)) {
            return $this->errors['error']['name_error'] = "Name is required.";
        }

        if (strlen($name) < 3 || strlen($name) > 255) {
            return $this->errors['error']['name_error'] = "Name must be between 3 and 255 characters.";
        }

        return true;
    }
    
    public function eventDescriptionValidation($description)
    {
        $description = trim($description);

        if (empty($description)) {
            return $this->errors['error']['description_error'] = "description is required.";
        }

        if (strlen($description) < 3 || strlen($description) > 255) {
            return $this->errors['error']['description_error'] = "description must be between 3 and 255 characters.";
        }

        return true;
    }

    
}
