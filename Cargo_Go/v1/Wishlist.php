<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['Customer_ID']) &&
        isset($_POST['Driver_ID']) 
    ) {
        $customerID = $_POST['Customer_ID'];
        $driverID = $_POST['Driver_ID'];
        // Set the time zone to Pakistan (Asia/Karachi)
        date_default_timezone_set('Asia/Karachi');

        // Get the current date and time in the Pakistani time zone
        $date = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS

        $db = new DbOperations();
        $result = $db->createWishlist($customerID, $driverID, $date);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "Driver Added successfully.";
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = "Some error occurred, please try again.";
        } elseif ($result == 0) {
            $response['error'] = true;
            $response['message'] = "Already in Wishlist.";
        }
    } else {
        $response['error'] = true;
        $response['message'] = "Required fields are missing.";
    }
} else {
    $response['error'] = true;
    $response['message'] = "Invalid Request.";
}

echo json_encode($response);

?>