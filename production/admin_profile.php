<?php
// Start session
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dicms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
include 'fetch.php';
// SQL query to fetch data from the messages table
$sql = "SELECT `id`, `user_id`, `title`, `message`, `status`, `created_at` FROM `messages`";
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
                                    <h2 class="dims_head">Profile</h2>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <?php
                                   $sql = "SELECT `id`, `first_name`, `last_name`, `phone_number`, `image`, `email`, `password`, `created_at` FROM `admins`";
                                    $result = $conn->query($sql);

                                    // Check if there are any records
                                    if ($result->num_rows > 0) {
                                        // Loop through the result and display admin details
                                        while ($row = $result->fetch_assoc()) {
                                            $id = $row['id'];
                                            $first_name = $row['first_name'];
                                            $last_name = $row['last_name'];
                                            $phone_number = $row['phone_number'];
                                            $image = $row['image'];
                                            $email = $row['email'];
                                            $password = $row['password'];
                                            $created_at = $row['created_at'];

                                            // Display the admin details
                                            echo "<div>";
                                            echo "<h3>Admin ID: $id</h3>";
                                            echo "<p>First Name: $first_name</p>";
                                            echo "<p>Last Name: $last_name</p>";
                                            echo "<p>Phone Number: $phone_number</p>";
                                            echo "<p>Email: $email</p>";
                                            echo "<p>Created At: $created_at</p>";
                                            echo "<img src='$image' alt='$first_name $last_name' width='100' height='100'>";
                                            echo "</div><hr>";
                                        }
                                    } else {
                                        echo "No admins found.";
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
