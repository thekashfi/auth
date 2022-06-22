<?php


namespace Controllers;


class IndexController
{
    use MiddlewaresTrait;

    public $middleware = 'loggedIn';

    public function index()
    {
        return view('index');
    }
}