<?php


namespace App\Controllers;


use App\Models\User;

class LoginController
{
    use MiddlewaresTrait, Validators;

    public $middleware = 'guestOnly';

    public function index()
    {
        if (isset($_POST['login']))
            $this->login();

        return view('login');
    }

    public function login()
    {
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];

        $this->validation();

        if ($user = (new User)->checkLogin($this->email, md5($this->password))) {
            $_SESSION['user'] = $user;
            redirect('/');
        }
        else {
            flashBack('email or password is wrong!');
        }
    }

    private function validation()
    {
        // email: req|email|max:100
        $this->required($this->email, 'email');
        $this->maxLength($this->email, 'email');
        $this->email($this->email);
        // password: max:100
        $this->required($this->password, 'password');
        $this->maxLength($this->password, 'password');
    }
}