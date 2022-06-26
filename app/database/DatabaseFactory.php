<?php

namespace App\Database;

use App\Database\MySql\Connection;

class DatabaseFactory
{
    public static function getConnection($type)
    {
        switch ($type) {
            default:
            case 'mysql':
                return new MySql\MySql;
                break;
            case 'json':
                $conn = new jsonconn();
                break;
        }
    }
}