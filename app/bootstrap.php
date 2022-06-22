<?php

use App\Core;

function conf($key) {
    return (require(ROOT . '/app/config.php'))->{$key};
}

spl_autoload_register(function($class) {
    $class = basename($class); // trims namespace
    $dirs = [
        ROOT . '/app/' . str_replace('\\', '/', $class) . '.php',
        ROOT . '/controllers/' . $class . '.php',
        ROOT . '/database/' . $class . '.php',
        ROOT . '/models/' . $class . '.php',
    ];
    foreach ($dirs as $class) {
        if(file_exists($class)) {
            require_once $class;
        }
    }
});

new Core();