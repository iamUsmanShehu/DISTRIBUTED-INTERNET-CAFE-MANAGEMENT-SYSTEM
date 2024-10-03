<?php
include 'conn.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $shop_id = mysqli_real_escape_string($conn, $_POST['shop_id']);
    $ceo_id = $_SESSION['user_id']; 

    // File upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // Upload the image to the "uploads" folder
    move_uploaded_file($image_tmp, "uploads/" . $image);

    // Insert data into the "products" table
    $sql = "INSERT INTO products (name, description, image, shop_id, ceo_id) 
            VALUES ('$product_name', '$description', '$image', '$shop_id', '$ceo_id')";

    if (mysqli_query($conn, $sql)) {
        $message = "New product added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close connection
// mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Distributed Internet Cafe Management System</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- External CSS for dashboard -->
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container" id="new_side_navbar">
        <div class="col-md-3 left_col" id="new_side_navbar">
          <div class="left_col scroll-view" id="new_side_navbar">
            
            <!-- Profile Info -->
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
            <!-- /Profile Info -->

            <!-- Sidebar Menu -->
            <?php include "ceo_sidebar.php"; ?>
          </div>
        </div>

        <!-- Top Navigation -->
      <?php include 'ceo_nav.php'; ?>
        <!-- /Top Navigation -->

        <!-- Page Content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2 class="dims_head">Add Product</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <!-- Product Form -->
                    <form method="post" enctype="multipart/form-data">
                      <?php 
                        if (isset($message)) { echo $message . "<br>"; }
                      ?>
                      <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Product Name<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                          <input class="form-control" type="text" name="product_name" required />
                        </div>
                      </div>

                      <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Description<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                          <input class="form-control" type="text" name="description" required />
                        </div>
                      </div>

                      <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Shop<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                          <select class="form-control" name="shop_id" required>
                            <option value="">Select Shop</option>
                            <!-- Populate shops dynamically using PHP -->
                            <?php
                            $ceo_id = $_SESSION['user_id'];
                            $sql = "SELECT id, name FROM shop_profiles WHERE ceo_id = $ceo_id";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)):?>
                              <option value='<?=$row['id']?>'><?=$row['name']?></option>";
                            <?php endwhile;?>

                          </select>
                        </div>
                      </div>

                      <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Product Image<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                          <input class="form-control" type="file" name="image" required />
                        </div>
                      </div>

                      <div class="ln_solid">
                        <div class="form-group">
                          <div class="col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                          </div>
                        </div>
                      </div>
                    </form>
                    <!-- /Product Form -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /Page Content -->

        <!-- Footer Content -->
        <footer>
          <div class="pull-right">
            <p>Distributed Internet Cafe Management System</p>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /Footer Content -->
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
