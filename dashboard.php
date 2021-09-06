<?php
// Start the session
session_start();
if (empty($_SESSION['status'])) {
    header("location:login.php");
}
if (isset($_GET['all'])) {
    $table_set = 'all';
} else {
    $table_set = 'user';
}
function your_charging_station($user_id)
{
    $conn = mysqli_connect("localhost", "root", "", "symvaro_stations_db");

    $stmt = $conn->prepare("SELECT core_stations.*, ref_charging_port.name as port_name, core_projects.name as proj_name  FROM core_stations  LEFT JOIN ref_charging_port on core_stations.port_id = ref_charging_port.id LEFT JOIN core_projects on core_stations.project_id = core_projects.id  WHERE core_stations.user_id = ? AND  core_stations.is_active = 'Y';");
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
function all_charging_station()
{
    $conn = mysqli_connect("localhost", "root", "", "symvaro_stations_db");

    $stmt = $conn->prepare("SELECT core_stations.*, ref_charging_port.name as port_name, core_projects.name as proj_name  FROM core_stations LEFT JOIN ref_charging_port on core_stations.port_id = ref_charging_port.id LEFT JOIN core_projects on core_stations.project_id = core_projects.id  WHERE core_stations.is_active = 'Y';");

    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}


?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

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

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <span class="brand-text font-weight-light">Charging Stations</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $_SESSION['email']; ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item menu-open">
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="dashboard.php" class="nav-link active">
                                        <i class="fas fa-charging-station nav-icon"></i>
                                        <p>Charging Stations</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Charging Stations</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <?php
                                    if ($table_set == 'user') { ?>
                                        <h5 class="m-0">Your Charging Stations</h5>
                                    <?php } else if ($table_set == 'all') { ?>
                                        <h5 class="m-0">All Charging Stations</h5>
                                    <?php } ?>
                                </div>
                                <div class="card-body">
                                    <div class="btn-group mb-3">
                                        <a href="add_charging_station.php" class="btn btn-primary"><i class="fas fa-charging-station nav-icon"></i></a>
                                        <a href="add_charging_station.php" class="btn btn-primary">New Charging Station</a>
                                    </div>
                                    <?php
                                    if (isset($_GET['notification_success'])) {
                                        if ($_GET['notification_success'] == "input") {
                                    ?>
                                            <div class="alert alert-success alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h5><i class="icon fas fa-check"></i> New charging stations registered!</h5>
                                                You have successfully registered your charging station!
                                            </div>
                                        <?php
                                        } else if ($_GET['notification_success'] == "delete") {
                                        ?>
                                            <div class="alert alert-warning alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h5><i class="icon fas fa-check"></i> Charging stations deleted!</h5>
                                                Your charging station has been successfully deleted!
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    if ($table_set == 'user') {
                                        $table = your_charging_station($_SESSION['user_id']);
                                        if ($table->num_rows > 0) { ?>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">ID</th>
                                                        <th>Name</th>
                                                        <th>Usage</th>
                                                        <th>Project</th>
                                                        <th>Location</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($table)) {
                                                        $proj_name = $row['proj_name'];
                                                        if ($proj_name == null) {
                                                            $proj_name = "No Project Assigned";
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $row['id']; ?></td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['port_name']; ?></td>
                                                            <td><?php echo $proj_name; ?></td>
                                                            <td><?php echo $row['street'] . " " . $row['number'] . ", " . $row['zip'] . ", " . $row['town'] . ", " . $row['country']; ?></td>
                                                            <td>
                                                                <form method="post" action="view_station.php" style="display:inline-block">
                                                                    <input type="hidden" name="station_id" value="<?php echo $row['id']; ?>">
                                                                    <button type="submit" class="btn btn-info btn-xs" name="submit_view"><i class="icon fas fa-eye"></i> View Station</button>
                                                                </form>
                                                                <form method="post" action="delete_station.php" style="display:inline-block">
                                                                    <input type="hidden" name="station_id" value="<?php echo $row['id']; ?>">
                                                                    <button type="submit" class="btn btn-warning btn-xs" name="submit_delete" onclick='return confirm("Are you sure?")'><i class="icon fas fa-trash"></i> Delete Station</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } ?>
                                                </tbody>
                                            </table>
                                            <a href="?all=true">All charging stations</a>
                                        <?php
                                        } else { ?>
                                            <div class="alert alert-info alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h5><i class="icon fas fa-info"></i> Charging stations not found!</h5>
                                                You haven't registered any charging station yet.
                                            </div>
                                            <a href="?all=true">All charging stations</a>
                                        <?php
                                        }
                                    } else if ($table_set == 'all') {
                                        $table = all_charging_station();
                                        if ($table->num_rows > 0) { ?>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">ID</th>
                                                        <th>Name</th>
                                                        <th>Usage</th>
                                                        <th>Project</th>
                                                        <th>Location</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    while ($row = mysqli_fetch_assoc($table)) {
                                                        $proj_name = $row['proj_name'];
                                                        if ($proj_name == null) {
                                                            $proj_name = "No Project Assigned";
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $row['id']; ?></td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['port_name']; ?></td>
                                                            <td><?php echo $proj_name; ?></td>
                                                            <td><?php echo $row['street'] . " " . $row['number'] . ", " . $row['zip'] . ", " . $row['town'] . ", " . $row['country']; ?></td>
                                                            <td>
                                                                <form method="post" action="view_station.php" style="display:inline-block">
                                                                    <input type="hidden" name="station_id" value="<?php echo $row['id']; ?>">
                                                                    <button type="submit" class="btn btn-info btn-xs" name="submit_view"><i class="icon fas fa-eye"></i> View Station</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } ?>
                                                </tbody>
                                            </table>
                                            <a href="dashboard.php">Your charging stations</a>
                                        <?php
                                        } else { ?>
                                            <div class="alert alert-info alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h5><i class="icon fas fa-info"></i> Charging stations not found!</h5>
                                                There is no charging station yet.
                                            </div>
                                            <a href="dashboard.php">Your charging stations</a>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="./assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script src="./assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="./assets/plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./assets/dist/js/adminlte.min.js"></script>
</body>

</html>