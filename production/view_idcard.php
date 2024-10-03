<?php

// Start the session
session_start();
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dicms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

// SQL query to fetch CEO profile data based on ceo_id
$sql_ceo = "SELECT `id`, `first_name`, `last_name`, `middle_name`, `gender`, `passport`, `dob`, `email`, `password`, 
            `phone_number`, `address`, `state_of_origin`, `lga_of_origin`, `identification_type`, 
            `identification_file`, `submission_date` 
            FROM `ceo_profiles` 
            WHERE id=$id";

// Execute the query and check if it succeeded
$fetched = $conn->query($sql_ceo);

if ($fetched && $fetched->num_rows > 0) {
    // Loop through the result and assign values to variables
    while ($fetch = $fetched->fetch_assoc()) {
        $fetch_id = $fetch['id'];
        $first_name = $fetch['first_name'] ?? 'Not Available';
        $last_name = $fetch['last_name'] ?? 'Not Available';
        $middle_name = $fetch['middle_name'] ?? 'Not Available';
        $gender = $fetch['gender'] ?? 'Not Available';
        $passport = $fetch['passport'] ?? 'Not Available'; // Assuming this is an image path
        $dob = $fetch['dob'] ?? 'Not Available';
        $email = $fetch['email'] ?? 'Not Available';
        $password = $fetch['password'] ?? 'Not Available';
        $phone_number = $fetch['phone_number'] ?? 'Not Available';
        $address = $fetch['address'] ?? 'Not Available';
        $state_of_origin = $fetch['state_of_origin'] ?? 'Not Available';
        $lga_of_origin = $fetch['lga_of_origin'] ?? 'Not Available';
        $identification_type = $fetch['identification_type'] ?? 'Not Available';
        $identification_file = $fetch['identification_file'] ?? 'Not Available'; // Assuming this is a file path
        $submission_date = $fetch['submission_date'] ?? 'Not Available';
    }
} else {
    echo "No CEO profile found for the provided ID.";
}


echo '<center><img src="uploads/' .$identification_file. '"><br><a href=admin.php>Back</a></center>';
?>
