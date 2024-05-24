<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Booking_ID'])) {
        $bookingId = $_POST['Booking_ID'];

        $db = new DbOperations();

        // Call a function to fetch booking status by booking ID
        $bookingStatus = $db->getBookingStatusById($bookingId);

        if ($bookingStatus !== null) {
            $response['error'] = false;
            $response['status'] = $bookingStatus;
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
