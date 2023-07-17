<?php
use sql_connection\User;

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.php');
}

require_once('./class/User.php');

$email = $_POST['text_email'];
$password = $_POST['text_password'];

$user = new User();

$user->get_user($email, $password);
