<?php
include "db_config.php";
include "client_folders.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folder_id = intval($_POST['folder_id']);
    $client_id = intval($_POST['client_id']);
    $new_name = trim($_POST['new_name']);
    $current_folder_id = isset($_POST['current_folder_id']) ? intval($_POST['current_folder_id']) : null;
    
    if (rename_client_folder($folder_id, $new_name, $client_id)) {
        $_SESSION['success_message'] = "Folder renamed successfully";
    } else {
        $_SESSION['error_message'] = "Failed to rename folder";
    }
    
    $redirect_url = "../view-client.php?id=$client_id&tab=files";
    if ($current_folder_id) {
        $redirect_url .= "&folder_id=$current_folder_id";
    }
    header("Location: $redirect_url");
    exit;
}
?>