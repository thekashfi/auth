<?php

function redirect($path) {
    header('location: ' . url() . ltrim($path, '/'));
    exit;
}

function view($name, $data = []) {
    $templates = new \League\Plates\Engine(ROOT . '/views');
    echo $templates->render($name, $data);
}

function url($path = '') {
    return conf('url') . '/' . ltrim($path, '/');
}

function asset($path) {
    return url('public') . '/' . ltrim($path, '/');
}

function dd($input) {
    echo '<pre><br>';
    var_dump($input);
    exit;
}