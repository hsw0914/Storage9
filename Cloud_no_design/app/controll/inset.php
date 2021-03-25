<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');
require PATH.'app/db/db.php';

$parent = "";
if (isset($_POST['idx'])) {
    $parent = $_POST['idx'];
}

$stmt = $db->prepare('SELECT * FROM `in_shape` WHERE idx = ?');
$stmt->execute([$_GET['idx']]);
$list = $stmt->fetch();

$GLOBALS['db']->prepare('INSERT INTO `inset`(`shape_idx`) VALUES (?)')->execute([
    $list['idx']
]);

echo "<script>alert('공유완료!'); history.back()</script>";
?>
