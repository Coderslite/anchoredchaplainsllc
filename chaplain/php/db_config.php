<?php
$isLive = false;
// $isLive = true;
$servername = "localhost";
$username = $isLive?"premvssx_user":"root";
$password = $isLive?"Premierbnk":"root";
$dbname = $isLive?"premvssx_db":"anchored";
$con = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


// include "../php/db_config.php";

?>