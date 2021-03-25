<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');
require PATH.'app/db/db.php';

    if ($_POST['pw'] == null) {
        $GLOBALS['db']->prepare('UPDATE `user` SET `id`=?,`name`=?,`lv`=? WHERE idx = ?')->execute([$_POST['id'],$_POST['name'],$_POST['lv'],$_POST['idx']]);

        echo "<script>alert('수정완료!'); location.replace('/')</script>";
    }else {
        $GLOBALS['db']->prepare('UPDATE `user` SET `id`=?,`pw`=?,`name`=?,`lv`=? WHERE idx = ?')->execute([$_POST['id'],hash('sha256', $_POST['id'].$_POST['pw']),$_POST['name'],$_POST['lv'],$_POST['idx']]);

        echo "<script>alert('수정완료!'); location.replace('/')</script>";
    }
?>