<?php


namespace Controllers;


class IndexController
{
    public function index()
    {
        $this->middleware();

        return view('index');
    }

    private function middleware()
    {
        if (!isset($_SESSION['user'])) {
            $href= url('/login');
            die("please <a href='{$href}'>login</a> first. and then visit home page."); //TODO: implement flash instead of die out errors.
        }
    }
}