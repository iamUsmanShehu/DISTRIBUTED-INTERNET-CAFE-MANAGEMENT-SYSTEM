<?php
include 'conn.php';
include "fetch.php";

// Fetch data from feedback table
$sql = "SELECT id, name, email, category, message, submitted_at FROM feedback";
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

    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 18px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
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
                                      <h3>Customer Feedback</h3>
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

                              <table>
                                  <thead>
                                      <tr>
                                          <th>ID</th>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Category</th>
                                          <th>Message</th>
                                          <th>Submitted At</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                      if ($result->num_rows > 0) {
                                          // Output data of each row
                                          while ($row = $result->fetch_assoc()) {
                                              echo "<tr>";
                                              echo "<td>" . $row["id"] . "</td>";
                                              echo "<td>" . $row["name"] . "</td>";
                                              echo "<td>" . $row["email"] . "</td>";
                                              echo "<td>" . $row["category"] . "</td>";
                                              echo "<td>" . $row["message"] . "</td>";
                                              echo "<td>" . $row["submitted_at"] . "</td>";
                                              echo "</tr>";
                                          }
                                      } else {
                                          echo "<tr><td colspan='6'>No feedback found</td></tr>";
                                      }
                                      ?>
                                  </tbody>
                              </table>

                              <?php
                              // Close the connection
                              $conn->close();
                              ?>
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
