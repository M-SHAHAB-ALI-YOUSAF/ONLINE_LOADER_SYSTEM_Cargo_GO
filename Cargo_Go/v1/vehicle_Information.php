<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['Vehicle_Model']) &&
        isset($_POST['Vehicle_type']) &&
        isset($_POST['CNIC']) &&
        isset($_POST['Licence']) &&
        isset($_POST['Registration_Number']) &&
        isset($_POST['Driver_ID']) &&
        isset($_POST['Vehicle_number'])
    ) {
        $vehicleModel = $_POST['Vehicle_Model'];
        $vehicleType = $_POST['Vehicle_type'];
        $driverID = $_POST['Driver_ID'];
        $vehicleNumber = $_POST['Vehicle_number'];

        // Check if 'cnic' is set, and if it is, handle the image upload
        if (isset($_POST['CNIC'])) {
            $base64Image = $_POST['CNIC'];

            // Generate the path for the image
            $cnicpath = 'images/' . date("d-m-y") . '-' . time() . '-' . rand(10000, 1000000) . '.jpg';

            // Save the base64-decoded image data to the specified path
            if (file_put_contents($cnicpath, base64_decode($base64Image))) {
                // Image uploaded successfully
                $cnicimagePath = $cnicpath;
            } else {
                // Failed to save the image
                $cnicimagePath = null;
            }
        } else {
            // 'profileimage' is not set, set image path to null
            $cnicimagePath = null;
        }

        //license
        if (isset($_POST['Licence'])) {
            $base64Image = $_POST['Licence'];

            // Generate the path for the image
            $licencepath = 'images/' . date("d-m-y") . '-' . time() . '-' . rand(10000, 1000000) . '.jpg';

            // Save the base64-decoded image data to the specified path
            if (file_put_contents($licencepath, base64_decode($base64Image))) {
                // Image uploaded successfully
                $licenceimagePath = $licencepath;
            } else {
                // Failed to save the image
                $licenceimagePath = null;
            }
        } else {
            // 'profileimage' is not set, set image path to null
            $licenceimagePath = null;
        }

        //registration number
        if (isset($_POST['Registration_Number'])) {
            $base64Image = $_POST['Registration_Number'];

            // Generate the path for the image
            $Registration_Numberpath = 'images/' . date("d-m-y") . '-' . time() . '-' . rand(10000, 1000000) . '.jpg';

            // Save the base64-decoded image data to the specified path
            if (file_put_contents($Registration_Numberpath, base64_decode($base64Image))) {
                // Image uploaded successfully
                $Registration_NumberpathimagePath = $Registration_Numberpath;
            } else {
                // Failed to save the image
                $Registration_NumberpathimagePath = null;
            }
        } else {
            // 'profileimage' is not set, set image path to null
            $Registration_NumberpathimagePath = null;
        }

        // Add vehicle and driver with image paths
        $db = new DbOperations();
        $result = $db->AddVehicleInformation($vehicleModel, $vehicleType, $cnicimagePath, $licenceimagePath, $Registration_NumberpathimagePath, $driverID, $vehicleNumber);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "Vehicle Information is saved.";
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
?>
