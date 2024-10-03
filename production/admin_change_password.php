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

  include 'fetch.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $user_id = $_SESSION['user_id']; // Assuming user is logged in and user_id is stored in session
    $old_password = $_POST['password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['password2'];

    // Check if new password and confirmation match
    if ($new_password !== $confirm_password) {
        $message = "New password and confirm password do not match!";
    } else {
        // Fetch user data from the database
        $sql = "SELECT password FROM admins WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify old password
        if (password_verify($old_password, $user['password'])) {
            // Hash new password
            $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password in the database
            $sql = "UPDATE admins SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $new_password_hashed, $user_id);

            if ($stmt->execute()) {
                $message = "Password updated successfully!";
            } else {
                $message = "Failed to update password!";
            }
        } else {
            // Old password is incorrect
            $message = "Old password is incorrect!";
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administrator</title>

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

            <?php include 'admin_side_top_bar.php';?>
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
                                    <?php if (!empty($message)) { echo "<p>$message</p>"; } ?>
                                </div>
                                <div class="x_content">
                                    <form action="" method="post" novalidate>
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
