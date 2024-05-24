<?php

require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Phone_No'])) {
        $db = new DbOperations();

        $phoneno = $_POST['Phone_No'];

        // Check if the phone number is already registered
        if ($db->isPhoneRegistered($phoneno)) {
            $response['error'] = true;
            $response['message'] = "Phone number is already registered";
        } else {
            $response['error'] = false;
            $response['message'] = "Phone number is available for registration";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
}

echo json_encode($response);
?>
