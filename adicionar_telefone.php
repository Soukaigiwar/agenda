<?php

use sql_connection\Database;
require_once('Database.php');
require_once('./env/constansts.php');


$db = new Database(MYSQL_CONFIG);

$select_params = [
    ':telefone' => $_POST['text_telefone']
];

$params = [
    ':nome' => $_POST['text_nome'],
    ':telefone' => $_POST['text_telefone']
];

$select_query = $db->execute_query("SELECT * FROM `telefones` WHERE telefone = :telefone", $select_params);
$select_data = $select_query->results;

if (empty($select_data)) {
    $result = $db->execute_non_query("INSERT INTO `telefones` (`nome`, `telefone`) 
VALUES (:nome, :telefone)", $params);
} else {
    $nome = 'erro';
    $valor = 'Já existe esse telefone registado.';
    setcookie($nome, $valor, time() + 10);
    header('Location: index.php');
}

header('Location: index.php')
?>
