<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');
require PATH.'app/db/db.php';

$name = $GLOBALS['db']->prepare('SELECT * FROM `in_shape` WHERE idx = ?');
$name -> execute([$_GET['idx']]);
$namee = $name->fetch();

$download = $GLOBALS['db']->prepare('SELECT * FROM `inset` WHERE shape_idx = ?');
$download -> execute([$_GET['idx']]);
$downloader = $download->fetch();
$down = $downloader['download'];

$downloadd = $GLOBALS['db']->prepare('SELECT * FROM `outset` WHERE shape_idx = ?');
$downloadd -> execute([$_GET['idx']]);
$downloadder = $downloadd->fetch();
$downn = $downloadder['download'];

$GLOBALS['db']->prepare('UPDATE `inset` SET `download`=? WHERE shape_idx = ? ')->execute([($down + 1),$_GET['idx']]);
$GLOBALS['db']->prepare('UPDATE `outset` SET `download`=? WHERE shape_idx = ? ')->execute([($downn + 1),$_GET['idx']]);
header('Content-Disposition:attachment; filename="'.$namee['file_src']);
echo file_get_contents(' static/file/'.$namee['file_src']);