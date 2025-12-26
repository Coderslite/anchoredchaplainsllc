<?php
require_once "db_config.php";

$id = $_GET['id'];

$stmt = $con->prepare("UPDATE chaplains SET status = 'deleted'WHERE id = ?");

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../chaplains.php?deleted=1");
exit;
