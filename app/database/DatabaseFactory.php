<?php

namespace App\Database;

use App\Database\Mysql\Connection;

class DatabaseFactory
{
    public static function getConnection($type)
    {
        $type = strtolower($type);
        $name = ucfirst(strtolower($type));
        $class = "App\\Database\\$name\\$name";
        if (file_exists(ROOT . "/app/database/{$type}/{$name}.php") &&
            class_exists($class)) {
            return new $class;
        }
        die("database driver '{$type}' is not installed!");
    }
}