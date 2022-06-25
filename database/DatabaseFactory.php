<?php

namespace Database;

class DatabaseFactory
{
    public static function getConnection($type)
    {
        switch ($type) {
            default:
            case 'mysql':
                $db = MySqlDB::getInstance();
                $conn = $db->connection();
                break;
            case 'json':
                $conn = new jsonconn();
                break;
        }
        return $conn;
    }
}