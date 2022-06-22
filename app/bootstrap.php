<?php

use App\Core;

session_start();

define('ROOT', __DIR__ . '/..');

function conf($key) {
    $config = require(ROOT . '/app/config.php');
    return $config[$key];
}
require_once ROOT . '/app/helpers.php';

// auto include classes
spl_autoload_register(function($class) {
    $class = basename($class); // trims namespace
    $dirs = [
        ROOT . '/app/' . str_replace('\\', '/', $class) . '.php',
        ROOT . '/controllers/' . $class . '.php',
        ROOT . '/database/' . $class . '.php',
        ROOT . '/models/' . $class . '.php',
        ROOT . '/libs/plates/' . $class . '.php',
        ROOT . '/libs/plates/Extension/' . $class . '.php',
        ROOT . '/libs/plates/Template/' . $class . '.php',
    ];
    foreach ($dirs as $class) {
        if(file_exists($class)) {
            require_once $class;
        }
    }
});

new Core();