<?php

namespace App\Controllers;

use App\Models\User;

class RegisterController
{
    use MiddlewaresTrait, Validators;

    public $middleware = 'guestOnly';

    public function index()
    {
        if (isset($_POST['register']))
            $this->register();

        return view('register');
    }

    public function register()
    {
        $this->name = $_POST['name'];
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];

        $this->validation();

        if ($id = (new User)->createUser($this->name, $this->email, md5($this->password))) {
            // TODO: check if user doesn't exists already! (email)
            // TODO: better implementation for User class. it keeps creating new object! Facade and singleton pattern needed!
            $user = (new User)->find($id);
            $_SESSION['user'] = $user;
            redirect('/');
        }
    }

    private function validation()
    {
        // name: req|max:100
        $this->required($this->name, 'name');
        $this->maxLength($this->name, 'name');
        // email: req|email|max:100
        $this->required($this->email, 'email');
        $this->maxLength($this->email, 'email');
        $this->email($this->email);
        // password: max:100
        $this->required($this->password, 'password');
        $this->maxLength($this->password, 'password');
    }
}