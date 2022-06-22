<?php


namespace Controllers;


class IndexController
{
    use MiddlewaresTrait;

    public function index()
    {
        if (guest()) {
            $href = url('login');
            flash("to see only your contacts and add/edit/delete them. please <a href='{$href}'>login</a> to site.");
        }
        return view('index');
    }
}