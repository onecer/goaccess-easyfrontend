<?php
/**
 * Created by PhpStorm.
 * User: phan
 * Date: 4/21/17
 * Time: 2:05 PM
 */
include_once './mydb.php';

if(file_exists('reg.lock')){
    echo "已经关闭注册，如需注册，请删网站目录下的./reg.lock文件。";
    exit();
}

if(!$_POST['user']||!$_POST['pass']){
    echo "请正确填写账号";
    exit();
}

$username=htmlspecialchars(trim($_POST['user']));
$password=md5(base64_encode(htmlspecialchars(trim($_POST['pass']))));

$mydb=new mydb();
$sql="INSERT INTO `gef_users`(username,password) VALUES ('$username','$password')";
$result=$mydb->query($sql);

if($row=mysqli_fetch_array($result)){
    echo "注册成功";
    $lock_file=fopen('reg.lock',w);
    if(!$lock_file){
        fwrite($lock_file,'需要注册的时候，删除此文件就能注册了。');
    }else{
        echo "创建reg.lock文件失败，可能是没权限，请手动创建";
    }
    fclose($lock_file);
}else{
    echo "注册失败";
}