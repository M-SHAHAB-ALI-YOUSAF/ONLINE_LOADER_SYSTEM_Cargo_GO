<?php

require_once '../includes/DbOperations.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Driver_Phone_No'])) {
        $db = new DbOperations();

        $phoneno = $_POST['Driver_Phone_No'];

        // Call a function to retrieve user data by phone number
        $user = $db->getDriverByPhone($phoneno); // Assuming getUserByPhone returns a single user

        if ($user) {
            $response['error'] = false;
            $response['Driver_ID'] = $user['Driver_ID'];
            $response['Driver_First_Name'] = $user['Driver_First_Name'];
            $response['Driver_Last_Name'] = $user['Driver_Last_Name'];
            $response['Driver_Email'] = $user['Driver_Email'];
            $response['Driver_Phone_No'] = $phoneno;
            $response['Driver_Profile_Image'] = $user['Driver_Profile_Image'];
        } else {
            $response['error'] = true;
            $response['message'] = "No user found for the provided phone number";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing";
    }
}

echo json_encode($response);
