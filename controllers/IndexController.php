<?php


namespace Controllers;


class IndexController
{
    use MiddlewaresTrait;

    public function index()
    {
        if (guest()) {
            $href = url('login');
            flash("please <a href='{$href}'>login</a> to site. <b>to see only your contacts</b> and be able to add/edit/delete them.");
        }
        return view('index');
    }
}