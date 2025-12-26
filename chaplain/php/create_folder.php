<?php
session_start();
include "db_config.php";
require_once 'client_folders.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = intval($_POST['client_id']);
    $folder_name = trim($_POST['folder_name']);
    $parent_id = isset($_POST['parent_id']) && $_POST['parent_id'] ? intval($_POST['parent_id']) : null;
    
    if (!empty($folder_name)) {
        $new_folder_id = create_client_folder($client_id, $folder_name, $parent_id);
        
        // Determine where to redirect
        $redirect_params = "id=$client_id";
        
        // If we created a subfolder, redirect back to the parent folder view
        if ($parent_id) {
            $redirect_params .= "&folder_id=$parent_id";
        }
        
        header("Location: ../view-client.php?$redirect_params");
        exit;
    }
}

// Fallback redirect if something went wrong
header("Location: ../view-client.php?id=$client_id");
exit;
?>