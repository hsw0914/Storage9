<?php
session_start();

$GLOBALS['db'] = new PDO('mysql:host=localhost; dbname=20180403; charset=utf8','root','');

$randomid = substr(sha1(uniqid()), 0, 4);

function dir_size ($list) {
    $size = 0;
    if ($list['is_dir'] == "N") {
        return $list['file_size'];
    }else {
       $ch = $GLOBALS['db']->prepare('SELECT * FROM `in_shape` WHERE user_idx = ? AND parent = ?');
       $ch->execute([$list['user_idx'],$list['idx']]);
       foreach ($ch as $re ) {
           $size += dir_size($re);
       }
    }
    return $size;
};
