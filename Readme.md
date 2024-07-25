# 📋 PHP Validation Class

Welcome to the **Validation Class**! This PHP library provides a comprehensive set of validation tools for form inputs and other data, making it easier to ensure data integrity and reliability in your applications. 🚀

## 🎯 Features

- **Predefined Patterns**: Validate common data types like URLs, emails, integers, and more.
- **Custom Patterns**: Define your own regex patterns for flexible validation.
- **File Validation**: Check file size, extension, and more.
- **Error Handling**: Retrieve and display user-friendly error messages.

## 🚀 Getting Started

### 🛠️ Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/arashnasrivatan/php-validation-class.git
   ```
2. Include the `Validation.php` file in your project:
   ```php
   require_once 'path/to/Validation.php';
   ```

3. Replace the line `160`,`180` in your project:
   ```php
   include('path/to/db.php');
   ```

### 🧑‍💻 Usage

Here's a quick example of how to use the Class:

```php
<?php
require_once 'Validation.php';

$validator = new Validation();
$validator->name('email')
          ->value('example@gmail.com')
          ->pattern('email')
          ->required()
          ->min(5)
          ->max(50);

if ($validator->isSuccess()) {
    echo "Validation passed! 🎉";
} else {
    echo $validator->displayErrors(); // Display all errors
    echo $validator->displayError(); // Display single error
}
?>
```

### 🔍 Available Patterns

- `uri` - Validates URI strings.
- `url` - Validates URLs.
- `alpha` - Validates alphabetic characters.
- `words` - Validates words (including spaces).
- `alphanum` - Validates alphanumeric characters.
- `int` - Validates integers.
- `float` - Validates floating-point numbers.
- `tel` - Validates Iranian phone numbers (format: 09XXXXXXXXX).
- `text` - Validates general text including punctuation.
- `file` - Validates filenames with allowed extensions.
- `folder` - Validates folder names.
- `address` - Validates addresses.
- `date_dmy` - Validates dates in DD-MM-YYYY format.
- `date_ymd` - Validates dates in YYYY-MM-DD format.
- `email` - Validates Gmail addresses.
- `postal_code` - Validates postal codes (e.g., 12345 or 12345-6789).
- `credit_card` - Validates credit card numbers.
- `slug` - Validates URL slugs (e.g., "my-url-slug").
- `ipv4` - Validates IPv4 addresses.
- `ipv6` - Validates IPv6 addresses.

### 🏗️ Methods

- `name($name)`: Set the name of the field.
- `value($value)`: Set the value to validate.
- `file($file)`: Set the file to validate.
- `pattern($name)`: Apply a predefined pattern.
- `customPattern($pattern)`: Apply a custom regex pattern.
- `required()`: Mark the field as required.
- `min($length)`: Set a minimum length or value.
- `max($length)`: Set a maximum length or value.
- `equal($value)`: Ensure the value matches another value.
- `maxSize($size)`: Validate the maximum file size.
- `ext($extension)`: Validate the file extension.
- `isSuccess()`: Check if all validations passed.
- `getErrors()`: Retrieve all error messages.
- `displayErrors()`: Display error messages as HTML.
- `result()`: Output errors and halt if validation fails.