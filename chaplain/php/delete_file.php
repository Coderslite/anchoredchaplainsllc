<?php
include "db_config.php";

if (isset($_GET['file_id'])) {
    $file_id = intval($_GET['file_id']);
    $client_id = intval($_GET['client_id']);
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'files'; // Default to 'files' tab
    
    // First get the folder_id of the file being deleted
    $sql = "SELECT file_path, folder_id FROM client_files WHERE id = $file_id";
    $result = mysqli_query($con, $sql);
    $file = mysqli_fetch_assoc($result);
    
    if ($file) {
        // Delete physical file
        if (file_exists('../'.$file['file_path'])) {
            unlink('../'.$file['file_path']);
        }
        
        // Delete from database
        $sql = "DELETE FROM client_files WHERE id = $file_id";
        mysqli_query($con, $sql);
        
        // Store the folder_id for redirect
        $folder_id = $file['folder_id'];
    }
}

// Redirect back to the client page with the folder_id and active tab
$redirect_url = "../view-client.php?id=$client_id";
$redirect_url .= isset($folder_id) ? "&folder_id=$folder_id" : "";
header("Location: $redirect_url");
exit;
?>