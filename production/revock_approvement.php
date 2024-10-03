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

// Check if 'id' is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL query to update the shop_profiles table
    $sql = "UPDATE `shop_profiles` SET `verify` = 0 WHERE `id` = ?";

    // Prepare and bind parameters to avoid SQL injection
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);

        // Execute the update query
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to admin.php if the update was successful
            header("Location: admin.php?status=success");
        } else {
            // In case of failure, redirect with an error message
            header("Location: admin.php?status=error");
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare the SQL statement.";
    }
} else {
    // If 'id' is not set, redirect with an error message
    header("Location: admin.php?status=missing_id");
}

// Close the database connection
$conn->close();
?>
