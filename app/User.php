<?php

namespace App;

class User
{
    private $name;
    private $email;
    private $password;

    public function register($name, $email, $password)
    {
        $this->validation();

        if (DB::createUser($name, $email, $password)) {
            // login him (make seesion and give the cookie)
            $this->login();
        }

        // redirect to dashboard page
    }

    public function login($email, $password)
    {
        $this->validation();

        if ($this->find()) {

        }

        // login him (make seesion and give the cookie)
        $this->login();
    }

    public function validate()
    {

    }

    public function find()
    {
        return DB::findUser($this->email, $this->password);
    }

    public function login()
    {

    }
}