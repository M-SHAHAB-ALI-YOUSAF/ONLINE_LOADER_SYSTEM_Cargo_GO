<?php

class DbOperations
{

    private $con;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';

        $db = new DbConnect();
        $this->con = $db->connect();
    }


public function createUser($firstname, $lastname, $email, $phoneno, $profileImageName)
{
    if ($this->isUserExist($email, $phoneno)) {
        return 0;
    } else {
        $stmt = $this->con->prepare("INSERT INTO customer_table (First_Name, Last_Name, Email, Phone_No, Profile_Image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $phoneno, $profileImageName);

        if ($stmt->execute()) {
            return 1;
        } else {
            return 2;
        }
    }
}


    private function isUserExist($email, $phoneno)
    {
        $stmt = $this->con->prepare("SELECT Customer_ID FROM customer_table WHERE Email = ? OR Phone_No = ?");
        $stmt->bind_param("ss", $email, $phoneno);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Check if phone number is registered
    public function isPhoneRegistered($phoneno) {
        $stmt = $this->con->prepare("SELECT Customer_ID FROM customer_table WHERE Phone_No = ?");
        $stmt->bind_param("s", $phoneno);
        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
        $stmt->close();
        return $count > 0;
    }

    // Check if email is registered
    public function isEmailRegistered($email) {
        $stmt = $this->con->prepare("SELECT Customer_ID FROM customer_table WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
        $stmt->close();
        return $count > 0;
    }


    //login
    public function isPhoneRegisteredForRole($phoneno, $role) {
        $stmt = $this->con->prepare("SELECT Customer_ID FROM customer_table WHERE Phone_No = ? AND Roles = ?");
        $stmt->bind_param("ss", $phoneno, $role);
        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
        $stmt->close();
        return $count > 0;
    }
    

    //getting all user
        // Function to get user data by phone number
        public function getUsersByPhone($phoneno)
        {
            $stmt = $this->con->prepare("SELECT Customer_ID, First_Name, Last_Name, Email, Profile_Image FROM customer_table WHERE Phone_No = ?");
            $stmt->bind_param("s", $phoneno);
            if ($stmt->execute()) {
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();
                return $user;
            } else {
                return null;
            }
        }


        ///update profile
         // Update a user's record, including profile image if provided
         public function updateUser($firstname, $lastname, $email, $phoneno, $imagePath)
         {
             try {
                 $stmt = $this->con->prepare("UPDATE customer_table SET First_Name=?, Last_Name=?, Email=?, Profile_Image=? WHERE Phone_No=?");
                 $stmt->bind_param("sssss", $firstname, $lastname, $email, $imagePath, $phoneno);
                 $stmt->execute();
         
                 // Check if any rows were affected
                 if ($stmt->affected_rows > 0) {
                     return 1; // Success
                 } else {
                     return 2; // No rows updated, maybe the user with the given phone number doesn't exist
                 }
             } catch (PDOException $e) {
                 // Handle database errors
                 return 2;
             }
         }

     // Function to create a new complaint
    public function createComplaint($bookingID, $complaintType, $complaintDescription, $complaintDate, $complaintStatus) {
        $stmt = $this->con->prepare("SELECT Complaint_ID FROM complaint WHERE Booking_ID = ?");
        $stmt->bind_param("i", $bookingID);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return 0; // Complaint already exists
        }

        $stmt->close();

        // Insert a new complaint
        $stmt = $this->con->prepare("INSERT INTO complaint (Booking_ID, Complaint_Type, Complaint_Description, Complaint_date, Complaint_status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $bookingID, $complaintType, $complaintDescription, $complaintDate, $complaintStatus);

        if ($stmt->execute()) {
            return 1; // Complaint registered successfully
        } else {
            return 2; // Error occurred while registering complaint
        }


    }


    // payment
    public function createTransaction($bookingID, $transactionDateTime, $amount, $paymentMethod, $customerID) {
        $stmt = $this->con->prepare("INSERT INTO payment_transactions (Booking_ID, Transaction_Date_and_Time, Amount, Payment_Method, Customer_ID) VALUES (?, ?, ?, ?, ?)");

        // Bind parameters to the query
        $stmt->bind_param("sssss", $bookingID, $transactionDateTime, $amount, $paymentMethod, $customerID);

        // Execute the query
        if ($stmt->execute()) {
            return 1; // Success
        } else {
            return 2; // Error
        }
    }



    // ============================== REMOVE customer ACCOUNT ===============================

	public function deleteCustomer($email)
	{
			$stmt1 = $this->con->prepare("DELETE FROM customer_table WHERE Email = ?");
			$stmt1->bind_param("s", $email);
	
			$stmt1->execute();
				
			return $stmt1->affected_rows > 0;
	}

    //++++++++++++++++++++++++++++update number of User+++++++++++++++++++++++++++++++++++++
    public function updateCustomerPhoneNo($phoneno, $email)
        {
    try {
        $stmt = $this->con->prepare("UPDATE customer_table SET Phone_No=? WHERE Email=? ");
        $stmt->bind_param("ss", $phoneno, $email);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            return 1; // Success
        } else {
            return 2; // No rows updated, maybe the user with the given phone number doesn't exist
        }
    } catch (PDOException $e) {
        // Handle database errors
        return 2;
    }
}







    //+++++++++++++++++++++++++++++++++++++++Driver++++++++++++++++++++++++++++++++++++


    public function AddDriver($firstname, $lastname, $email, $phoneno, $profileImageName, $active)
{
    if ($this->isdriverExist($email, $phoneno)) {
        return 0;
    } else {
        $stmt = $this->con->prepare("INSERT INTO driver (Driver_First_Name, Driver_Last_Name, Driver_Email, Driver_Phone_No, Driver_Profile_Image, is_Active) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstname, $lastname, $email, $phoneno, $profileImageName, $active);

        if ($stmt->execute()) {
            return 1;
        } else {
            return 2;
        }
    }
}


    private function isdriverExist($email, $phoneno)
    {
        $stmt = $this->con->prepare("SELECT Driver_ID FROM driver WHERE Driver_Email = ? OR Driver_Phone_No = ?");
        $stmt->bind_param("ss", $email, $phoneno);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

        // Check if phone number is registered
        public function isdriverPhoneRegistered($phoneno) {
            $stmt = $this->con->prepare("SELECT Driver_ID FROM driver WHERE Driver_Phone_No = ?");
            $stmt->bind_param("s", $phoneno);
            $stmt->execute();
            $stmt->store_result();
            $count = $stmt->num_rows;
            $stmt->close();
            return $count > 0;
        }
    
        // Check if email is registered
        public function isdriverEmailRegistered($email) {
            $stmt = $this->con->prepare("SELECT Driver_ID FROM driver WHERE Driver_Email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $count = $stmt->num_rows;
            $stmt->close();
            return $count > 0;
        }
            

        public function getDriverByPhone($phoneno)
        {
            $stmt = $this->con->prepare("SELECT Driver_ID, Driver_First_Name, Driver_Last_Name, Driver_Email, Driver_Profile_Image FROM driver WHERE Driver_Phone_No = ?");
            $stmt->bind_param("s", $phoneno);
            if ($stmt->execute()) {
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();
                return $user;
            } else {
                return null;
            }
        }



          // Update a user's record, including profile image if provided
          public function updateDriver($firstname, $lastname, $email, $phoneno, $imagePath)
          {
              try {
                  $stmt = $this->con->prepare("UPDATE driver SET Driver_First_Name=?, Driver_Last_Name=?, Driver_Email=?, Driver_Profile_Image=? WHERE Driver_Phone_No=?");
                  $stmt->bind_param("sssss", $firstname, $lastname, $email, $imagePath, $phoneno);
                  $stmt->execute();
          
                  // Check if any rows were affected
                  if ($stmt->affected_rows > 0) {
                      return 1; // Success
                  } else {
                      return 2; // No rows updated, maybe the user with the given phone number doesn't exist
                  }
              } catch (PDOException $e) {
                  // Handle database errors
                  return 2;
              }
          }
    
          public function AddVehicleInformation($vehicleModel, $vehicleType, $cnicImagePath, $licenseImagePath, $registrationNumberImagePath, $driverID, $vehicleNumber)
          {
              
                  $stmt = $this->con->prepare("INSERT INTO vehicle (Vehicle_Model, Vehicle_type, CNIC, Licence, Registration_Number, Driver_ID, Vehicle_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
                  $stmt->bind_param("sssssss",$vehicleModel, $vehicleType, $cnicImagePath, $licenseImagePath, $registrationNumberImagePath, $driverID, $vehicleNumber);
          
                  if ($stmt->execute()) {
                      return 1;
                  } else {
                      return 2;
                  }
          }



          //++++++++++++++++++++update status+++++++++++++++++++++++++++++++++++++++++++++++++++
          
          // Update a user's record, including profile image if provided
         // Update a user's record, including profile image if provided
public function updateDriverStatus($phoneno, $status)
{
    try {
        $stmt = $this->con->prepare("UPDATE driver SET is_Active=? WHERE Driver_Phone_No=?");
        $stmt->bind_param("ss", $status, $phoneno);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            return 1; // Success
        } else {
            return 2; // No rows updated, maybe the user with the given phone number doesn't exist
        }
    } catch (PDOException $e) {
        // Handle database errors
        return 2;
    }
}


//++++++++++++++++++++++++++++update number of driver+++++++++++++++++++++++++++++++++++++
    public function updateDriverPhoneNo($phoneno, $email)
        {
    try {
        $stmt = $this->con->prepare("UPDATE driver SET Driver_Phone_No=? WHERE Driver_Email=?");
        $stmt->bind_param("ss", $phoneno, $email);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            return 1; // Success
        } else {
            return 2; // No rows updated, maybe the user with the given phone number doesn't exist
        }
    } catch (PDOException $e) {
        // Handle database errors
        return 2;
    }
}


// ============================== REMOVE customer ACCOUNT ===============================

public function deleteDriver($email)
{
        $stmt1 = $this->con->prepare("DELETE FROM driver WHERE Driver_Email = ?");
        $stmt1->bind_param("s", $email);

        $stmt1->execute();
            
        return $stmt1->affected_rows > 0;
}


//getting id++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function getDriverIDByEmail($phone) {
    $stmt = $this->con->prepare("SELECT Driver_ID FROM driver WHERE Driver_Phone_No = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();
    
    // Check if any rows were returned
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($driverID);
        $stmt->fetch();
        $stmt->close();
        return $driverID;
    } else {
        // No driver found with the given email
        $stmt->close();
        return null;
    }
}

//++++++++++++++++++++++++++++getting all drivers++++++++++++++++++++++++++++++++++++++++++++
public function getAllDrivers() {
    $sql = "SELECT * FROM driver";
    $result = $this->con->query($sql);

    if ($result && $result->num_rows > 0) {
        $drivers = array();
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }
        return $drivers;
    } else {
        return null; // No drivers found in the database
    }
}



///++++++++++++++++++++++++++++booking++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function createBooking($customerId, $driverId, $pickDateTime, $pickupLocation, $dropoffLocation, $helpers, $totalCost, $bookingStatus, $Vehicle_Type)
{
    
        $stmt = $this->con->prepare("INSERT INTO booking (Customer_ID, Driver_ID, Pick_Date_and_Time, Pickup_Location, Dropoff_Location, Helpers, Total_Cost, Booking_Status, vehicle_Type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $customerId, $driverId, $pickDateTime, $pickupLocation, $dropoffLocation, $helpers, $totalCost, $bookingStatus, $Vehicle_Type);
        if ($stmt->execute()) {
            return 1;
        } else {
            return 2;
        }
    
}


//++++++++++++++++available driver+++++++++++++++++++++++++++++++++++++++++++++++++++++++
// public function getAvailableDrivers($vehicleType) {
//     $stmt = $this->con->prepare("SELECT d.* FROM driver d JOIN vehicle v ON d.Driver_ID = v.Driver_ID WHERE d.is_Active = 'true' AND v.Vehicle_type = ?");
//     $stmt->bind_param("s", $vehicleType);
//     $stmt->execute();
//     $result = $stmt->get_result();
    
//     if ($result->num_rows > 0) {
//         $drivers = array();
//         while ($row = $result->fetch_assoc()) {
//             $drivers[] = $row;
//         }
//         return $drivers;
//     } else {
//         return null;
//     }
// }
public function getAvailableDriversWithVehicles($vehicleType) {
    $stmt = $this->con->prepare("SELECT d.*, v.* FROM driver d JOIN vehicle v ON d.Driver_ID = v.Driver_ID WHERE d.is_Active = 'true' AND v.Vehicle_type = ?");
    $stmt->bind_param("s", $vehicleType);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $drivers = array();
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }
        return $drivers;
    } else {
        return null;
    }
}


public function getRideHistoryByCustomerId($customerId) {
    $stmt = $this->con->prepare("SELECT * FROM ride_history WHERE Customer_ID = ?");
    $stmt->bind_param("s", $customerId);
    $stmt->execute();
    $rides = $stmt->get_result();
    $stmt->close();
    return $rides->fetch_all(MYSQLI_ASSOC);
}


public function getRideHistoryByDriverId($driverid) {
    $stmt = $this->con->prepare("SELECT * FROM ride_history WHERE Driver_ID = ?");
    $stmt->bind_param("s", $driverid);
    $stmt->execute();
    $rides = $stmt->get_result();
    $stmt->close();
    return $rides->fetch_all(MYSQLI_ASSOC);
}


//++++++++++++++++++++++++++Wishlist+++++++++++++++++++++++++++++++++++
public function getWishlistDrivers($userId) {
    $stmt = $this->con->prepare("SELECT d.*, w.*  FROM wishlist w JOIN driver d ON w.Driver_ID = d.Driver_ID WHERE w.Customer_ID = ?");
    $stmt->bind_param("s", $userId); // Assuming user_id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $drivers = array();
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }
        return $drivers;
    } else {
        return null;
    }
}

