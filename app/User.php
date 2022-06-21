<?php

namespace App;

class User
{
    use Validators;

    private $name;
    private $email;
    private $password;

    public function register($name, $email, $password)
    {
        $this->name = $name; // TODO: refactor needed!
        $this->email = $email;
        $this->password = md5($password);

        $this->validation();

        if ($id = DB::createUser($this->name, $this->email, $this->password)) {
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
        // TODO: put all method except login&register to other traits
        // name: req|max:100
        if ($this->name !== false) {
            $this->required($this->name, 'name');
            $this->maxLength($this->name, 'name');
        }
        // email: req|email|max:100
        $this->required($this->email, 'email');
        $this->email($this->email);
        $this->maxLength($this->email, 'email');
        // password: max:100
        $this->maxLength($this->password, 'password');
    }
}