<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Booking_ID'])) {
        $bookingId = $_POST['Booking_ID'];

        $db = new DbOperations();

        // Call a function to check the status of the booking
        $booking = $db->checkBookingDetail($bookingId);

        if ($booking) {
            $response['error'] = false;
            $response['booking_details'] = $booking;
        } else {
            $response['error'] = true;
            $response['message'] = "No booking found for the provided ID";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Booking ID is missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
