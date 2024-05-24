<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Customer_ID'])) {
        $customerId = $_POST['Customer_ID'];

        $db = new DbOperations();

        // Call a function to fetch ride history based on customer_id
        $rideHistory = $db->getRideHistoryByCustomerId($customerId);

        if ($rideHistory !== null) {
            $response['error'] = false;
            $response['message'] = "Ride history retrieved successfully";
            $response['ride_history'] = $rideHistory;
        } else {
            $response['error'] = true;
            $response['message'] = "No ride history found for the given customer_id";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Customer ID is missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
