<?php 
require('session.php');
include('bal.php');
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0" /><title>Webname</title><link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet"
    /><link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    rel="stylesheet"
    /><link rel="stylesheet"
    href="https://unpkg.com/tippy.js@6/animations/scale-extreme.css"
    /><link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    rel="stylesheet"
    /><link href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
    rel="stylesheet"
    /><link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    rel="stylesheet"
    crossorigin="anonymous"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
    /><link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"
    /><link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&family=Poppins:wght@200;300;400;500;600;700;800&&family=Rubik:wght@200;300;400;500;600;700;800&display=swap"
    rel="stylesheet"
    /><link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
    rel="stylesheet"
    /><link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
    /><link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .payment-options input:checked+label {
    border: 2px solid #00e84d;
    background-color: #ecfcf3;
    color: #000;
    transition: all .2s;
}

.payment-options input:disabled+label {
    border: 2px solid silver;
    background-color: #d0d0d0;
    color: #000;
    transition: all .2s;
}
.no-select {
    user-select: none;
    -webkit-tap-highlight-color: transparent; 
}

.no-select a {
    text-decoration: none;
    color: inherit;
}

    </style>
    </head>

    <body class="bg-white no-select" style="font-family: 'Rubik', sans-serif">

       <div>
        <h2 class="p-2 text-xl text-gray-900 mb-2 font-semibold no-select" onclick="goBack()"><i class="fad fa-chevron-left"></i> Recent</h2>
</div>
<script>
    function goBack() {
        window.history.back();
    }
          
</script>
<hr>
<div class="p-2">
    <h2 class="text-xl">Transaction History</h2>
    <p class="text-sm">Service provided By Avenger</p>
    <br>

    <!-- Filter buttons -->
    <div class="mb-4">
        <button onclick="filterTransactions('debit')" class="bg-blue-500 text-white px-16 py-2 mr-2">Debit</button>
        <button onclick="filterTransactions('credit')" class="bg-green-500 text-white px-16 py-2 ">Credit</button>
    </div>

    <!-- Search bar -->
    <div class="mb-4">
        <input type="text" id="merchantSearch" oninput="searchTransactions()" placeholder="Search by Merchant" class="border p-2 w-full rounded-lg">
    </div>

    <?php
    include('db.php');

    $userNumber = $_SESSION['number'];
    $sql = "SELECT id, user, merchant, amount, type, date_time, pic FROM transactions WHERE user = '$userNumber' ORDER BY date_time DESC";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $statusClass = ($row['type'] === 'debit') ? 'text-red-500' : 'text-green-500';
    ?>
                <div class="p-2 mb-2 flex items-center" id="transaction_<?php echo $row['id']; ?>">
                    <div class="rounded-full overflow-hidden h-12 w-12">
                        <img class="w-full h-full object-cover" src="<?php echo $row['pic']; ?>" alt="<?php echo $row['merchant']; ?> Avatar">
                    </div>
                    <div class="flex-grow ml-4">
                        <a href="view.php?id=<?php echo $row['id']; ?>"><p class="text-black"><?php echo $row['merchant']; ?></p>
                        <p class="text-gray-600"><?php echo date('d M Y \a\t h:i A', strtotime($row['date_time'])); ?></p></a>
                    </div>
                    <p class="<?php echo $statusClass; ?> font-semibold">
                        <?php echo ($row['type'] === 'debit' ? '-' : '+') . '₹' . number_format($row['amount'], 2); ?>
                    </p>
                </div>
    <?php
            }
        } else {
            echo "No transaction history found.";
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

    $conn->close();
    ?>
</div>

<script>
    function filterTransactions(type) {
        var searchInput = document.getElementById('merchantSearch');
        searchInput.value = ''; 

        var transactions = document.querySelectorAll('.flex.items-center');
        transactions.forEach(function(transaction) {
            var transactionType = transaction.querySelector('.font-semibold').textContent.trim().charAt(0);
            if (type === 'debit' && transactionType === '-') {
                transaction.style.display = 'flex';
            } else if (type === 'credit' && transactionType === '+') {
                transaction.style.display = 'flex';
            } else {
                transaction.style.display = 'none';
            }
        });
    }

    function searchTransactions() {
        var searchInput = document.getElementById('merchantSearch');
        var searchTerm = searchInput.value.toLowerCase();

        var transactions = document.querySelectorAll('.flex.items-center');
        transactions.forEach(function(transaction) {
            var merchantName = transaction.querySelector('.text-black').textContent.toLowerCase();
            if (merchantName.includes(searchTerm)) {
                transaction.style.display = 'flex';
            } else {
                transaction.style.display = 'none';
            }
        });
    }
</script>

</body>

</html>