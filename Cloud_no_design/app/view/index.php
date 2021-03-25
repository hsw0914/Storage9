<?php

$stmt = $db->prepare('SELECT * FROM `user` WHERE 1');
$stmt->execute();
$data = $stmt->fetchAll();

$isset_idx = "";
$isset_lv = "";
if (isset($_SESSION['idx'])) {
    $isset_idx = $_SESSION['idx'];
    $isset_lv = $_SESSION['lv'];
}
//session_destroy()
?>

<?php if (!$isset_idx) { ?>
    <div class="login">
        <form action="/app/controll/login.php" method="post">
            <input type="text" name="id">
            <input type="password" name="pw">
            <input type="submit" value="로그인">
        </form>
    </div>
<?php } else { ?>
    <h1>파일관리</h1>
    <form action="/app/controll/add_dir.php" method="post">
        <input type="text" name="dir">
        <input type="hidden" name="idx" value="<?=$_GET['idx']?>">
        <input type="submit" value="생성">
    </form>
    <table border="1" width="100%">
    <?php
        $parent = 0;
        if (isset($_GET['idx'])) {
            $parent = $_GET['idx'];
        }

        $dir = $GLOBALS['db']->prepare('SELECT * FROM `in_shape`WHERE user_idx = ? && parent = ?');
        $dir->execute([$_SESSION['idx'],$parent]);
        $dir_list = $dir->fetchAll();

        $par = $GLOBALS['db']->prepare('SELECT * FROM `in_shape` WHERE user_idx = ? && idx =?');
        $par->execute([$_SESSION['idx'],$parent]);
        $id = $par->fetch();

        if ( $parent > 1) {
    ?>
    <tr>
        <td colspan="9"><a href="?idx=<?=$id['parent']?>">...</a></td>
    </tr>
    <?php } ?>
    <tr>
        <td>파일 / 디렉토리명</td>
        <td>크기</td>
        <td>종류</td>
        <td>생성일</td>
        <td>수정일</td>
        <td>내부공유</td>
        <td>외부공유</td>
        <td>이름변경</td>
        <td>삭제</td>
    </tr>
    <?php foreach ($dir_list as $list) { ?>
        <tr>
        <?php if ($list['is_dir'] === "Y") {?>
            <td><a href="?idx=<?=$list['idx']?>"><?=$list['file_name']?></a></td>
        <?php } else { ?>
            <td><a href="/download.php?idx=<?=$list['idx']?>"><?=$list['file_name']?></a></td>
        <?php } ?>
        <td><?=dir_size($list)?> MB</td>
        <td><?=$list['file_kinds']?></td>
        <td><?=$list['c_date']?></td>
        <td><?=$list['u_date']?></td>
        <?php if ($list['is_dir'] === "Y") {?>
            <td></td>
            <td></td>
        <?php } else { ?>
        <td><a href="/app/controll/inset.php?idx=<?=$list['idx']?>" class="inset">내부공유</a></td>
            <td><a href="/app/controll/outset.php?idx=<?=$list['idx']?>">외부공유</a></td>
        <?php }  ?>
        <td><a href="/app/view/dir_update.php?idx=<?=$list['idx']?>">이름 변경</a></td>
        <td><a href="/app/controll/del_dir.php?idx=<?=$list['idx']?>&name=in_shape">삭제</a></td>
        </tr>
    <?php } ?>
    </table>

    <form action="/app/controll/add_file.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="hidden" name="idx" value="<?=$_GET['idx']?>">
        <input type="submit" value="생성">
    </form>
<?php } ?>
    <h1>내부 공유</h1>
