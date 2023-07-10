<?php

//Gerir lista de contatos com nomes e telefones;
//Permitir add, edit, delete os contatos;
//Impedir telefones duplicados;
//Permitir pesquisa por nome e/ ou telefone;
//Funcionalidade para exportação de dados para csv;

use sql_connection\Database;

require_once('./class/Database.php');
require_once('./env/constansts.php');

$db = new Database(MYSQL_CONFIG);

$params = [
    ':id' => $_POST['telefone_id']
];

$query = $db->execute_non_query("DELETE FROM `telefones` WHERE `id` = (:id)", $params);

header('Location: index.php');
?>