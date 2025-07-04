<?php
session_start();
include "db_config.php";
$id = $_GET['id'];
$q = mysqli_query($con, "SELECT * FROM books WHERE id = '$id'");
$post = mysqli_fetch_assoc($q);
$image = $post['name'];
$query = mysqli_query($con, "DELETE FROM books WHERE id = '$id'");
if($query){
    unlink("../../uploads/$image");
    $_SESSION['SuccessMessage'] = "Delete Successful";
    header('location:../books.php');
}
else{
    $_SESSION['ErrorMessage'] = "Something went wrong";
    header('location:../books.php');
}
?>