<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');

require PATH.'app/db/db.php';
if (isset($_GET['q'])) {
    $name = $GLOBALS['db']->prepare('SELECT * FROM `in_shape` WHERE out_src = ?');
    $name -> execute([$_GET['q']]);
    $namee = $name->fetch();

    $download = $GLOBALS['db']->prepare('SELECT * FROM `outset` WHERE shape_idx = ?');
    $download -> execute([$namee['idx']]);
    $downloader = $download->fetch();
    $down = $downloader['download'];

    $GLOBALS['db']->prepare('UPDATE `outset` SET `download`=? WHERE 1')->execute([$down + 1]);
    header('Content-Disposition:attachment; filename="'.$namee['file_src']);
    echo file_get_contents(' static/file/'.$namee['file_src']);
    exit;
}
require PATH.'app/view/header.php';
require PATH.'app/view/index.php';
require PATH.'app/view/footer.php';