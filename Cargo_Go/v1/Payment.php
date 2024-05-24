<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['Booking_ID']) &&
        isset($_POST['Amount']) &&
        isset($_POST['Payment_Method']) &&
        isset($_POST['Customer_ID'])
    ) {
        $bookingID = $_POST['Booking_ID'];
        $amount = $_POST['Amount'];
        $paymentMethod = $_POST['Payment_Method'];
        $customerID = $_POST['Customer_ID'];

        // Set the time zone to Pakistan (Asia/Karachi)
        date_default_timezone_set('Asia/Karachi');

        // Get the current date and time in the Pakistani time zone
        $transactionDateTime = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS


        $db = new DbOperations();
        $result = $db->createTransaction($bookingID, $transactionDateTime, $amount, $paymentMethod, $customerID);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "Payment is Done.";
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = "Some error occurred, please try again";
        } elseif ($result == 0) {
            $response['error'] = true;
            $response['message'] = "Transaction already registered";
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