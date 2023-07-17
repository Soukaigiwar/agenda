<?php

//session_start();

// OK - Gerir lista de contatos com nomes e telefones;
// OK - Permitir add, edit, delete os contatos;
// OK - Impedir telefones duplicados;
// OK - Permitir pesquisa por nome e/ ou telefone;
// OK - Funcionalidade para exportação de dados para csv;

// OK - Day and Night Mode

// OK - Adicionar controle de usuarios
// OK - Usar sessões para controlar usuarios

?>

<?php include_once('components/head.php'); ?>

    <body>
        <main>
            <?php include_once('components/header.php'); ?>
            <?php include_once('components/error_msg.php'); ?>

            <?php if (!$erro): ?>

                <?php if(!isset($_SESSION['user'])) : ?>
                    <?php
                    include_once('components/user_login_form.php');
                    ?>
                <?php else : ?>
                    <?php
                    include_once('components/contact_add_form.php');
                    include_once('components/contact_list.php');
                    ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php include_once('components/side_tag.php'); ?>
        </main>
        <footer>
            <?php if(isset($_SESSION['user'])) : ?>
                <?php include_once('components/status_bar.php'); ?>
            <?php endif; ?>
            <?php include_once('components/footer.php'); ?>
        </footer>

    <body>
</html>
