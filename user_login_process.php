<?php

$email = $_POST['email'];
$password = substr(hash("sha256", $_POST['password']), 0, 63);

function user_login($email, $password) {
    $conn = mysqli_connect("localhost","root","","symvaro_stations_db");
       
    $stmt = $conn->prepare("SELECT * FROM core_users WHERE email = ? AND password = ?;");
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    
    $stmt->execute();
    $stmt->close();
    $conn->close();
    $status = "success";

    return $status;
}
  
echo user_login($email, $password);
