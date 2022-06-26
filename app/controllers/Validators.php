<?php

namespace App\Controllers;

trait Validators
{
    public function email($item)
    {
        if (!filter_var($item, FILTER_VALIDATE_EMAIL))
            return flashBack('invalid email format');
        return true;
    }

    public function maxLength($item, $name)
    {
        if (strlen(trim($item)) > 100)
            return flashBack("$name shouldn't be more than 100 characters");
        return true;
    }

    public function required($item, $name = null)
    {
        if (empty(trim($item)))
            return flashBack("the $name field can't be empty!");
        return true;
    }

    public function requiredFile($name)
    {
        if (! isset($_FILES) ||  empty($_FILES[$name]['tmp_name'])) {
            return flashBack("$name file is required");
        }
        return true;
    }

    public function isImage($name)
    {
        $allowedTypes = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg'
        ];

        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($fileInfo, $_FILES[$name]['tmp_name']);

        if (!in_array($fileType, array_keys($allowedTypes)))
            return flashBack("$name file must be an image (allowed: jpeg/png)");
        return true;
    }

    public function maxSize($name, $maxSize)
    {
        $file = $_FILES[$name]['tmp_name'];
        $size = filesize($file);
        if ($size > $maxSize*1024*1024)
            return flashBack("$name file can't be more than {$maxSize}MB");
        return true;
    }
}