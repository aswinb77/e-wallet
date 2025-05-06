<?php
include('db.php');

if (isset($_GET['status'], $_GET['trx'])) {
    $status = $_GET['status'];
    $trx = $_GET['trx'];

    $validStatus = ['paid', 'reject']; 

    if (in_array($status, $validStatus)) {
        $updateQuery = "UPDATE withdraw SET status = ? WHERE trxid = ?";

        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('ss', $status, $trx);

        if ($stmt->execute()) {
            echo 'Withdrawal status updated successfully!';
        } else {
            echo 'Error updating withdrawal status: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        echo 'Invalid status parameter.';
    }
} else {
    echo 'Missing status or trx parameter.';
}

$conn->close();
?>
