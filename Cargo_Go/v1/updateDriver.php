<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['Driver_First_Name']) &&
        isset($_POST['Driver_Last_Name']) &&
        isset($_POST['Driver_Email']) &&
        isset($_POST['Driver_Phone_No'])
    ) {
        $firstname = $_POST['Driver_First_Name'];
        $lastname = $_POST['Driver_Last_Name'];
        $email = $_POST['Driver_Email'];
        $phoneno = $_POST['Driver_Phone_No'];

        
        if (isset($_POST['Driver_Profile_Image'])) {
            $base64Image = $_POST['Driver_Profile_Image'];

            // Generate the path for the image
            $path = 'images/' . date("d-m-y") . '-' . time() . '-' . rand(10000, 1000000) . '.jpg';

            // Save the base64-decoded image data to the specified path
            if (file_put_contents($path, base64_decode($base64Image))) {
                // Image uploaded successfully
                $imagePath = $path;
                $response['image_path'] = $imagePath;
            } else {
                // Failed to save the image
                $imagePath = null;
            }
        } else {
            // No new image uploaded, retrieve the existing image path from the database
            $db = new DbOperations();
            $imagePath = $db->getdriverProfileImage($email);
        }

        $db = new DbOperations();

        // Perform the update directly
        $result = $db->updateDriver($firstname, $lastname, $email, $phoneno, $imagePath);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "Driver profile updated successfully";
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

