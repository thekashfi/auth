<?php

// if method is post and don't have authenticated session
//   register the user
if(User::register('name', 'email', 'pass')) {


}
// else
//   show the form
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>register is here
<form action="">
    <input type="text" name="name">
    <input type="email" name="email">
    <input type="password" name="password">
</form>
</body>
</html>

