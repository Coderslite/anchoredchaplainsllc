<?php
session_start();
if(isset($_POST['logout'])){
	session_destroy();
	unset($_SESSION['anchored-chaplain-email']);
 	header('location:../login.php');
}

?>