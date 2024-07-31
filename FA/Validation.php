<?php
class Validation {

    // تعریف الگوهای معمول برای اعتبارسنجی
    public $patterns = array(
        'uri'           => '[A-Za-z0-9-\/_?&=]+', // آدرس ساده
        'url'           => '[A-Za-z0-9-:.\/_?&=#]+', // آدرس کامل URL
        'alpha'         => '[\p{L}]+', // فقط حروف الفبا
        'words'         => '[\p{L}\s]+', // حروف و فاصله‌ها
        'alphanum'      => '[\p{L}0-9]+', // حروف و اعداد
        'int'           => '[0-9]+', // اعداد صحیح
        'float'         => '[0-9\.,]+', // اعداد اعشاری
        'tel'           => '^09[0-9]{9}$', // شماره تلفن ایرانی
        'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+', // متون عمومی
        'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}', // نام فایل
        'folder'        => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+', // نام پوشه
        'address'       => '[\p{L}0-9\s.,()°-]+', // آدرس
        'date_dmy'      => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}', // تاریخ به فرمت روز-ماه-سال
        'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}', // تاریخ به فرمت سال-ماه-روز
        'email'         => '^[a-zA-Z0-9._%+-]+@gmail\.com$', // ایمیل با دامنه جیمیل
        'postal_code'   => '[0-9]{5}(-[0-9]{4})?', // کد پستی
        'credit_card'   => '^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9]{2})[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$', // شماره کارت اعتباری
        'slug'          => '^[a-z0-9-]+$',
        'ipv4'          => '\b(?:\d{1,3}\.){3}\d{1,3}\b', // آدرس IP نسخه 4
        'ipv6'          => '\b(?:[a-fA-F0-9]{1,4}:){7}[a-fA-F0-9]{1,4}\b', // آدرس IP نسخه 6
    );

    // ذخیره خطاهای اعتبارسنجی
    public $errors = array();

    // تنظیم نام فیلدی که اعتبارسنجی می‌شود
    public function name($name){
        $this->name = $name;
        return $this;
    }

    // تنظیم مقدار فیلدی که اعتبارسنجی می‌شود
    public function value($value){
        $this->value = $value;
        return $this;
    }

    // تنظیم فایل برای اعتبارسنجی فایل
    public function file($value){
        $this->file = $value;
        return $this;
    }

    // اعمال یک الگوی از پیش تعریف شده به مقدار
    public function pattern($name){
        if($name == 'array'){
            if(!is_array($this->value)){
                $this->errors[] = 'فرمت فیلد '.$this->name.' نامعتبر است.';
            }
        }else{
            $regex = '/^('.$this->patterns[$name].')$/u';
            if($this->value != '' && !preg_match($regex, $this->value)){
                $this->errors[] = 'فرمت فیلد '.$this->name.' نامعتبر است.';
            }
        }
        return $this;
    }

    // اعمال یک الگوی سفارشی به مقدار
    public function customPattern($pattern){
        $regex = '/^('.$pattern.')$/u';
        if($this->value != '' && !preg_match($regex, $this->value)){
            $this->errors[] = 'فرمت فیلد '.$this->name.' نامعتبر است.';
        }
        return $this;
    }

    // بررسی اگر مقدار فیلد ضروری است و نباید خالی باشد
    public function required(){
        if((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)){
            $this->errors[] = 'فیلد '.$this->name.' اجباری است.';
        }
        return $this;
    }

    // بررسی اگر مقدار دارای طول حداقل باشد
    public function min($length){
        if(is_string($this->value)){
            if(strlen($this->value) < $length){
                $this->errors[] = 'مقدار فیلد '.$this->name.' کمتر از '.$length.' است.';
            }
        }else{
            if($this->value < $length){
                $this->errors[] = 'مقدار فیلد '.$this->name.' کمتر از '.$length.' است.';
            }
        }
        return $this;
    }

    // بررسی اگر مقدار از طول حداکثر تجاوز نکند
    public function max($length){
        if(is_string($this->value)){
            if(strlen($this->value) > $length){
                $this->errors[] = 'مقدار فیلد '.$this->name.' بیشتر از '.$length.' است.';
            }
        }else{
            if($this->value > $length){
                $this->errors[] = 'مقدار فیلد '.$this->name.' بیشتر از '.$length.' است.';
            }
        }
        return $this;
    }

    // بررسی اگر مقدار با مقدار دیگری برابر باشد
    public function equal($value){
        if($this->value != $value){
            $this->errors[] = 'مقدار فیلد '.$this->name.' مطابقت ندارد.';
        }
        return $this;
    }

    // بررسی اگر اندازه فایل از حداکثر اندازه مجاز تجاوز نکند
    public function maxSize($size){
        if($this->file['error'] != 4 && $this->file['size'] > $size){
            $this->errors[] = 'حجم فایل '.$this->name.' از حداکثر مجاز بیشتر است: '.number_format($size / 1048576, 2).' MB.';
        }
        return $this;
    }

    // بررسی اگر فایل دارای فرمت صحیح باشد
    public function ext($extension){
        if($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension){
            $this->errors[] = 'فرمت فایل '.$this->name.' باید '.$extension.' باشد.';
        }
        return $this;
    }

    // پاکسازی یک رشته
    public function purify($string){
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    // بررسی اگر هیچ خطای اعتبارسنجی وجود ندارد
    public function isSuccess(){
        return empty($this->errors);
    }

    // دریافت لیست خطاهای اعتبارسنجی
    public function getErrors(){
        return $this->isSuccess() ? [] : $this->errors;
    }

    // نمایش تمام خطاهای اعتبارسنجی به صورت لیست HTML
    public function displayErrors(){
        $html = '<ul>';
        foreach($this->getErrors() as $error){
            $html .= '<li>'.$error.'</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    // نمایش اولین خطای اعتبارسنجی
    public function displayError(){
        return !empty($this->errors) ? $this->errors[0] : '';
    }

    // چاپ خطاهای اعتبارسنجی و متوقف کردن اجرای اسکریپت در صورت وجود خطا
    public function result(){
        if(!$this->isSuccess()){
            foreach($this->getErrors() as $error){
                echo "$error\n";
            }
            exit;
        }
        return true;
    }

    // بررسی اگر یک مقدار در جدول و ستون مشخص منحصر به فرد باشد
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
            $this->errors[] = 'مقدار فیلد '.$this->name.' از قبل وجود دارد';
        } else {
            return true;
        }
    }

    // بررسی اگر یک مقدار در جدول و ستون مشخص وجود داشته باشد
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
            $this->errors[] = 'مقدار فیلد '.$this->name.'  وجود ندارد';
        }
    }

    // متدهای استاتیک برای بررسی‌های اعتبارسنجی عمومی
    public static function is_int($value){
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    public static function is_float($value){
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    public static function is_alpha($value){
        return filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/"))) !== false;
    }

    public static function is_alphanum($value){
        return filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/"))) !== false;
    }

    public static function is_url($value){
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    public static function is_uri($value){
        return filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/"))) !== false;
    }

    public static function is_bool($value){
        return is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE));
    }

    public static function is_email($value){
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

}

?>