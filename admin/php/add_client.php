<?php
require_once "db_config.php";

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$program = $_POST['program_applied'];
$route = $_POST['route'];
$applied = $_POST['applied_date'];
$approved = $_POST['approved_date'] ?: NULL;
$renewed = $_POST['renewed_date'] ?: NULL;

$stmt = $con->prepare("
    INSERT INTO clients 
    (fullname, email, phone, program_applied, applied_date, approved_date, renewed_date)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssssss",
    $fullname,
    $email,
    $phone,
    $program,
    $applied,
    $approved,
    $renewed
);

$stmt->execute();

header("Location: ../$route.php");
exit;
