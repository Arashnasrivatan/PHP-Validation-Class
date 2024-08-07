<?php

class Validation {
    
    // Define common validation patterns
    public $patterns = array(
        'uri'           => '[A-Za-z0-9-\/_?&=]+', // Simple URI
        'url'           => '[A-Za-z0-9-:.\/_?&=#]+', // Full URL
        'alpha'         => '[\p{L}]+', // Only alphabetic characters
        'words'         => '[\p{L}\s]+', // Words (letters and spaces)
        'alphanum'      => '[\p{L}0-9]+', // Alphanumeric characters
        'int'           => '[0-9]+', // Integer numbers
        'float'         => '[0-9\.,]+', // Floating point numbers
        'tel'           => '^09[0-9]{9}$', // Iranian phone numbers
        'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+', // General text
        'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}', // File name
        'folder'        => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+', // Folder name
        'address'       => '[\p{L}0-9\s.,()°-]+', // Address
        'date_dmy'      => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}', // Date in day-month-year format
        'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}', // Date in year-month-day format
        'email'         => '^[a-zA-Z0-9._%+-]+@gmail\.com$', // Gmail email
        'postal_code'   => '[0-9]{5}(-[0-9]{4})?', // Postal code
        'credit_card'   => '^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9]{2})[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$', // Credit card number
        'slug'          => '^[a-z0-9-]+$', // Slug format
        'ipv4'          => '\b(?:\d{1,3}\.){3}\d{1,3}\b', // IPv4 address
        'ipv6'          => '\b(?:[a-fA-F0-9]{1,4}:){7}[a-fA-F0-9]{1,4}\b', // IPv6 address
    );
    
    // Array to hold validation errors
    public $errors = array();
    
    // Set the name of the field being validated
    public function name($name){
        $this->name = $name;
        return $this;
    }
    
    // Set the value of the field being validated
    public function value($value){
        $this->value = $value;
        return $this;
    }
    
    // Set the file for file validation
    public function file($value){
        $this->file = $value;
        return $this;
    }
    
    // Apply a predefined pattern to the value
    public function pattern($name){
        if($name == 'array'){
            if(!is_array($this->value)){
                $this->errors[] = 'The format of the field '.$this->name.' is invalid.';
            }
        }else{
            $regex = '/^('.$this->patterns[$name].')$/u';
            if($this->value != '' && !preg_match($regex, $this->value)){
                $this->errors[] = 'The format of the field '.$this->name.' is invalid.';
            }
        }
        return $this;
    }
    
    // Apply a custom pattern to the value
    public function customPattern($pattern){
        $regex = '/^('.$pattern.')$/u';
        if($this->value != '' && !preg_match($regex, $this->value)){
            $this->errors[] = 'The format of the field '.$this->name.' is invalid.';
        }
        return $this;
    }
    
    // Check if the field is required and not empty
    public function required(){
        if((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)){
            $this->errors[] = 'The field '.$this->name.' is required.';
        }            
        return $this;
    }
    
    // Check if the value has a minimum length or value
    public function min($length){
        if(is_string($this->value)){
            if(strlen($this->value) < $length){
                $this->errors[] = 'The length of the field '.$this->name.' must be at least '.$length.'.';
            }
        }else{
            if($this->value < $length){
                $this->errors[] = 'The value of the field '.$this->name.' must be at least '.$length.'.';
            }
        }
        return $this;
    }
    
    // Check if the value does not exceed a maximum length or value
    public function max($length){
        if(is_string($this->value)){
            if(strlen($this->value) > $length){
                $this->errors[] = 'The length of the field '.$this->name.' must not exceed '.$length.'.';
            }
        }else{
            if($this->value > $length){
                $this->errors[] = 'The value of the field '.$this->name.' must not exceed '.$length.'.';
            }
        }
        return $this;
    }

    // Check if the value falls within a specified range
    public function range($min, $max){
        if($this->value < $min || $this->value > $max){
            $this->errors[] = 'The value of the field '.$this->name.' must be between '.$min.' and '.$max.'.';
        }
        return $this;
    }

    
    public function length($length){
        if (is_string($this->value)) {
            if (strlen($this->value) != $length) {
                $this->errors[] = 'The length of the field ' . $this->name . ' must be exactly ' . $length . ' characters.';
            }
        } else {
            if ($this->value != $length) {
                $this->errors[] = 'The length of the field ' . $this->name . ' must be exactly ' . $length . ' characters.';
            }
        }
        return $this;
    }
    
    
    // Check if the value matches a specified value
    public function equal($value){
        if($this->value != $value){
            $this->errors[] = 'The value of the field '.$this->name.' does not match.';
        }
        return $this;
    }
    
    // Check if the file size does not exceed a maximum size
    public function maxSize($size){
        if($this->file['error'] != 4 && $this->file['size'] > $size){
            $this->errors[] = 'The file size of '.$this->name.' exceeds the maximum allowed size: '.number_format($size / 1048576, 2).' MB.';
        }
        return $this;
    }

    // Check if the value is one of the allowed values
    public function enum($allowedValues){
        $allowedValuesArray = explode('|', $allowedValues);
        if(!in_array($this->value, $allowedValuesArray)){
            $this->errors[] = 'The value of the field '.$this->name.' is not valid.';
        }
        return $this;
    }

    
    // Check if the file has the correct extension
    public function ext($extension){
        if($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension){
            $this->errors[] = 'The file format of '.$this->name.' must be '.$extension.'.';
        }
        return $this;
    }

        // Check if the value exist in the array
        public function inList(array $list){
            if(!in_array($this->value, $list)){
                $this->errors[] = 'The value of the field '.$this->name.' is not a valid value';
            }
            return $this;
        }
    
    // Sanitize a string
    public function purify($string){
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
    
    // Check if there are no validation errors
    public function isSuccess(){
        return empty($this->errors);
    }
    
    // Get the list of validation errors
    public function getErrors(){
        return $this->isSuccess() ? [] : $this->errors;
    }
    
    // Display all validation errors as an HTML list
    public function displayErrors(){
        $html = '<ul>';
        foreach($this->getErrors() as $error){
            $html .= '<li>'.$error.'</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    // Display the first validation error
    public function displayError(){
        return !empty($this->errors) ? $this->errors[0] : '';
    }
    
    // Output validation errors and halt the script if there are errors
    public function result(){
        if(!$this->isSuccess()){
            foreach($this->getErrors() as $error){
                echo "$error\n";
            }
            exit;
        }else{
            return true;
        }
    }

    // Check if a value is unique in a specified table and column
    public function uniq($table, $cul, $value){
        global $db;
        
        if (!isset($db)) {
            include('../../config/loader.php');
        }
        
        $stmt = $db->prepare("SELECT * FROM $table WHERE $cul = ? ORDER BY id DESC");
        $stmt->bind_param('s', $value);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            $this->errors[] = 'The value of the field '.$this->name.' already exists.';
        } else {
            return true;
        }
    }

    // Check if a value exists in a specified table and column
    public function isExist($table, $cul, $value){
        global $db;
        
        if (!isset($db)) {
            include('../../config/loader.php');
        }
        
        $stmt = $db->prepare("SELECT * FROM $table WHERE $cul = ? ORDER BY id DESC");
        $stmt->bind_param('s', $value);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            return true;
        } else {
            $this->errors[] = 'The value of the field '.$this->name.' does not exist.';
        }
    }
    
    // Static methods for common validation tasks

    // Check if the value is a valid float
    public static function is_float($value){
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    // Check if the value is a valid integer
    public static function is_int($value){
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }
    
    // Check if the value contains only alphabetic characters
    public static function is_alpha($value){
        return filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/"))) !== false;
    }
    
    // Check if the value contains only alphanumeric characters
    public static function is_alphanum($value){
        return filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/"))) !== false;
    }

    // Check if the value is a valid email address
    public static function is_email($value){
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    // Check if the value is a valid URL
    public static function is_url($value){
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }
    
    // Check if the value is a valid URI
    public static function is_uri($value){
        return filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/"))) !== false;
    }
    
    // Check if the value is a valid boolean
    public static function is_bool($value){
        return is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE));
    }
    
}

?>