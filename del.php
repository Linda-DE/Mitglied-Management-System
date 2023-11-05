<?php
include_once 'checkAdmin.php';
include_once 'conn.php';
$id = $_GET['id'];
$vorname = $_GET['vorname'];
$nachname = $_GET['nachname'];

if(is_numeric($id)){
    $sql = "delete from info where id = $id";
    $result = mysqli_query($conn,$sql);
    if($result){
        echo "<script>alert('Kunden: $vorname $nachname delete.');location.href = 'admin.php?id=5';</script>";
    }else{
        echo "<script>alert('Kunden: $vorname $nachname ist nicht delete wird.');history.back();</script>";
    }
}else{
    echo "<script>alert('Parametrischer Fehler');history.back();</script>";
}