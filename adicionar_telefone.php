<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.php');
}

use sql_connection\Database;
require_once('Database.php');
require_once('./env/constants.php');


$db = new Database(MYSQL_CONFIG);

if (strlen($_POST['text_nome']) < 3) {
    $erro = 'erro';
    $valor = 'O nome precisa ter mais que 3 letras.';
    setcookie($erro, $valor, time() + 10);
    header('Location: index.php');
}

$select_params = [
    ':telefone' => trim($_POST['text_telefone'])
];

$params = [
    ':nome' => trim($_POST['text_nome']),
    ':telefone' => trim($_POST['text_telefone'])
];

$select_query = $db->execute_query("SELECT * FROM `telefones` WHERE telefone = :telefone", $select_params);
$select_data = $select_query->results;

if (empty($select_data)) {
    $result = $db->execute_non_query("INSERT INTO `telefones` 
        VALUES (0, :nome, :telefone, NOW(), NOW())", $params);
} else {
    $erro = 'erro';
    $valor = 'Já existe esse telefone registado.';
    setcookie($erro, $valor, time() + 10);
    header('Location: index.php');
}

header('Location: index.php')
?>
