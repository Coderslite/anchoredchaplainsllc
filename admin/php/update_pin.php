<?php
session_start();
include "db_config.php";
$pin = $_POST['pin'];
$query = mysqli_query($con, "UPDATE lock_content SET pin = '$pin'");
if($query){
    $_SESSION['SuccessMessage'] = "Update Successful";
    header('location:../pin.php');
}
else{
    $_SESSION['ErrorMessage'] = "Something went wrong";
    header('location:../pin.php');
}
?>