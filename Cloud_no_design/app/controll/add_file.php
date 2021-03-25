<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');
require PATH.'app/db/db.php';

$parent = "";
if (isset($_POST['idx'])) {
    $parent = $_POST['idx'];
}

$file = $_FILES['file'];
$filename = "";

if (is_uploaded_file($file['tmp_name'])) {
    $exetension = strtoupper(pathinfo($file['name'],4));
    $url = $_SERVER['DOCUMENT_ROOT'].'/static/file/';
    $filename = uniqid(). ".". $exetension;

    move_uploaded_file($file['tmp_name'], $url.$filename);
}

$GLOBALS['db']->prepare('INSERT INTO `in_shape`(`user_idx`, `file_name`, `file_size`, `file_src`, `out_src`, `file_kinds`, `parent`, `is_dir`) VALUES (?,?,?,?,?,?,?,?)')->execute([
    $_SESSION['idx'], $file['name'],(1024*1024)/$file['size'],$filename,$randomid,pathinfo($file['name'],4),$parent,"N"
]);

echo "<script>alert('업로드 완료!'); history.back()</script>";