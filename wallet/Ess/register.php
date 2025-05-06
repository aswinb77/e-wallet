<?php

$host = "localhost";
$database = "colorpix_randion";
$user = "colorpix_blush";
$password = "4~;w06B~2*OW";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $number = mysqli_real_escape_string($conn, $_POST["number"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $upi = mysqli_real_escape_string($conn, $_POST["upi"]);

    $query = "INSERT INTO person (name, number, password, email, upi, balance, photo) 
              VALUES (?, ?, ?, ?, ?, '0.00', 'https://ui-avatars.com/api/?name=User&format=svg&background=random')";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $number, $password, $email, $upi);

    if (mysqli_stmt_execute($stmt)) {
        $response["status"] = "success";
        $response["message"] = "Registration successful!";
    } else {
        $response["status"] = "error";
        $response["message"] = "Error: Unable to Register";
    }

    mysqli_stmt_close($stmt);

    header('Content-Type: application/json');
    echo json_encode($response);
} else {

    $response["status"] = "error";
    $response["message"] = "Invalid request method. Use POST.";


    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
