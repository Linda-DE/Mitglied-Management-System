<?php
include_once 'conn.php';

$email=$_POST['email'];
$response = array();
if (empty($email)) {
    $response['code'] = 'empty';
    $response['msg'] = 'Email is empty';
} else {
    $sql = "select 1 from info where email = '$email'";
    $result = mysqli_query($conn,$sql);
    if (mysqli_num_rows($result) > 0) {
        $response['code'] = 'exist';
        $response['msg'] = 'Email already exists';
        $response['email'] = $email; 
    } else {
        $response['code'] = 'available';
        $response['msg'] = 'Email is available';
        $response['email'] = $email; 
    }
}
header('Content-Type: application/json');
echo json_encode(['data' => $response]);
exit;
?>