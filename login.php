<?php
// Start the session
session_start();
if (isset($_SESSION['status'])){// check login status
  header("location:dashboard.php");
}
$status_check = "none"; 

// check if submit already done
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = substr(hash("sha256", $_POST['password']), 0, 64);

  function user_login($email, $password) 
  {
    $conn = mysqli_connect("localhost", "root", "", "symvaro_stations_db");

    $stmt = $conn->prepare("SELECT * FROM core_users WHERE core_users.email = ? AND core_users.password = ? LIMIT 1;"); // accessing the table to check username and password
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      while($row = mysqli_fetch_assoc($result)) { // loading data if user exist
        $_SESSION['user_id'] = $row["id"];
        $_SESSION['email'] = $row["email"];
        $_SESSION['status'] = "login";
        header("location:dashboard.php");
      }
      $status = "success";
    } else{
      $status = "fail1";
    }
    $stmt->close();
    $conn->close();

    return $status;
  }

  $status_check = user_login($email, $password);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sign In Page</title>
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
        <p class="login-box-msg">Sign In</p>

        <?php
        //check input status
        if ($status_check == "fail") { //if sign in failed without any reason, display this alert
        ?>
          <div id="success_input" class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> warning!</h5>
            Account registration failed, please try again!
          </div>
        <?php
        } elseif ($status_check == "fail1") { //if sign in failed because email not registered, display this alert
        ?>
          <div id="success_input" class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> warning!</h5>
            Email and password not found!
          </div>
        <?php
        }
        if ($status_check <> "success") {
        ?>
          <form id="user_login" action="login.php" method="post">
            <div class="form-group mb-3">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="form-group mb-3">
              <button type="submit" class="btn btn-primary btn-block" name="submit">Sign In</button>
            </div>
          </form>
        <?php
        }
        ?>
        <h6 align="center"><a href="index.php">Register new account?</a></h6>
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
      $('#user_login').validate({
        rules: {
          email: {
            required: true,
            email: true,
          },
          password: {
            required: true,
          }
        },
        messages: {
          email: {
            required: "Please enter a email address",
            email: "Please enter a vaild email address"
          },
          password: {
            required: "Please provide a password",
          }
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