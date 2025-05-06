<?php
$host = "localhost";
$database = "colorpix_randion";
$user = "colorpix_blush";
$password = "4~;w06B~2*OW";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die(json_encode(array('status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error)));
}
?>