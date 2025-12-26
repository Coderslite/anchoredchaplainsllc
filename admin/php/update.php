<?php
session_start();
include "db_config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit_client'])) {

        $client_id = (int) $_POST['client_id'];

        $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $phone = mysqli_real_escape_string($con, $_POST['phone']);
        $program_applied = mysqli_real_escape_string($con, $_POST['program_applied']);
        $status = mysqli_real_escape_string($con, $_POST['status']);
        $additional_information = mysqli_real_escape_string($con, $_POST['additional_information']);

        // Nullable fields
        $assigned_chaplain = nullable($_POST['assigned_chaplain'] ?? null);
        $applied_date     = nullable($_POST['applied_date'] ?? null);
        $approved_date    = nullable($_POST['approved_date'] ?? null);
        $renewed_date     = nullable($_POST['renewed_date'] ?? null);

        $update_query = "
            UPDATE clients SET 
                fullname = '$fullname',
                email = '$email',
                phone = '$phone',
                program_applied = '$program_applied',
                assigned_chaplain = $assigned_chaplain,
                applied_date = $applied_date,
                approved_date = $approved_date,
                renewed_date = $renewed_date,
                status = '$status',
                additional_information = '$additional_information'
            WHERE id = $client_id
        ";

        if (mysqli_query($con, $update_query)) {
            $_SESSION['SuccessMessage'] = "Client information updated successfully!";
        } else {
            $_SESSION['ErrorMessage'] = "Error updating client: " . mysqli_error($con);
        }

        header("Location: ../view-client.php?id=$client_id");
        exit;
    }
}

function nullable($value) {
    return (isset($value) && trim($value) !== '') ? "'" . mysqli_real_escape_string($GLOBALS['con'], $value) . "'" : "NULL";
}


?>