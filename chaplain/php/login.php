<?php
include "db_config.php";
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($con, "SELECT * FROM chaplains WHERE email ='$email' AND password = '$password'");

$num = mysqli_num_rows($query);
if ($num == 1) {
    $user = mysqli_fetch_assoc($query);
    $userId = $user['id'];
        header('location:../index.php');
        $_SESSION['anchored-chaplain-email']=$email;
        $_SESSION['chaplain-id'] = $userId;

} else {
    $_SESSION['ErrorMessage'] = "Invalid Login Information";
    header('location:../login.php');
}

?>
