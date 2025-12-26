<?php
include "db_config.php";
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_query($con, "SELECT * FROM users WHERE email ='$email' AND password = '$password'");

$num = mysqli_num_rows($query);
if ($num == 1) {
    $user = mysqli_fetch_assoc($query);
    $role = $user['role']; // Corrected role assignment
    $userId = $user['id'];

    if ($role == 'Admin') {
        header('location:../index.php');
        $_SESSION['anchored-admin-email']=$email;
        $_SESSION['admin-id'] = $userId;
        

    } elseif ($role == 'Chaplain') {
        header('location:../../chaplain/index.php');
        $_SESSION['chapain-email']=$email;
        $_SESSION['chaplain-id'] = $userId;

    } else {
        $_SESSION['ErrorMessage'] = "Invalid Role Assigned to this user: $role";
        header('location:../login.php');
    }
} else {
    $_SESSION['ErrorMessage'] = "Invalid Login Information";
    header('location:../login.php');
}

?>
