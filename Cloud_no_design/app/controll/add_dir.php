<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');
require PATH.'app/db/db.php';

$parent = "";
if (isset($_POST['idx'])) {
    $parent = $_POST['idx'];
}

$GLOBALS['db']->prepare('INSERT INTO `in_shape`(`user_idx`, `file_name`, `parent`, `is_dir`) VALUES (?,?,?,?)')->execute([
    $_SESSION['idx'], $_POST['dir'],$parent,"Y"
]);

echo "<script>alert('생성완료!'); history.back()</script>";
?>
