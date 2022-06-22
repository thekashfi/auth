<?php

function middleware($name) {
    if ($name === 'logged_in') {
        if (isset($_SESSION['user'])) {
            redirect('dashboard');
        }
    }

    if ($name === 'auth') {
        if (!isset($_SESSION['user'])) {
            die('you don\'t have access to this route. GET OUTTA HERE!');
        }
    }
}

function redirect($path) {
    header('location: ' . URL . ltrim($path, '/'));
    exit;
}

function view($name, $data = []) {
    $templates = new \League\Plates\Engine(ROOT . '/views');
    echo $templates->render($name, $data);
}