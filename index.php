<?php
$status_check = "none"; // to initiate the current status check for the form

// check if submit already done
if (isset($_POST['submit'])) {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $password = hash("sha256", $_POST['password']);

  function new_user_input($first_name, $last_name, $email, $password)
  {
    $conn = mysqli_connect("localhost", "root", "", "symvaro_stations_db");

    //check if there are same email already in db
    $stmt1 = $conn->prepare("SELECT * FROM core_users WHERE core_users.email=?");
    mysqli_stmt_bind_param($stmt1, "s", $email);
    
    $stmt1->execute();    
    $result = $stmt1->get_result();
    
    if ($result->num_rows > 0) {
      $status = "fail1";
    }else{
      //register account if email is unique
      $stmt2 = $conn->prepare("INSERT INTO core_users (core_users.first_name, core_users.last_name, core_users.email, core_users.password) VALUES (?, ?, ?, ?);");
      mysqli_stmt_bind_param($stmt2, "ssss", $first_name, $last_name, $email, $password);
  
      $stmt2->execute();
      $stmt2->close();
      $status = "success";
    }   
    $stmt1->close();
    $conn->close();

    return $status;
  }

  $status_check = new_user_input($first_name, $last_name, $email, $password);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="index.php"><b>Charging Stations</b></a><br>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">User Registration</p>

        <?php
        //check input status
        if ($status_check == "success") { //if input is success, display this alert
        ?>
          <div id="success_input" class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            New account has been successfully registered! Please check your email for validation!
          </div>
        <?php
        } elseif ($status_check == "fail") { //if input is failed without reason, display this alert
        ?>
          <div id="success_input" class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> warning!</h5>
            Account registration failed, please try again!
          </div>
        <?php
        }elseif ($status_check == "fail1") { //if input is failed because email already registered, display this alert
          ?>
            <div id="success_input" class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fas fa-check"></i> warning!</h5>
              Account registration failed! This email is already registered.
            </div>
          <?php
          }
        if ($status_check <> "success") {
        ?>
          <form id="new_user_registration" method="post">
            <div class="form-group mb-3">
              <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name">
            </div>
            <div class="form-group mb-3">
              <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name">
            </div>
            <div class="form-group mb-3">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="form-group mb-3">
              <input type="password" class="form-control" name="re_password" id="re_password" placeholder="Retype password">
            </div>
            <div class="row">
              <div class="form-group col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                  <label for="agreeTerms">
                    I agree to the <a href="#">terms</a>
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block" name="submit">Register</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
        <?php
        }
        ?>
        <h6 align="center"><a href="login.php">Already have an account?</a></h6>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="./assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- jquery-validation -->
  <script src="./assets/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="./assets/plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./assets/dist/js/adminlte.min.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      //input validation function using jquery
      $('#new_user_registration').validate({
        rules: {
          email: {
            required: true,
            email: true,
          },
          password: {
            required: true,
            minlength: 8
          },
          re_password: {
            equalTo: "#password"
          },
          terms: {
            required: true
          },
        },
        messages: {
          email: {
            required: "Please enter a email address",
            email: "Please enter a vaild email address"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 8 characters long"
          },
          re_password:"Password must be the same",
          terms: "Please accept our terms"
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>

</body>

</html>