<?php
// Start the session
session_start();

if (isset($_POST['submit_station'])) {
    $user_id = $_SESSION['user_id'];
    $port_id = $_POST['port_id'];
    $proj_id = $_POST['proj_id'];
    $name = $_POST['name'];
    $street = $_POST['street'];
    $number = $_POST['number'];
    $zip = $_POST['zip'];
    $town = $_POST['town'];
    $country = $_POST['country'];
    $lat = $_POST['lat'];
    $long = $_POST['long'];

    $conn = mysqli_connect("localhost", "root", "", "symvaro_stations_db");

    $stmt2 = $conn->prepare("INSERT INTO core_stations (core_stations.user_id, core_stations.port_id, core_stations.project_id, core_stations.name, core_stations.street, core_stations.number, core_stations.zip, core_stations.town, core_stations.country, core_stations.lat, core_stations.long) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
    mysqli_stmt_bind_param($stmt2, "iiissssssss", $user_id, $port_id,$proj_id, $name, $street, $number, $zip, $town, $country, $lat, $long);

    $stmt2->execute();
    $stmt2->close();
    $conn->close();
    header("location:dashboard.php?notification_success=input");
}

function all_charging_port()
{
    $conn = mysqli_connect("localhost", "root", "", "symvaro_stations_db");

    $stmt = $conn->prepare("SELECT * FROM ref_charging_port;");

    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
function all_project()
{
    $conn = mysqli_connect("localhost", "root", "", "symvaro_stations_db");

    $stmt = $conn->prepare("SELECT * FROM core_projects WHERE core_projects.is_active = 'Y';");

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
    <title>Add Charging Station</title>

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
                                <li class="breadcrumb-item">Add Charging Station</li>
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
                                    <h5 class="m-0">Add Charging Station</h5>
                                </div>
                                <div class="card-body">
                                    <form id="new_user_registration" action="add_charging_station.php" method="post">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group mb-3">
                                                    <label>Charging Station Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Charging Station Name">
                                                </div>
                                                <div class="form-group">
                                                    <?php $select_port = all_charging_port(); ?>
                                                    <label>Select Charging Port</label>
                                                    <select class="form-control select2" style="width: 100%;" name="port_id">
                                                        <?php while ($row_port = mysqli_fetch_assoc($select_port)) {
                                                        ?>
                                                            <option value="<?php echo $row_port['id']; ?>"><?php echo $row_port['name']; ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <?php $select_project = all_project(); ?>
                                                    <label>Select Project</label>
                                                    <select class="form-control select2" style="width: 100%;" name="proj_id">
                                                        <option value="0">No Project Assigned</option>
                                                        <?php while ($row_proj = mysqli_fetch_assoc($select_project)) {
                                                        ?>
                                                            <option value="<?php echo $row_proj['id']; ?>"><?php echo $row_proj['name']; ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label>Street</label>
                                                    <input type="text" class="form-control" id="street" name="street" placeholder="Street">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label>Number</label>
                                                    <input type="text" class="form-control" id="number" name="number" placeholder="number">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label>Zip</label>
                                                    <input type="text" class="form-control" id="zip" name="zip" placeholder="zip">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label>Town</label>
                                                    <input type="text" class="form-control" id="town" name="town" placeholder="town">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label>Country</label>
                                                    <input type="text" class="form-control" id="country" name="country" placeholder="country">
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
                                                        <input type="text" class="form-control" id="lat" name="lat" placeholder="lat" value="46.6314566" readonly>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label>Longitude</label>
                                                        <input type="text" class="form-control" id="long" name="long" placeholder="long" value="14.2974941" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-2">
                                                <button type="submit" class="btn btn-primary btn-block" name="submit_station">Register</button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </form>
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
        const mymap = L.map('station_location_map').setView([46.6314566, 14.2974941], 14);
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

            var marker = L.marker([46.6314566, 14.2974941]).addTo(mymap);
        }

        function onMapClick(e) {
            mymap.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(mymap);
            var coord = marker.getLatLng();
            var lat = coord.lat;
            var lng = coord.lng;
            document.getElementById("lat").value = lat;
            document.getElementById("long").value = lng;
        }
        mymap.on('click', onMapClick);
    </script>
</body>

</html>