<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');
require PATH.'app/db/db.php';

if ($_POST['name'] == null) {
    echo "<script>alert('빈값!'); history.back()</script>";
}else {
    $GLOBALS['db']->prepare('UPDATE `in_shape` SET `file_name`=? WHERE idx = ?')->execute([$_POST['name'],$_POST['idx']]);

    echo "<script>alert('수정완료!'); location.replace('/')</script>";
}
?>