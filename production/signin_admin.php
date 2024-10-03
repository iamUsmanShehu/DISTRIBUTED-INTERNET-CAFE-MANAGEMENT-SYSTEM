<?php
// Start the session
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dicms";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['Email'];
    $password = $_POST['password'];

    // Prepare SQL query to check if user exists
    $sql = "SELECT id, first_name, last_name, image, email, password FROM admins WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['image'] = $user['image'];

            // Redirect user to a dashboard or homepage
            header("Location: admin.php");
            exit();
        } else {
            // Invalid password
            $message = "Invalid password!";
        }
    } else {
        // Invalid email
        $message = "Invalid email!";
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DISTRIBUTED INTERNET CAFE MANAGEMENT SYSTEM</title>
	<link rel="stylesheet" type="text/css" href="css\index.css">
	<link rel="stylesheet" type="text/css" href="css\sign up.css">
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" id="nbr">
	
	<?php include 'nav.php';?>
	<!-- <center><h1></h1></center> -->
	</nav>

	<!-- Login -->
	<div class="container">
		<div class="row" id="Register">
			
				<div class="col-md-6 img">
					<div class="img_container">
						<img src="pic/pic6.jpg">
					</div>
				</div>
			<div class="col-md-6">
				<div class="sign_up img_container" id="sign_up">
						<form action="" method="POST" enctype="multipart/form-data">
					    <div class="sign_up_head">
					        <h2 id="sign_up_reg">Administrator Login</h2>
					        <?php if (isset($message)) { echo $message; } ?>
					    </div>
					    <div class="sign_up_content">
					        <div class="row">
					            <div class="col-lg-12"> 
					                <div class="form-group">
					                    <input type="email" name="Email" class="form-control" placeholder="abc@email.com" required>
					                </div>
					            </div>
					        </div>
					        <div class="row">
					            <div class="col-md-12">
					                <div class="form-group">
					                    <input type="password" name="password" class="form-control" placeholder="password" required title="6 to 8 characters required" pattern=".{6,8}">
					                </div>
					            </div>
					        </div>
					    </div>
					    <div class="row">
					        <div class="col-lg-6">
					            <button type="submit" class="btn btn-info" id="submit_btn">Login</button>
					        </div>
					        <div class="col-lg-6">
					            <a href="signup_admin.php" class="btn" id="submit_btn">Sign Up</a>
					        </div>
					    </div>
					</form>

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
                      
          </div>

      </footer>
  </div>

<script src="https://code.jquery.com/jquery-2.1.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>