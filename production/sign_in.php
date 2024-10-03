<?php
// Start the session
session_start();

// Database connection
$db = mysqli_connect("localhost", "root", "", "dicms");

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_or_phone = mysqli_real_escape_string($db, $_POST['Email_or_phone']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Query to check if the user exists with the provided email or phone
    $query = "SELECT id, first_name, last_name, middle_name, gender, passport, dob, email, phone_number, password 
              FROM ceo_profiles 
              WHERE email = ? OR phone_number = ?";

    // Prepare the SQL query
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $email_or_phone, $email_or_phone);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Check if a row is returned
    if (mysqli_num_rows($result) == 1) {
        // Fetch the user's details
        $user = mysqli_fetch_assoc($result);

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['middle_name'] = $user['middle_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone_number'] = $user['phone_number'];
            $_SESSION['passport'] = $user['passport'];

            // Redirect to a dashboard or welcome page
            header("Location: plain_page.php");
            exit();
        } else {
            // Invalid password
            $message = "<p style='color:red;'>Invalid password</p>";
        }
    } else {
        // Invalid email or phone number
        $message = "<p style='color:red;'>Invalid email or phone number</p>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($db);
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
		</nav>

	<!-- Login -->
	<div class="container">
		<div class="row" id="Register">
			<form action="" method="POST">
				<?php
					if (isset($message)) {
						echo $message;
					}
				?>
			    <div class="sign_up_head">
			        <h2 id="sign_up_reg">Sign in</h2>
			    </div>
			    <div class="sign_up_content">
			        <div class="row">
			            <div class="col-lg-12"> 
			                <div class="form-group">
			                    <input type="email" name="Email_or_phone" class="form-control" placeholder="Email or Phone" required> 
			                </div>
			            </div>
			        </div>
			        <div class="row">
			            <div class="col-md-12">
			                <div class="form-group">
			                    <input type="password" name="password" class="form-control" placeholder="Password" required>
			                </div>
			            </div>  
			        </div>
			    </div>
			    <div class="col-lg-12">
			        <div class="f-pass">
			            <a href="reset.html">Forgot Password?</a>
			            <p id="plog"><i>By signing in, you agree to our <a href="terms.html">DICMS Terms and Conditions</a>. Please read our <a href="p&p.html">DICMS Privacy and Cookie Policy</a> for more details.</i></p>
			        </div>
			    </div>
			    <div class="row">
			        <div class="col-lg-12">
			            <button type="submit" class="btn btn-info" id="submit_btn">Sign In</button>
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