<?php
session_start();
$source = $_GET['source'] ?? '';
$page =$_GET['page'] ?? '';
if(!$source or (($source <> 'admin') and ($source <> 'member'))){
    echo "<script>alert('页面来源错误');location.href='index.php';</script>";
    exit;
}
if($page){
    if(!is_numeric($page)){
        echo "<script>alert('参数错误');location.href='index.php';</script>";
        exit;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Mitglied Management System</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="main">
    <?php 
    include_once 'nav.php';    //引入导航栏
    include_once 'conn.php';   //引入连接数据库文件
    $vorname = $_GET['vorname'];  
    $nachname = $_GET['nachname'];
    if ($vorname && $nachname) {     //如果为true,说明是管理员,在修改普通用户的资料
        //则需要验证管理员权限
        include_once 'checkAdmin.php';
        $sql ="select * from info where vorname = '$vorname' and nachname = '$nachname'";
    }else {  //说明是会员登陆以后,修改自己的信息
        //建立数据库连接
        $sql ="select * from info where vorname='" .$_SESSION['loggedVorname']. "'and nachname='" .$_SESSION['loggedNachname']. "'";
    }
    $result = mysqli_query($conn, $sql); //将查询结果保存为变量result
    if(mysqli_num_rows($result)){
        $info = mysqli_fetch_array($result);   //从记录集中抓取一条，存入到数组info中，以便在下面的表单中引用
    }else{
        die("Kunden Daten nicht gefunden.Bitte anmelden.");
    }
    ?>
</div>

<form action="postModify.php" method="post" onsubmit="return check()">
    <table id="table">
        <tr>
            <td>Vorname</td>
            <td><input name="vorname" readonly value="<?php echo $info['vorname'];?>"></td> <!--用户姓名不允许被修改,readonly-->
        </tr>
        <tr>
            <td>Nachname</td>
            <td><input name="nachname" readonly value="<?php echo $info['nachname'];?>"></td>  <!--用户姓名不允许被修改,readonly-->
        </tr>
        <tr>
            <td>Stadt</td>
            <td><input name="stadt" placeholder="stadt ändern"></td>
        </tr>
        <tr>
            <td>E-Mail</td>
            <td><input name="email" readonly value="<?php echo $info['email'];?>"></td> 
        </tr>
        <tr>
            <td>Password</td>
            <td><input name="pw" type="password" placeholder="password ändern"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input name="cpw" type="password" placeholder="password ändern"></td>
        </tr>
        <tr>
            <td><input type="submit" value="Submit"></td>
            <td>
                <input type="reset" value ="Reset">
                <input type="hidden" name="source" value="<?php echo $source;?>">
                <input type="hidden" name="page" value="<?php echo $page;?>">
            </td>
        </tr>
    </table>
</form>

<script>
    function check(){
        let pw = document.getElementsByName('pw')[0].value.trim(); //获取DOM数组对象vorname中的第一个key的值.然后用trim函数去掉用户填写的前后空格
        let cpw = document.getElementsByName('cpw')[0].value.trim(); //获取DOM数组对象vorname中的第一个key的值.然后用trim函数去掉用户填写的前后空格
        let pwReg = /^[a-zA-Z0-9_*!]{6,10}$/;
        if(pw.length>0){
            if (!pwReg.test(pw)) {
            alert('Der Password ist erforderlich und kann nur aus Groß- und Kleinbuchstaben,Zahlen, _ ,! ,oder * bestehen, die Länge beträgt 6')
            return false;
            }else if(pw!=cpw){
                alert('Password muss gleich.')
                return false;
            }
        }
        return true;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>