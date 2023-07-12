<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.php');
}

use sql_connection\Database;
use sql_connection\Contact;
require_once('Database.php');
require_once('./class/Contact.php');
require_once('./env/constants.php');

$params = [
    ':id' => $_POST['id'],
    ':nome' => $_POST['text_nome'],
    ':telefone' => $_POST['text_telefone']
];

$contact_to_update = new Contact();

$result_to_update = $params[':id'];
$telefone_to_update = $params[':telefone'];

$query = new Contact();
$search = $query->get_contacts($telefone_to_update);
$result = $search->affected_rows;

$result_id = ($result) ? $search->results[0]->id : 0;

if ($result && $result_id != $_POST['id']) {
    $nome = 'erro';
    $valor = 'Já existe esse telefone registado.';
    setcookie($nome, $valor, time() + 10);
} else {
    $db = new Database(MYSQL_CONFIG);
    $result = $db->execute_non_query("UPDATE `telefones` 
        SET nome=:nome, telefone=:telefone, updated_at=NOW() 
        WHERE id=:id", $params);
}

header('Location: index.php');
?>
