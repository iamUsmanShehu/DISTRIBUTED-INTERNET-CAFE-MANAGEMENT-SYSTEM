<?php
// Database connection
$db = mysqli_connect("localhost", "root", "", "dicms");

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the ID is set and is a number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    // Prepare the delete query
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, 'i', $productId);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Redirect back to the product list with a success message
        header("Location: projects.php?success=Product deleted successfully");
        exit();
    } else {
        echo "Error deleting product: " . mysqli_error($db);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($db);
?>
