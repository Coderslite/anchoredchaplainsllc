<?php
session_start();
require_once 'db_config.php';

if(isset($_GET['type']) && isset($_GET['id']) && isset($_GET['client_id'])) {
    $type = sanitize($_GET['type']);
    $id = intval($_GET['id']);
    $client_id = intval($_GET['client_id']);
    
    if($type == 'file') {
        // Get file path first
        $query = mysqli_query($con, "SELECT file_path FROM client_files WHERE id = $id");
        if($file = mysqli_fetch_assoc($query)) {
            // Delete physical file
            if(file_exists($file['file_path'])) {
                unlink($file['file_path']);
            }
            // Delete database record
            mysqli_query($con, "DELETE FROM client_files WHERE id = $id");
            $_SESSION['success'] = 'File deleted successfully!';
        }
    } elseif($type == 'folder') {
        // Get all files in folder first
        $files_query = mysqli_query($con, "SELECT file_path FROM client_files WHERE folder_id = $id");
        while($file = mysqli_fetch_assoc($files_query)) {
            if(file_exists($file['file_path'])) {
                unlink($file['file_path']);
            }
        }
        // Delete files from database
        mysqli_query($con, "DELETE FROM client_files WHERE folder_id = $id");
        // Delete folder
        mysqli_query($con, "DELETE FROM client_folders WHERE id = $id");
        $_SESSION['success'] = 'Folder and all its contents deleted successfully!';
    }
    
    header("Location: view-client.php?id=$client_id");
    exit();
} else {
    $_SESSION['error'] = 'Invalid request';
    header('Location: clients.php');
    exit();
}
?>