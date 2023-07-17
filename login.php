<?php

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
            include_once('components/user_login_form.php');
            ?>
        <?php endif; ?>
        <?php include_once('components/side_tag.php'); ?>
    </main>
    <footer>
        <?php
        include_once('components/status_bar.php');
        include_once('components/footer.php');
        ?>
    </footer>
</body>

</html>