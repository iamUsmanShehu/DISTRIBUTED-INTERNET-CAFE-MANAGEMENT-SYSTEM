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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Paystack Payment</title>

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

    <script src="https://js.paystack.co/v1/inline.js"></script>
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
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_content">

                    <section class="content invoice">
                     
                      <div class="row">
                        <!-- /.col -->
                        <div class="col-md-12">
                         
                          <?php
                            $session_user = $_SESSION['user_id'];
                            // SQL query to fetch data from the payments table
                            $sql = "SELECT `id`, `user_id`, `reference`, `amount`, `status`, `created_at` FROM `payments` WHERE user_id = $session_user";
                            $result = $conn->query($sql);

                            // Check if there are any records
                            if ($result->num_rows > 0) {
                                // Loop through the result and display payment details
                              $i = 1;
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $user_id = $row['user_id'];
                                    $reference = $row['reference'];
                                    $amount = number_format($row['amount'], 2);
                                    $status = $row['status'];
                                    $created_at = $row['created_at'];

                                     echo "<center><div>
                                          <h3>Payment Reciept</h3>";
                                      echo "<p>Reference: $reference</p>";
                                      echo "<p>Amount: $amount</p>";
                                      echo "<p>Status: $status</p>";
                                      echo "<p>Created At: $created_at</p>";
                                      echo "</div></center><hr>";
                                }
                            } else {
                                echo "No payments found.";
                            }

                            // Close the connection
                            $conn->close();
                            ?>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      
                    </section>
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
  <script>
        function payWithPaystack() {
            const handler = PaystackPop.setup({
                key: 'pk_test_6890595463b6cd16c8b4320f1ed906db9864215d', // Replace with your public key
                email: document.getElementById('email-address').value,
                amount: document.getElementById('amount').value * 100, // Paystack works in kobo
                currency: 'NGN', // Currency
                callback: function(response) {
                    // Payment completed successfully
                    alert('Payment successful! Reference: ' + response.reference);
                    // Redirect to verify payment
                    window.location.href = 'verify_payment.php?reference=' + response.reference;
                },
                onClose: function() {
                    alert('Payment was not completed.');
                }
            });
            handler.openIframe(); // Open the Paystack payment modal
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

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>