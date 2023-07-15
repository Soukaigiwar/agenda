<div class="group_user_add">
    <h2>Adicionar Usuário</h2>
    <form action="adicionar_usuario.php" method="post">
        <div class="group_input">
            <span>Nome:</span>
            <input type="text" name="text_nome" id="nome" required>
        </div>
        <div class="group_input">
            <span>Apelido:</span>
            <input type="text" name="text_apelido" id="apelido" required>
        </div>
        <div class="group_input">
            <span>Email:</span>
            <input type="email" name="text_email" id="email" required>
        </div>
        <div class="group_input">
            <span>Password:</span>
            <input type="password" name="text_password" id="password" required>
        </div>
        <div class="submit_group">
            <input type="submit" value="Criar conta">
        </div>
    </form>
</div>