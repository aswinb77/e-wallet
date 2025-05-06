<?php
    require('secure/session.php');
    include('secure/db.php');

    $number = $_SESSION['number'];
$sql = "SELECT * FROM recharge WHERE number = '$number'";
$result = $conn->query($sql);
    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Webname</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale-extreme.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" rel="stylesheet" />
    <link href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" rel="stylesheet" crossorigin="anonymous" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&family=Poppins:wght@200;300;400;500;600;700;800&&family=Rubik:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    *:focus {
    outline: none;
}
    .no-select {
    user-select: none;
    -webkit-tap-highlight-color: transparent; 
    }

    .no-select a {
        text-decoration: none;
        color: inherit;
    }
    .no-select body {
        text-decoration: none;
        color: inherit;
    }
    </style>
  </head>
  <body class="bg-white-100 no-select" style="font-family: 'Rubik', sans-serif">
      <div>
        <h2 class="p-2 text-xl text-gray-900 mb-2 font-semibold no-select" onclick="goBack()"><i class="fad fa-chevron-left"></i> Recharge History</h2>
</div>
<hr>
      <div class="p-2">
       <?php
        while ($row = $result->fetch_assoc()):
            $trx = $row['trxid'];
            $amo = $row['amount'];
            $date = $row['date'];
            $sta = $row['status'];

            $icon = '';
            if ($sta == 'paid') {
                $icon = 'fa-check-circle text-green-500';
                $bg = 'green-200';
                $t = 'text-green-500 border border-green-600';
            } elseif ($sta == 'pending') {
                $icon = 'fa-exclamation-circle text-yellow-500';
                 $bg = 'yellow-200';
                 $t = 'text-yellow-500 border border-yellow-600';
            } else {
                 $bg = 'red-200';
                 $t = 'text-red-500 border border-red-600';
                $icon = 'fa-times-circle text-red-500';
            }
        ?>

        <div class="card-container flex items-center bg-transparent p-4 w-full">
            <div class="flex items-center justify-between w-full">
                <div>
                    <h2 class="text-lg font-semibold">
                        ₹ <?php echo $amo; ?> <i class="fad <?php echo $icon; ?> text-lg"></i>
                    </h2>
                    <p class="text-gray-500"><?php echo $date; ?></p>
                </div>
                <div class="ml-auto flex flex-col items-end">
                    <button class="bg-<?php echo $bg;?> <?php echo $t;?> rounded-full px-4 py-2 w-24 items-center"><?php echo $sta; ?> </button>
                    <p class="text-sm text-gray-400 mt-1">#<?php echo $trx; ?></p>
                </div>
            </div>
        </div>
        <hr class="mb-2">

        <?php endwhile; ?>

        <center><p class="text-sm text-gray-500 items-center">Need help? Contact</p></center>
    </div>
    <script>
    function goBack() {
        window.history.back();
    }
          
</script>
</body>
</html>


