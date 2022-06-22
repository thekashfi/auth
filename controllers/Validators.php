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
            die('$name shouldn\'t be more than 100 characters');
    }

    public function required($item, $name)
    {
        if (empty(trim($item)))
            die("the $name field can't be empty!");
    }
}