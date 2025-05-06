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
    .no-select a {
    text-decoration: none;
    color: inherit;
}
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

    <body class="bg-white" style="font-family: 'Rubik', sans-serif">

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
    <h2 class="text-2xl">Withdraw History</h2>
    <p class="text-sm">Service provided By Avneger</p>
    <br>

    <?php
    include('db.php');

    $userNumber = $_SESSION['number'];
    $sql = "SELECT id, user, time, type, status, trxid, amount FROM withdraw WHERE user = '$userNumber' ORDER BY time DESC";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               $statusClass = ($row['status'] === 'pending') 
    ? 'text-yellow-500' 
    : (($row['status'] === 'paid') 
        ? 'text-green-500' 
        : (($row['status'] === 'reject') 
            ? 'text-red-500' 
            : 'text-red-500'));

    ?>
                <div class="p-2 mb-2 flex items-center">
                    <div class="rounded-full overflow-hidden h-12 w-12">
                        <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name=Debit&format=svg&background=random" alt="<?php echo $row['user']; ?> Avatar">
                    </div>
                    <div class="flex-grow ml-4">
                        <p class="text-black text-red-500 font-semibold">₹<?php echo $row['amount']; ?></p>
                        <p class="text-gray-600"><?php echo ($row['time']); ?></p>
                    </div>
                    <p class="<?php echo $statusClass; ?> font-semibold"><?php echo ucfirst($row['status']); ?></p>
                </div>
    <?php
            }
        } else {
            echo "<div class='p-2'>
            <script src='https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js'></script>
<center><lottie-player src='https://lottie.host/5d11890d-8fe2-413c-98cf-21c9eb47af7a/YLgqDvXyx9.json' background='transparent' speed='1' style='width: 300px; height: 300px' direction='1' mode='normal' loop autoplay></lottie-player></center>
<h2 class='text-center text-xl'>No Withdrawal history found.</h2>
</div>";
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

    $conn->close();
    ?>
</div>
</div>
</body>
</html>