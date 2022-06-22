<?php

namespace App;
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

    static function createUser($name, $email, $password)
    {
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $pdo = (new self)->pdo;
        if ($pdo->prepare($sql)->execute([$name, $email, $password]))
            return $pdo->lastInsertId();
    }

    static function findUser($email, $password = false)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
        $pdo = (new self)->pdo;
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $password]);
        return $stmt->fetchObject();
    }

    static function find($id)
    {
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $pdo = (new self)->pdo;
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchObject();
    }

}