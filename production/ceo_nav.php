<div class="top_nav">
          <div class="nav_menu">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>
            <nav class="nav navbar-nav">
              <ul class="navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="uploads/<?=$_SESSION['passport']?>" alt=""><?=$_SESSION['first_name']. ' ' .$_SESSION['last_name']?>

       <!--  $_SESSION['middle_name'] = $user['middle_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['phone_number'] = $user['phone_number']; -->
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="form_validation.php"> Profile</a>
                    <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>
                <?php
                  $sql = "SELECT `id`, `ceo_id`, `name`, `motto`, `address`, `email`, `phone_number`, `rc_number`, `verify`, `logo`, `banner`, `created_at` FROM `shop_profiles`WHERE ceo_id = $ceo_id";
                  $result = $conn->query($sql);

                   if ($result->num_rows > 0) {
                    // Loop through the result and display in table rows
                    $row = $result->fetch_assoc();
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
                  }
                ?>
                <strong>Status: <i><?=$verify?></i></strong>
              </ul>
            </nav>
          </div>
        </div>