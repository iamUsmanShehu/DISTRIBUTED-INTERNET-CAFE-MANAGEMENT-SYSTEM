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
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve the form data
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $category = $conn->real_escape_string($_POST['category']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert the data into the database
    $sql = "INSERT INTO feedback (name, email, category, message) 
            VALUES ('$name', '$email', '$category', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo  "Thank you for your feedback!";
        header("refresh:2; index.php"); // Redirect to the form page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


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
            shop_profiles.verify,
            shop_profiles.phone_number
        FROM products
        INNER JOIN ceo_profiles ON products.ceo_id = ceo_profiles.id
        INNER JOIN shop_profiles ON products.shop_id = shop_profiles.id WHERE shop_profiles.verify = 1 LIMIT 10";

$result = mysqli_query($conn, $sql);

include 'fetch.php';

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

<style type="text/css">
	#slider_header, #slider_heade{
		/*color: #101010!important;*/
		color: #f5f5f5!important;
	}
	#slide{
		background-image: url('pic/pic6.jpg');
	    background-size: cover;
	    background-position: center;
	    background-repeat: no-repeat;
	    width: 100%;
	    height: 700px;
	}
</style>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" id="nbr">
	<?php include 'nav.php';?>
</nav>

<!-- image slider -->
	 <div class="container slide" id="slide">
		 	<div class="slider">
			    <div class="slide"></div>
			    <div class="slide"></div>
			    <div class="slide"></div>
			    <div class="slide"></div>
			    <div class="slide"></div>
			    <div class="row">
				 		<div class="col-lg-12">
				 			<div id="content">
				 				<h1 id="slider_header">DICMS</h1>
					 			<h3 id="slider_heade">Automating your Business . . . </h3>
					 			<button class="btn-default btn-lg"><a href="sign">Get a Design</a></button>
				 			</div>
				 		</div>
		 			</div>
			</div>
	</div>
<div>

<!-- Services -->
	<div class="container services">
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
								<a href="more_product.php?product_id=<?=$product_id?>">Description</a>
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

<!-- About us -->
	
		<section class="our-facts" id="about_us">
		    <div class="container">
		      <div class="row">
		        <div class="col-lg-12">
		          <div class="row">
		            <div class="col-lg-12">
		              <h3 class="dims_head" >A Few Facts About Our System</h3>
		            </div>
		            <div class="col-lg-12">
		              <div class="row">
		                <div class="col-md-4">
		                  <div class="count-area-content">
		                    <div class="count-digit"><?=$shop_registered_total?></div>
		                    <div class="count-title">Total Clients</div>
		                  </div>
		                </div>
		                <div class="col-md-4">
		                  <div class="count-area-content percentage">
		                    <div class="count-digit">
		                    <?php

		                    $svt = $shop_verified_total / 100 *2 ;
		                    echo $svt;
		                    ?></div>
		                    <div class="count-title">Percent Verified</div>
		                  </div>
		                </div>
		                <div class="col-md-4">
		                  <div class="count-area-content">
		                    <div class="count-digit"><?=$shop_verified_total?></div>
		                    <div class="count-title">Total Verified</div>
		                  </div>
		                </div>
		            </div>
		          </div>
		        </div> 
		      </div>
		    </div>
		</section>

<!-- Contact Us -->

<section class="contact-us" id="contact">
    <div class="container">
      <div class="row contact">
        <div class="col-lg-9 align-self-center">
          <div class="row">
            <div class="col-lg-12">
              <form class="form-horizontal" action="" method="POST">
  <div class="form-group">
    <p id="connect" style="font-weight: bold; font-size: 18px;">LET'S CONNECT</p>
    <p><?php if (isset($message)) {echo $message;}?></p>
    <div class="row">
      <div class="col-md-6">
        <label for="inputName" class="control-label">Your Name</label>
        <input type="text" class="form-control" id="inputName" placeholder="Your Name" name="name" required>
      </div>
      <div class="col-md-6">
        <label for="inputEmail" class="control-label">Email</label>
        <input type="email" class="form-control" id="inputEmail" placeholder="abc@gmail.com" name="email" required>
      </div>
    </div>
  </div>
  
  <div class="form-group">
    <label for="feedbackCategory" class="control-label">Feedback Category</label>
    <select class="form-control" id="feedbackCategory" name="category" required>
      <option disabled selected value="">Select a Category</option>
      <option value="Comment">Comment</option>
      <option value="Suggestion">Suggestion</option>
      <option value="Observation">Observation</option>
    </select>
  </div>
  
  <div class="form-group">
    <label for="feedbackMessage" class="control-label">Your Feedback</label>
    <textarea class="form-control" id="feedbackMessage" rows="3" placeholder="Please provide your feedback" name="message" required></textarea>
  </div>
  
  <div class="form-group">
    <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
  </div>
</form>

            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="right-info">
            <ul>
              <li>
                <h6>Phone Number</h6>
                <span>010-020-0340</span>
              </li>
              <li>
                <h6>Email Address</h6>
                <span>Dims@email.com</span>
              </li>
              <li>
                <h6>Street Address</h6>
                <span>No. 1234, ABCD Kano- Nigeria</span>
              </li>
              <li>
                <h6>Website URL</h6>
                <span>www.dims.ng</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

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