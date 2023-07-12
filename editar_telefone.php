<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    if (empty($_COOKIE['telefone_id'])) {
        header('Location: index.php');
    }
}

$id = !empty($_POST['id']) ? $_POST['id'] : $_COOKIE['telefone_id'];
setcookie('telefone_id', $id, time() + 120);

use sql_connection\Database;

require_once('./class/Database.php');
require_once('./env/constants.php');

$actual_url = 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$theme = !empty($_COOKIE['theme']) ? $_COOKIE['theme'] : 'night';

$db = new Database(MYSQL_CONFIG);

$params = [
    ':id' => $id
];

$query = $db->execute_query("SELECT * FROM telefones WHERE id=:id", $params);
$results = $query->results;
?>

<?php include_once('components/head.php'); ?>

<body>
    <?php include_once('components/header.php'); ?>
    <?php include_once('components/contact_edit_form.php'); ?>
    <?php include_once('components/side_tag.php'); ?>
</body>

</html>