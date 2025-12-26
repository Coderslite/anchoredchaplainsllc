<?php
include "db_config.php";

function get_client_folders($client_id, $parent_id = null) {
    global $con;
    
    $client_id = intval($client_id);
    $parent_condition = $parent_id === null ? "IS NULL" : "= " . intval($parent_id);
    
    $sql = "SELECT * FROM client_folders 
            WHERE client_id = $client_id AND parent_id $parent_condition 
            ORDER BY name";
    
    $result = mysqli_query($con, $sql);
    $folders = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $folders[] = $row;
        }
    }
    
    return $folders;
}

function create_client_folder($client_id, $name, $parent_id = null) {
    global $con;
    
    $client_id = intval($client_id);
    $name = mysqli_real_escape_string($con, $name);
    $parent_id = $parent_id ? intval($parent_id) : 'NULL';
    
    $sql = "INSERT INTO client_folders (client_id, name, parent_id) 
            VALUES ($client_id, '$name', $parent_id)";
    
    if (mysqli_query($con, $sql)) {
        return mysqli_insert_id($con);
    }
    return false;
}

function get_client_folder_path($folder_id) {
    global $con;
    $path = [];
    
    while ($folder_id) {
        $sql = "SELECT id, name, parent_id FROM client_folders WHERE id = " . intval($folder_id);
        $result = mysqli_query($con, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $folder = mysqli_fetch_assoc($result);
            array_unshift($path, $folder);
            $folder_id = $folder['parent_id'];
        } else {
            $folder_id = null;
        }
    }
    
    return $path;
}

function get_client_files($client_id, $folder_id) {
    global $con;
    
    $sql = "SELECT * FROM client_files 
            WHERE client_id = " . intval($client_id) . " 
            AND folder_id = " . intval($folder_id) . "
            ORDER BY name";
    
    $result = mysqli_query($con, $sql);
    $files = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $files[] = $row;
        }
    }
    
    return $files;
}

function rename_client_folder($folder_id, $new_name, $client_id) {
    global $con;
    
    $folder_id = intval($folder_id);
    $client_id = intval($client_id);
    $new_name = mysqli_real_escape_string($con, trim($new_name));
    
    if (empty($new_name)) {
        return false;
    }
    
    $sql = "UPDATE client_folders SET name = '$new_name' 
            WHERE id = $folder_id AND client_id = $client_id";
    
    return mysqli_query($con, $sql);
}
?>