<?php
include_once 'checkAdmin.php';
$action = $_GET['action'];
$id = $_GET['id'];
if(is_numeric($action) && is_numeric($id)){
    if($action == 1 || $action == 0){  //说明是设置或取消管理员
        $sql = "update info set admin = $action where id = $id";
    }else{
        echo "<script>alert('Erro');history.back();</script>";
        exit;
    }

    include_once 'conn.php';
    $result = mysqli_query($conn,$sql);

    if($action){
        $msg = 'Set Administrator';
    }else{
        $msg = 'Delete Administrator';
    }

    if($result){
        echo "<script>alert('{$msg}Erfolg');location.href='admin.php?id=5';</script>";
    }else{
        echo "<script>alert('{$msg}Fehler');history.back();</script>";
    }
}else{
    //说明action和（或）id不是数字
    echo "<script>alert('Erro');history.back();</script>";
}