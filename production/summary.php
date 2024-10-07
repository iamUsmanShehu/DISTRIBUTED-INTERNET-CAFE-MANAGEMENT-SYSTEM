<?php
include 'conn.php';
include "fetch.php";

// Get the selected month from the dropdown
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : 'All';

// Base SQL query
$sql = "SELECT shop_profiles.id, amount, `ceo_id`, `name`, `motto`, `address`, `email`, `phone_number`, `rc_number`, `verify`, `logo`, `banner`, shop_profiles.created_at 
        FROM `shop_profiles` 
        JOIN payments ON payments.user_id = shop_profiles.ceo_id";

// Modify the query if a specific month is selected
if ($selectedMonth != 'All') {
    $sql .= " WHERE MONTH(shop_profiles.created_at) = $selectedMonth";
}

$result2 = $conn->query($sql);

// Initialize counters
$ceo_total = 0;
$shop_registered_total = 0;
$shop_verified_total = 0;
$shop_suspended_total = 0;
$payment_total = 0;

// Loop through the results to count totals
if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        // Count CEOs (assuming ceo_id is unique)
        $ceo_total++;

        // Count registered shops (all returned rows are registered)
        $shop_registered_total++;

        // Count verified accounts (assuming 'verify' is 1 for verified)
        if ($row['verify'] == 1) {
            $shop_verified_total++;
        }

        // Count suspended accounts (assuming 'verify' is 2 for suspended)
        if ($row['verify'] == 2) {
            $shop_suspended_total++;
        }

        // Calculate total income (assuming payments table has a field 'amount')
        $payment_total += $row['amount'];
    }
} else {
    echo "No results found.";
}

// SQL Query for the chart
$sqlChart = "SELECT 
                SUM(CASE WHEN verify = 1 THEN 1 ELSE 0 END) AS total_verified,
                SUM(CASE WHEN verify = 0 THEN 1 ELSE 0 END) AS total_unverified,
                SUM(CASE WHEN verify = 2 THEN 1 ELSE 0 END) AS total_suspended
            FROM shop_profiles";

// Modify the query for the chart if a specific month is selected
if ($selectedMonth != 'All') {
    $sqlChart .= " WHERE MONTH(created_at) = $selectedMonth";
}

$resultChart = $conn->query($sqlChart);
$rowChart = $resultChart->fetch_assoc();

$totalVerified = $rowChart['total_verified'];
$totalUnverified = $rowChart['total_unverified'];
$totalSuspended = $rowChart['total_suspended'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
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
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container" id="new_side_navbar">
        <div class="col-md-3 left_col" id="new_side_navbar">
          <div class="left_col scroll-view" id="new_side_navbar">

            <!-- sidebar menu -->
            <?php include 'admin_side_top_bar.php';?>

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
                                      <h3>System Summary</h3>
                                    </div>
                                    <div class="title_right">
                                      <div class="col-md-5 col-sm-5 form-group pull-right top_search">
                                        <div class="input-group">
                                          <form method="GET" action="">
                                            <label><h4>Sort By</h4></label>
                                            <select class="form-control" name="month" onchange="this.form.submit()">
                                              <option value="All" <?= ($selectedMonth == 'All') ? 'selected' : '' ?>>All</option>
                                              <option value="1" <?= ($selectedMonth == '1') ? 'selected' : '' ?>>January</option>
                                              <option value="2" <?= ($selectedMonth == '2') ? 'selected' : '' ?>>February</option>
                                              <option value="3" <?= ($selectedMonth == '3') ? 'selected' : '' ?>>March</option>
                                              <option value="4" <?= ($selectedMonth == '4') ? 'selected' : '' ?>>April</option>
                                              <option value="5" <?= ($selectedMonth == '5') ? 'selected' : '' ?>>May</option>
                                              <option value="6" <?= ($selectedMonth == '6') ? 'selected' : '' ?>>June</option>
                                              <option value="7" <?= ($selectedMonth == '7') ? 'selected' : '' ?>>July</option>
                                              <option value="8" <?= ($selectedMonth == '8') ? 'selected' : '' ?>>August</option>
                                              <option value="9" <?= ($selectedMonth == '9') ? 'selected' : '' ?>>September</option>
                                              <option value="10" <?= ($selectedMonth == '10') ? 'selected' : '' ?>>October</option>
                                              <option value="11" <?= ($selectedMonth == '11') ? 'selected' : '' ?>>November</option>
                                              <option value="12" <?= ($selectedMonth == '12') ? 'selected' : '' ?>>December</option>
                                            </select>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div> 
                          </div>
                        </div>
                        <div class="x_content">
                          <!-- start project list -->
                          <table class="table table-striped projects">
                            <thead>
                              <tr>
                                <th>No. of Client</th>
                                <th>No. of Registered Account</th>
                                <th>No. of Verified Account</th>
                                <th>No. of Suspended Account</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td><p><?=$ceo_total?></p></td>
                                <td><p><?=$shop_registered_total?></p></td>
                                <td class="project_progress"><p><?=$shop_verified_total?></p></td>
                                <td><p><?=$shop_suspended_total?></p></td>
                              </tr>
                              <tr>
                                <td><p><strong>TOTAL INCOME GENERATED</strong></p></td>
                                <td></td>
                                <td></td>
                                <td><p>&#8358; <?=number_format($payment_total, 2);?></p></td>
                              </tr>
                            </tbody>
                          </table>
                          <!-- end project list -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <div class="row">
              <div class="col-md-6">
                <h2>Shop Verification Status Distribution</h2>
                <canvas id="pieChart" width="400" height="200"></canvas>

                <script>
                  // Data from PHP
                  const totalVerified = <?= $totalVerified; ?>;
                  const totalUnverified = <?= $totalUnverified; ?>;
                  const totalSuspended = <?= $totalSuspended; ?>;

                  // Initialize Chart.js
                  const ctx = document.getElementById('pieChart').getContext('2d');
                  const pieChart = new Chart(ctx, {
                      type: 'bar', // Change to 'pie' for pie chart
                      data: {
                          labels: ['Verified Shops', 'Unverified Shops', 'Suspended Shops'],
                          datasets: [{
                              data: [totalVerified, totalUnverified, totalSuspended],
                              backgroundColor: [
                                  'rgba(75, 192, 192, 0.6)',  // Color for verified
                                  'rgba(255, 99, 132, 0.6)',  // Color for unverified
                                  'rgba(255, 206, 86, 0.6)'    // Color for suspended
                              ],
                              borderColor: [
                                  'rgba(75, 192, 192, 1)',
                                  'rgba(255, 99, 132, 1)',
                                  'rgba(255, 206, 86, 1)'
                              ],
                              borderWidth: 1
                          }]
                      },
                      options: {
                          responsive: true,
                          plugins: {
                              legend: {
                                  position: 'top',
                              },
                              tooltip: {
                                  callbacks: {
                                      label: function(tooltipItem) {
                                          const total = tooltipItem.dataset.data.reduce((a, b) => a + b, 0);
                                          const currentValue = tooltipItem.dataset.data[tooltipItem.dataIndex];
                                          const percentage = ((currentValue / total) * 100).toFixed(2);
                                          return tooltipItem.label + ': ' + currentValue + ' (' + percentage + '%)';
                                      }
                                  }
                              }
                          }
                      }
                  });
                </script>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap and custom scripts -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../build/js/custom.min.js"></script>
  </body>
</html>
