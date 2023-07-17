<div class="group_contact_edit">
    <h2>Editar Contato</h2>
    <form action="editar_telefone_db.php" method="post">
        <input type="hidden" id="id" name="id" value="">
        <!-- <?= $results[0]->id ?> -->
        <div class="group_input">
            <span>Nome</span>
            <input type="text" name="text_nome" id="nome" value="" required>
            <!-- <?= $results[0]->nome ?> -->
        </div>
        <div class="group_input">
            <span>Telefone</span>
            <input type="tel" name="text_telefone" id="telefone" value="" required>
            <!-- <?= $results[0]->telefone ?> -->
        </div>
        <div class="submit_group">
            <input class="submit" type="submit" value="Gravar">
        </div>
    </form>
</div>