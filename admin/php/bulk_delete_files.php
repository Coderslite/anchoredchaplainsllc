<?php
require_once 'db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = intval($_POST['client_id']);
    $folder_id = isset($_POST['folder_id']) ? intval($_POST['folder_id']) : null;
    $file_ids = isset($_POST['file_ids']) ? $_POST['file_ids'] : [];
    $folder_ids = isset($_POST['folder_ids']) ? $_POST['folder_ids'] : [];
    
    // Initialize response
    $response = [
        'success' => false,
        'message' => 'No items selected for deletion'
    ];
    
    try {
        // Process file deletions
        if (!empty($file_ids)) {
            $file_ids = array_map('intval', $file_ids);
            $file_ids_str = implode(',', $file_ids);
            
            // First get file paths to delete from server
            $query = "SELECT file_path FROM client_files WHERE id IN ($file_ids_str) AND client_id = $client_id";
            $result = mysqli_query($con, $query);
            
            while ($file = mysqli_fetch_assoc($result)) {
                if (file_exists($file['file_path'])) {
                    unlink($file['file_path']);
                }
            }
            
            // Delete from database
            $delete_query = "DELETE FROM client_files WHERE id IN ($file_ids_str) AND client_id = $client_id";
            mysqli_query($con, $delete_query);
            
            $response['message'] = 'Selected files deleted successfully';
            $response['success'] = true;
        }
        
        // Process folder deletions (recursive)
        if (!empty($folder_ids)) {
            require_once 'client_folders.php';
            
            foreach ($folder_ids as $folder_id_to_delete) {
                $folder_id_to_delete = intval($folder_id_to_delete);
                delete_client_folder_recursive($con, $client_id, $folder_id_to_delete);
            }
            
            if ($response['message'] === 'No items selected for deletion') {
                $response['message'] = 'Selected folders deleted successfully';
            } else {
                $response['message'] = 'Selected items deleted successfully';
            }
            $response['success'] = true;
        }
        
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
    
    $_SESSION[$response['success'] ? 'SuccessMessage' : 'ErrorMessage'] = $response['message'];
    
    // Redirect back
    $redirect_url = "view-client.php?id=$client_id";
    if ($folder_id) {
        $redirect_url .= "&folder_id=$folder_id";
    }
    header("Location: ../$redirect_url");
    exit();
}

function delete_client_folder_recursive($con, $client_id, $folder_id) {
    // First delete all files in this folder
    $files_query = "SELECT id, file_path FROM client_files WHERE client_id = $client_id AND folder_id = $folder_id";
    $files_result = mysqli_query($con, $files_query);
    
    while ($file = mysqli_fetch_assoc($files_result)) {
        if (file_exists($file['file_path'])) {
            unlink($file['file_path']);
        }
        mysqli_query($con, "DELETE FROM client_files WHERE id = {$file['id']}");
    }
    
    // Then delete all subfolders recursively
    $subfolders_query = "SELECT id FROM client_folders WHERE client_id = $client_id AND parent_id = $folder_id";
    $subfolders_result = mysqli_query($con, $subfolders_query);
    
    while ($subfolder = mysqli_fetch_assoc($subfolders_result)) {
        delete_client_folder_recursive($con, $client_id, $subfolder['id']);
    }
    
    // Finally delete the folder itself
    mysqli_query($con, "DELETE FROM client_folders WHERE id = $folder_id AND client_id = $client_id");
}
?>