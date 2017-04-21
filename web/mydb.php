<?php

/**
 * Created by PhpStorm.
 * User: phan
 * Date: 4/20/17
 * Time: 5:03 PM
 */
define('MYHOST','127.0.0.1');
define('MYPORT','3306');
define('MYNAME','shixin_logview');
define('MYPASS','CWbvSh');
define('MYDB','shixin_logview');

class mydb
{
    private $db;
    private $sql;
    function __construct(){
        $this->db=mysqli_connect(
            constant('MYHOST'),
            constant('MYNAME'),
            constant('MYPASS'),
            constant('MYDB'),
            constant('MYPORT')
        );
        if(!$this->db){
            die("连接错误 ".mysqli_connect_error());
        }
    }

    public function query($sql){
        $this->sql=$sql;
        return mysqli_query($this->db,$this->sql);
    }

    public function free(){
        mysqli_close($this->db);
    }
}
