<?php
session_start();
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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must log in first.";
    exit();
}

// Get the current CEO ID from the session
$ceo_id = $_SESSION['user_id'];

// Fetch the current password from the database
$query = "SELECT password FROM ceo_profiles WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $ceo_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$ceo = mysqli_fetch_assoc($result);

$errors = [];

if ($_POST) {
    $old_password = $_POST['password'];  // This should match the input name in the form
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['password2'];

    // Verify the old password against the stored hashed password
    if (password_verify($old_password, $ceo['password'])) {
        if ($new_password === $confirm_password) {
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Prepare the update query
            $updateQuery = "UPDATE ceo_profiles SET password = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, 'si', $new_password_hashed, $ceo_id);

            if (mysqli_stmt_execute($stmt)) {
                echo "Password updated successfully.";
            } else {
                $errors[] = "Failed to update the password: " . mysqli_error($conn);
            }
        } else {
            $errors[] = "New password and confirm password do not match.";
        }
    } else {
        $errors[] = "Old password is incorrect.";
    }
}


// Close database connection
// mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Distributed Internet Cafe Management System </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- External CSS for dashboard -->
    <link rel="stylesheet" type="text/css" href="css\dashboard.css">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

<body class="nav-md">
    <div class="container body">
      <div class="main_container" id="new_side_navbar">
        <div class="col-md-3 left_col" id="new_side_navbar">
          <div class="left_col scroll-view" id="new_side_navbar">
           <!--  <div class="navbar nav_title" style="border: 0;" id="new_side_navbar">
              <a href="index.html" class="site_title"> <span> DICMS </span> </a>
            </div> -->

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/pic.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome!</span>
                <h2><?php if (isset($shop_name)) {echo $shop_name;}?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            
            <?php include "ceo_sidebar.php"; ?>
          </div>
        </div>

        <!-- top navigation -->
      <?php include 'ceo_nav.php'; ?>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2 class="dims_head">Change Password</h2>

                                    <div class="clearfix"></div>
                                    <?php
                                      if (!empty($errors)) {
                                          foreach ($errors as $error) {
                                              echo "<div class='alert alert-danger'>$error</div>";
                                          }
                                      }
                                      ?>
                                </div>
                                <div class="x_content">
                                    <form action="change_password.php" method="post" novalidate>
                                      <div class="field item form-group">
                                          <label class="col-form-label col-md-3 col-sm-3  label-align">Old Password<span class="required">*</span></label>
                                          <div class="col-md-6 col-sm-6">
                                              <input class="form-control" type="password" id="old_password" name="password" required />
                                          </div>
                                      </div>
                                      <div class="field item form-group">
                                          <label class="col-form-label col-md-3 col-sm-3  label-align">New Password<span class="required">*</span></label>
                                          <div class="col-md-6 col-sm-6">
                                              <input class="form-control" type="password" id="password1" name="new_password"  required />
                                              <span style="position: absolute;right:15px;top:7px;" onclick="hideshow()" >
                                                  <i id="slash" class="fa fa-eye-slash"></i>
                                                  <i id="eye" class="fa fa-eye"></i>
                                              </span>
                                          </div>
                                      </div>

                                      <div class="field item form-group">
                                          <label class="col-form-label col-md-3 col-sm-3  label-align">Repeat password<span class="required">*</span></label>
                                          <div class="col-md-6 col-sm-6">
                                              <input class="form-control" type="password" name="password2" data-validate-linked='new_password' required />
                                          </div>
                                      </div>

                                      <div class="ln_solid">
                                          <div class="form-group">
                                              <div class="col-md-6 offset-md-3">
                                                  <button type="submit" class="btn btn-success">Update</button>
                                                  <button type="reset" class="btn btn-danger">Reset</button>
                                              </div>
                                          </div>
                                      </div>
                                  </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    <p>Distributed Internet Cafe Management System</p>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../vendors/validator/multifield.js"></script>
    <script src="../vendors/validator/validator.js"></script>
    
    <!-- Javascript functions	-->
	<script>
		function hideshow(){
			var password = document.getElementById("password1");
			var slash = document.getElementById("slash");
			var eye = document.getElementById("eye");
			
			if(password.type === 'password'){
				password.type = "text";
				slash.style.display = "block";
				eye.style.display = "none";
			}
			else{
				password.type = "password";
				slash.style.display = "none";
				eye.style.display = "block";
			}

		}
        // initialize a validator instance from the "FormValidator" constructor.
        // A "<form>" element is optionally passed as an argument, but is not a must
        var validator = new FormValidator({
            "events": ['blur', 'input', 'change']
        }, document.forms[0]);
        // on form "submit" event
        document.forms[0].onsubmit = function(e) {
            var submit = true,
                validatorResult = validator.checkAll(this);
            console.log(validatorResult);
            return !!validatorResult.valid;
        };
        // on form "reset" event
        document.forms[0].onreset = function(e) {
            validator.reset();
        };
        // stuff related ONLY for this demo page:
        $('.toggleValidationTooltips').change(function() {
            validator.settings.alerts = !this.checked;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);

      // Function to toggle password visibility
      function hideshow() {
          var password1 = document.getElementById('password1');
          var slash = document.getElementById('slash');
          var eye = document.getElementById('eye');
          
          if (password1.type === "password") {
              password1.type = "text";
              slash.style.display = "none";
              eye.style.display = "block";
          } else {
              password1.type = "password";
              slash.style.display = "block";
              eye.style.display = "none";
          }
      }
</script>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- validator -->
    <!-- <script src="../vendors/validator/validator.js"></script> -->

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

</body>

</html>
