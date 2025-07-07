<?php 
session_start();
include "../admin/php/db_config.php";

$pin = $_POST['pin'];
$query = mysqli_query($con, "SELECT * FROM lock_content");
$row = mysqli_fetch_assoc($query);
$d_pin = $row['pin'];
if($d_pin == $pin){
    $_SESSION['anchoredPin'] = $pin;
}
else{
    $_SESSION['ErrorMessage'] = "Incorrect PIN";
}
header('location:../chaplain-training.php');
?>