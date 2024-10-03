<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['First_Name'];
    $last_name = $_POST['Last_Name'];
    $phone_number = $_POST['Phone_number'];
    $email = $_POST['Email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['password']; // Assuming both password fields have the same name

    // Validate if passwords match
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email or phone number already exists in the database
    $check_query = "SELECT id FROM admins WHERE email = ? OR phone_number = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $email, $phone_number);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // If a record with the same email or phone number exists
        $message = "Email or Phone number already registered!";
    } else {
        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "uploads/"; // Directory to save the uploaded image
            $image_name = basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $image_name;

            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Insert data into the database
                $insert_query = "INSERT INTO admins (first_name, last_name, phone_number, image, email, password) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insert_query);
                $stmt->bind_param("ssssss", $first_name, $last_name, $phone_number, $target_file, $email, $hashed_password);

                if ($stmt->execute()) {
                    $message = "Registration successful!";
                    header("refresh:2; url='signin_admin.php'");
                } else {
                    $message = "Error: " . $stmt->error;
                }
            } else {
                $message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $message = "Please upload a valid image.";
        }
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
	<div id="head_title">
		<div class="container">
			<p>DISTRIBUTED INTERNET CAFE MANAGEMENT SYSTEM</p>
		</div>
	</div>
	<center><h1>Register New Administrator</h1></center>
	</nav>

	<!-- Login -->
	<div class="container">
		<div class="row" id="Register">
			<form>
				<div class="col-md-6 img">
					<div class="img_container">
						<img src="pic/pic6.jpg">
					</div>
				</div>
			</form>
			<div class="col-md-6">
				<div class="sign_up img_container" id="sign_up">
						<form action="" method="POST" enctype="multipart/form-data">
							<div class="sign_up_head">
								<h2 id="sign_up_reg">Register</h2>
								<?php if (isset($message)) {echo $message;}?>
							</div>
							<div class="sign_up_content">
								<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" name="First_Name" class="form-control" placeholder="First name" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" name="Last_Name" class="form-control" placeholder="Last name" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<input type="number" name="Phone number" class="form-control" placeholder="+234 156 7890" required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="file" name="image" class="form-control" required>
									</div>
								</div>
							</div>
							<div class="row">
									<div class="col-lg-12"> 
										<div class="form-group">
											<input type="email" name="Email" class="form-control" placeholder="abc@email.com" required>
										</div>
									</div>
							</div>
							<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="password" name="password" class="form-control" placeholder="password" required required title="6 to 8 charachter required" pattern=".{6,8}">
										</div>
									</div>	
									<div class="col-md-6">
										<div class="form-group">
											<input type="password" name="password" class="form-control" placeholder="Confirm Password" required required title="6 to 8 charachter required" pattern=".{6,8}">
										</div>
									</div>
								</div>
							</div>
								<div class="row">
									<div class="col-lg-6">
										<button type="submit" class="btn btn-info" id="submit_btn">Sign Up</button>
									</div>
									<div class="col-lg-6">
										<a href="signin_admin.php" class="btn" id="submit_btn">Sign In</a>
									</div>
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