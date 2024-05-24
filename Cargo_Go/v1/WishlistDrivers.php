<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Customer_ID'])) {
        $vehicleType = $_POST['Customer_ID'];


        $db = new DbOperations();

        // Call a function to get available drivers based on vehicle size
        $availableDrivers = $db->getWishlistDrivers($vehicleType);

        if ($availableDrivers) {
            $response['error'] = false;
            $response['message'] = "Available drivers retrieved successfully";
            $response['available_drivers'] = $availableDrivers;
        } else {
            $response['error'] = true;
            $response['message'] = "No available drivers in Wishlist";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Customer_ID is missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
