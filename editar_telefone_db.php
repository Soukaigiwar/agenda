<?php

session_start();

$_user_id = $_SESSION['user_id'];
$_contact_id = $_POST['id'];
$_contact_nome = $_POST['text_nome'];
$_contact_telefone = $_POST['text_telefone'];

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.php');
}

use sql_connection\Database;
use sql_connection\Contact;
require_once('class/Database.php');
require_once('class/Contact.php');
require_once('env/constants.php');

$params = [
    ':user_id' => $_user_id,
    ':id' => $_contact_id,
    ':nome' => $_contact_nome,
    ':telefone' => $_contact_telefone
];

echo '<pre>';


$contact = new Contact();
$query = $contact->get_contacts_by_id($_contact_id);







if (!$query) {
    $_SESSION['error'] = 'Erro ao tentar alterar o contacto.';
    echo 'erro ao tentar localizar contato';
} 
$affected_rows = $query->affected_rows;
$result = $query->results;
$query_user_id = $result[0]->user_id;

$query_contact_id = ($affected_rows) ? $result[0]->id : 0;



if ($_user_id != $query_user_id) {
    $_SESSION['error'] = 'Erro ao tentar alterar o contacto.';
    echo 'erro aqui';
    //header('Location: index.php');
} else {
    unset($_SESSION['error']);
}


if ($result && $query_contact_id != $_contact_id) {
    $_SESSION['error'] = 'Já existe esse telefone registado.';
    //header('Location: index.php');
} else {
    unset($_SESSION['error']);
    $db = new Database(MYSQL_CONFIG);
    $result = $db->execute_non_query("UPDATE `telefones` 
        SET nome = :nome, telefone = :telefone, updated_at = NOW() 
        WHERE id = :id AND user_id = :user_id", $params);
}

header('Location: index.php');
?>
