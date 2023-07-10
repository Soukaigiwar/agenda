<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    if (empty($_COOKIE['telefone_id'])) {
        header('Location: index.php');
    }
}

$id = !empty($_POST['telefone_id']) ? $_POST['telefone_id'] : $_COOKIE['telefone_id'];
setcookie('telefone_id', $id, time() + 120);

use sql_connection\Database;

require_once('./class/Database.php');
require_once('./env/constansts.php');

$actual_url = 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$theme = !empty($_COOKIE['theme']) ? $_COOKIE['theme'] : 'night';

$db = new Database(MYSQL_CONFIG);

$params = [
    ':id' => $id
];

$query = $db->execute_query("SELECT * FROM telefones WHERE id=:id", $params);
$results = $query->results;
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestao de telefones</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Syne&display=swap" rel="stylesheet">

    <?php if ($theme == 'night'): ?>
        <link rel='stylesheet' href='./assets/styles_night.css'>
        <?php
        $switch_theme = 'day';
        ?>
    <?php else: ?>
        <link rel='stylesheet' href='./assets/styles_day.css'>
        <?php
        $switch_theme = 'night';
        ?>
    <?php endif; ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <div class="header">
        <div class="logo">
            Agenda
        </div>
        <div class="menu">
            <a href="index.php"><i class="fa-solid fa-address-book"></i>Listar Telefones</a>
            <!-- <a href="criar_database.php" style='color: #DD1111;'><i class="fa-solid fa-database"></i>Resetar base de
                dados!</a> -->
            <?php if ($theme == 'night'): ?>
                <a href="theme_<?= $switch_theme ?>.php?&url=<?= $actual_url ?>"><i class="fa-solid fa-sun"></i></a>
            <?php else: ?>
                <a href="theme_<?= $switch_theme ?>.php?&url=<?= $actual_url ?>"><i class="fa-solid fa-moon"></i></a>
            <?php endif; ?>
        </div>
    </div>
    <div class="formulario_editar">
        <form action="editar_telefone_db.php" method="post">
            <input type="hidden" id="id" name="id" value="<?= $results[0]->id ?>">
            <input type="text" name="text_nome" id="nome" placeholder="Nome completo" value="<?= $results[0]->nome ?>"
                required>
            <input type="tel" name="text_telefone" id="telefone" placeholder="+351 " value="<?= $results[0]->telefone ?>"
                required>
            <input class="submit" type="submit" value="Gravar">
        </form>
    </div>
</body>

</html>