<?php
session_start(); //开启session会话
if($_SESSION['admin']!=1){   //判断是不是管理员 admin==1
    echo "<script>alert('Bitte melden Sie sich als Administrator an.');location.href='anmelden.php';</script>";
}
?>
