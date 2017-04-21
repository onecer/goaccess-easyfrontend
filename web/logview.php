<?php
/**
 * Created by PhpStorm.
 * User: phan
 * Date: 4/20/17
 * Time: 4:46 PM
 */
session_start();
if(!$_SESSION['id']){
    header('Location: /index.php');
    exit;
}

include_once './mydb.php';

if(!$_GET['id']){
   exit('请提交正确的参数');
}

// 按ID查询日志
$id=intval($_GET['id']);
if($id){
    $mydb=new mydb();
    $sql="SELECT * FROM `gef_infos` WHERE id='$id' LIMIT 1";
    $result=$mydb->query($sql);
    if($row=mysqli_fetch_array($result)){
        $file_path = $row['path'];
        if(file_exists($file_path)){
            $str = file_get_contents($file_path);
            echo $str;
        } else {
            exit('不存在此日志文件');
        }
    } else {
        exit('查询失败！');
    }
    $mydb->free();
}
