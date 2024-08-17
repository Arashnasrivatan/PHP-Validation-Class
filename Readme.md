# <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Telegram-Animated-Emojis/main/Objects/Memo.webp" alt="Memo" width="25" height="25" /> PHP Validation Class

Welcome to the **Validation Library**! This PHP library provides a comprehensive set of validation tools for form inputs and other data, making it easier to ensure data integrity and reliability in your applications. <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Telegram-Animated-Emojis/main/Travel%20and%20Places/Rocket.webp" alt="Rocket" width="20" height="20" />

Login , Register , ForgotPassword project using this class <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Telegram-Animated-Emojis/main/Objects/Laptop.webp" alt="Laptop" width="20" height="20" /> <a href="https://github.com/Arashnasrivatan/Secure-Login-Register">Click To See <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Telegram-Animated-Emojis/main/People/Eyes.webp" alt="Eyes" width="20" height="20" /></a>


## <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Telegram-Animated-Emojis/main/Activity/Sparkles.webp" alt="Sparkles" width="25" height="25" /> Features

- **Predefined Patterns**: Validate common data types like URLs, emails, integers, and more.
- **Custom Patterns**: Define your own regex patterns for flexible validation.
- **File Validation**: Check file size, extension, and more.
- **Error Handling**: Retrieve and display user-friendly error messages.
- **English and Persian** Available in two languages: Persian and English.

## <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Telegram-Animated-Emojis/main/Travel%20and%20Places/Rocket.webp" alt="Rocket" width="25" height="25" /> Getting Started

### <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Telegram-Animated-Emojis/main/Objects/Keyboard.webp" alt="Keyboard" width="22" height="22" /> Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/Arashnasrivatan/PHP-Validation-Class.git
   ```
2. Include the `Validation.php` file in your project:
   ```php
   require_once 'path/to/Validation.php';
   ```

3. Replace the line `160`,`180` in your project:
   ```php
   include('path/to/db.php');
   ```

### <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Telegram-Animated-Emojis/main/People/Man%20Technologist.webp" alt="Man Technologist" width="22" height="22" /> Usage

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

### <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Telegram-Animated-Emojis/main/Objects/Magnifying%20Glass%20Tilted%20Left.webp" alt="Magnifying Glass Tilted Left" width="22" height="22" /> Available Patterns

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

### <img src="https://raw.githubusercontent.com/Tarikul-Islam-Anik/Telegram-Animated-Emojis/main/Animals%20and%20Nature/Glowing%20Star.webp" alt="Glowing Star" width="22" height="22" /> Methods

- `name($name)`: Set the name of the field.
- `value($value)`: Set the value to validate.
- `file($file)`: Set the file to validate.
- `pattern($name)`: Apply a predefined pattern.
- `customPattern($pattern)`: Apply a custom regex pattern.
- `required()`: Mark the field as required.
- `min($length)`: Set a minimum length or value.
- `max($length)`: Set a maximum length or value.
- `range($min,$max)`: Check if the value falls within a specified range
- `length($length)`: Set a length for input example length("11") = must be 11 chars
- `equal($value)`: Ensure the value matches another value.
- `enum`: Check if the value is one of the allowed values.
- `maxSize($size)`: Validate the maximum file size.
- `ext($extension)`: Validate the file extension.
- `isSuccess()`: Check if all validations passed.
- `getErrors()`: Retrieve all error messages.
- `displayErrors()`: Display error messages as HTML.
- `result()`: Output errors and halt if validation fails.
