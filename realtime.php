<?php
session_start();
if(!$_SESSION['id']){
    header('Location: /index.php');
    exit;
}
$file_path = '../loghtml/realtime.html';
if(file_exists($file_path)){
    $str = file_get_contents($file_path);
    echo $str;
} else {
    exit('不存在此日志文件');
}