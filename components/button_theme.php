<?php
$toogle_theme = $theme == 'night' ? 'day' : 'night';
$toogle_icon = $theme == 'night' ? 'fa-sun' : 'fa-moon';
$where_im = 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>

<a href="theme_<?= $toogle_theme ?>.php?url=<?= $where_im ?>"><i class="fa-solid <?=$toogle_icon?>"></i></a>
