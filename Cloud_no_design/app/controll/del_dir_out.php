<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');
require PATH.'app/db/db.php';

if (empty($_POST['namee'])) {
    echo "<script>alert('하나이상선택하세요');history.back()</script>";
    return 0;
}

foreach ($_POST['namee'] as $value) {
    $GLOBALS['db']->prepare('DELETE FROM outset WHERE idx = ?')->execute([$value]);
    $GLOBALS['db']->prepare('DELETE FROM outset WHERE parent = ?')->execute([$value]);
}

echo "<script>alert('삭제 완료!'); location.replace('/')</script>";