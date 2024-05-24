<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Driver_ID'])) {
        $driverID = $_POST['Driver_ID'];



        $db = new DbOperations();

        // Call a function to get booking and customer details based on driver ID and status
        $bookingAndCustomerDetails = $db->getBookingAndCustomerDetailsByDriverAndStatus($driverID, "Requested");

        if ($bookingAndCustomerDetails) {
            $response['error'] = false;
            $response['message'] = "Booking and customer details successfully fetched";
            $response['booking_and_customer_details'] = $bookingAndCustomerDetails;
        } else {
            $response['error'] = true;
            $response['message'] = "No booking Request please refersh after sometime.";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Driver ID or Status is missing";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}

echo json_encode($response);


?>



