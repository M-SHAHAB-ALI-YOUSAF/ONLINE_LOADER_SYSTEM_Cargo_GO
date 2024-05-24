<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if  (isset($_POST['Customer_ID'])){
        
        $customerID = $_POST['Customer_ID'];

        $db = new DbOperations();

        // Call a function to get available drivers based on vehicle size
        $availableDrivers = $db->getAvailableDriversWithVehicless($customerID);

        if ($availableDrivers) {
            $response['error'] = false;
            $response['message'] = "Data successfully";
            $response['available_data'] = $availableDrivers;
        } else {
            $response['error'] = true;
            $response['message'] = "No available drivers matching the criteria";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Vehicle type or customer ID is missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
