<?php
include('db.php');

$newMid = generateMid();
$number = $_POST['number'];
$updateMidQuery = $conn->prepare("UPDATE merchant SET mid = ? WHERE number = ?");
$updateMidQuery->bind_param("ss", $newMid, $number);
$updateMidQuery->execute();
$updateMidQuery->close();
echo json_encode(array('status' => 'success', 'newMid' => $newMid));

function generateMid() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $newMid = '';
    for ($i = 0; $i < 10; $i++) {
        $newMid .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $newMid;
}
?>
