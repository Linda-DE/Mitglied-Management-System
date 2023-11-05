<?php
  $vorname = trim($_POST['vorname']); //注意！更改页面的前端代码中，用span代替了input，因此不能用$_POST获取了
  $nachname = trim($_POST['nachname']); //注意！更改页面的前端代码中，用span代替了input，因此不能用$_POST获取了
  $stadt = trim($_POST['stadt']);
  $pw = trim($_POST['pw']);
  $cpw = trim($_POST['cpw']);
  $source = $_POST['source'];
  $page = $_POST['page'];

//进行必要的验证
//判断两次输入的密码是否相同
if(!empty($pw)){
  if($pw <> $cpw){
      echo "<script>alert('Password muss gleich sein!');history.back();</script>";
      exit;
  }else{
    if(!preg_match('/^[a-zA-Z0-9_*]{6,10}$/',$pw)){
        echo "<script>alert('Das Passwort darf nur aus Groß- und Kleinbuchstaben, Zahlen, _, ! oder * bestehen und muss 6 bis 10 Zeichen lang sein.');history.back();</script>";
        exit;
    }
  }
}

include_once("conn.php");   //引入数据库连接代码文件
if($pw){  //如果密码不为空，说明用户已经修改了密码，需要更新
  $sql = "update info set pw ='".md5($pw)."',stadt='$stadt' where vorname='$vorname' and nachname='$nachname'";
  $url = 'logout.php';
}else{  //如果密码为空,就只需要更改城市名
  $sql = "update info set stadt='$stadt' where vorname='$vorname' and nachname='$nachname'";
  $url = 'index.php';
}

if($source == 'admin'){     //如果发现是管理员在修改用户信息,则修改完后转回到管理员页面
  $url = 'admin.php?id=5&page=' . $page;
}

//把用户更改的内容，更新到数据库中
$result= mysqli_query($conn,$sql); //执行查询语句,使用mysqli_query()查询函数.查询后会返回记录集合.有两个参数:第一个参数:使用哪一个连接,第二个参数:要执行哪一个查询语句.如果查询正常执行,返回真,否则返回假.
if($result){
  echo "<script>alert('Daten erfolgreich geändert!');location.href='$url';</script>";
}
else{
  echo "<script>alert('Daten nicht geändert!');history.back();</script>";
}
?>