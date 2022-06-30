<?php


namespace App\Controllers;


trait MiddlewaresTrait
{ // TODO: write documentation for my code. like: middleware, routing, viewsTemplateEngine
    public function loggedIn()
    {
        if (guest()) {
            $href= url('/login');
            die("please <a href='{$href}'>login</a> first. and then visit this page.");
        }
    }

    public function guestOnly()
    {
        if (auth()) {
            redirect('/');
        }
    }
}