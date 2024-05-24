<?php

require_once '../includes/DbOperations.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if all required parameters are present
    if (isset($_POST['Customer_ID']) && isset($_POST['Driver_ID']) && isset($_POST['Booking_ID']) && isset($_POST['Fare_Amount']) && isset($_POST['Ride_Status']) && isset($_POST['Pick_up']) && isset($_POST['Drop_off'])) {
        // Retrieve parameters from POST request
        $customerId = $_POST['Customer_ID'];
        $driverId = $_POST['Driver_ID'];
        $bookingId = $_POST['Booking_ID'];
        $fareAmount = $_POST['Fare_Amount'];
        $rideStatus = $_POST['Ride_Status'];
        $pickUp = $_POST['Pick_up'];
        $dropOff = $_POST['Drop_off'];

        // Instantiate DbOperations object
        $db = new DbOperations();

        // Call insertRideHistory function to insert data into ride_history table
        if ($db->insertRideHistory($customerId, $driverId, $bookingId, $fareAmount, $rideStatus, $pickUp, $dropOff)) {
            // Data inserted successfully
            $response['error'] = false;
            $response['message'] = "Ride history inserted successfully";
        } else {
            // Failed to insert data
            $response['error'] = true;
            $response['message'] = "Failed to insert ride history";
        }
    } else {
        // Missing parameters
        $response['error'] = true;
        $response['message'] = "Missing parameters";
    }
} else {
    // Invalid request method
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

// Convert response array to JSON and echo
echo json_encode($response);
?>