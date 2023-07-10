<?php

use sql_connection\Database;

require_once('./class/Export.php');
require_once('./class/Database.php');
require_once('./env/constansts.php');

$nome = !empty($_GET['nome']) ? $_GET['nome'] : '';
$telefone = !empty($_GET['telefone']) ? $_GET['telefone'] : '';



$params = [
    ':nome' => '%' . $nome . '%',
    ':telefone' => '%' . $telefone . '%'
];

$db = new Database(MYSQL_CONFIG);
$query = $db->execute_query(" 
    SELECT * FROM telefones 
    WHERE nome like :nome
    AND telefone like :telefone
    ORDER BY nome", $params);

$content = [];

foreach ($query->results as $data){
    $content[] = [$data->nome, $data->telefone];
}

$export_to_csv = new Export();

$file = $export_to_csv->export_to_csv($content);

setcookie('export_file', $file, time() + 10);

header('Location: index.php');
