<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['Customer_ID']) &&
        isset($_POST['Driver_ID']) &&
        isset($_POST['Pickup_Location']) &&
        isset($_POST['Dropoff_Location']) &&
        isset($_POST['Helpers']) &&
        isset($_POST['Total_Cost']) &&
        isset($_POST['vehicle_Type']) &&
        isset($_POST['Booking_Status'])
    ) {
        $customerId = $_POST['Customer_ID'];
        $driverId = $_POST['Driver_ID'];
    
        $pickupLocation = $_POST['Pickup_Location'];
        $dropoffLocation = $_POST['Dropoff_Location'];
        $helpers = $_POST['Helpers'];
        $totalCost = $_POST['Total_Cost'];
        $bookingStatus = $_POST['Booking_Status'];
        $Vehicle_Type = $_POST['vehicle_Type'];

        $pickDateTime = date('Y-m-d H:i:s');

        $db = new DbOperations();
        $result = $db->createBooking($customerId, $driverId, $pickDateTime, $pickupLocation, $dropoffLocation, $helpers, $totalCost, $bookingStatus, $Vehicle_Type);

        if ($result == 1) {
            // Fetch the booking ID after inserting the booking record
            $bookingId = $db->getLatestBookingId();

            $response['error'] = false;
            $response['message'] = "Booking Request is sent successfully";
            $response['booking_id'] = $bookingId; // Add the booking ID to the response
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
?>
