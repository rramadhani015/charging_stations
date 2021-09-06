<?php
// Start the session
session_start();

if (isset($_POST['submit_view'])) {
    $station_id = $_POST['station_id'];
    $conn = mysqli_connect("localhost", "root", "", "symvaro_stations_db");

    $stmt = $conn->prepare("SELECT core_stations.*, ref_charging_port.name as port_name, core_projects.name as proj_name FROM core_stations  LEFT JOIN ref_charging_port on core_stations.port_id = ref_charging_port.id LEFT JOIN core_projects on core_stations.project_id = core_projects.id WHERE core_stations.id = ? LIMIT 1;");
    mysqli_stmt_bind_param($stmt, "i", $station_id);

    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = mysqli_fetch_assoc($result)) {
        if($row["proj_name"]==null){
            $row["proj_name"]="No Project Assigned";
        }
        $station_detail = array(
            "id" => $row["id"],
            "user_id" => $row["user_id"],
            "name" => $row["name"],
            "street" => $row["street"],
            "number" => $row["number"],
            "zip" => $row["zip"],
            "town" => $row["town"],
            "country" => $row["country"],
            "lat" => $row["lat"],
            "long" => $row["long"],
            "port_name" => $row["port_name"],
            "proj_name" => $row["proj_name"]
        );
    }
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
    <title>View Charging Station</title>

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
    <!-- Leafletjs Map API -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
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
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item">View Charging Station</li>
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
                                    <h5 class="m-0">View Charging Station</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label>Charging Station Name</label>
                                                <h5><?php echo $station_detail["name"]; ?></h5>
                                            </div>
                                            <div class="form-group">
                                                <label>Charging Port</label>
                                                <h5><?php echo $station_detail["port_name"]; ?></h5>
                                            </div>
                                            <div class="form-group">
                                                <label>Charging Station Project</label>
                                                <h5><?php echo $station_detail["proj_name"]; ?></h5>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Street</label>
                                                <h5><?php echo $station_detail["street"]; ?></h5>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Number</label>
                                                <h5><?php echo $station_detail["number"]; ?></h5>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Zip</label>
                                                <h5><?php echo $station_detail["zip"]; ?></h5>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Town</label>
                                                <h5><?php echo $station_detail["town"]; ?></h5>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Country</label>
                                                <h5><?php echo $station_detail["country"]; ?></h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label>Mark Location</label>
                                                    <div id="station_location_map" style="height:480px"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>Latitude</label>
                                                    <h5><?php echo $station_detail["lat"]; ?></h5>
                                                    <input type="hidden" class="form-control" id="lat" name="lat" placeholder="lat" value="<?php echo $station_detail["lat"]; ?>">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label>Longitude</label>
                                                    <h5><?php echo $station_detail["long"]; ?></h5>
                                                    <input type="hidden" class="form-control" id="long" name="long" placeholder="long" value="<?php echo $station_detail["long"]; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

    <script>
        const mymap = L.map('station_location_map').setView([46.6314566, 14.2974941], 13);
        const token = "pk.eyJ1IjoicmFtYWRoYW5pMDE1IiwiYSI6ImNpeHo1ZTU4eTAwNXAzM3J5YTB0cndteWIifQ.TfUY-zPT2r6bdci0vc7FCA";
        const attribution = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';
        if (mymap) {
            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                accessToken: 'pk.eyJ1IjoicmFtYWRoYW5pMDE1IiwiYSI6ImNpeHo1ZTU4eTAwNXAzM3J5YTB0cndteWIifQ.TfUY-zPT2r6bdci0vc7FCA'
            }).addTo(mymap);

            var lat = document.getElementById("lat").value;
            var lng = document.getElementById("long").value;
            var marker = L.marker([lat, lng]).addTo(mymap);
            mymap.setView([lat, lng],13);
        }
    </script>
</body>

</html>