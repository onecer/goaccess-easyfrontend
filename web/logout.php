<?php
/**
 * Created by PhpStorm.
 * User: phan
 * Date: 4/21/17
 * Time: 2:24 PM
 */
session_start();
unset($_SESSION['id']);
header('Location: /index.php');