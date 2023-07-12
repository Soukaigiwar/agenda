<div class="formulario_editar">
    <form action="editar_telefone_db.php" method="post">
        <input type="hidden" id="id" name="id" value="<?= $results[0]->id ?>">
        <input type="text" name="text_nome" id="nome" placeholder="Nome completo" value="<?= $results[0]->nome ?>"
            required>
        <input type="tel" name="text_telefone" id="telefone" placeholder="+351 " value="<?= $results[0]->telefone ?>"
            required>
        <input class="submit" type="submit" value="Gravar">
    </form>
</div>