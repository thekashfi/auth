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
                $db = Connection::getInstance();
                $conn = $db->connection();
                break;
            case 'json':
                $conn = new jsonconn();
                break;
        }
        return $conn;
    }
}