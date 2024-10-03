<?php
include 'conn.php';
include "fetch.php";
// SQL query to fetch data from shop_profiles
$sql = "SELECT `id`, `ceo_id`, `name`, `motto`, `address`, `email`, `phone_number`, `rc_number`, `verify`, `logo`, `banner`, `created_at` FROM `shop_profiles` WHERE verify = 1";
$result2 = $conn->query($sql);


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

            <?php include 'admin_side_top_bar.php';?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                  <div class="x_content">
                      <section class="our-facts">
                        <div class="container">
                          <div class="row">
                            <div class="col-lg-12">
                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="page-title">
                                    <div class="title_left">
                                      <h3>Verified Accounts</h3>
                                    </div>
                                    <div class="title_right">
                                      <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                                        <div class="input-group">
                                          <input type="text" class="form-control" placeholder="Search for...">
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Go!</button>
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <!-- <h2 class="dims_head">A Few Facts About Our System</h2> -->
                                </div>
                            </div> 
                          </div>
                        </div><hr>
                        <div class="row">
                          <div class="col-md-12">
                            <table class="table table-striped projects">
                              <thead>
                                <tr>
                                  <th style="width: 1%">S/N</th>
                                  <th style="width: 1%">Shop Logo</th>
                                  <th>Shop Title</th>
                                  <th>Status</th>
                                  <th style="width: 25%">Actions</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                            // Check if the query returned any result2s
                            if ($result2->num_rows > 0) {
                                // Loop through the result2 and display in table rows
                                while($row = $result2->fetch_assoc()) {
                                   $verify = $row['verify'];
                                    if ($verify == 1) {
                                      $verify = '<label class="badge badge-success">Verified';
                                    }
                                    if ($verify == 0) {
                                      $verify = '<label class="badge badge-warning">Not Verified';
                                    }
                                    if ($verify == 2) {
                                      $verify = '<label class="badge badge-danger">Suspended';
                                    }
                            ?>
                        <tr>
                          <td>1</td>
                          <td>
                            <img src="uploads/<?=$row['logo']?>" alt="Product Image" width="100px" height="80px">
                          </td>
                          <td>
                            <p><?=$row['name']?></p>
                          </td>
                          <td class="project_progress">
                             <p><strong> <i> <?=$verify?> </i> </strong> </p>
                          </td>
                          <td>
                            <a href="profile.php?id=<?=$row['id']?>" class="btn btn-primary btn-sm"><i class="fa fa-folder"></i> View </a>
                          </td>
                        </tr>
                        <?php
                           }
            } else {
                echo "<tr><td colspan='12'>No records found</td></tr>";
            }
            ?>
                        
                      </tbody>
                    </table>
                          </div>
                        </div>
                        
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
            <p>copyright &copy;DICMS 2024</p>
            <!-- <p>Distributed Internet Cafe Management System</p> -->
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
    
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>
