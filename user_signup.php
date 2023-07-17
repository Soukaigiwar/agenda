<?php
session_start();

use sql_connection\User;

if ($_SERVER['REQUEST_METHOD'] != 'POST' || isset($_SESSION['user'])) {
    header('Location: index.php');
}

require_once('./class/User.php');

$user_data = [];
$user_data['name'] = $_POST['text_nome'];
$user_data['last_name'] = $_POST['text_apelido'];
$user_data['email'] = $_POST['text_email'];
$user_data['password'] = $_POST['text_password'];

$user = new User();

$new_user = $user->add_user($user_data);

if (!$new_user) {
    $error = 'Erro ao criar novo usuário, verifique os dados digitados';
    setcookie($erro, $error, time() + 180);
    header('Location: index.php', 400);
} else {
    header('Location: index.php', 200);
}


// header('Location: index.php');
