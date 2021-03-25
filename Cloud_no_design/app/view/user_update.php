<?php
define('PATH',$_SERVER['DOCUMENT_ROOT'].'/');

require PATH.'app/db/db.php';
require PATH.'app/view/header.php';

$stmt = $db->prepare('SELECT * FROM `user` WHERE idx = ?');
$stmt->execute([$_GET['idx']]);
$data = $stmt->fetchAll();

?>

<div class="table">
    <form action="/app/controll/update_user.php" method="post">
        <table border="1" width="100%" style="text-align: center;">
            <colgroup>
                <col style="width: 25%">
                <col style="width: 10%">
                <col style="width: 10%">
                <col style="width: 40%">
                <col style="width: 10%">
            </colgroup>
            <tr>
                <td>아이디</td>
                <td>이름</td>
                <td>회원구분</td>
                <td>암호</td>
                <td>기능</td>
            </tr>
            <tr>
                <?php foreach ($data as $list) :?>
                    <td><input type="text" name="id" style="width: 100%;" value="<?=$list['id']?>"></td>
                    <td><input type="text" name="name" style="width: 100%;" value="<?=$list['name']?>"></td>
                    <td>
                        <select name="lv"  style="width: 100%;">
                            <option value="1" <?=($list['lv']==1)?"selected":"" ?>>회원</option>
                            <option value="99" <?=($list['lv']==99)?"selected":"" ?>>관리자</option>
                        </select>
                    </td>
                    <td><input type="password" name="pw" style="width: 100%;"></td>
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