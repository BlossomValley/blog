<?php
require('./lib/init.php');
if (empty($_POST)) {
    require(ROOT . '/view/front/login.html');
} else {
    $user['name'] = trim($_POST['name']);
    if (empty($user['name'])) {
        error('用户名不能为空');
    }
    $user['password'] = trim($_POST['password']);
    if (empty($user['password'])) {
        error('密码不能为空');
    }
    $sql = "select * from users where name = '$user[name]' ";
    $row = mGetRow($sql);
    if (!$row) {
        error('用户名错误');
    } else {
        if (md5($user['password'].$row['salt']) === $row['password']) {
            setcookie('name' , $user['name']);
            setcookie('token' , cCode($user['name']));
            header("Location: artlist.php");
        } else {
            error('密码错误');
        }
    }
}

 ?>