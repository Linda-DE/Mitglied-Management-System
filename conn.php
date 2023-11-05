<?php
//连接数据库服务器
//用PHP内置函数完成数据库连接: php可以连接几乎所有常用数据库,包括MySQL
//第一步,连接数据库服务器: mysqli_connect()函数
$conn = mysqli_connect("localhost","root","root","member");
if(!$conn){
    die("Datenbank nicht verbunden!"); //die函数表示:输出参数里面指定的内容,然后终止程序的运行
}

?>