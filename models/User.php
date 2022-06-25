<?php

namespace Models;

use Database\DB;

class User
{
    public function checkLogin($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND password = ? LIMIT 1";
        $stmt = pdo()->prepare($sql);
        $stmt->execute([$email, md5($password)]);
        return $stmt->fetchObject();
    }

    static function createUser($name, $email, $password)
    {
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        if (pdo()->prepare($sql)->execute([$name, $email, md5($password)]))
            return pdo()->lastInsertId();
        return false;
    }

    static function find($id)
    {
        $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
        $stmt = pdo()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchObject(); // TODO: check if not found user by id. returns what?!
    }
}