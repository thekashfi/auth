<?php


namespace Controllers;


class LogoutController
{
    public function index()
    {
        if (isset($_SESSION['user'])) {
            session_destroy();
            redirect('/');
        }
    }
}