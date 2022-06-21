<?php

namespace App;
use PDO;

class DB
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    public $pdo;

    public function __construct()
    {
        $this->connect();
    }

    static function createUser($name, $email, $password) {
        // TODO: hash the password in appropriate way.
        $sql = "insert into users (name, email, password) values (?, ?, ?)";
        return (new self)->pdo->prepare($sql)->execute([$name, $email, $password]);
    }

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