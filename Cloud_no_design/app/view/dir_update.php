<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');

require PATH.'app/db/db.php';
require PATH.'app/view/header.php';

$stmt = $db->prepare('SELECT * FROM `in_shape` WHERE idx  = ?');
$stmt->execute([$_GET['idx']]);
$data = $stmt->fetchAll();

?>

<div class="table">
    <form action="/app/controll/update_dir.php" method="post">
        <table border="1" width="100%" style="text-align: center;">
            <tr>
                <td colspan="2">파일 / 디렉토리명</td>
            </tr>
            <tr>
                <?php foreach ($data as $list) :?>
                    <td><input type="text" name="name" style="width: 100%;" value="<?=$list['file_name']?>"></td>
                    <td><input type="submit" value="수정"></td>
                    <input type="hidden" name="idx" value="<?=$list['idx']?>">
                <?php endforeach; ?>
            </tr>
        </table>
    </form>
</div>
<?php
require PATH.'app/view/footer.php';
?>
