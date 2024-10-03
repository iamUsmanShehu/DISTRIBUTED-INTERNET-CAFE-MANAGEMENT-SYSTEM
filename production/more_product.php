<?php
include 'conn.php';
$product_id = $_GET['product_id']; 
// Fetch product details
$product_query = "SELECT `name`, `description`, `image`, `shop_id` FROM `products` WHERE `id` = ?";
$stmt = $conn->prepare($product_query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product_result = $stmt->get_result();

if ($product_result->num_rows > 0) {
    $product = $product_result->fetch_assoc();
    $shop_id = $product['shop_id'];
    $description = $product['description'];
    $image = $product['image'];
    $shop_name = $product['name'];

    // Fetch shop details
    $shop_query = "SELECT `phone_number`, `email` FROM `shop_profiles` WHERE `id` = ?";
    $stmt = $conn->prepare($shop_query);
    $stmt->bind_param("i", $shop_id);
    $stmt->execute();
    $shop_result = $stmt->get_result();

    if ($shop_result->num_rows > 0) {
        $shop = $shop_result->fetch_assoc();
        $phone_number = $shop['phone_number'];
        $email = $shop['email'];
    } else {
        $phone_number = "N/A";
        $email = "N/A";
    }
} else {
    echo "Product not found.";
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DISTRIBUTED INTERNET CAFE MANAGEMENT SYSTEM</title>
	<link rel="stylesheet" type="text/css" href="css\index.css">
	<link rel="stylesheet" type="text/css" href="bootstrap\bootstrap.css">
	<link rel="stylesheet" type="text/css" href="bootstrap\bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css\more_product.css">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" id="nbr">
	<div id="head_title">
		<div class="container">
			<p>DISTRIBUTED INTERNET CAFE MANAGEMENT SYSTEM</p>
		</div>
	</div> 	
		<div class="container" id="nav-element">
			<div class="navbar-header">
				 <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-nav-demo" aria-expanded="false">
		        	<span class="sr-only">Toggle navigation</span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		        	<span class="icon-bar"></span>
		      	</button>
			</div>
			<div class="collapse navbar-collapse" id="bs-nav-demo">
				<ul class="nav navbar-nav">
					<li><a href="index.html" id="nav-element"><i class="fa fa-home" aria-hidden="true" active></i> Home</a>

					</li>
					<li><a href="about.html" id="nav-element">About</a></li>
					<li><a href="contact.html" id="nav-element">Contact</a></li>
					<li><a href="gallery.html" id="nav-element">Gallery</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="sign up.html" id="nav-element"> Sign Up <i class="fa fa-user-plus" aria-hidden="true"></i></a></li>
					<li><a href="sign in.html" id="nav-element">Sign In <i class="fa fa-user" aria-hidden="true"></i></a></li>
				</ul>
			</div>
		</div>
	</nav>

<!-- More Product -->
	<div class="container" id="product_item">
			<div class="row" id="row_content">
				<div class="col-md-6">
            <img src="uploads/<?= $image; ?>" class="serv_img">
        </div>
        <div class="col-md-6">
            <label>Title:</label>
            <p><?=$shop_name; ?></p>
            <label>Description:</label>
            <p><?php echo $description; ?></p>
            <p><?php echo $phone_number; ?></p>
			      <p><?php echo $email; ?></p>
          <button class="btn btn-info" id="submit_btn">
              <a href="shop_profile_out.php?shop_id=<?=$shop_id;?>" class="visit">Visit Company's Profile</a>
          </button>

				</div>
		</div>
	</div>



	<!-- Footer -->
     <footer>
          <div class="footer-content">
              <h3>DICMS</h3>
              <ul class="socials">
                  <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                  <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                  <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                  <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
              </ul>
          </div>
          <div class="footer-bottom">
              <p>copyright &copy; <a href="#">DICMS 2024</a>  </p>
                      <div class="footer-menu">
                       <!--  <ul class="f-menu">
                         <li><a href="home.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="gallery.html"></i> Gallery</a></li>
                        </ul> -->
                      </div>
          </div>

      </footer>
  </div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>