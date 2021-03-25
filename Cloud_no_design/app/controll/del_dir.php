<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');
require PATH.'app/db/db.php';

$GLOBALS['db']->prepare('DELETE FROM '. $_GET['name'] .' WHERE idx = ?')->execute([$_GET['idx']]);
$GLOBALS['db']->prepare('DELETE FROM '. $_GET['name'] .' WHERE parent = ?')->execute([$_GET['idx']]);

echo "<script>alert('삭제 완료!'); location.replace('/')</script>";
