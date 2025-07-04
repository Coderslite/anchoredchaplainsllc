<?php
session_start();
include "db_config.php";

// Retrieve form data
$title = $_POST['title'];
$date = date("d-M-Y H:i:s");

// Define upload directory and file handling
$uploadDir = "../../uploads/"; // Ensure this folder exists and is writable
$allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']; // Allow PDF and DOCX

// Check if a file was uploaded
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $fileType = $file['type'];
    $fileSize = $file['size'];
    $fileTmp = $file['tmp_name'];

    // Validate file type and size
    if (!in_array($fileType, $allowedTypes)) {
        $_SESSION['ErrorMessage'] = "Invalid file type. Only PDF and DOCX are allowed.";
        header('location:../books.php');
        exit();
    }

    // Generate a unique file name
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = time() . "_" . uniqid() . "." . $fileExtension;
    $destination = $uploadDir . $newFileName;

    // Move uploaded file to destination
    if (!move_uploaded_file($fileTmp, $destination)) {
        $_SESSION['ErrorMessage'] = "Failed to upload the file.";
        header('location:../books.php');
        exit();
    }
} else {
    $_SESSION['ErrorMessage'] = "No file uploaded or upload error occurred.";
    header('location:../books.php');
    exit();
}

// Sanitize inputs to prevent SQL injection
$title = mysqli_real_escape_string($con, $title);

// Insert data into the database
$query = mysqli_query($con, "INSERT INTO books (title, name, createdAt) VALUES ('$title', '$newFileName', '$date')");

if ($query) {
    $_SESSION['SuccessMessage'] = "New Book Added Successfully";
    header('location:../books.php');
} else {
    $_SESSION['ErrorMessage'] = "Failed to add post: " . mysqli_error($con);
    header('location:../books.php');
}
?>