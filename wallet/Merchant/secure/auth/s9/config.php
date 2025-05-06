<?php
$host = "localhost";
$database = "colorpix_randion";
$user = "colorpix_blush";
$password = "4~;w06B~2*OW";

$dbconn = new mysqli($host, $user, $password, $database);

if ($dbconn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>