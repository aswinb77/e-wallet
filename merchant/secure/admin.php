<?php
include('db.php');
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && time() < $_SESSION['expiry_time']) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action']) && isset($_POST['trxid'])) {
            $action = $_POST['action'];
            $trxid = $_POST['trxid'];

            if ($action === 'pay') {
                $updateSql = "UPDATE recharge SET status = 'paid' WHERE trxid = ? AND status = 'pending'";
            } elseif ($action === 'reject') {
                $updateSql = "UPDATE recharge SET status = 'reject' WHERE trxid = ? AND status = 'pending'";
            }

            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("s", $trxid);

            if ($stmt->execute()) {
                echo "Status updated successfully.";
            } else {
                echo "Error updating status: " . $stmt->error;
            }

            $stmt->close();
        }
        if (isset($_POST['change_balance']) && isset($_POST['number']) && isset($_POST['new_balance'])) {
            $number = $_POST['number'];
            $newBalance = $_POST['new_balance'];

            $updateBalanceSql = "UPDATE balance SET balance = ? WHERE number = ?";
            $stmt = $conn->prepare($updateBalanceSql);
            $stmt->bind_param("ds", $newBalance, $number);

            if ($stmt->execute()) {
                echo "Balance updated successfully.";
            } else {
                echo "Error updating balance: " . $stmt->error;
            }

            $stmt->close();
        }
    }
    echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Pending Transactions</title>
                <link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'>
            </head>
            <body class='bg-gray-100 p-8'>
                <div class='max-w-screen-md mx-auto'>
                    <h2 class='text-2xl font-bold mb-4'>Pending Transactions</h2>

                    <table class='min-w-full bg-white border border-gray-300'>
                        <thead>
                            <tr>
                                <th class='py-2 px-4 border-b'>ID</th>
                                <th class='py-2 px-4 border-b'>Amount</th>
                                <th class='py-2 px-4 border-b'>Number</th>
                                <th class='py-2 px-4 border-b'>Transaction ID</th>
                                <th class='py-2 px-4 border-b'>Date</th>
                                <th class='py-2 px-4 border-b'>Status</th>
                                <th class='py-2 px-4 border-b'>Action</th>
                            </tr>
                        </thead>
                        <tbody>";

    $sql = "SELECT * FROM recharge WHERE status = 'pending'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td class='py-2 px-4 border-b'>" . $row["id"] . "</td>
                    <td class='py-2 px-4 border-b'>" . $row["amount"] . "</td>
                    <td class='py-2 px-4 border-b'>" . $row["number"] . "</td>
                    <td class='py-2 px-4 border-b'>" . $row["trxid"] . "</td>
                    <td class='py-2 px-4 border-b'>" . $row["date"] . "</td>
                    <td class='py-2 px-4 border-b'>" . $row["status"] . "</td>
                    <td class='py-2 px-4 border-b'>
                        <form method='post'>
                            <input type='hidden' name='trxid' value='" . $row["trxid"] . "'>
                            <button type='submit' name='action' value='pay' class='bg-green-500 text-white px-4 py-2 mr-2'>Pay</button>
                            <button type='submit' name='action' value='reject' class='bg-red-500 text-white px-4 py-2'>Reject</button>
                        </form>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr>
                <td colspan='7' class='py-2 px-4 text-center'>No pending transactions.</td>
            </tr>";
    }

    echo "</tbody>
        </table>
    </div>";
    $balanceSql = "SELECT balance, number FROM balance WHERE number IN (SELECT DISTINCT number FROM recharge WHERE status = 'pending')";
    $balanceResult = $conn->query($balanceSql);

    if ($balanceResult->num_rows > 0) {
        echo "<h2 class='text-2xl font-bold mt-8 mb-4'>User Balances</h2>";
        echo "<table class='min-w-full bg-white border border-gray-300'>
                <thead>
                    <tr>
                        <th class='py-2 px-4 border-b'>Number</th>
                        <th class='py-2 px-4 border-b'>Balance</th>
                        <th class='py-2 px-4 border-b'>Merchant Name</th>
                        <th class='py-2 px-4 border-b'>Actions</th>
                    </tr>
                </thead>
                <tbody>";

        while ($balanceRow = $balanceResult->fetch_assoc()) {
            $number = $balanceRow['number'];
            $merchantNameSql = "SELECT name FROM merchant WHERE number = '$number'";
            $merchantNameResult = $conn->query($merchantNameSql);
            $merchantName = ($merchantNameResult->num_rows > 0) ? $merchantNameResult->fetch_assoc()['name'] : '';

            echo "<tr>
                    <td class='py-2 px-4 border-b'>$number</td>
                    <td class='py-2 px-4 border-b'>" . number_format($balanceRow["balance"], 2) . "</td>
                    <td class='py-2 px-4 border-b'>$merchantName</td>
                    <td class='py-2 px-4 border-b'>
                        <button onclick=\"openModal('$number')\" class='bg-blue-500 text-white px-4 py-2 mr-2'>Change Balance</button>
                    </td>
                </tr>";
        }

        echo "</tbody>
            </table>";
    } else {
        echo "<p class='mt-4'>No user balances found.</p>";
    }

    echo "<div id='balanceModal' class='hidden fixed inset-0 bg-gray-500 bg-opacity-75 justify-center items-center flex'>
                <div class='bg-white p-6 rounded shadow-md'>
                    <h2 class='text-lg font-bold mb-4'>Change User Balance</h2>
                    <form method='post'>
                        <input type='hidden' id='modalNumber' name='number'>
                        <label for='new_balance' class='block mb-2'>New Balance:</label>
                        <input type='number' id='new_balance' name='new_balance' class='w-full p-2 border border-gray-300 rounded mb-4' required>
                        <button type='submit' name='change_balance' class='bg-blue-500 text-white px-4 py-2 mr-2'>Change Balance</button>
                        <button type='button' onclick='closeModal()' class='bg-gray-300 text-gray-700 px-4 py-2'>Cancel</button>
                    </form>
                </div>
            </div>

            <script>
                function openModal(number) {
                    document.getElementById('modalNumber').value = number;
                    document.getElementById('balanceModal').classList.remove('hidden');
                }

                function closeModal() {
                    document.getElementById('modalNumber').value = '';
                    document.getElementById('new_balance').value = '';
                    document.getElementById('balanceModal').classList.add('hidden');
                }
            </script>
        </body>
    </html>";

    $conn->close();
} else {
    header("Location: admin.php");
    exit();
}
?>
