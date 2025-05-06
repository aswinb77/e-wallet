<?php
include('db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $telegramId = $_POST['telegramId'];
    $link = $_POST['link'];
    $sessionValue = $_POST['session'];


    $updateQuery = "UPDATE merchant SET tgid = ?, photo = ? WHERE number = ?";
    $stmt = $conn->prepare($updateQuery);

    if ($stmt) {
        $stmt->bind_param('sss', $telegramId, $link, $sessionValue);


        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $response = array('status' => 'success', 'message' => 'Database updated successfully');
        } else {
            $response = array('status' => 'error', 'message' => 'Error updating database');
        }

        $stmt->close();
    } else {
        $response = array('status' => 'error', 'message' => 'Error preparing statement');
    }
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    header('HTTP/1.1 400 Bad Request');
    echo 'Invalid request method';
}
?>
