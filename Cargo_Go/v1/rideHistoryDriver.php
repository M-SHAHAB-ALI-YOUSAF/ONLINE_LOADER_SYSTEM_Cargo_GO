<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Driver_ID'])) {
        $driverid = $_POST['Driver_ID'];

        $db = new DbOperations();

        // Call a function to fetch ride history based on customer_id
        $rideHistory = $db->getRideHistoryByDriverId($driverid);

        if ($rideHistory !== null) {
            $response['error'] = false;
            $response['message'] = "Ride history retrieved successfully";
            $response['ride_history'] = $rideHistory;
        } else {
            $response['error'] = true;
            $response['message'] = "No ride history found for the given Driver_ID";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Driver ID is missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
