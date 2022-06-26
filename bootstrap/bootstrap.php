<?php

use Bootstrap\Core;

session_start();

define('ROOT', __DIR__ . '/..');

function conf($key) {
    $config = require(ROOT . '/bootstrap/config.php');
    return $config[$key];
}
require_once ROOT . '/app/helpers.php';

// auto include classes
require_once ROOT . '/vendor/autoload.php';

new Core();