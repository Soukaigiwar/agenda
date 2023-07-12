<?php

$total = isset($total_contacts) ? $total_contacts : 0;

$export = $total > 0 ? true : false;
$export_params = $search ? $search: '';
$result_export_file = '';
$download_url = 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['REQUEST_URI'], 0, -10) . "/";
if (!empty($_COOKIE['export_file'])) {
    $result_export_file = $_COOKIE['export_file'];
}
?>

<div class="total">
    Total de registos: <?= $total; ?>
    <?php if ($export): ?>
        <?php if ($result_export_file !== ''): ?>
            <div>
                <a href="<?=$download_url . $result_export_file?>">
                    <?= $result_export_file ?> exportado com sucesso.
                    <i class="fa-solid fa-file-arrow-down"></i>
                </a>
            </div>
        <?php else: ?>
            <div class="export_csv">
                <form action="export_csv.php" method="post">
                    Exportar
                    <input type="hidden" name="text_search" value="<?=$export_params?>" />
                    <button class="submit" type="submit">
                        <i class="fa-solid fa-file-csv"></i>
                    </button>
                </form>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>