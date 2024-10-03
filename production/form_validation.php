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
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['date']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $state_of_origin = mysqli_real_escape_string($conn, $_POST['state_of_origin']);
    $lga_of_origin = mysqli_real_escape_string($conn, $_POST['lga_of_origin']);
    $identification_type = mysqli_real_escape_string($conn, $_POST['means_of_identification']);

    // File upload for passport and means of identification
    $passport = $_FILES['passport']['name'];
    $passport_tmp = $_FILES['passport']['tmp_name'];
    $identification_file = $_FILES['means_of_identification']['name'];
    $identification_tmp = $_FILES['means_of_identification']['tmp_name'];

    // Upload files to a directory
    move_uploaded_file($passport_tmp, "uploads/" . $passport);
    move_uploaded_file($identification_tmp, "uploads/" . $identification_file);

    // Check if CEO exists by email or phone number
    $check_query = "SELECT * FROM ceo_profiles WHERE email='$email' OR phone_number='$phone_number' LIMIT 1";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        // CEO already exists
        $message = "Error: A record with this email or phone number already exists.";
    } else {
        // Insert data into the database
        $sql = "INSERT INTO ceo_profiles (first_name, last_name, middle_name, gender, dob, email, password, phone_number, address, state_of_origin, lga_of_origin, identification_type, passport, identification_file)
                VALUES ('$first_name', '$last_name', '$middle_name', '$gender', '$dob', '$email', '$password', '$phone_number', '$address', '$state_of_origin', '$lga_of_origin', '$identification_type', '$passport', '$identification_file')";

        if (mysqli_query($conn, $sql)) {
            $message = "New record created successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

// Close connection
// mysqli_close($conn);
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
                        <div class="col-md-12 col-sm-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2 class="dims_head">Company C.E.O Profile</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <form  method="POST" enctype="multipart/form-data">
                                        <?php 
                                        	if (isset($message)) {echo $message . "<br>";}
                                        ?>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">First Name<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" name="first_name" required="required" />
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Last Name<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" name="last_name" required="required" />
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Middle Name<span></span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" name="middle_name" required="required" />
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Gender<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select class="form-control" class='date' type="gender" name="gender">
                                                    <option>Select Gender</option>
                                                    <option name="male">Male</option>
                                                    <option name="female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Passport<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="file" class='file' name="passport" required='required'></div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Date<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" class='date' type="date" name="date" required='required'></div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">email<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" name="email" class='email' required="required" type="email" /></div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Confirm email address<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="email" class='email' name="confirm_email" data-validate-linked='email' required='required' /></div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">password<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" name="password" class='password' required="required" type="password" /></div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Phone Number <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="number" class='number' name="number" required='required'></div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Address<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" name="address" required="required" />
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">State of Origin<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select class="form-control" class='state' type="Gender" name="state_of_origin">
                                                    <option>Select State</option>
                                                    <option name="">FCT Abuja</option>
                                                    <option name="">Abia</option>
                                                    <option name="">Adamawa</option>
                                                    <option name="">Akwa-Ibom</option>
                                                    <option name="">Anambra</option>
                                                    <option name="">Bauchi</option>
                                                    <option name="">Bayelsa</option>
                                                    <option name="">Benue</option>
                                                    <option name="">Borno</option>
                                                    <option name="">Cross-River</option>
                                                    <option name="">Delta</option>
                                                    <option name="">Ebonyi</option>
                                                    <option name="">Edo</option>
                                                    <option name="">Ekiti</option>
                                                    <option name="">Enugu</option>
                                                    <option name="">Gombe</option>
                                                    <option name="">Jigawa</option>
                                                    <option name="">Kaduna</option>
                                                    <option name="">Kano</option>
                                                    <option name="">Katsina</option>
                                                    <option name="">Kebbi</option>
                                                    <option name="">Kogi</option>
                                                    <option name="">Kwara</option>
                                                    <option name="">Lagos</option>
                                                    <option name="">Nassarawa</option>
                                                    <option name="">Niger</option>
                                                    <option name="">Ogun</option>
                                                    <option name="">Ondo</option>
                                                    <option name="">Osun</option>
                                                    <option name="">Oyo</option>
                                                    <option name="">Plateau</option>
                                                    <option name="">Rivers</option>
                                                    <option name="">Sokoto</option>
                                                    <option name="">Taraba</option>
                                                    <option name="">Yobe</option>
                                                    <option name="">Zamfara</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">LGA of Origin<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select class="form-control" class='lga' type="Gender" name="lga_of_origin">
                                                    <option>Select LGA</option>
                                                    <option name=""> --- </option>
                                                    <option name=""> --- </option>
                                                    <option name=""> --- </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Means of Identification<span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <select class="form-control" class='' type="means of identification" required="required" name="means_of_identification" />
                                                    <option>Select means of Identification</option>
                                                    <option>National ID card</option>
                                                    <option>Driving License</option>
                                                    <option>International Passport</option>
                                                    <option>Voters Card</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3  label-align">Upload Means of Identification <span class="required">*</span></label>
                                            <div class="col-md-6 col-sm-6">
                                                <input class="form-control" type="file" class='file' name="means_of_identification" required='required'></div>
                                        </div>
                                        
                                        <div class="ln_solid">
                                            <div class="form-group">
                                                <div class="col-md-6 offset-md-3">
                                                    <button type='submit' class="btn btn-success">Submit</button>
                                                    <button type='reset' class="btn btn-danger">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
                    <p>Distributed Internet Cafe Management System - Abubakar Usman Bashir</p>
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="../vendors/validator/multifield.js"></script>
    <script src="../vendors/validator/validator.js"></script>
    
    <!-- Javascript functions	-->
	<script>
		function hideshow(){
			var password = document.getElementById("password1");
			var slash = document.getElementById("slash");
			var eye = document.getElementById("eye");
			
			if(password.type === 'password'){
				password.type = "text";
				slash.style.display = "block";
				eye.style.display = "none";
			}
			else{
				password.type = "password";
				slash.style.display = "none";
				eye.style.display = "block";
			}

		}
	</script>

    <script>
        // initialize a validator instance from the "FormValidator" constructor.
        // A "<form>" element is optionally passed as an argument, but is not a must
        var validator = new FormValidator({
            "events": ['blur', 'input', 'change']
        }, document.forms[0]);
        // on form "submit" event
        document.forms[0].onsubmit = function(e) {
            var submit = true,
                validatorResult = validator.checkAll(this);
            console.log(validatorResult);
            return !!validatorResult.valid;
        };
        // on form "reset" event
        document.forms[0].onreset = function(e) {
            validator.reset();
        };
        // stuff related ONLY for this demo page:
        $('.toggleValidationTooltips').change(function() {
            validator.settings.alerts = !this.checked;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);

    </script>

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
