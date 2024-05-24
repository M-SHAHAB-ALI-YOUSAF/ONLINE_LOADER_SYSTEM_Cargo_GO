<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Booking_ID']) && isset($_POST['Booking_Status'])) {
        $bookingId = $_POST['Booking_ID'];
        $newStatus = $_POST['Booking_Status'];

        $db = new DbOperations();

        // Call the method to update the booking status
        $result = $db->updateBookingStatus($bookingId, $newStatus);

        if ($result) {
            $response['error'] = false;
            $response['message'] = "Booking status updated successfully";
        } else {
            $response['error'] = true;
            $response['message'] = "Failed to update booking status";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Booking ID or new status is missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);
?>
