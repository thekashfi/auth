<?php

namespace Database;

use PDO;

class DB
{
    private static $obj;
    private $pdo;

    private final function __construct()
    {
        $this->pdo = $this->connect();
    }

    public static function getInstance()
    {
        if (! isset(self::$obj)) {
            self::$obj = new DB;
        }
        return self::$obj;
    }

    public function pdo()
    {
        if (isset($this->pdo)) {
            return $this->pdo;
        }
        return null;
    }

    private function connect()
    {
        try {
            $pdo = new PDO('mysql:host=' . conf('host') . ';dbname=' . conf('database'), conf('username'), conf('password'));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        return $pdo;
    }
}