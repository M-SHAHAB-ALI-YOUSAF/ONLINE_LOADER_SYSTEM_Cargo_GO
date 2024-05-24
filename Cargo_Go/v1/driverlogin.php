<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Driver_Phone_No'])) {
        $phoneno = $_POST['Driver_Phone_No'];

        $db = new DbOperations();

        // Check if the phone number is registered as a driver
        if ($db->isdriverPhoneRegistered($phoneno)) {
            // Check if the driver ID exists in the vehicle_information table
            if ($db->isDriverIDExistsInVehicleInformation($phoneno)) {
                $response['error'] = true;
                $response['message'] = "Phone number is already registered, please choose a different one.";
            } else {
                $response['error'] = false;
                $response['message'] = "Phone number is registered but not associated with a vehicle.";
            }
        } else {
            $response['error'] = false;
            $response['message'] = "Phone number is not registered. You can use it for registration.";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Phone number parameter is missing.";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
