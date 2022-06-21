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
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $pdo = (new self)->pdo;
        if ($pdo->prepare($sql)->execute([$name, $email, $password]))
            return $pdo->lastInsertId();
    }

    static function findUser($email, $password = false) {
        $sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
        $pdo = (new self)->pdo;
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $password]);
        return $stmt->fetchObject();
    }

    static function find($id) {
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $pdo = (new self)->pdo;
        $stmt = $pdo->prepare($sql);
        $stmt->execute($id);
        return $stmt->fetchObject();
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