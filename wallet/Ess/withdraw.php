<?php

include('../db.php');
session_start(); 

$telegramBotToken = '1977469600:Bottoken';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $paymentType = $_POST['paymentType'];
    $userNumber = $_POST['userNumber']; 

    $amount = filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $paymentType = filter_var($paymentType, FILTER_SANITIZE_STRING);

    $checkBalanceSql = "SELECT balance,upi,name FROM person WHERE number = '$userNumber'";
    $result = $conn->query($checkBalanceSql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userBalance = $row['balance'];
        $upi = $row['upi'];
        $name = $row['name'];

        if (($paymentType === 'bank' && $amount > 100) || ($paymentType === 'paytm' && $amount > 10)) {
            if ($userBalance >= $amount) {
                $newBalance = $userBalance - $amount;
                $updateBalanceSql = "UPDATE person SET balance = '$newBalance' WHERE number = '$userNumber'";
                
                if ($conn->query($updateBalanceSql) === TRUE) {
                    date_default_timezone_set('Asia/Kolkata');
                    $time = date('d-M-y h:i A');
                    $trx =  substr(md5(uniqid()), 0, 6);
                    $insertWithdrawSql = "INSERT INTO withdraw (user, time, type, status, trxid, amount) VALUES ('$userNumber', '$time', '$paymentType', 'pending', '$trx', '$amount')";
                    
                    if ($conn->query($insertWithdrawSql) === TRUE) {
                        $insertTransactionSql = "INSERT INTO transactions (user, merchant, amount, type, date_time, pic) VALUES ('$userNumber', 'Withdraw', '$amount', 'debit', '$time', 'https://ui-avatars.com/api/?name=Debit&format=svg&background=random')";
                        
                        if ($conn->query($insertTransactionSql) === TRUE) {
                            $telegramMessage = "Withdrawal request and transaction successful.
                            
User: $name \n
Amount: $amount \n 
Type: $paymentType \n
Paytm Number : $userNumber \n
upi : $upi \n";

                            sendTelegramMessage($telegramBotToken, $telegramMessage,$trx);

                            $response = "Withdrawal request successful";
                        } else {
                            $response = "Error <br>";
                        }
                    } else {
                        $response = "Error <br>";
                    }
                } else {
                    $response = "Error updating user balance: <br>";
                }
            } else {
                $response = "Error: Insufficient balance";
            }
        } else {
            $response = "Error: Invalid withdrawal conditions";
        }
    } else {
        $response = "Error: User not found";
    }

    $conn->close();
    echo $response;
} else {
    echo "Invalid request method";
}


function sendTelegramMessage($token, $message, $trx) {
    $telegramApiUrl = "https://api.telegram.org/bot$token/sendMessage";
    $chatId = '1320785887'; 
    
    $inlineKeyboard = [
    [
        ['text' => 'Paid', 'url' => 'https://color-pix.in/Ess/pay?status=paid&trx=' . $trx.''],
        ['text' => 'Reject', 'url' => 'https://color-pix.in/Ess/pay?status=reject&trx=' . $trx.'']
    ],
];

    
    $replyMarkup = [
        'inline_keyboard' => $inlineKeyboard
    ];
    
    $params = [
        'chat_id' => $chatId,
        'text' => $message,
        'reply_markup' => json_encode($replyMarkup)
    ];

    $url = $telegramApiUrl . '?' . http_build_query($params);


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
}
?>
