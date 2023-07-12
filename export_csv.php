<?php

use sql_connection\Contact;

require_once('./class/Export.php');
require_once('class/Contact.php');

$search = !empty($_POST['text_search']) ? $_POST['text_search'] : '';

$query = new Contact();

$result = $query->get_contacts($search);
$contacts = $result->results;

$export_to_csv = new Export();
$filename = date("YmdHis") . 'contatos.csv';

$export_to_csv->export_to_csv($contacts, $filename);

setcookie('export_file', $filename, time() + 2);
setcookie('search', $search, time() + 2);

header('Location: index.php');
