<?php

namespace Database;

class DatabaseFactory
{
    public static function getConnection($type)
    {
        switch ($type) {
            case 'mysql':
                $db = MySqlDB::getInstance();
                $conn = $db->connection();
                break;
            case 'json':
                $conn = new jsonconn();
                break;
            default:
                $conn = new mysqlconn();
                break;
        }
        return $conn;
    }
}