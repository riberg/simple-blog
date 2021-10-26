<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Блог' ?></title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            Блог
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?php if (!empty($user)): ?>
            Привет, <?= $user->getNickname() ?> | <a href="http://blog.loc/users/logout">Выйти</a>
            <?php else: ?>
            <a href="http://blog.loc/users/login">Войти</a> | <a href="http://blog.loc/users/register">Зарегистрироваться</a>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>
