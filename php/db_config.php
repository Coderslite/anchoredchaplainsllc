<?php
$live = true;
// $live = false;
$servername = "localhost";
$username = $live?"leatviuo_anchored":"root";
$password = $live?"Anchoredchaplainsllc":"root";
$dbname = $live?"leatviuo_anchored":"anchored";
$con = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
?>