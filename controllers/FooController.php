<?php

namespace Controllers;

class FooController
{
    public function index()
    {
        $name = 'ali';
        return view('foo', ['name' => $name]);
    }
}