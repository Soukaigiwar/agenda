<?php

use sql_connection\Database;
require_once('Database.php');
require_once('./env/constansts.php');

$db = new Database(MYSQL_CONFIG);

$params = [
    ':id' => $_POST['id'],
    ':nome' => $_POST['text_nome'],
    ':telefone' => $_POST['text_telefone']
];

$query_params = [
    ':telefone' => $_POST['text_telefone']
];

$select_query = $db->execute_query("SELECT * FROM `telefones` WHERE telefone = :telefone", $query_params);
$select_data = $select_query->results;

if (empty($select_data)) {
    $result = $db->execute_non_query("UPDATE `telefones` SET nome=:nome, telefone=:telefone WHERE id=:id", $params);
} else {
    $nome = 'erro';
    $valor = 'Já existe esse telefone registado.';
    setcookie($nome, $valor, time() + 10);
    header('Location: index.php');
}

header('Location: index.php')
?>