<form action="/app/controll/del_dir_in.php" method="post">
    <table border="1" width="100%">
    <?php
        $inset = $GLOBALS['db']->prepare('
SELECT `in_shape`.*, `inset`.* FROM `inset`
INNER JOIN `in_shape` ON `inset`.`shape_idx` = `in_shape`.`idx`
WHERE 1');
        $inset->execute([]);
        $inset_list = $inset->fetchAll();

        $inmyshape = $GLOBALS['db']->prepare('SELECT * FROM `inset` WHERE shape_idx = ?');
        $inmyshape->execute([$_SESSION['idx']]);
        $inmyshapes = $inmyshape->fetchAll();
    ?>
    <p>전체공유 <?=count($inset_list)?>개</p>
    <p>나의공유 <?=count($inmyshapes)?>개</p>
    <tr>
        <td><input type="checkbox" id="check"><label for="check">전체선택</label></td>
        <td>파일명</td>
        <td>파일용량</td>
        <td>공유자</td>
        <td>공유일</td>
        <td>다운로드 횟수</td>
        <td>다운로드 주소</td>
        <td>공유삭제</td>
    </tr>

    <?php foreach ($inset_list as $list ) :?>
    <?php
        $user = $GLOBALS['db']->prepare('SELECT * FROM `user` WHERE idx = ?');
        $user -> execute([$list['user_idx']]);
        $user_ok = $user->fetch();
    ?>
    <tr>
        <td>
            <?php if ($_SESSION['idx'] === $list['user_idx'] || $_SESSION['lv'] == 99) { ?>
                <input type="checkbox" name="name[]" value="<?=$list['idx']?>">
            <?php }?>
        </td>
        <td><a href="/download.php?idx=<?=$list['shape_idx']?>"><?=$list['file_name']?></a></td>
        <td><?=$list['file_size']?></td>
        <td><?=$user_ok['name']?></td>
        <td><?=$list['date']?></td>
        <td><?=$list['download']?></td>
        <td><?=$list['file_src']?></td>
        <td>
            <?php if ($_SESSION['idx'] === $list['user_idx'] || $_SESSION['lv'] == 99) { ?>
                <a href="/app/controll/del_dir.php?idx=<?=$list['idx']?>&name=inset">공유삭제</a>
            <?php } ?>
        </td>
    </tr>
    <?php endforeach;?>
    </table>
    <input type="submit" value="일괄삭제">
</form>
<h1>외부 공유</h1>
<form action="/app/controll/del_dir_out.php" method="post">
    <table border="1" width="100%">
        <?php
        $ourset = $GLOBALS['db']->prepare('
SELECT `in_shape`.*, `outset`.* FROM `outset`
INNER JOIN `in_shape` ON `outset`.`shape_idx` = `in_shape`.`idx`
WHERE 1');
        $ourset->execute([]);
        $ourset_list = $ourset->fetchAll();

        $myshape = $GLOBALS['db']->prepare('SELECT * FROM `outset` WHERE shape_idx = ?');
        $myshape->execute([$isset_idx]);
        $myshapes = $myshape->fetchAll();
        ?>
        <p>전체공유 <?=count($ourset_list)?>개</p>
        <p>나의공유 <?=count($myshapes)?>개</p>
        <tr>
            <td><input type="checkbox" id="check_"><label for="check_">전체선택</label></td>
            <td>파일명</td>
            <td>파일용량</td>
            <td>공유자</td>
            <td>공유일</td>
            <td>다운로드 횟수</td>
            <td>다운로드 주소</td>
            <td>공유삭제</td>
        </tr>
        <?php foreach ($ourset_list as $list ) :?>
            <?php
            $user = $GLOBALS['db']->prepare('SELECT * FROM `user` WHERE idx = ?');
            $user -> execute([$list['shape_idx']]);
            $user_ok = $user->fetch();
            ?>
            <tr>
                <td>
                    <?php if ($isset_idx === $list['user_idx'] || $isset_lv == 99) { ?>
                        <input type="checkbox" name="namee[]"  value="<?=$list['idx']?>">
                    <?php }?>
                </td>
                <td><a href="/download.php?idx=<?=$list['shape_idx']?>"><?=$list['file_name']?></a></td>
                <td><?=$list['file_size']?></td>
                <td><?=$user_ok['name']?></td>
                <td><?=$list['date']?></td>
                <td><?=$list['download']?></td>
                <td>localhost/?q=<?=$list['out_src']?></td>
                <?php if ($isset_idx === $list['user_idx'] || $isset_lv == 99) { ?>
                    <td><a href="/app/controll/del_dir.php?idx=<?=$list['idx']?>&name=outset">공유삭제</a></td>
                <?php }else { ?>
                    <td></td>
                <?php }?>
            </tr>
        <?php endforeach;?>
    </table>
    <input type="submit" value="일괄 삭제">
</form>
