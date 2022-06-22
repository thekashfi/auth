<?php

namespace Database;

use PDO;

class DB
{
    public $pdo;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO('mysql:host=' . conf('host') . ';dbname=' . conf('database'), conf('username'), conf('password'));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function pdo()
    {
        return (new self)->pdo;
    }

}