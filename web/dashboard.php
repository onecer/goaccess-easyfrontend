<?php
    session_start();
    if(!$_SESSION['id']){
        header('Location: /index.php');
        exit;
    }
    include_once './mydb.php';
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Logview Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            padding-top: 50px;
            padding-bottom: 20px;
        }
    </style>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Dashboard</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <div class="navbar-form navbar-right">
                <?php echo "<a class=\"btn btn-primary\" href=\"/logout.php\" role=\"button\">退出登录</a>";?>
            </div>
        </div>
    </div>
</nav>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <p>欢迎登录，
        <?php
            echo $_SESSION['username'];
        ?>
        </p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">今日实时日志</a></p>
    </div>
</div>
<div class="container">
    <h1>最近7天访问日志</h1>
    <table class="table table-hover table-striped table-bordered text-center">
        <tr>
            <th>#id</th>
            <th>#时间</th>
            <th>#源日志大小</th>
            <th>#查看</th>
        </tr>
        <!--列出日志-->
        <?php
            $mydb=new mydb();
            $sql="SELECT * FROM `gef_infos` ORDER BY id DESC LIMIT 7";
            $result=$mydb->query($sql);
            if(!$result){
                $mydb->free();
                exit('查询失败！');
            }
            $count=1;
            while($row=mysqli_fetch_array($result)){
                echo "<tr>";
                echo "<td>$count .</td>";
                echo "<td>{$row['logdate']}</td>";
                echo "<td>{$row['logsize']} MB</td>";
                echo "<td><a class=\"btn btn-primary btn-lg\" href=\"/logview.php?id={$row['id']}\" role=\"button\" target='_blank'>查看日志</a></td>";
                echo "</tr>";
                $count=$count+1;
            }
            $mydb->free();
        ?>
    </table>
</div>
<div class="container">
    <hr>

    <footer>
        <p>&copy; Company 2017</p>
    </footer>
</div> <!-- /container -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

<script src="js/vendor/bootstrap.min.js"></script>

<script src="js/main.js"></script>
</body>
</html>