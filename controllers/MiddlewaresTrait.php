<?php


namespace Controllers;


trait MiddlewaresTrait
{
    public function loggedIn()
    {
        if (guest()) {
            $href= url('/login');
            die("please <a href='{$href}'>login</a> first. and then visit this page."); //TODO: implement flash instead of die out errors.
        }
    }

    public function guestOnly()
    {
        if (auth()) {
            redirect('dashboard');
        }
    }
}