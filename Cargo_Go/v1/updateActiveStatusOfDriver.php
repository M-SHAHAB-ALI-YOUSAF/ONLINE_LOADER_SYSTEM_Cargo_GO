<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['is_Active']) &&
        isset($_POST['Driver_Phone_No'])
    ) {
   
        $status = $_POST['is_Active'];
        $phoneno = $_POST['Driver_Phone_No'];
        $db = new DbOperations();

        // Perform the update directly
        $result = $db->updateDriverStatus($phoneno, $status);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "Driver Active Now";
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

