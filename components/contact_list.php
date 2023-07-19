<?php 

use sql_connection\Contact;

require_once('class/Contact.php');

$search = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = $_POST['text_search'];
    setcookie('search', $search, time() + 2);
} else {
    $search = '';
}

$query = new Contact();


$result = $query->get_contacts($search);

if (!$result) {
    $total_contacts = 0;
} else {
    $contacts = $result->results;
    $total_contacts = $result->affected_rows;
}
?>

<?php if ($total_contacts == 0) : ?>
    <div class='empty_data'>
    <h2>não há telefones registados</h2>
    </div>
<?php else : ?>
    <div class='list'>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
            <?php foreach ($contacts as $contact) : ?>
                <tr class='list_item'>
                    <td><?=$contact->nome?></td>
                    <td>
                        <div class='phone_item'>
                            <?php if (str_contains($contact->telefone, '+55')) : ?>
                                <img width="24" height="24" src="./assets/img/brazil-48.png" alt="brazil-flag"/>
                                <?=$contact->telefone?>
                            <?php elseif (str_contains($contact->telefone, '+351')) : ?>
                                <img width="24" height="24" src="./assets/img/portugal-48.png" alt="portugal-flag"/>
                                <?=$contact->telefone?>
                                <?php else :?>
                                    <img width="24" height="24" src="./assets/img/unknown-flag.png" alt="unknown-flag"/>
                                    <?=$contact->telefone?>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <div class='actions'>
                            <form action='remover_telefone.php' method='post'>
                                <button class='remove' type='submit' name='id' value='<?=$contact->id?>'>
                                    <span><i class='fa-solid fa-circle-minus'></i></span>
                                </button>
                            </form>
                            <form action='editar_telefone.php' method='post'>
                                <input type='hidden' id='id' name='id' value='<?=$contact->id?>'>
                                <input type='hidden' id='text_nome' name='text_nome' value='<?=$contact->nome?>'>
                                <input type='hidden' id='text_telefone' name='text_telefone' value='<?=$contact->telefone?>'>
                                <button class='edit' type='submit'>
                                    <span><i class='fa-solid fa-pen'></i></span>
                                </button>
                            </form>
                        </div>
                    </td>
                <tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <div>
<?php endif; ?>
