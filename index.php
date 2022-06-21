<?php

$request = str_replace('/auth', '', rtrim($_SERVER['REQUEST_URI'], '/'));

switch ($request) {
    case '':
        require './home.php';
        break;
    case '/home':
        require './home.php';
        break;
    case '/login':
        require './login.php';
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        var_dump($request);
        require './404.php';
        break;
}