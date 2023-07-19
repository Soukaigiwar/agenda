<div class="menu">
    <?php if (isset($_SESSION['user'])) : ?>
        <a href="logout.php"><i class="fa-solid fa-user"></i>Olá <?= $_SESSION['user'] ?>, clique aqui para sair</a>
    <?php else :?>
        <a href="signup.php"><i class="fa-solid fa-user-plus"></i>Criar conta</a>
        <a href="login.php"> | Login</a>
    <?php endif; ?>
</div>
