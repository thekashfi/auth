<?php


namespace Controllers;


class LogoutController
{
    use MiddlewaresTrait;

    public $middleware = 'loggedIn';

    public function index()
    {
        if (isset($_SESSION['user'])) {
            session_destroy();
            redirect('/');
        }
    }
}