<?php

function middleware($name) {
    if ($name === 'logged_in') {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            header('location: ' . URL);
            exit;
        }
    }

    if ($name === 'auth') {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            die('you don\'t have access to this route. GET OUTTA HERE!');
        }
    }
}