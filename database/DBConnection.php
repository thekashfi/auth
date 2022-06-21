<?php

namespace App;

use PDO;

trait DBConnection
{

    public $pdo;
    protected $password = '';
    protected $host = 'localhost';
    protected $username = 'root';

    public function connect()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=auth", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}