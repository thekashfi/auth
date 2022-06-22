<?php


namespace Controllers;

use App\DB;

class InstallController
{
    public function index()
    {
        $pdo = DB::pdo();

        try {
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                password VARCHAR(100) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE (email)
                );";

            $sql .= "CREATE TABLE IF NOT EXISTS contacts (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id INT(6) UNSIGNED,
                first_name VARCHAR(100) NOT NULL,
                last_name VARCHAR(100),
                phone VARCHAR(100) NOT NULL,
                email VARCHAR(100),
                gender VARCHAR(100),
                image VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
            );";
            $pdo->exec($sql);
        } catch(PDOException $e) {
            echo 'couldn\'t create tables: ' . $e->getMessage();
        }

        echo 'tables has been created successfully.';
    }
}