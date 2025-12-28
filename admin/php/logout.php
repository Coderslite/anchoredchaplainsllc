<?php
session_start();
if(isset($_POST['logout'])){
	session_destroy();
	unset($_SESSION['anchored-admin-email']);
 	header('location:../login.php');
}

?>