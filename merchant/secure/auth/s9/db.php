<?php
$host = "localhost";
$database = "colorpix_merchant";
$user = "colorpix_mer";
$password = "N=Q-Nl5pWaci";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
