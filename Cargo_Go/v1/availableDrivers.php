<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['vehicle_Type'])) {
        $vehicleType = $_POST['vehicle_Type'];


        $db = new DbOperations();

        // Call a function to get available drivers based on vehicle size
        $availableDrivers = $db->getAvailableDriversWithVehicles($vehicleType);

        if ($availableDrivers) {
            $response['error'] = false;
            $response['message'] = "Available drivers retrieved successfully";
            $response['available_drivers'] = $availableDrivers;
        } else {
            $response['error'] = true;
            $response['message'] = "No available drivers matching the criteria";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Vehicle type is missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
