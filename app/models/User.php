<?php

namespace App\Models;

use App\Database\DB;

class User
{
    public function checkLogin($email, $password)
    {
        return db()->findByEmailPass($email, $password);
    }

    public function createUser($name, $email, $password)
    {
        return db()->insert('users', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function find($id)
    {
        return db()->find('users', $id);
    }
}