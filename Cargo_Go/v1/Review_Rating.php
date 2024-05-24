<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['Customer_ID']) &&
        isset($_POST['Driver_ID']) &&
        isset($_POST['Rating']) &&
        isset($_POST['Review_Text'])
    ) {
        $customerID = $_POST['Customer_ID'];
        $driverID = $_POST['Driver_ID'];
        $rating = $_POST['Rating'];
        $reviewText = $_POST['Review_Text'];

        // Set the time zone to Pakistan (Asia/Karachi)
        date_default_timezone_set('Asia/Karachi');

        // Get the current date and time in the Pakistani time zone
        $date = date('Y-m-d H:i:s'); // Format: YYYY-MM-DD HH:MM:SS

        $db = new DbOperations();
        $result = $db->createReview($customerID, $driverID, $rating, $reviewText, $date);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "Review inserted successfully.";
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = "Some error occurred, please try again.";
        } elseif ($result == 0) {
            $response['error'] = true;
            $response['message'] = "Review already exists.";
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