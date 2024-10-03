<?php
// Database connection
$db = mysqli_connect("localhost", "root", "", "dicms");

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the product ID is set in the URL and is a number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product details
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, 'i', $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $product = mysqli_fetch_assoc($result);

    if (!$product) {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Invalid product ID.";
    exit();
}

// Update product logic when form is submitted
if ($_POST) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $shopId = $_POST['shop_id'];
    $ceoId = $_POST['ceo_id'];

    // Handle image upload if a new image is selected
    if (!empty($_FILES['image']['name'])) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        $imagename = $_FILES['image']['name'];
    } else {
        // If no new image is selected, keep the old one
        $imagePath = $product['image'];
    }

    // Prepare the update query
    $updateQuery = "UPDATE products SET name = ?, description = ?, image = ?, shop_id = ?, ceo_id = ? WHERE id = ?";
    $stmt = mysqli_prepare($db, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'sssiii', $name, $description, $imagename, $shopId, $ceoId, $productId);

    // Execute the update query
    if (mysqli_stmt_execute($stmt)) {
        header("Location: view_products.php?success=Product updated successfully");
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($db);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($db);
?>

<!-- HTML Form to Edit the Product -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>

<h2>Edit Product</h2>
<form method="POST" action="" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>

    <label>Description:</label>
    <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea><br>

    <label>Image:</label><br>
    <img src="<?php echo 'uploads/'.$product['image']; ?>" alt="Product Image" width="100" height="100"><br>
    <input type="file" name="image"><br>

    <label>Shop ID:</label>
    <input type="number" name="shop_id" value="<?php echo htmlspecialchars($product['shop_id']); ?>" required><br>

    <label>CEO ID:</label>
    <input type="number" name="ceo_id" value="<?php echo htmlspecialchars($product['ceo_id']); ?>" required><br>

    <input type="submit" value="Update Product">
</form>

</body>
</html>
