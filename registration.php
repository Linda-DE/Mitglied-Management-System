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
    <title>Mitglied Management System</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<div class="main">
    <?php include_once 'nav.php'; ?>
</div>

<form action="postReg.php" method="post" onsubmit="return check()">
    <table id="table">
        <tr>
            <td>Vorname</td>
            <td><input name="vorname" placeholder="vorname"><span class ="mustWrite">*</span></td>
        </tr>
        <tr>
            <td>Nachname</td>
            <td><input name="nachname" placeholder="nachname"><span class ="mustWrite">*</span></td>
        </tr>
        <tr>
            <td>Stadt</td>
            <td><input name="stadt" placeholder="stadt"></td>
        </tr>
        <tr>
            <td>E-Mail</td>
            <td>
                <input name="email" onblur="checkEmail()" placeholder="email">
                <span class ="mustWrite">*</span>
                <span id="emailMsg"></span>
            </td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input name="pw" type="password" placeholder="password"><span class ="mustWrite">*</span></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input name="cpw" type="password" placeholder="repeat password"><span class ="mustWrite">*</span></td>
        </tr>
        <tr>
            <td><button type="submit">Submit</button></td>
            <td><button type="reset">Reset</button></td>
        </tr>
    </table>
</form>

<!--通过Axios库进行异步请求,检查用户在前端页面输入的电子邮件地址是否有效以及是否已经在后端数据库中注册-->
<!-- 引入axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // 设置拦截器，这应该在初始化 Axios 实例之前进行
    axios.interceptors.response.use(
        response => {
            const { data } = response;
            // 根据实际返回的数据格式进行适当地处理
            return data;
        },
        error => Promise.reject(error)
    )

    function checkEmail() {
        var email = document.getElementsByName("email")[0].value.trim();
        let emailReg = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,30}$/;
        if (email.trim() === "") {
            // 输入为空，显示错误消息
            document.getElementById("emailMsg").innerHTML = "Email is empty";
        } else if (!emailReg.test(email)) {
            document.getElementById("emailMsg").innerHTML = "Email is invalid";
        } else {
            console.log(email);
            const data = new URLSearchParams();
            data.append('email', email);
            axios.post("checkEmail.php", {email:email}, {
                headers: {    //改变json的格式,使后端能够通过post解析
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(response){
                console.log(response); // 访问响应中的 data 字段
                if (response && response.data) {
                    if (response.data.code === "error") {
                        alert("response hat keind data code!");
                    } else if (response.data.code === "available") {
                        document.getElementById("emailMsg").innerHTML = "Email is available";
                        //document.getElementById("email").value = response.data.msg;
                    } else if (response.data.code === "exist") {
                        document.getElementById("emailMsg").innerHTML = "Email already exists";
                        //document.getElementById("email").value = response.data.msg;
                    }
                } else {
                    console.log("Response or response.data is undefined or not in the expected format.");
                    console.log(response.data);
                }
            }).catch(function(error) {
                console.log(error);
                alert(error);
            })
        }
    }
</script>

<script>
    function check(){
        let vorname = document.getElementsByName('vorname')[0].value.trim(); //获取DOM数组对象vorname中的第一个key的值.然后用trim函数去掉用户填写的前后空格
        let nachname = document.getElementsByName('nachname')[0].value.trim(); //获取DOM数组对象vorname中的第一个key的值.然后用trim函数去掉用户填写的前后空格
        let email = document.getElementsByName('email')[0].value.trim(); //获取DOM数组对象vorname中的第一个key的值.然后用trim函数去掉用户填写的前后空格
        let pw = document.getElementsByName('pw')[0].value.trim(); //获取DOM数组对象vorname中的第一个key的值.然后用trim函数去掉用户填写的前后空格
        let cpw = document.getElementsByName('cpw')[0].value.trim(); //获取DOM数组对象vorname中的第一个key的值.然后用trim函数去掉用户填写的前后空格
    
    //1.用户名验证: 正则表达式
    //返回到form的onsubmit属性里,如果onsubmit属性为假,整个表单拒绝被提交
        let vornameReg =/^[a-zA-ZüÜäÄöÖßß0-9]{2,10}$/;
        let nachnameReg =/^[a-zA-ZüÜäÄöÖßß0-9]{2,10}$/;
        let emailReg = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,30}$/;
        let pwReg = /^[a-zA-Z0-9_*!]{6,10}$/;
        if (!vornameReg.test(vorname)) {
            alert('Der Vorname ist erforderlich und kann nur aus Groß- und Kleinbuchstaben und Zahlen bestehen, die Länge beträgt 2-10');
            return false;
        }
        
        if (!nachnameReg.test(nachname)){
            alert('Der Nachname ist erforderlich und kann nur aus Groß- und Kleinbuchstaben und Zahlen bestehen, die Länge beträgt 2-10');
            return false;
        }

        if (!emailReg.test(email)){
            alert('Der Email ist erforderlich und kann nur aus Groß- und Kleinbuchstaben und Zahlen bestehen, die Länge beträgt 3-30');
            return false;
        }

        if (!pwReg.test(pw)) {
            alert('Der Password ist erforderlich und kann nur aus Groß- und Kleinbuchstaben,Zahlen, _ ,! ,oder * bestehen, die Länge beträgt 6-10')
            return false;
        }else if(pw!=cpw){
            alert('Password ist nicht gleicht.')
        }
    }
</script>




<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>