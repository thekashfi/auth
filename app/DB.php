<?php

namespace App;
use PDO;

class DB
{
    use DBConnection;

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
        $stmt->execute([$id]);
        return $stmt->fetchObject();
    }

}