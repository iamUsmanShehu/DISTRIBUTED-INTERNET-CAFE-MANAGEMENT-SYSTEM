<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "dicms"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products for shop_id=2
$shop_id = 2;
$productQuery = "SELECT id, name, description, image, shop_id, ceo_id, created_at FROM products WHERE shop_id=$shop_id";
$productResult = $conn->query($productQuery);

// Fetch CEO profiles
$ceoQuery = "SELECT id, first_name, last_name, middle_name, gender, passport, dob, email, phone_number, address FROM ceo_profiles";
$ceoResult = $conn->query($ceoQuery);

// Fetch shop profile for shop_id=2
$shopProfileQuery = "SELECT id, ceo_id, name, motto, address, email, phone_number, logo, banner FROM shop_profiles WHERE id=$shop_id";
$shopProfileResult = $conn->query($shopProfileQuery);

// Fetch shop and CEO information
$shopProfile = $shopProfileResult->fetch_assoc();
$ceoProfile = $ceoResult->fetch_assoc();
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
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
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
        <div class="col-lg-12">
          <img src="uploads/<?php echo $shopProfile['banner']; ?>" class="serv_img">
        </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <img class="shop_logo" src="uploads/<?php echo $shopProfile['logo']; ?>"  alt="Avatar" title="Change">
        <h3 class="shop_title"><?php echo $shopProfile['name']; ?></h3>
        <ul class="list-unstyled user_data" id="list_element">
          <li>
            <img src="uploads/<?php echo $ceoProfile['passport']; ?>" class="ceo_picture" style='width: 100%;'>
          </li>
          <li class="ceo_name">CEO: <?php echo $ceoProfile['first_name'] . ' ' . $ceoProfile['last_name']; ?></li>
          <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $shopProfile['address']; ?>
          </li>
          <li>
            <i class="fa fa-briefcase user-profile-icon"></i><?php echo $shopProfile['motto']; ?>
          </li>
          <li>
            <i class="fa fa-phone user-profile-icon"></i> <?php echo $shopProfile['phone_number']; ?>
          </li>
          <li class="m-top-xs">
            <i class="fa fa-external-link user-profile-icon"></i>
            <a href="#" target="_blank"><?php echo $shopProfile['email']; ?></a>
          </li>
        </ul>
      </div>
      <div class="col-md-8">
        <h3 class="product_title">List of Services</h3>
        <div class="row product_cont">
          <?php while($product = $productResult->fetch_assoc()): ?>
          <div class="col-md-4 col-sm-4">
            <div class="service_content product_content">
              <div class="service_name">
                <a href="#"><?php echo $product['name']; ?></a>
              </div>
              <div class="service_img">
                <img src="uploads/<?php echo $product['image']; ?>" class="serv_img">
              </div>
              <div class="service_shop_content">
                <p class="c-name"><span>Description:</span> <?php echo $product['description']; ?></p>
                <p class="c-name cname"><span>Contact</span>
                <p class="c-name cname"><?php echo $shopProfile['phone_number']; ?></p>
                <p class="c-name cname"><?php echo $shopProfile['email']; ?></p></p>
                <div class="service_more"> 
                  <a href="more_product.php?product_id=<?php echo $product['id']; ?>">More Info</a>
                </div>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
          <?php $conn->close(); ?>
        </div>
        
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