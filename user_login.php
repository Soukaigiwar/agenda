<?php
session_start();

use sql_connection\User;

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.php');
}

require_once('./class/User.php');

$email = $_POST['text_email'];
$password = $_POST['text_password'];

$user = new User();

$user_data = $user->get_user($email, $password);

if (!$user_data) {
    unset($_SESSION['user']);
    header('Location: index.php');
} else {
    $_SESSION['user'] = $user_data['name'];
    $_SESSION['user_id'] = $user_data['user_id'];
}


header('Location: index.php');
