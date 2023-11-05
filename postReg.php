<?php
header("Content-Type: text/html;charset=utf-8");  //设置本页面的php全局为utf-8类型
//在后段获取前端表单数据的方法是使用全局数组$_GET或$_POST
$vorname = trim($_POST['vorname']);
$nachname = trim($_POST['nachname']);
$stadt = trim($_POST['stadt']);
$pw = trim($_POST['pw']);
$cpw = trim($_POST['cpw']);
$email = trim($_POST['email']);

//引入数据库连接代码文件
include_once("conn.php");   

//第二步,设置字符集为utf8:mysqli_query()查询函数
mysqli_query($conn,"set names utf8");  //由于所有的字符串类型的数据,都在数据库中有一个"排序规则",所以,为了正确的显示字符串,需要正确的设置字符集.第一个参数:使用的连接名,第二个参数,设置字符集的类型

//第三步,进行必要的验证
//3.2 判断用户输入是否为空
if (!strlen($vorname) && !strlen($nachname)){
    echo "<script>alert('Name und Password kann nicht leer sein.');history.back();</script>";
    exit; 
}else if(!preg_match('/^[a-zA-ZüÜäÄöÖßß0-9]{2,10}$/',$vorname)){
    echo "<script>alert('Der Vorname ist erforderlich und kann nur aus Groß- und Kleinbuchstaben und Zahlen bestehen, die Länge beträgt 2-10');history.back();</script>";
    exit; 
}else if(!preg_match('/^[a-zA-ZüÜäÄöÖßß0-9]{2,10}$/',$nachname)){
    echo "<script>alert('Der Nachname ist erforderlich und kann nur aus Groß- und Kleinbuchstaben und Zahlen bestehen, die Länge beträgt 2-10');history.back();</script>";
    exit; 
}

//3.3 判断两次输入的密码是否相同
if(!strlen($pw) && $pw <> $cpw){
    echo "<script>alert('Password sind nicht gleich.');history.back();</script>";
    exit;
}else if(!preg_match('/^[a-zA-Z0-9_*!]{6,10}$/',$pw)){
    echo "<script>alert('Der Password ist erforderlich und kann nur aus Groß- und Kleinbuchstaben,Zahlen, _ ,! ,oder * bestehen, die Länge beträgt 6-10');history.back();</script>";
    exit; 
}

//3.4 检查邮箱是否为空 用empty()函数
if (!empty($email)) {
    if(!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{3,30}$/',$email)){
        echo "<script>alert('Der Email Format ist falsch.');history.back();</script>";
        exit; 
    }
}

//3.5 查询用户名是否已被占用
$sql = "select * from info where vorname ='$vorname' && nachname ='$nachname'";
$result= mysqli_query($conn,$sql); //执行查询语句,使用mysqli_query()查询函数.查询后会返回记录集合.有两个参数:第一个参数:使用哪一个连接,第二个参数:要执行哪一个查询语句.如果查询正常执行,返回真,否则返回假.
$num = mysqli_num_rows($result);
if($num){
    echo "<script>alert('Diese Username ist besetzt,bitte benutzen andere Username.');history.back();</script>";
    exit;
}

//用SQL语句,插入内容到Datenbank中
$sql = "insert into info(vorname,nachname,stadt,pw,email,createTime) 
        values('$vorname','$nachname','$stadt','".md5($pw)."','$email',".time().")"; //键的名字必须和数据库里的一样,顺序不要求
$result= mysqli_query($conn,$sql); //执行查询语句,使用mysqli_query()查询函数.查询后会返回记录集合.有两个参数:第一个参数:使用哪一个连接,第二个参数:要执行哪一个查询语句.如果查询正常执行,返回真,否则返回假.
if($result){
    echo "<script>alert('Daten insert erfolgreich!');location.href='registration.php';</script>"; //location.href=''跳转到别的页面
}else{
    // 查询失败，获取失败详细信息
    $error_message = mysqli_error($conn);
    echo "Query failed with error: " . $error_message;
    echo "<button>Zurück</button><script>history.back();</script>";  //history.back()如果插入数据失败,则返回填写页面
}

?>