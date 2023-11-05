<?php
session_start();
?>

<link rel="stylesheet" href="style.css">

<?php $id = $_GET['id'] ?? 1; ?>  <!--通过地址栏传参数,老的写法: $id=isset($_GET['id'])? $_GET['id'] : 1; -->
    
<!--菜单展开按钮-->
<div class="dropdown">
        <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-justify" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2 12.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="index.php">Home</a>
            <a class="dropdown-item" href="registration.php">Registration</a>
            <a class="dropdown-item" href="anmelden.php">Anmelden</a>
            <a class="dropdown-item" href="modify.php">Modification</a>
            <a class="dropdown-item" href="admin.php">Administration</a>
        </div>
    </div>

<!--页面链接-->
<h4 class="link">
    <a href="index.php?id=1" <?php if($id == 1){?>class="current"<?php }?>>Home</a> 
    <a href="registration.php?id=2" <?php if($id == 2){?>class="current"<?php }?>>Registration</a>
    <a href="anmelden.php?id=3" <?php if($id == 3){?>class="current"<?php }?>>Anmelden</a>
    <a href="modify.php?id=4&source=member" <?php if($id == 4){?>class="current"<?php }?>>Modification</a>
    <a href="admin.php?id=5" <?php if($id == 5){?>class="current"<?php }?>>Administration</a>
</h4>

<!--公司Logo-->
<h1><a><img src="PBeaKK_logo.png" alt=""></a>   Member Dynamic Registration System</h1>

<!--登录后显示用户姓名，以及退出登录按钮-->
<?php
    if((isset($_SESSION['loggedVorname']) &&isset($_SESSION['loggedNachname']))
    && ($_SESSION['loggedVorname']!= "" && $_SESSION['loggedNachname']!= "")) {
?>
    <div class="logged">Username: 
        <?php echo $_SESSION['loggedVorname']." ".$_SESSION['loggedNachname'];?>
        <?php if($_SESSION['admin']) echo '🔧'?>
        <button class="logout"><a href="abmelden.php">Abmelden</a></button>
    </div>
<?php
    }
?>