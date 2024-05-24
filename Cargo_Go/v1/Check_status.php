<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Customer_ID']) && isset($_POST['Driver_ID'])&& isset($_POST['Booking_ID'])) {
        $customerId = $_POST['Customer_ID'];
        $driverId = $_POST['Driver_ID'];
        $bookingid = $_POST['Booking_ID'];

        $db = new DbOperations();

        // Call a function to check the status of the booking
        $booking = $db->checkBookingStatus($customerId, $driverId, $bookingid);

        if ($booking  != null) {
            $response['error'] = false;
            $response['booking_id'] = $booking['booking_id'];
            $response['status'] = $booking['booking_status'];
            $response['cost'] = $booking['booking_cost'];

            
        } else {
            $response['error'] = true;
            $response['message'] = "No status found for the provided IDs";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Customer ID or Driver ID is missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
