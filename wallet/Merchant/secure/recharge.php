<?php
include('db.php');

$botToken = '1977469600:AAEJmiPTYxpBa7bvoOENuu04ShHZvH9HNcM';
$chatId = '1320785887';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $amount = $_POST['amount'];
    $session = $_POST['session'];
    $trxid = uniqid('trx');
    $date = date('Y-m-d H:i:s');
    $status = 'pending';
    $uploadedFile = $_FILES['file_input'];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($uploadedFile["name"]);

    if (move_uploaded_file($uploadedFile["tmp_name"], $targetFile)) {
        $message = "New recharge request:\nAmount: $amount\nSession: $session\nTransaction ID: $trxid";
        
        sendToTelegram($botToken, $chatId, $message, $targetFile, $trxid);

        $sql = "INSERT INTO recharge (amount, number, trxid, date, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dssss", $amount, $session, $trxid, $date, $status);

        if ($stmt->execute()) {
            $response = array("status" => "success", "message" => "Recharge request submitted!");
            echo json_encode($response);
        } else {
            $response = array("status" => "error", "message" => "Error inserting into database: " . $stmt->error);
            echo json_encode($response);
        }

        $stmt->close();
    } else {
        $response = array("status" => "error", "message" => "Error uploading image file.");
        echo json_encode($response);
    }

    $conn->close();
} else {
    $response = array("status" => "error", "message" => "Invalid request!");
    echo json_encode($response);
}

function sendToTelegram($botToken, $chatId, $message, $imagePath, $trxid) {
    $url = "https://api.telegram.org/bot$botToken/sendPhoto";
    $postFields = array(
        'chat_id' => $chatId,
        'caption' => $message,
        'photo' => new CURLFile(realpath($imagePath)),
        'reply_markup' => json_encode(array(
            'inline_keyboard' => array(
                array(
                    array('text' => 'Add', 'url' => 'http://color-pix.in/Merchant/secure/status.php?s=paid&trx='.$trxid.''),
                    array('text' => 'Reject', 'url' => 'http://color-pix.in/Merchant/secure/status.php?s=reject&trx='.$trxid.'')
                )
            )
        ))
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Telegram API Request Error: ' . curl_error($ch);
    }

    curl_close($ch);
}

?>
