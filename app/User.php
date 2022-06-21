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
        $this->password = $password;

        $this->validation();

        if (DB::createUser($name, $email, $password)) {
            // login him (make seesion and give the cookie)
            // TODO: check if user doesn't exists already! (email)
            die('logged in');
            $this->login();
        }

        // redirect to dashboard page
    }

    public function login($email, $password)
    {
        $this->name = false;
        $this->email = $email;
        $this->password = $password; // TODO: refactor needed!
        $this->validation();

        if ($this->find()) {

        }

        // login him (make seesion and give the cookie)
        $this->login();
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

    public function find()
    {
        return DB::findUser($this->email, $this->password);
    }

//    public function clean($text) {
//        return htmlspecialchars(stripslashes(trim($text)));
//    }
}