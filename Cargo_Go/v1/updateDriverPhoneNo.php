<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['Driver_Email']) &&
        isset($_POST['Driver_Phone_No'])
    ) {
   
        $Email = $_POST['Driver_Email'];
        $phoneno = $_POST['Driver_Phone_No'];
        $db = new DbOperations();

        // Perform the update directly
        $result = $db->updateDriverPhoneNo($phoneno, $Email);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "Driver Phone Number is Updated";
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = "Some error occurred, please try again";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);

