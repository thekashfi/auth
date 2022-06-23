<?php

namespace Controllers;

trait Validators
{

    public function email($item)
    {
        if (!filter_var($item, FILTER_VALIDATE_EMAIL))
            die('invalid email format');
    }

    public function maxLength($item, $name)
    {
        if (strlen(trim($item)) > 100)
            die("$name shouldn\'t be more than 100 characters");
    }

    public function required($item, $name)
    {
        if (empty(trim($item)))
            die("the $name field can't be empty!");
    }

    public function requiredFile($name)
    {
        if (! isset($_FILES) ||  empty($_FILES[$name]['tmp_name'])) {
            die("$name file is required");
        }
    }

    public function isImage($name)
    {
        $allowedTypes = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg'
        ];

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($fileInfo, $_FILES[$name]['tmp_name']);

        if (!in_array($fileType, array_keys($allowedTypes))) {
            die("$name file must be an image (allowed: jpeg/png)");
        }
        return true;
    }

    public function maxSize($name, $maxSize)
    {
        $file = $_FILES[$name]['tmp_name'];
        $size = filesize($file);
        if ($size > $maxSize*1024*1024) {
            die("$name file can't be more than {$maxSize}MB");
        }
        return true;
    }
}