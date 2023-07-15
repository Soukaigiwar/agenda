<?php

$contatcs = null;
$total_contacts = 0;
$search = null;

?>

<?php include_once('components/head.php'); ?>

<body>
    <div class="page">
        <?php include_once('components/header.php'); ?>
        <?php include_once('components/error_msg.php'); ?>
        <?php if (!$erro): ?>
            <!-- <?php include_once('components/user_add_form.php'); ?> -->
            <?php include_once('components/contact_add_form.php'); ?>
        <?php endif; ?>
        <?php include_once('components/side_tag.php'); ?>

        <!-- <?php include_once('components/footer.php'); ?> -->
    </div>
</body>