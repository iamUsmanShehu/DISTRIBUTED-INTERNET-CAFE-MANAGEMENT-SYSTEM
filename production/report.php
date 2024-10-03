<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: sign_in.html"); // Redirect to login if not authenticated
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "dicms");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

include 'fetch.php';
// Initialize an error message variable
$message = '';

// Process form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Get user ID from session
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $message_content = mysqli_real_escape_string($conn, $_POST['message']);

    // Check for empty fields
    if (!empty($title) && !empty($message_content)) {
        // Insert into messages table
        $query = "INSERT INTO messages (user_id, title, message) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iss', $user_id, $title, $message_content);

        if (mysqli_stmt_execute($stmt)) {
            $message = "<p style='color:green;'>Message submitted successfully!</p>";
        } else {
            $message = "<p style='color:red;'>Error: Could not submit the message.</p>";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        $message = "<p style='color:red;'>Please fill out all fields.</p>";
    }
}

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
                <img src="uploads/<?=$_SESSION['passport']?>" alt="..." class="img-circle profile_img">
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
                        <div class="col-md-4 col-sm-4">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2 class="dims_head">Report</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <form class="" action="" method="post" novalidate>
                                      <div class="field item form-group">
                                          <label class="col-form-label">Title<span class="required">*</span></label>
                                          <div>
                                              <input class="form-control" type="text" name="title" required />
                                          </div>
                                      </div>
                                      <div class="field item form-group">
                                          <label class="col-form-label">Message<span class="required">*</span></label>
                                          <div>
                                              <textarea class="form-control" rows="5" name="message" placeholder="Type Your message here..." required></textarea>
                                          </div>
                                      </div>
                                      <div class="ln_solid">
                                          <div class="form-group">
                                              <button type='submit' class="btn btn-success">Submit</button>
                                              <button type='reset' class="btn btn-danger">Reset</button>
                                          </div>
                                      </div>
                                  </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8">
                          <h2>History</h2>
                          <?php

                            // Fetch all messages
                            $query = "SELECT id, user_id, title, message, created_at FROM messages WHERE 1";
                            $result = mysqli_query($conn, $query);

                            // Check if any rows were returned
                            if (mysqli_num_rows($result) > 0) {
                                echo "<table border='1' cellpadding='10' class='table'>";
                                echo "<thead>";
                                echo "<tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Message Body</th>
                                        <th>Created At</th>
                                      </tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                // Loop through and output data from each row
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $i++ . "</td>";
                                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "</tr>";
                                }

                                echo "</tbody>";
                                echo "</table>";
                            } else {
                                echo "No messages found.";
                            }

                          ?>
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
