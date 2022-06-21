<?php

use App\User;

// if method is post and don't have authenticated session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    (new User)->login(
        $_POST['email'],
        $_POST['password']
    );
}

//if(User::register('name', 'email', 'pass')) {
//
//
//}

// else
//   show the form
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
Login Form <br><br>
<form action="" method="post">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="submit">
</form>
</body>
</html>

