<?php
session_start();
include "db_config.php";

// Retrieve form data
$title = $_POST['title'];
$url = $_POST['url'];
$date = date("d-M-Y H:i:s");

// Sanitize inputs to prevent SQL injection
$title = mysqli_real_escape_string($con, $title);
$url = mysqli_real_escape_string($con, $url);

// Insert data into the database
$query = mysqli_query($con, "INSERT INTO videos (title, url, createdAt) VALUES ('$title', '$url', '$date')");

if ($query) {
    $_SESSION['SuccessMessage'] = "New Video Added Successfully";
    header('location:../videos.php');
} else {
    $_SESSION['ErrorMessage'] = "Failed to add post: " . mysqli_error($con);
    header('location:../videos.php');
}
?>