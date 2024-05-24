<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['Email']) &&
        isset($_POST['Phone_No'])
    ) {
   
        $Email = $_POST['Email'];
        $phoneno = $_POST['Phone_No'];
        $db = new DbOperations();

        // Perform the update directly
        $result = $db->updateCustomerPhoneNo($phoneno, $Email);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "Customer Phone Number is Updated";
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

