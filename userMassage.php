<?php
session_start();
$message = $_POST["message"];
$vorname = $_SESSION["loggedVorname"];
$nachname = $_SESSION["loggedNachname"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 连接到数据库
    include_once("conn.php");
    
    // 执行更新操作
    if((isset($vorname) &&isset($nachname))&&($vorname!= "" && $nachname!= "")) {
        $sql ="update info set messages='$message' where vorname='$vorname' and nachname='$nachname'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Message submit erfolgreich!');location.href='index.php';</script>";
        } else {
            echo "<script>alert('Message submit failed.');location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Benutzerdaten nicht verfügbar. Nachricht konnte nicht eingefügt werden.');location.href='index.php';</script>";
    }
}
?>