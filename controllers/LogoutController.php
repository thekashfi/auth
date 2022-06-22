<?php


namespace Controllers;


class LogoutController
{
    public function index()
    {
        $this->middleware();

        if (isset($_SESSION['user'])) {
            session_destroy();
            redirect('/');
        }
    }

    private function middleware()
    {
        if (!isset($_SESSION['user'])) {
            $href= url('/login');
            die("please <a href='{$href}'>login</a> first. and then visit this page.");
        }
    }
}