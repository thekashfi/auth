<?php

namespace App;

class User
{
    private $name;
    private $email;
    private $password;

    public function register($name, $email, $password)
    {
        $this->name = $name; // TODO: refactor needed!
        $this->email = $email;
        $this->password = md5($password);

        $this->validation();

        if ($id = DB::createUser($name, $email, $this->password)) {
            // TODO: check if user doesn't exists already! (email)
            // login him (make seesion and give the cookie)

            $user = DB::find($id);
            $_SESSION['user'] = $user;
            redirect('dashboard');
        }
    }

    public function login($email, $password)
    {
        $this->name = false;
        $this->email = $email;
        $this->password = md5($password); // TODO: refactor needed!
        $this->validation();

        if ($user = $this->find()) {
            $_SESSION['user'] = $user;
            redirect('dashboard');
        }
    }

    public static function logout() {
        if (isset($_SESSION['user'])) {
            session_destroy();
            redirect('home');
        }
    }

    public function find()
    {
        return DB::findUser($this->email, $this->password);
    }

    public function validation()
    {
        // TODO: put these to a validationTrait helper
        // TODO: put all method except login&register to other traits
        // name: req|max:100
        if ($this->name !== false) {
            if (empty(trim($this->name))) {
                die('fill the name field');
            }
            if (strlen(trim($this->name)) > 100) {
                die('name shouldn\'t be more than 100 characters');
            }
        }
        // email: req|email|max:100
        if (empty(trim($this->email))) {
            die('fill the email field');
        }
        if (strlen(trim($this->email)) > 100) {
            die('email can\'t be more than 100 characters');
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            die('invalid email format');
        }
        // password: text|max:100
        if (strlen(trim($this->email)) > 100) {
            die('password can\'t be more than 100 characters');
        }
    }
}