<?php

require_once './app/User.php';
require_once './app/DB.php';
require_once './helpers.php';

define('URL', 'http://localhost/auth/');
session_start();
$path = str_replace('/auth', '', rtrim($_SERVER['REQUEST_URI'], '/'));

switch ($path) {
    case '':
    case '/home':
        require './home.php';
        break;
    case '/log':
        middleware('logged_in');
        require './login.php';
        break;
    case '/register':
        middleware('logged_in');
        require './register.php';
        break;
    case '/dashboard':
        middleware('auth');
        require './dashboard.php';
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        var_dump($path);
        require './404.php';
        break;
}