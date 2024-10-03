<?php

// Start the session
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

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}
// $ceo_id = $_SESSION['user_id'];
// SQL query to fetch data from shop_profiles
$sql = "SELECT `id`, `ceo_id`, `name`, `motto`, `address`, `email`, `phone_number`, `rc_number`, `verify`, `logo`, `banner`, `created_at` FROM `shop_profiles` WHERE id=$id";
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
    <style type="text/css">
      .avata{
        height: 50%;
        width: 60%;
        border-radius: 150px;
      }
      .col-form-label span{
        padding-left: px;
      }
      .banner{
        width: 100%;
        height: 200px;
      }
    </style>
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
              <?php
                // Loop through the result and display in table rows
                while($row = $result->fetch_assoc()) {
                   
                    $shop_name = $row['name'];
                    $shop_address = $row['address'];
                    $shop_motto =$row['motto'];
                    $shop_email = $row['email'];
                    $id = $row['id'];
                    $ceo_id = $row['ceo_id'];
                    $shop_phone_number = $row['phone_number'];
                    $rc_number = $row['rc_number'];
                    $logo = $row['logo'];
                    $banner = $row['banner'];
                    $shop_created_at = $row['created_at'];
                    $shop_id = $row['id'];

                    $verify = $row['verify'];
                    if ($verify == 1) {
                      $verify = 'Verified';
                    }
                    if ($verify == 0) {
                      $verify = 'Not Verified';
                    }
                    if ($verify == 2) {
                      $verify = 'Suspended';
                    }
                }
            ?>
            <?php
                // Ensure you are using the proper database connection
                $ceo_id = (int) $ceo_id;  // Sanitizing the $ceo_id to prevent SQL injection (assuming $ceo_id is an integer)

                // SQL query to fetch CEO profile data based on ceo_id
                $sql_ceo = "SELECT `id`, `first_name`, `last_name`, `middle_name`, `gender`, `passport`, `dob`, `email`, `password`, 
                            `phone_number`, `address`, `state_of_origin`, `lga_of_origin`, `identification_type`, 
                            `identification_file`, `submission_date` 
                            FROM `ceo_profiles` 
                            WHERE id=$ceo_id";

                // Execute the query and check if it succeeded
                $fetched = $conn->query($sql_ceo);

                if ($fetched && $fetched->num_rows > 0) {
                    // Loop through the result and assign values to variables
                    while ($fetch = $fetched->fetch_assoc()) {
                        $fetch_id = $fetch['id'];
                        $first_name = $fetch['first_name'] ?? 'Not Available';
                        $last_name = $fetch['last_name'] ?? 'Not Available';
                        $middle_name = $fetch['middle_name'] ?? 'Not Available';
                        $gender = $fetch['gender'] ?? 'Not Available';
                        $passport = $fetch['passport'] ?? 'Not Available'; // Assuming this is an image path
                        $dob = $fetch['dob'] ?? 'Not Available';
                        $email = $fetch['email'] ?? 'Not Available';
                        $password = $fetch['password'] ?? 'Not Available';
                        $phone_number = $fetch['phone_number'] ?? 'Not Available';
                        $address = $fetch['address'] ?? 'Not Available';
                        $state_of_origin = $fetch['state_of_origin'] ?? 'Not Available';
                        $lga_of_origin = $fetch['lga_of_origin'] ?? 'Not Available';
                        $identification_type = $fetch['identification_type'] ?? 'Not Available';
                        $identification_file = $fetch['identification_file'] ?? 'Not Available'; // Assuming this is a file path
                        $submission_date = $fetch['submission_date'] ?? 'Not Available';
                    }
                } else {
                    echo "No CEO profile found for the provided ID.";
                }
                ?>

            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3  profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          <img class="img-responsive avatar-view" src="uploads/<?=$logo?>"  alt="Avatar" title="Change the avatar" style='width: 100%;'>
                        </div>
                      </div>
                      <h3><?=$shop_name?></h3>

                      <ul class="list-unstyled user_data">
                        <li><i class="fa fa-map-marker user-profile-icon"></i> <?=$shop_address?>
                        </li>

                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> <?=$shop_motto?>
                        </li>

                        <li class="m-top-xs">
                          <i class="fa fa-external-link user-profile-icon"></i>
                          <a href="#" target="_blank"><?=$shop_email?></a>
                        </li>
                      </ul>

                      <!-- start skills -->
                      <h4>Services</h4>
                      <ul class="list-unstyled user_data">
                        <?php

                          // SQL query to fetch data from the products table
                          $sql = "SELECT `id`, `name`, `description`, `image`, `shop_id`, `ceo_id`, `created_at` FROM `products`WHERE shop_id = $id";
                          $result = $conn->query($sql);

                          // Check if there are any records
                          if ($result->num_rows > 0) {
                              // Loop through the result and display the product details
                              while ($row = $result->fetch_assoc()) {
                                  $id = $row['id'];
                                  $name = $row['name'];
                                  $description = $row['description'];
                                  $image = $row['image'];
                                  $shop_id = $row['shop_id'];
                                  $ceo_id = $row['ceo_id'];
                                  $created_at = $row['created_at'];?>
                                  <li>
                                    <p><?=$name?></p>
                                    <div class="progress progress_sm">
                                      <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="90"></div>
                                    </div>
                                  </li>
                                  <?php
                              }
                          } else {
                              echo "No products found.";
                          }

                        ?>
                        
                      </ul>
                      <!-- end of skills -->

                    </div>
                    <div class="col-md-9 col-sm-9 ">
                      <?php if ($verify == "Suspended"):?>
                                            <span class="badge badge-danger">Account Has Been Suspended</span>
                                          <?php endif;?>
                      <!-- start of user-activity-graph -->
                      <!-- end of user-activity-graph -->
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">CEO Profile</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Shop Profile</a>
                          </li>
                          <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Action</a>
                          </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                          <div role="tabpanel" class="tab-pane active " id="tab_content1" aria-labelledby="home-tab">

            
                            <!-- start recent activity -->
                            <ul class="messages">
                              <li>
                                <div class="container">
                                  <div class="row">  
                                    <div class="col-md-4">
                                      <img src="uploads/<?=$passport?>" class="avata" alt="Avatar">
                                    </div> 
                                    <div class="col-md-8">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Full Name:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$first_name.' '. $last_name?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Gender:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$gender?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Date of Birth:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$dob?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Email:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$email?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Phone Number:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?$phone_number?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Address:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?$Address?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">State of Origin:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$state_of_origin?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">LGA of Origin:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span> <?=$lga_of_origin?> </span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </li>
                            </ul>
                            <!-- end recent activity -->
                            <!-- 
                              
                             -->
                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <!-- start user projects -->
                            <ul class="messages">
                              <li>
                                <div class="container">
                                  <div class="row">  
                                    <div class="col-md-12">
                                      <img src="uploads/<?=$banner?>" class="banner" alt="Avatar">
                                    </div> 
                                  <div class="row">
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Shop Name:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$shop_name?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Motto:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$shop_motto?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Address:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$shop_address?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Email:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$shop_email?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Phone Number:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$shop_phone_number?></span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">RC Number:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span><?=$rc_number?></span>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                              </li>
                            </ul>
                            <!-- end user projects -->

                          </div>
                          <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                              <ul class="messages">
                              <li>
                                <div class="container"> 
                                  <div class="row">
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Payment Status:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span> Paid </span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Payment Reciept:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <span> <button class="btn btn-info">View</button> </span>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">Means of ID:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <a href="view_idcard.php?id=<?=$fetch_id?>" class="btn btn-info">View</a>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-4">
                                            <label class="col-form-label">CAC Certificate:</label>
                                          </div>
                                          <div class="col-md-8">
                                            <button class="btn btn-info">View</button>
                                          </div>
                                        </div>
                                        <div class="col-md-12">
                                          <div class="col-md-8"></div>
                                          <div class="col-md-4">
                                          <?php if ($verify == "Not Verified" OR $verify == "Suspended"):?>
                                            <a href="approve.php?id=<?=$shop_id?>" class="btn btn-success">Verify</a>
                                          <?php endif;?>
                                          <?php if ($verify == "Verified"):?>
                                            <a href="revock_approvement.php?id=<?=$shop_id?>" type="submit" class="btn btn-warning">Revock Approvement</a>
                                          <?php endif;?>
                                          <?php if ($verify != "Suspended"):?>
                                            <a href="suspend-shop.php?id=<?=$shop_id?>" type="submit" class="btn btn-danger">Suspend Shop</a>
                                          <?php endif;?>
                                          <?php if ($verify == "Suspended"):?>
                                            <span class="badge badge-danger">Account Has Been Suspended</span>
                                          <?php endif;?>
                                          </div>
                                        </div>
                                        </div>  
                                      </div>
                                </div>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
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
            <p>copyright &copy;DICMS 2024</p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
   <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- morris.js -->
    <script src="../vendors/raphael/raphael.min.js"></script>
    <script src="../vendors/morris.js/morris.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

  </body>
</html>