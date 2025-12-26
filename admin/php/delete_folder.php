<?php
include "db_config.php";

if (isset($_GET['folder_id'])) {
    $folder_id = intval($_GET['folder_id']);
    $client_id = intval($_GET['client_id']);
    
    // First get the parent folder ID before deletion
    $parent_id = null;
    $sql = "SELECT parent_id FROM client_folders WHERE id = $folder_id";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $folder = mysqli_fetch_assoc($result);
        $parent_id = $folder['parent_id'];
    }

    // Delete all files in this folder
    $sql = "SELECT file_path FROM client_files WHERE folder_id = $folder_id";
    $result = mysqli_query($con, $sql);
    
    while ($file = mysqli_fetch_assoc($result)) {
        if (file_exists($file['file_path'])) {
            unlink($file['file_path']);
        }
    }
    
    // Then delete the folder
    $sql = "DELETE FROM client_folders WHERE id = $folder_id";
    mysqli_query($con, $sql);
    
    // Determine redirect URL
    $redirect_url = "../view-client.php?id=$client_id";
    
    // If we deleted a subfolder, redirect back to the parent folder view
    if ($parent_id) {
        $redirect_url .= "&folder_id=$parent_id";
    }
    
    header("Location: $redirect_url");
    exit;
}

// Fallback redirect if something went wrong
header("Location: ../view-client.php?id=$client_id");
exit;
?>