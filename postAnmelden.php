<?php
session_start(); //开启session会话标志

//在后段获取前端表单数据的方法是使用全局数组$_GET或$_POST
$vorname = trim($_POST['vorname']);
$nachname = trim($_POST['nachname']);
$pw = trim($_POST['pw']);   //先从前端页面取值，然后用trim去掉前后的空格，保存在变量pw里
 
//进行必要的验证
//3.2 判断用户输入的用户名和密码是否符合规则
if (!strlen($vorname) || !strlen($nachname)){
    echo "<script>alert('Bitte geben Sie Ihre Name ein.');history.back();</script>";
    exit; 
}else if(!preg_match('/^[a-zA-ZüÜäÄöÖßß0-9]{3,10}$/',$vorname)){
    echo "<script>alert('Der Vorname ist falsch.');history.back();</script>";
    exit; 
}else if(!preg_match('/^[a-zA-ZüÜäÄöÖßß0-9]{3,10}$/',$nachname)){
    echo "<script>alert('Der Nachname ist falsch.');history.back();</script>";
    exit; 
}else if(!preg_match('/^[a-zA-Z0-9_*!]{6}$/',$pw)){
    echo "<script>alert('Das Password ist falsch.');history.back();</script>";
    exit; 
}

//引入数据库连接代码文件
include_once("conn.php");   

//3.5 在数据库中查询用户名和密码
$sql = "select * from info where vorname ='$vorname' && nachname ='$nachname' && pw='". md5($pw). "'";
$result= mysqli_query($conn,$sql); //执行查询语句,使用mysqli_query()查询函数.查询后会返回记录集合.有两个参数:第一个参数:使用哪一个连接,第二个参数:要执行哪一个查询语句.如果查询正常执行,返回真,否则返回假.
$num = mysqli_num_rows($result); //把查询的结果（数据集合），保存在变量num中

//如果在数据库中查询到了这个用户的数据记录，那么if($num)为真，否则为假
if($num){
    $_SESSION['loggedVorname'] = $vorname ;  //存一个session键值对 loggedVorname
    $_SESSION['loggedNachname'] = $nachname; //存另一个session键值对 loggedNachname
//判断登陆的人是不是管理员
    $info = mysqli_fetch_array($result);  //从记录集中取一条,存入数组info中
    if($info['admin'] == 1){     //如果admin==1,那么这个人就是管理员
        $_SESSION['admin'] = 1;
        echo "<script>alert('Welcome Administator! ^_^');location.href='admin.php';</script>";   
    }else{
        $_SESSION['admin'] = 0;
        echo "<script>alert('Anmelden erfolgreich ^_^');location.href='index.php';</script>";
    }
}else {
    unset($_SESSION['admin']); //销毁session的键值对 admin
    unset($_SESSION['loggedVorname']); //销毁session的键值对
    unset($_SESSION['loggedNachname']); //销毁session的键值对
    echo "<script>alert('Anmelden nicht erfolgreich!');history.back()</script>";
}


?>