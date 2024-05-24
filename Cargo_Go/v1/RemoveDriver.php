<?php

require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Driver_Email'])) {
        $db = new DbOperations();

        // Delete the driver and check for errors
        $result = $db->deleteDriver($_POST['Driver_Email']);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = 'true';
        } else {
            $response['error'] = true;
            $response['message'] = "Failed to delete account";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
}

echo json_encode($response);
?>