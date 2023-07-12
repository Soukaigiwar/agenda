<?php

use sql_connection\Database;

require_once('./class/Database.php');
require_once('./env/constants.php');

$db = new Database(MYSQL_CONFIG);

$params = [
    ':id' => $_POST['id']
];

$query = $db->execute_non_query("DELETE FROM telefones WHERE id = :id", $params);

header('Location: index.php');
