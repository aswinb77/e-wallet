<?php
include('db.php');

if (isset($_GET['s'])) {
    $status = $_GET['s'];
    $trx = $_GET['trx'];
    $taxRate = 0.06;

    if ($status == 'paid' || $status == 'reject') {
        $checkPaidQuery = "SELECT status FROM recharge WHERE trxid = ?";
        $stmtCheckPaid = $conn->prepare($checkPaidQuery);
        $stmtCheckPaid->bind_param("s", $trx);
        $stmtCheckPaid->execute();
        $stmtCheckPaid->bind_result($currentStatus);
        $stmtCheckPaid->fetch();
        $stmtCheckPaid->close();

        if ($currentStatus == 'paid') {
            echo "Transaction already paid.";
        } else {
            $getAmountQuery = "SELECT amount,number FROM recharge WHERE trxid = ?";
            $stmtAmount = $conn->prepare($getAmountQuery);
            $stmtAmount->bind_param("s", $trx);
            $stmtAmount->execute();
            $stmtAmount->bind_result($amount,$number);
            $stmtAmount->fetch();
            $stmtAmount->close();

            $taxAmount = $amount * $taxRate;
            $newBalance = $amount - $taxAmount;

            $getBalanceQuery = "SELECT balance FROM balance WHERE number = ?";
            $stmtBalance = $conn->prepare($getBalanceQuery);
            $stmtBalance->bind_param("s", $number); 
            $stmtBalance->execute();
            $stmtBalance->bind_result($balance);
            $stmtBalance->fetch();
            $stmtBalance->close();

            if ($stmtBalance->errno) {
                echo "Error retrieving balance: " . $stmtBalance->error;
            } else {
                $newBalance += $balance;

                $updateBalanceQuery = "UPDATE balance SET balance = ? WHERE number = ?";
                $stmtUpdateBalance = $conn->prepare($updateBalanceQuery);
                $stmtUpdateBalance->bind_param("ds", $newBalance, $number);
                $stmtUpdateBalance->execute();

                if ($stmtUpdateBalance->errno) {
                    echo "Error updating balance: " . $stmtUpdateBalance->error;
                } else {
                    $stmtUpdateBalance->close();

                    $updateStatusQuery = "UPDATE recharge SET status = 'paid' WHERE trxid = ?";
                    $stmtUpdateStatus = $conn->prepare($updateStatusQuery);
                    $stmtUpdateStatus->bind_param("s", $trx);

                    if ($stmtUpdateStatus->execute()) {
                        echo "Update successful!";
                        echo "$newBalance";
                        echo "balance : $balance";
                    } else {
                        echo "Error updating record: " . $stmtUpdateStatus->error;
                    }

                    $stmtUpdateStatus->close();
                }
            }
        }
    } else {
        echo "Invalid status value";
    }
}
?>
