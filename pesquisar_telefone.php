<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.php');
}


$nome = !empty($_POST['text_nome']) ? $_POST['text_nome'] : "";
setcookie("pesquisar_nome", "$nome", time() + 60);
$telefone = !empty($_POST['text_telefone']) ? $_POST['text_telefone'] : "";
setcookie("pesquisar_telefone", "$telefone", time() + 60);
$pesquisa_ativa = ($_POST['text_nome'] != '' || $_POST['text_telefone'] != '') ? 'true' : 'false';
setcookie("pesquisa_ativa", "$pesquisa_ativa", time() + 60);

echo $nome . $telefone . $pesquisa_ativa;
//die();
header('Location: index.php')
?>
