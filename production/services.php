<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dicms";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

include 'fetch.php';
// SQL query to join products with ceo_profiles and shop_profiles
$sql = "SELECT 
            products.id AS product_id, 
            products.name AS product_name, 
            products.description, 
            products.image, 
            products.created_at, 
            ceo_profiles.first_name AS ceo_name, 
            shop_profiles.name AS shop_name,
            shop_profiles.email,
            shop_profiles.phone_number
        FROM products
        INNER JOIN ceo_profiles ON products.ceo_id = ceo_profiles.id
        INNER JOIN shop_profiles ON products.shop_id = shop_profiles.id";

$result = mysqli_query($conn, $sql);



// mysqli_close($conn);
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

<!-- Services -->
	<div class="container services" style="margin-top: 200px;">
			<div class="row">
				<?php
				// Check if any products exist
				if (mysqli_num_rows($result) > 0){
				    // Fetch each row and store the data in variables
			    while ($row = mysqli_fetch_assoc($result)):
			        // Storing values in variables
			        $product_id = $row['product_id'];
			        $product_name = $row['product_name'];
			        $description = $row['description'];
			        $image = $row['image'];
			        $created_at = $row['created_at'];
			        $ceo_name = $row['ceo_name'];
			        $shop_name = $row['shop_name'];
			        $shop_email = $row['email'];
			        $phone_number = $row['phone_number'];
					  
				?>
				<div class="col-md-3 col-sm-6">
					<div class="service_content">
						
						<div class="service_name">
							<a href="#"><?=$shop_name?></a>
						</div>
						<div class="service_img">
							<img src="uploads/<?=$image?>" class="serv_img">
						</div>
						<div class="service_shop_content">
							
							<p class="c-name"><span>Description:</span><?=$description?></p>
							<p class="c-name cname"><span>Contact</span></p>
							<p class="c-name cname"><?=$phone_number?></p>
							<p class="c-name cname"><?=$shop_email?></p>
							<div class="service_more">
								<a href="more_product.html">Description</a>
							</div>
							</div>
					</div>
				</div>
				<?php
					  endwhile;
					} else {
					    echo "No products found.";
					}
				?>		
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
                        </ul> -->
                      </div>
          </div>

      </footer>
  </div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>