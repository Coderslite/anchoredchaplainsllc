<?php
require_once "db_config.php";


$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = generatePassword();

$stmt = $con->prepare("INSERT INTO chaplains (name, email, phone, password, status)VALUES (?, ?, ?, ?, 'active')");

$stmt->bind_param("ssss", $name, $email, $phone, $password);
$stmt->execute();

header("Location: ../chaplains.php?added=1");
exit;

function generatePassword($length = 10) {
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789@#$%';
    return substr(str_shuffle($chars), 0, $length);
}

$plainPassword = generatePassword(10);

?>