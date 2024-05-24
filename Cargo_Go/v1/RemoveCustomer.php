<?php

require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Email'])) {
        $db = new DbOperations();

        // Delete the student and check for errors
        $result = $db->deleteCustomer($_POST['Email']);

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