<?php
include('db.php');
include('config.php');

$token = isset($_GET['uid']) ? $_GET['uid'] : null;
$amount = isset($_GET['amount']) ? $_GET['amount'] : null;
$usernumber = isset($_GET['number']) ? $_GET['number'] : null;
$comment = isset($_GET['com']) ? $_GET['com'] : null;

function sendTelegramBotAlert($chatId, $message, $trx, $dateTime, $amount) {
    $botToken = '1977469600:AAEJmiPTYxpBa7bvoOENuu04ShHZvH9HNcM';
    $telegramApiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

    $alertInfo = "*Transaction Details:*\n";
    $alertInfo .= "\n _Message:_ {$message}\n";
    $alertInfo .= "\n _Transaction ID:_ {$trx}\n";
    $alertInfo .= "\n _Date and Time:_ {$dateTime}\n";
    $alertInfo .= "\n _Amount:_ {$amount}";
    $url = "{$telegramApiUrl}?chat_id={$chatId}&text={$alertInfo}&parse_mode=Markdown";

    file_get_contents($url);
}

if (empty($token) || empty($amount) || empty($usernumber) || empty($comment)) {
    echo json_encode(['success' => false, 'message' => 'Missing or empty required parameters']);
    exit;
}

$queryMerchant = "SELECT name, number, photo, tgid FROM merchant WHERE mid = ?";
$statementMerchant = $conn->prepare($queryMerchant);

if (!$statementMerchant) {
    echo json_encode(['success' => false, 'message' => 'Error preparing merchant statement']);
    exit;
}

$statementMerchant->bind_param('s', $token);
$statementMerchant->execute();
$statementMerchant->bind_result($name, $number, $photo, $tgid);
$statementMerchant->fetch();
$statementMerchant->close();

if (!$name) {
    echo json_encode(['success' => false, 'message' => 'Merchant not found']);
    exit;
}

$queryBalance = "SELECT balance FROM balance WHERE number = ?";
$statementBalance = $conn->prepare($queryBalance);

if (!$statementBalance) {
    echo json_encode(['success' => false, 'message' => 'Error preparing balance statement']);
    exit;
}

$statementBalance->bind_param('s', $number);
$statementBalance->execute();
$statementBalance->bind_result($balance);
$statementBalance->fetch();
$statementBalance->close();

if (!$balance) {
    echo json_encode(['success' => false, 'message' => 'Error fetching balance']);
    exit;
}

if ($amount !== null && $amount <= $balance) {
    $type = 'credit';
    date_default_timezone_set('Asia/Calcutta'); 
    $date_time = date('d-M-y h:i:s');
    $trx = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 10);
    $comment = isset($_GET['com']) ? $_GET['com'] : null;

    $queryTransaction = "INSERT INTO transactions (user, merchant, amount, type, date_time, pic, trx, com) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $statementTransaction = $dbconn->prepare($queryTransaction);

    if (!$statementTransaction) {
        echo json_encode(['success' => false, 'message' => 'Error preparing transaction statement']);
        exit;
    }

    $statementTransaction->bind_param('ssdsssss', $usernumber, $name, $amount, $type, $date_time, $photo, $trx, $comment);

    if ($statementTransaction->execute()) {
        $newMerchantBalance = $balance - $amount;
        $queryUpdateMerchantBalance = "UPDATE balance SET balance = ? WHERE number = ?";
        $statementUpdateMerchantBalance = $conn->prepare($queryUpdateMerchantBalance);

        if (!$statementUpdateMerchantBalance) {
            echo json_encode(['success' => false, 'message' => 'Error preparing update merchant balance statement']);
            exit;
        }

        $statementUpdateMerchantBalance->bind_param('ds', $newMerchantBalance, $number);

        if ($statementUpdateMerchantBalance->execute()) {
            $queryUpdateUserBalance = "UPDATE person SET balance = balance + ? WHERE number = ?";
            $statementUpdateUserBalance = $dbconn->prepare($queryUpdateUserBalance);

            if (!$statementUpdateUserBalance) {
                echo json_encode(['success' => false, 'message' => 'Error preparing update user balance statement']);
                exit;
            }

            $statementUpdateUserBalance->bind_param('ds', $amount, $usernumber);

            if ($statementUpdateUserBalance->execute()) {
                $queryTransactionMerchant = "INSERT INTO transaction_merchant (date, amount, status, usernumber, merchant) 
                                             VALUES (?, ?, ?, ?, ?)";
                $statusMerchant = 'success';
                $statementTransactionMerchant = $conn->prepare($queryTransactionMerchant);

                if (!$statementTransactionMerchant) {
                    echo json_encode(['success' => false, 'message' => 'Error preparing transaction statement']);
                    exit;
                }

                $statementTransactionMerchant->bind_param('sdsss', $date_time, $amount, $statusMerchant, $usernumber, $number);

                if ($statementTransactionMerchant->execute()) {
                    sendTelegramBotAlert($tgid, 'Transaction success', $trx, $date_time, $amount);
                    echo json_encode(['success' => true, 'message' => 'Transaction success', '200' => 1001]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error inserting into tran table']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating user balance']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating merchant balance']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Transaction failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Insufficient funds or something went wrong', 'error_code' => 1001]);
}
?>
