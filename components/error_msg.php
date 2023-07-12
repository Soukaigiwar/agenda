<?php

$erro = !empty($_COOKIE['erro']) ? $_COOKIE['erro'] : null;
setcookie('erro', '', time() - 1);

if ($erro) {
    echo ("<form action='index.php' method='get'>
    <div class='formulario_erro'>
        <div class=msg_erro>$erro</div>
        <div><input class=submit_btn type='submit' value='Voltar'></div>
    </div>
</form>");
}
?>
