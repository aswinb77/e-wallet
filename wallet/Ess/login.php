<?php
include('db.php');

$number = $_POST['number'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM person WHERE number = ? AND password = ?");
$stmt->bind_param("ss", $number, $password);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    session_start();
    $_SESSION['number'] = $number;
    $stmt->close();

    die(json_encode(array('status' => 'success', 'message' => 'Login successful')));
} else {
    $stmt->close();
    die(json_encode(array('status' => 'error', 'message' => 'Invalid username or password')));
}

$conn->close();
?>
