<?php
/**
 * Created by PhpStorm.
 * User: phan
 * Date: 4/18/17
 * Time: 4:08 PM
 */
include_once './mydb.php';

if(empty($_POST['user'])||empty($_POST['pass'])){
    echo '填写完整用户名和密码！';
    exit;
}

$username=htmlspecialchars(trim($_POST['user']));
$password=md5(base64_encode(htmlspecialchars(trim($_POST['pass']))));

$mydb=new mydb();
$sql="SELECT * FROM `gef_users` WHERE username='$username' and password='$password' LIMIT 1";
$result=$mydb->query($sql);

if($row=mysqli_fetch_array($result)){
    session_start();
    $_SESSION['id']=$row['id'];
    $_SESSION['username']=$row['username'];
//    echo "登录成功";
    header("Location: /dashboard.php");
//    exit;
} else {
    exit('登录失败');
}

$mydb->free();
//mysqli_close($db);