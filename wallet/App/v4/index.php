<?php
// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$host = "localhost";
$database = "colorpix_randion";
$user = "colorpix_blush";
$password = "4~;w06B~2*OW";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user = filter_var($_GET["user"], FILTER_SANITIZE_STRING);
    $merchant = filter_var($_GET["merchant"], FILTER_SANITIZE_STRING);
    $amount = filter_var($_GET["amount"], FILTER_VALIDATE_FLOAT);
    $type = filter_var($_GET["type"], FILTER_SANITIZE_STRING);
    $com = filter_var($_GET["com"], FILTER_SANITIZE_STRING);
    date_default_timezone_set('Asia/Kolkata');
    $date_time = date('d M y h:i A');
     $trx =  substr(md5(uniqid()), 0, 9);
    $pic_path = "https://ui-avatars.com/api/?name=" . urlencode($merchant) . "&format=svg&background=random";

    $query = "INSERT INTO transactions (user, merchant, amount, type, date_time, pic, trx, com) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "ssdsssss", $user, $merchant, $amount, $type, $date_time, $pic_path, $trx, $com);
    
    if (mysqli_stmt_execute($stmt)) {
        $query_balance = "UPDATE person SET balance = balance + ? WHERE number = ?";
        $stmt_balance = mysqli_prepare($conn, $query_balance);

        mysqli_stmt_bind_param($stmt_balance, "ds", $amount, $user);
        mysqli_stmt_execute($stmt_balance);

        $response["success"] = true;
        $response["message"] = "Data inserted successfully!";
    } else {
        error_log("Error: " . mysqli_error($conn));
        $response["success"] = false;
        $response["message"] = "An error occurred. Please try again later.";
    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt_balance);
} else {
    $response["success"] = false;
    $response["message"] = "Invalid request method. Use GET.";
}

header('Content-Type: application/json');
echo json_encode($response);
?>
