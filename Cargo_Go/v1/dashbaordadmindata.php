<?php

require_once '../includes/DbOperations.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new DbOperations();

    // Call functions to retrieve total booking, cancel booking, complete booking, and total user
    $totalBooking = $db->getTotalBooking();
    $cancelBooking = $db->getCancelBooking();
    $completeBooking = $db->getCompleteBooking();
    $totalUser = $db->getTotalUser();

    // Check if data retrieval was successful
    if ($totalBooking !== false && $cancelBooking !== false && $completeBooking !== false && $totalUser !== false) {
        $response['error'] = false;
        $response['total_booking'] = $totalBooking;
        $response['cancel_booking'] = $cancelBooking;
        $response['complete_booking'] = $completeBooking;
        $response['total_user'] = $totalUser;
    } else {
        $response['error'] = true;
        $response['message'] = "Error retrieving data from the database";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>
