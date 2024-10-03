<?php
// Start session
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dicms";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
include 'fetch.php';
$sql = "UPDATE `messages` SET `status` = 1 WHERE `id` = ?";

    // Prepare and bind parameters to avoid SQL injection
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);

        // Execute the update query
        if (mysqli_stmt_execute($stmt)) {

      }
    }
// SQL query to fetch data from the messages table
$sql = "SELECT `id`, `user_id`, `title`, `message`, `status`, `created_at` FROM `messages` WHERE id=$id";
$result = $conn->query($sql);

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
                                    <h2 class="dims_head">View Message</h2>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                  <?php 
                                    if ($result->num_rows > 0) {
                                      // Loop through the result and display the messages
                                      while ($row = $result->fetch_assoc()) {
                                          $id = $row['id'];
                                          $user_id = $row['user_id'];
                                          $title = $row['title'];
                                          $message = $row['message'];
                                          $status = $row['status'];
                                          $created_at = $row['created_at'];

                                          // Display the message details
                                          echo "<div>";
                                          echo "<h3>Message ID: $id</h3>";
                                          echo "<p>Title: $title</p>";
                                          echo "<p>Message: $message</p>";
                                          echo "<p>Status: $status</p>";
                                          echo "<p>Created At: $created_at</p>";
                                          echo "</div><hr>";
                                      }
                                  } else {
                                      echo "No messages found.";
                                  }
                                  ?>
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
