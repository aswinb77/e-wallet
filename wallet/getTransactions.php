<?php
require('db.php');
session_start();

if (!isset($_SESSION['number'])) {
    header('HTTP/1.1 401 Unauthorized');
    exit();
}

$userNumber = $_SESSION['number'];
$limit = 10;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;

$sql = "SELECT merchant, amount, type, date_time, pic FROM transactions WHERE user = ? ORDER BY date_time DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $userNumber, $offset, $limit);
$stmt->execute();
$stmt->bind_result($merchant, $amount, $type, $date_time, $pic);

while ($stmt->fetch()) {
    echo '<div class="p-2 mb-2 flex items-center">';
    echo '<img class="rounded-full h-12 mr-4" src="' . $pic . '" alt="' . $merchant . ' Avatar">';
    echo '<div class="flex-grow">';
    echo '<p class="text-black">' . $merchant . '</p>';
    echo '<p class="text-gray-600">' . date('d M Y \a\t h:i A', strtotime($date_time)) . '</p>';
    echo '</div>';
    echo '<p class="' . (($type === 'debit') ? 'text-red-500' : 'text-green-500') . ' font-semibold">' . ($type === 'debit' ? '-' : '+') . '₹' . number_format($amount, 2) . '</p>';
    echo '</div>';
}

$stmt->close();
$conn->close();
?>
