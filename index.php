<?php

// OK - Gerir lista de contatos com nomes e telefones;
// OK - Permitir add, edit, delete os contatos;
// OK - Impedir telefones duplicados;
// OK - Permitir pesquisa por nome e/ ou telefone;
// OK - Funcionalidade para exportação de dados para csv;

// OK - Day and Night Mode

// Adicionar controle de usuarios
// Usar sessões para controlar usuarios

$contatcs = null;
$total_contacts = 0;
$search = null;

?>

<?php include_once('components/head.php'); ?>

    <body>
        <main>
            <?php include_once('components/header.php'); ?>
            <?php include_once('components/error_msg.php'); ?>

            <?php if (!$erro): ?>
                <?php
                include_once('components/contact_add_form.php');
                include_once('components/contact_list.php');
                ?>
            <?php endif; ?>
            <?php include_once('components/side_tag.php'); ?>
        </main>
        <footer>

            <?php include_once('components/status_bar.php'); ?>
            <?php include_once('components/footer.php'); ?>
        </footer>

    <body>
</html>
