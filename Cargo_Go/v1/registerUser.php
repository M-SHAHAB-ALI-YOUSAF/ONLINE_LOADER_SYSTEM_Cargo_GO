
<?php
require_once '../includes/DbOperations.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
        isset($_POST['First_Name']) &&
        isset($_POST['Last_Name']) &&
        isset($_POST['Email']) &&
        isset($_POST['Phone_No'])

    ) {
        $firstname = $_POST['First_Name'];
        $lastname = $_POST['Last_Name'];
        $email = $_POST['Email'];
        $phoneno = $_POST['Phone_No'];
    

        // Check if 'profileimage' is set, and if it is, handle the image upload
        if (isset($_POST['Profile_Image'])) {
            $base64Image = $_POST['Profile_Image'];

            // Generate the path for the image
            $path = 'images/' . date("d-m-y") . '-' . time() . '-' . rand(10000, 1000000) . '.jpg';

            // Save the base64-decoded image data to the specified path
            if (file_put_contents($path, base64_decode($base64Image))) {
                // Image uploaded successfully
                $imagePath = $path;
            } else {
                // Failed to save the image
                $imagePath = null;
            }
        } else {
            // 'profileimage' is not set, set image path to null
            $imagePath = null;
        }

        $db = new DbOperations();
        $result = $db->createUser($firstname, $lastname, $email, $phoneno, $imagePath);

        if ($result == 1) {
            $response['error'] = false;
            $response['message'] = "User registered successfully";
        } elseif ($result == 2) {
            $response['error'] = true;
            $response['message'] = "Some error occurred, please try again";
        } elseif ($result == 0) {
            $response['error'] = true;
            $response['message'] = "Email or phone number is already registered, please choose different values";
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
