<?php
require_once "db_config.php";

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$stmt = $con->prepare("
    UPDATE chaplains 
    SET name = ?, email = ?, phone = ?
    WHERE id = ?
");

$stmt->bind_param("sssi", $name, $email, $phone, $id);
$stmt->execute();

header("Location: ../chaplains.php?updated=1");
exit;
