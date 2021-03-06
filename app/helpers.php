<?php

use App\Database\DatabaseFactory;
use App\Database\DB;

function redirect($path) {
    header('location: ' . url() . ltrim($path, '/'));
    exit;
}

function view($name, $data = []) {
    $templates = new \League\Plates\Engine(ROOT . '/app/views');
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

function auth() {
    if (isset($_SESSION['user']))
        return true;
    return false;
}

function guest() {
    if (! isset($_SESSION['user']))
        return true;
    return false;
}

function user() {
    return $_SESSION['user'];
}

function flash($msg = false) {
    if ($msg !== false) {
        $_SESSION['flash'] = $msg;
    } elseif (isset($_SESSION['flash'])) {
        $msg = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $msg;
    }
}

function db($driver = null) {
    return DatabaseFactory::getConnection($driver ?: conf('driver'));
}

function pdo() {
    return DatabaseFactory::getConnection('mysql')->conn();
}

function json() {
    return DatabaseFactory::getConnection('json')->conn();
}

function flashBack($msg) {
    if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
        die(json_encode(['msg' => $msg]));
    }
    flash($msg);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

function routeIs($path) { // TODO: remove parameters from end of the route
    return trim(str_replace('/auth', '', $_SERVER['REQUEST_URI']), '/') === trim(strtolower($path), '/');
}