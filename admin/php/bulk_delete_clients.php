<?php
session_start();
include "db_config.php";

// Check if request is POST and has client_ids
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!empty($data['client_ids'])) {
        // Sanitize the IDs
        $client_ids = array_map('intval', $data['client_ids']);
        $ids_string = implode(',', $client_ids);
        
        // Update status to 'deleted' for selected clients
        $query = mysqli_query($con, "UPDATE clients SET status = 'deleted' WHERE id IN ($ids_string)");
        
        if ($query) {
            $count = mysqli_affected_rows($con);
            echo json_encode([
                'success' => true,
                'message' => "Successfully deleted $count client(s)"
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error deleting clients: ' . mysqli_error($con)
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No clients selected'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>