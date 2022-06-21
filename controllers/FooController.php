<?php

namespace Controllers;

class FooController
{
    public function index($name)
    {
        echo 'i\'m index :)' . $name;
    }
}