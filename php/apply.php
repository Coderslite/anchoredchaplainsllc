<?php
include "db_config.php";
$fname = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$program = $_POST['program'];
$additional = $_POST['message'];
$date = date('Y-m-d');

$query = mysqli_query($con,"INSERT INTO clients (fullname,email,phone,applied_program,additional_information,status,created_at)VALUES('$fname','$email','$phone','$program','$additional','active','$date')");

if($query){
    $result ='success';
}
else{
    $result ='failed';
}

header('content-Type: application/json');
echo json_encode($result);
?>