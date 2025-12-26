<?php
session_start();
$id = $_GET['id'];
$route = $_GET['route'];
include "db_config.php";

$query = mysqli_query($con, "UPDATE clients SET status = 'deleted' WHERE id ='$id'");
if($query){
    $_SESSION['SuccessMessage'] = "Client deleted successfully";
}
else{
    $_SESSION['SuccessMessage'] = "Client deleted successfully";
}

header('location:../'.$route.'.php');


?>