<?php
# FileName="connect.php"
$hostname = "localhost";
$database = "NEP_Calculator";
$username = "root";
$password = "";

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    echo $conn->connect_error;
    trigger_error('Database connection failed: ' . $conn->connect_error, E_USER_ERROR);
}
?>