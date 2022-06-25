<?php

namespace Database;

use PDO;

class MySqlDB implements Foo
{
    private static $obj;
    private $conn;

    private final function __construct()
    {
        $this->conn = $this->connect();
    }

    public static function getInstance()
    {
        if (! isset(self::$obj)) {
            self::$obj = new MySqlDB;
        }
        return self::$obj;
    }

    public function connection()
    {
        if (isset($this->conn)) {
            return $this->conn;
        }
        return null;
    }

    private function connect()
    {
        try {
            $conn = new PDO('mysql:host=' . conf('host') . ';dbname=' . conf('database'), conf('username'), conf('password'));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        return $conn;
    }
}