public function getAvailableDriversWithVehicless($customerID) {
    $stmt = $this->con->prepare("SELECT * from wishlist where Customer_ID = ?");
    $stmt->bind_param("s", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $drivers = array();
        while ($row = $result->fetch_assoc()) {
            $drivers[] = $row;
        }
        return $drivers;
    } else {
        return null;
    }
}


//++++++++++++++++++++++boooking request to driver+++++++++++++++++++++++++++++++++++++++++++++++++++
// DbOperations.php

public function getBookingAndCustomerDetailsByDriverAndStatus($driverID, $status) {
    $stmt = $this->con->prepare("SELECT b.*, c.* FROM booking b 
                                    JOIN customer_table c ON b.Customer_ID = c.Customer_ID 
                                    WHERE b.Driver_ID = ? AND b.Booking_Status = ?");
    $stmt->bind_param("is", $driverID, $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    $bookingAndCustomerDetails = array();
    
    while ($row = $result->fetch_assoc()) {
        $bookingAndCustomerDetails[] = $row;
    }
    
    return $bookingAndCustomerDetails;
}

// public function getBookingRequestsForDriverWithStatus($driverID, $bookingStatus) {
//     $stmt = $this->con->prepare("SELECT * FROM booking WHERE Driver_ID = ? AND Booking_Status = ?");
//     $stmt->bind_param("ss", $driverID, $bookingStatus);
//     $stmt->execute();
//     $result = $stmt->get_result();
    
//     if ($result->num_rows > 0) {
//         $bookingRequests = array();
//         while ($row = $result->fetch_assoc()) {
//             $bookingRequests[] = $row;
//         }
//         return $bookingRequests;
//     } else {
//         return null;
//     }
// }


//+++++++++++++===checkk booking status++++++++++++++++++++++++++++++++++++++++++++++++
public function checkBookingStatus($customerId, $driverId, $bookingid)
{
    $stmt = $this->con->prepare("SELECT Booking_Status, Booking_ID, Total_Cost FROM booking WHERE Customer_ID = ? AND Driver_ID = ? AND Booking_ID = ? ORDER BY Booking_ID DESC LIMIT 1");
    $stmt->bind_param("sss", $customerId, $driverId, $bookingid);
    $stmt->execute();
    $stmt->bind_result($bookingStatus, $bookingId, $bookingcost);
    $stmt->fetch();
    $stmt->close();

    if ($bookingId) {
        return array('booking_id' => $bookingId, 'booking_status' => $bookingStatus, "booking_cost"=> $bookingcost);
    } else {
        return null;
    }
}


//+++++++++++++++++++++++=booking detail++++++++++++++++++++++++++++++++++++++++++++++++++=
public function checkBookingDetail($bookingId)
{
    $stmt = $this->con->prepare("SELECT b.*, d.*, v.* 
                                FROM booking b 
                                JOIN driver d ON b.Driver_ID = d.Driver_ID 
                                JOIN vehicle v ON d.Driver_ID = v.Driver_ID 
                                WHERE b.Booking_ID = ?");
    $stmt->bind_param("s", $bookingId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result;
}


//++++++++++++++++++++++++++++++++Booking Status++++++++++++++++++++++++++++++++++++++++++++++++++++
public function updateBookingStatus($bookingId, $newStatus)
{
    $stmt = $this->con->prepare("UPDATE booking SET Booking_Status = ? WHERE Booking_ID = ?");
    $stmt->bind_param("ss", $newStatus, $bookingId);
    $result = $stmt->execute();
    $stmt->close();

    return $result; // Return true on success, false on failure
}



//+++++++++++++++++++++++++=ride history+++++++++++++++++++++++++++++++++++++++++++++++++++
public function insertRideHistory($customerId, $driverId, $bookingId, $fareAmount, $rideStatus, $pickUp, $dropOff) {
    // Get the current date and time
    $date = date("Y-m-d");

    $stmt = $this->con->prepare("INSERT INTO ride_history (Customer_ID, Driver_ID, Booking_ID, Fare_Amount, Ride_Status, Pick_up, Drop_off, Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $customerId, $driverId, $bookingId, $fareAmount, $rideStatus, $pickUp, $dropOff, $date);

    if ($stmt->execute()) {
        return true; // Insertion successful
    } else {
        return false; // Insertion failed
    }
}


//++++++++++++++++++++++++++++++booking status+++++++++++++++++++++++++++++++++++++
public function getBookingStatusById($bookingId)
{
    $stmt = $this->con->prepare("SELECT Booking_Status FROM booking WHERE Booking_ID = ?");
    $stmt->bind_param("s", $bookingId);
    if ($stmt->execute()) {
        $stmt->bind_result($bookingStatus);
        $stmt->fetch();
        $stmt->close();
        return $bookingStatus;
    } else {
        return null;
    }
}

//image update++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function getUserProfileImage($email) {
    $stmt = $this->con->prepare("SELECT Profile_Image FROM Customer_Table WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($profileImage);
    $stmt->fetch();
    $stmt->close();
    return $profileImage;
}


//image driveer update++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function getdriverProfileImage($email) {
    $stmt = $this->con->prepare("SELECT Driver_Profile_Image FROM driver WHERE Driver_Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($profileImage);
    $stmt->fetch();
    $stmt->close();
    return $profileImage;
}


//++++++++++++++++++=latest booking id++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function getLatestBookingId()
    {
        $stmt = $this->con->prepare("SELECT MAX(Booking_ID) AS LatestBookingId FROM booking");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['LatestBookingId'];
    }



    //+++++++++++++++++=review+++++++++++++++++++++++++++
    public function createReview($customerID, $driverID, $rating, $reviewText, $date) {
        $stmt = $this->con->prepare("SELECT * FROM reviews WHERE Customer_ID = ? AND Driver_ID = ?");
        $stmt->bind_param("ii", $customerID, $driverID);
        $stmt->execute();
        $stmt->store_result();
        $numRows = $stmt->num_rows;
        $stmt->close();

        if ($numRows > 0) {
            // Review already exists
            return 0;
        } else {
            $stmt = $this->con->prepare("INSERT INTO reviews (Customer_ID, Driver_ID, Rating, Review_Text, Date) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iidss", $customerID, $driverID, $rating, $reviewText, $date);

            if ($stmt->execute()) {
                // Review inserted successfully
                return 1;
            } else {
                // Error occurred while inserting review
                return 2;
            }
        }
    }



    //+++++++++++++++++++++++++++++++Wishlists++++++++++++++++++++++++++++++++++++++++++++++++
    public function createWishlist($customerID, $driverID, $wishlistDate) {
        $stmt = $this->con->prepare("SELECT * FROM wishlist WHERE Customer_ID = ? AND Driver_ID = ?");
        $stmt->bind_param("ii", $customerID, $driverID);
        $stmt->execute();
        $stmt->store_result();
        $numRows = $stmt->num_rows;
        $stmt->close();

        if ($numRows > 0) {
            // Driver already exists in wishlist
            return 0;
        } else {
            $stmt = $this->con->prepare("INSERT INTO wishlist (Customer_ID, Driver_ID, Wishlist_date) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $customerID, $driverID, $wishlistDate);

            if ($stmt->execute()) {
                // Driver added to wishlist successfully
                return 1;
            } else {
                // Error occurred while adding driver to wishlist
                return 2;
            }
        }
    }


     // Function to get total booking
     public function getTotalBooking()
     {
         $sql = "SELECT COUNT(*) AS total_booking FROM booking";
         $result = $this->con->query($sql);
         if ($result && $result->num_rows > 0) {
             $row = $result->fetch_assoc();
             return $row['total_booking'];
         } else {
             return false;
         }
     }
 
     // Function to get cancel booking
     public function getCancelBooking()
     {
         $sql = "SELECT COUNT(*) AS cancel_booking FROM booking WHERE Booking_Status = 'Cancel'";
         $result = $this->con->query($sql);
         if ($result && $result->num_rows > 0) {
             $row = $result->fetch_assoc();
             return $row['cancel_booking'];
         } else {
             return false;
         }
     }
 
     // Function to get complete booking
     public function getCompleteBooking()
     {
         $sql = "SELECT COUNT(*) AS complete_booking FROM booking WHERE Booking_Status = 'Complete'";
         $result = $this->con->query($sql);
         if ($result && $result->num_rows > 0) {
             $row = $result->fetch_assoc();
             return $row['complete_booking'];
         } else {
             return false;
         }
     }
 
     // Function to get total user
     public function getTotalUser()
     {
         $sql = "SELECT COUNT(*) AS total_user FROM (SELECT Driver_ID FROM driver UNION SELECT Customer_ID FROM customer_table) AS users";
         $result = $this->con->query($sql);
         if ($result && $result->num_rows > 0) {
             $row = $result->fetch_assoc();
             return $row['total_user'];
         } else {
             return false;
         }
     }
 


     public function getComplaints()
     {
        $sql = "SELECT c.*, b.Booking_ID, d.Driver_First_Name AS driver_name, ct.First_Name AS customer_name 
        FROM complaint c
        LEFT JOIN booking b ON c.booking_id = b.Booking_ID
        LEFT JOIN driver d ON b.driver_id = d.Driver_ID
        LEFT JOIN customer_table ct ON b.customer_id = ct.Customer_ID";

         
         $result = $this->con->query($sql);
         if ($result && $result->num_rows > 0) {
             $complaints = array();
             while ($row = $result->fetch_assoc()) {
                 $complaints[] = $row;
             }
             return $complaints;
         } else {
             return false;
         }
     }


     public function isDriverIDExistsInVehicleInformation($phoneno) {
        $stmt = $this->con->prepare("SELECT * FROM vehicle WHERE Driver_ID = (SELECT Driver_ID FROM driver WHERE Driver_Phone_No = ?)");
        $stmt->bind_param("s", $phoneno);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
}
