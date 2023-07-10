<?php

$nome = 'theme';
$valor = 'day';
$expiracao = 86400;

setcookie($nome, $valor, time() + $expiracao);

$previous_url = $_GET['url'];
header("$previous_url");