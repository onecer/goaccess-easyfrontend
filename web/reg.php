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

if(!empty($_POST['user'])&&!empty($_POST['pass'])){
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
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Goaccess-Logview</title>
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .container{
            display:table;
            height:100%;
        }

        .row{
            display: table-cell;
            vertical-align: middle;
        }
        .row-centered {
            text-align:center;
        }
        .col-centered {
            display:inline-block;
            float:none;
            text-align:left;
            margin-right:-4px;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row row-centered">
        <div class="well col-md-6 col-centered">
            <h2>注册</h2>
            <form action="/reg.php" method="post" role="form">
                <div class="input-group input-group-md">
                    <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-user" aria-hidden="true"></i></span>
                    <input type="text" class="form-control" id="userid" name="user" placeholder="请输入用户名"/>
                </div>
                <div class="input-group input-group-md">
                    <span class="input-group-addon" id="sizing-addon1"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="pass" placeholder="请输入密码"/>
                </div>
                <br/>
                <button type="submit" class="btn btn-primary btn-block">注册</button>
            </form>
        </div>
    </div>
</div>


<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script src="//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>