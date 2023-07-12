<?php 

use sql_connection\Contact;

require_once('./class/Contact.php');

$search = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = $_POST['text_search'];
    setcookie('search', $search, time() + 2);
} else {
    $search = '';
}

// adicionar cookie com search param para manter busca ao mudar tema day/night

$query = new Contact();

$result = $query->get_contacts($search);
$contacts = $result->results;
$total_contacts = $result->affected_rows;
?>

<?php if ($total_contacts == 0) : ?>
    <div class='tabela_vazia'>
            não há registos na tabela
    </div>
<?php else : ?>
    <div class='tabela'>
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
                <tr>
                    <td><?=$contact->nome?></td>
                    <td>
                        <div>
                            <?php if (str_contains($contact->telefone, +55)) : ?>
                                <img width="24" height="24" src="./assets/img/brazil-48.png" alt="brazil-flag"/>
                                <?=$contact->telefone?>
                            <?php elseif (str_contains($contact->telefone, +351)) : ?>
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
                                <button class='editar' type='submit' name='id' value='<?=$contact->id?>'>
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
