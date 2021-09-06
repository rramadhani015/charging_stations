<?php
if (isset($_POST['submit_delete'])) {
    $station_id = $_POST['station_id'];

    $conn = mysqli_connect("localhost", "root", "", "symvaro_stations_db");

    $stmt2 = $conn->prepare("UPDATE core_stations SET core_stations.is_active = 'N' WHERE core_stations.id = ?;");
    mysqli_stmt_bind_param($stmt2, "i", $station_id);

    $stmt2->execute();
    $stmt2->close();
    $conn->close();
    header("location:dashboard.php?notification_success=delete");
}
