<?php


namespace Controllers;

use Database\DB;

class InstallController
{
    public function index()
    {
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
            pdo()->exec($sql);
        } catch(PDOException $e) {
            echo 'couldn\'t create tables: ' . $e->getMessage();
        }

        $sql = "INSERT INTO users(name, email, password) VALUES ('admin', 'example@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055')"; // 1234
        pdo()->exec($sql);
        $id = pdo()->lastInsertId();

        $sql = "
        INSERT INTO
	        contacts(user_id, first_name, last_name, phone, email, gender, image)
        VALUES
            ($id, 'Carl', 'Rosales', '09171231234', 'example@gmail.com', 'male', '1.jpg'),
            ($id, 'Areli', 'Wu', '09171231234', 'example@gmail.com', 'female', '2.jpg'),
            ($id, 'Darsh', 'Wilkinson', '09171231234', 'example@gmail.com', 'male', '3.jpg'),
            ($id, 'Eliza', 'Kane', '09171231234', 'example@gmail.com', 'female', '4.jpg'),
            ($id, 'peter', 'Jarvis', '09171231234', 'example@gmail.com', 'male', '5.jpg'),
            ($id, 'Taliyah', 'Stewart', '09171231234', 'example@gmail.com', 'female', '6.jpg'),
            ($id, 'jack', 'Sims', '09171231234', 'example@gmail.com', 'male', '7.jpg'),
            ($id, 'Avah', 'Yates', '09171231234', 'example@gmail.com', 'female', '8.jpg'),
            ($id, 'john', 'Arellano', '09171231234', 'example@gmail.com', 'male', '9.jpg'),
            ($id, 'Alisson', 'Cordova', '09171231234', 'example@gmail.com', 'female', '10.jpg');
        ";

        if (pdo()->exec($sql) !== 10)
            die('problem');
        sleep(1);

        $sql = "INSERT INTO users(name, email, password) VALUES ('user2', 'example@email.com', '81dc9bdb52d04dc20036dbd8313ed055')"; // 1234
        pdo()->exec($sql);
        $id = pdo()->lastInsertId();

        $sql = "
        INSERT INTO
	        contacts(user_id, first_name, last_name, phone, email, gender, image)
        VALUES
            ($id, 'The', 'Rock', '09171231234', 'example@gmail.com', 'male', '11.jpg'),
            ($id, 'John', 'Doe', '09171231234', 'example@gmail.com', 'male', '12.jpg');
        ";

        if (pdo()->exec($sql) == 2) {
            $href = url();
            die("<b>Successfully</b> created tables and seeded some dummy data. now you can go to <a href='{$href}'>home page</a>.");
        }
    }
}