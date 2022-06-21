<?php

use App\User;

// if method is post and don't have authenticated session
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    (new User)->register(
            $_POST['name'],
            $_POST['email'],
            $_POST['password']
    );
}
//   register the user

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
Register Form <br><br>
<form action="" method="post">
    <input type="text" name="name" placeholder="name">
    <input type="email" name="email" placeholder="email">
    <input type="password" name="password" placeholder="password">
    <input type="submit">
</form>
</body>
</html>

