<?php
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_upload'])) {
    $client_id = intval($_POST['client_id']);
    $folder_id = isset($_POST['folder_id']) ? intval($_POST['folder_id']) : null;
    
    $target_dir = "../../uploads/clients/$client_id/";
    $target_dir2 = "../uploads/clients/$client_id/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $original_name = basename($_FILES["file_upload"]["name"]);
    $file_name = mysqli_real_escape_string($con, $original_name);
    $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
    $new_name = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9\.]/', '_', $original_name);
    $target_file = $target_dir . $new_name;
    $target_file2 = $target_dir2 . $new_name;
    $file_size = $_FILES["file_upload"]["size"];
    
    if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO client_files (folder_id, client_id, name, file_path, size, type) 
                VALUES ($folder_id, $client_id, '$file_name', '$target_file2', $file_size, '$file_ext')";
        mysqli_query($con, $sql);
    }
}

header("Location: ../view-client.php?id=$client_id&" . ($folder_id ? "&folder_id=$folder_id" : ""));
exit;
?>