<?php
// getDriverIDByEmail.php

require_once '../includes/DbOperations.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Driver_Phone_No'])) {
        $email = $_POST['Driver_Phone_No'];

        $db = new DbOperations();
        $driverID = $db->getDriverIDByEmail($email);

        if ($driverID) {
            $response['error'] = false;
            $response['Driver_ID'] = $driverID;
        } else {
            $response['error'] = true;
            $response['message'] = "Driver ID not found for the provided phone no";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Driver email is missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
