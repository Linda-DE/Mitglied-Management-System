<?php
session_start();
session_destroy();
header("Location:index.php"); //跳转到首页
?>