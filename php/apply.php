<?php
include "db_config.php";
$fname = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$program = $_POST['program'];
$additional = $_POST['message'];
$dob =$_POST['dob'];
$address = $_POST['address'];
$date = date('Y-m-d');

$query = mysqli_query($con,"INSERT INTO clients (fullname,email,phone,program_applied,additional_information,dob,address,status,created_at)VALUES('$fname','$email','$phone','$program','$additional','$dob','$address','active','$date')");

if($query){
    $result ='success';
}
else{
    $result ='failed';
}

header('content-Type: application/json');
echo json_encode($result);
?>