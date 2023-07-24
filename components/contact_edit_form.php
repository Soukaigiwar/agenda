<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.php');
}
$id = $_POST['id'];
$nome = $_POST['text_nome'];
$telefone = $_POST['text_telefone'];
?>

<div class="group_contact_edit">
    <h2>Editar Contato</h2>
    <form action="editar_telefone_db.php" method="post">
        <input type="hidden" id="id" name="id" value="<?= $id ?>">

        <div class="group_input">
            <span>Nome</span>
            <input type="text" name="text_nome" id="nome" value="<?= $nome ?>" required>

        </div>
        <div class="group_input">
            <span>Telefone</span>
            <input type="tel" name="text_telefone" id="telefone" value="<?= $telefone ?>" required>

        </div>
        <div class="submit_group">
            <input class="submit" type="submit" value="Gravar">
        </div>
    </form>
</div>
