<?php


namespace Controllers;

use App\DB;

class InstallController
{
    public function index()
    {
        $pdo = DB::pdo;
    }
}