<?php

include_once './app/User.php';
include_once './app/DB.php';

$request = str_replace('/auth', '', rtrim($_SERVER['REQUEST_URI'], '/'));

switch ($request) {
    case '':
    case '/home':
        require './home.php';
        break;
    case '/log':
        require './login.php';
        break;
    case '/register':
        require './register.php';
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        var_dump($request);
        require './404.php';
        break;
}