<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
    <a href="<?= url() ?>login">login</a> | <a href="<?= url() ?>register">register</a> | <a href="<?= url('/') ?>">home</a><br>
    <?= $this->section('content') ?>
</body>
</html>
