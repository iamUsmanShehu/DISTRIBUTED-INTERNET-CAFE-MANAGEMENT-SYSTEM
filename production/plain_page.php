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
$ceo_id = $_SESSION['user_id'];
include 'fetch.php';
// Fetch products from the database
$query = "SELECT id, name, description, image, shop_id, ceo_id, created_at FROM products WHERE ceo_id = $ceo_id";


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
            <div class="page-title">
              <div class="title_left">
                <h3>Dashboard</h3>
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
                                  <div class="row">
                                    <div class="col-md-6">
                                      <div class="count-area-content">
                                        <div class="count-digit"><?=$messages_total?></div>
                                        <div class="count-title">Total Messages</div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="count-area-content">
                                        <div class="count-digit"><?=$products_counter_total?></div>
                                        <div class="count-title">Registered Product</div>
                                      </div>
                                    </div>
                                   
                                </div>
                              </div>
                            </div> 
                          </div>
                        </div>
                    </section>
                  </div>
                </div>

              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 class="dims_head">Manage Product</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <!-- start project list -->
                    <table class="table table-striped projects">
                      <thead>
                        <tr>
                          <th style="width: 1%">S/N</th>
                          <th style="width: 20%">Product Name</th>
                          <th>Product Description</th>
                          <th>Product Image</th>
                          <th style="width: 25%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>

                         <?php 
                         $result = mysqli_query($conn, $query);

                          if (mysqli_num_rows($result) > 0) {
                              // Store products in an array
                              $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
                          } else {
                              echo "No products found.";
                          }
                         if (!empty($products)): ?>
                        <?php $i=1; foreach ($products as $product): ?>
        
                        <tr>
                          <td><?=$i++?></td>
                          <td>
                            <p><?php echo $product['name']; ?></p>
                          </td>
                          <td>
                            <p><?php echo $product['description']; ?></p>
                          </td>
                          <td class="project_progress">
                            <img src="uploads/<?php echo $product['image']; ?>" width='150'>
                          </td>
                          <td>
                            <a href="edit_product.php?id=<?php echo $product['id']; ?>"  class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                            <a href="delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete </a>
                          </td>
                        </tr>

                      <?php endforeach; ?>
                  <?php endif; ?>
                        
                        
                      </tbody>
                    </table>
                    <!-- end project list -->

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
