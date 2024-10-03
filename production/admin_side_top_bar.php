<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dicms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// SQL query to fetch data from the messages table
$sql_message = "SELECT `id`, `user_id`, `title`, `message`, `status`, `created_at` FROM `messages` WHERE status = 1";
$result_message = $conn->query($sql_message);

?>


<div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="<?=$_SESSION['image']?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome!</span>
                <!-- <h2>Admin Dashboard</h2> -->
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <!-- <h3>General</h3> -->
                <ul class="nav side-menu">
                  <li><a href="admin.php" class="active"><i class="fa fa-home"></i> Dashboard</a>
                  </li>
                  <li><a><i class="fa fa-area-chart"></i>System Report <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="registered-account.php"><i class="fa fa-plus"></i>Clients</a></li>
                      <li><a href="verified-account.php"><i class="fa fa-unlock"></i>Verified Account</a></li>
                      <li><a href="pending-account.php"><i class="fa fa-edit"></i>Pending Account</a></li>
                      <li><a href="suspended-account.php"><i class="fa fa-lock"></i>Suspended Account</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-folder-open"></i>Feed Back<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="#"><i class="fa fa-users"></i>Users</a></li>
                      <li><a href="customer-feedback.php"><i class="fa fa-users"></i>Customer</a></li>
                    </ul>
                  </li>
                  <li><a href="admin_change_password.php"><i class="fa fa-pencil"></i> Change Password</a></li>
                  <li><a href="messages.php"><i class="fa fa-envelope-o"></i> Messages</a></li>
                  <li><a href="logout.php"><i class="fa fa-sign-out pull-left"></i> Logout</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <ul class=" navbar-right">
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                      <img src="<?=$_SESSION['image']?>" alt=""><?=$_SESSION['first_name'] . ' '.$_SESSION['last_name']?>
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      <a href="admin_profile.php" class="dropdown-item"  href="#"> Profile</a>
                      <a class="dropdown-item"  href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </div>
                  </li>
                  <li role="presentation" class="nav-item dropdown open">
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-envelope-o"></i>
                      <?php if ($messages_id_total):?>
                        <span class="badge bg-red"><?=$messages_id_total?></span>
                      <?php endif;?>
                    </a>
                    <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                     
                      <li class="nav-item">
                          <?php
                            // Check if there are any records
                              if ($result_message->num_rows > 0) {
                                  // Loop through the result_message and display the messages
                                  while ($row = $result_message->fetch_assoc()) {
                                      $id = $row['id'];
                                      $user_id = $row['user_id'];
                                      $title = $row['title'];
                                      $message = $row['message'];
                                      $status = $row['status'];
                                      $created_at = $row['created_at'];?>

                        <a href="view_message.php?id=<?=$id?>" class="dropdown-item">
                         <!-- <span class="image"><img src="images/pic.png" alt="Profile Image" /></span> -->
                          <span>
                            <span><?=$title?></span>
                            <span class="time"><?=$created_at?> mins ago</span>
                          </span>
                          <span class="message">
                            <?=$message?>
                          </span>
                        </a>             
                           <?php   }
                              } else {
                                  echo "No new messages.";
                              }
                            ?>
                          
                      </li>
                      <li class="nav-item">
                        <div class="text-center">
                          <a class="dropdown-item" href="messages.php">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                          </a>
                        </div>
                      </li>
                    </ul>
                    <li class="nav-item">
                      <a href="javascript:;" aria-haspopup="true" data-toggle="dropdown" aria-expanded="false">      
                      </a>
                    </li>
                  </li>
                  <!-- <strong> Status: <label class="badge badge-info"><i> Verified </i> </strong>  -->
                </ul>
              </nav>
            </div>
          </div>