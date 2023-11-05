<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="main">
    <?php include_once 'nav.php'; ?>
</div>

<form action="postAnmelden.php" method="post" onsubmit="return check()">
    <table id="table">
        <tr>
            <td>Vorname</td>
            <td><input name="vorname" onblur="checkUsername()" placeholder="vorname"><span class ="mustWrite">*</span></td>
        </tr>
        <tr>
            <td>Nachname</td>
            <td><input name="nachname" placeholder="nachname"><span class ="mustWrite">*</span></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input name="pw" type="password" placeholder="password"><span class ="mustWrite">*</span></td>
        </tr>
        <tr>
            <td><button type="submit">Anmelden</button></td>
            
        </tr>
    </table>
</form>

//引入axios
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> 
<script>
        //1.使用async的post请求
        (async ()=>{
            const res2 = await axios.post('这里写要用的json地址',{
                pname:'这里写需要从后端调用的接口名',
            })
            console.log(res2.data); //查看json是否引入成功
            //这里写操作命令
        })()
</script>

<script>
    function check(){
        let vorname = document.getElementsByName('vorname')[0].value.trim(); //获取DOM数组对象vorname中的第一个key的值.然后用trim函数去掉用户填写的前后空格
        let nachname = document.getElementsByName('nachname')[0].value.trim(); //获取DOM数组对象vorname中的第一个key的值.然后用trim函数去掉用户填写的前后空格
        let pw = document.getElementsByName('pw')[0].value.trim(); //获取DOM数组对象vorname中的第一个key的值.然后用trim函数去掉用户填写的前后空格
    
    //1.用户名验证: 正则表达式
    //返回到form的onsubmit属性里,如果onsubmit属性为假,整个表单拒绝被提交
        let vornameReg =/^[a-zA-ZüÜäÄöÖßß0-9]{3,10}$/;
        let nachnameReg =/^[a-zA-ZüÜäÄöÖßß0-9]{3,10}$/;
        let pwReg = /^[a-zA-Z0-9_*!]{6}$/;

        if (!vornameReg.test(vorname)) {
            alert('Der Vorname ist erforderlich und kann nur aus Groß- und Kleinbuchstaben und Zahlen bestehen, die Länge beträgt 3-10');
            return false;
        }
        
        if (!nachnameReg.test(nachname)){
            alert('Der Nachname ist erforderlich und kann nur aus Groß- und Kleinbuchstaben und Zahlen bestehen, die Länge beträgt 3-10');
            return false;
        }

        if (!pwReg.test(pw)) {
            alert('Der Password ist erforderlich und kann nur aus Groß- und Kleinbuchstaben,Zahlen, _ ,! ,oder * bestehen, die Länge beträgt 6')
            return false;
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>