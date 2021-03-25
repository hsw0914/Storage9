<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');
require PATH.'app/db/db.php';

$user = $GLOBALS['db']->prepare('SELECT * FROM `user` WHERE id = ?');
$user -> execute([$_POST['id']]);
$user_ok = $user->fetch();

if (!$user_ok) {
    $GLOBALS['db']->prepare('INSERT INTO `user`(`id`, `pw`, `name`, `lv`) VALUES (?,?,?,?)')->execute([$_POST['id'], hash("sha256", $_POST['id'] . $_POST['pw']), $_POST['name'], $_POST['lv']]);
}else {
    echo "<script>alert('아이디 중복!'); history.back()</script>";
}

echo "<script>alert('추가완료!'); location.replace('/')</script>";