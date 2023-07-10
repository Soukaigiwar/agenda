<?php

// OK - Gerir lista de contatos com nomes e telefones;
// OK - Permitir add, edit, delete os contatos;
// OK - Impedir telefones duplicados;
// OK - Permitir pesquisa por nome e/ ou telefone;
// OK - Funcionalidade para exportação de dados para csv;

// OK - Day and Night Mode

use sql_connection\Database;

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}


require_once('./class/Database.php');
require_once('./env/constansts.php');

$actual_url = 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$theme = !empty($_COOKIE['theme']) ? $_COOKIE['theme'] : 'night';
$erro = !empty($_COOKIE['erro']) ? $_COOKIE['erro'] : null;

$pesquisa_ativa = !empty($_COOKIE['pesquisa_ativa']) && $_COOKIE['pesquisa_ativa'] == 'true' ? true : false;

$pesquisar_nome = !empty($_COOKIE['pesquisar_nome']) ? $_COOKIE['pesquisar_nome'] : '';
$pesquisar_telefone = !empty($_COOKIE['pesquisar_telefone']) ? $_COOKIE['pesquisar_telefone'] : '';

$export = true;
$result_export_file = !empty($_COOKIE['export_file']) ? $_COOKIE['export_file'] : '';
console_log($result_export_file);

setcookie('erro', '', time() - 1);
setcookie('pesquisar_nome', '', time() - 1);
setcookie('pesquisar_telefone', '', time() - 1);
setcookie('pesquisa_ativa', '', time() - 1);
setcookie('export_file', '', time() - 1);

$db = new Database(MYSQL_CONFIG);
if (!$pesquisar_nome && !$pesquisar_telefone) {
    $query = $db->execute_query("SELECT * FROM telefones");
} else {
    $params = [
        ':nome' => '%' . $pesquisar_nome . '%',
        ':telefone' => '%' . $pesquisar_telefone . '%'
    ];
    $query = $db->execute_query("SELECT * FROM telefones WHERE nome LIKE :nome AND telefone LIKE :telefone", $params);
}


$results = $query->results;

if ($pesquisa_ativa && count($results) == 0) {
    $export = false;
    $erro = "Nenhum resultado da pesquisa.";
}
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
    <!-- Header -->
    <div class="header">
        <div class="logo">
            Agenda
        </div>
        <div class="tools">
            <div class="formulario_pesquisar">
                <form action="pesquisar_telefone.php" method="post">
                    <span class="span_pesquisar">Pesquisar:</span>
                    <input type="text" name="text_nome" id="nome" placeholder="nome">
                    <input type="tel" name="text_telefone" id="telefone" placeholder="telefone">
                    <button class="submit" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
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
    </div>

    <!-- Formulario -->
    <?php if ($erro !== null): ?>
        <form action="index.php" method="get">
            <div class="formulario_erro">
                <div class=msg_erro><?= $erro ?></div>
                <div><input class=submit_btn type="submit" value="Voltar"></div>
            </div>
        </form>
    <?php else: ?>
        <div class="formulario">
            <form action="adicionar_telefone.php" method="post">
                <input type="text" name="text_nome" id="nome" placeholder="Nome completo" required>
                <input type="tel" name="text_telefone" id="telefone" placeholder="+351 " required>
                <input class="submit" type="submit" value="Adicionar">
            </form>
        </div>
    <?php endif; ?>

    <!-- Tabela -->
    <div class="tabela">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $item): ?>
                    <tr>
                        <td>
                            <?= $item->nome ?>
                        </td>
                        <td>
                            <?= $item->telefone ?>
                        </td>
                        <td>
                            <div class="actions">
                                <form action="remover_telefone.php" method="post">
                                    <button class="remove" type="submit" name="telefone_id" value="<?= $item->id ?>">
                                        <span><i class="fa-solid fa-circle-minus"></i></span>
                                    </button>
                                </form>
                                <form action="editar_telefone.php" method="post">
                                    <button class="editar" type="submit" name="telefone_id" value="<?= $item->id ?>">
                                        <span><i class="fa-solid fa-pen"></i></span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div>
            <div class="total">
                Total de registos:
                <?php count($results); ?>
                <?php if ($export): ?>
                <?php if ($result_export_file !== ''): ?>
                    <div>Arquivo '<?= $result_export_file ?>' exportado com sucesso.</div>
                    <?php else : ?>
                    <div><a href="export_csv.php?nome=<?= $pesquisar_nome ?>&telefone=<?= $pesquisar_telefone ?>">Exportar <i
                    class="fa-solid fa-file-csv"></i></a></div>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
        </div>
        <div class="tag">
            <div class="inner_tag">
                <p>Feito por:</p>
                <p>Sergio Mello</p>
            </div>
        </div>
</body>

</html>