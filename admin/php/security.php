<?php
if(!$_SESSION['anchored-admin-email'])
{
	header('location:login.php');
}

?>