<?php
include('bal.php');
$id = $_GET['id'];

if (!ctype_digit($id)) {
    die("Invalid input");
}

$sql = "SELECT * FROM transactions WHERE id = $id";
$res = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($res);

if ($row) {
    $user = $row['user'];
    $merchant = $row['merchant'];
    $amount = $row['amount'];

function convertNumberToWords($number) {
    $words = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
    $tens = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];
    $teens = ["", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"];

    $numberInWords = '';

    $crore = floor($number / 10000000);
    $number %= 10000000;

    $lakh = floor($number / 100000);
    $number %= 100000;

    $thousand = floor($number / 1000);
    $number %= 1000;

    $hundred = floor($number / 100);
    $number %= 100;

    if ($crore) {
        $numberInWords .= convertNumberToWords($crore) . " Crore ";
    }

    if ($lakh) {
        $numberInWords .= convertNumberToWords($lakh) . " Lakh ";
    }

    if ($thousand) {
        $numberInWords .= convertNumberToWords($thousand) . " Thousand ";
    }

    if ($hundred) {
        $numberInWords .= $words[$hundred] . " Hundred ";
    }

    if ($number >= 20) {
        $numberInWords .= $tens[floor($number / 10)] . " ";
        $number %= 10;
    } elseif ($number >= 11) {
        $numberInWords .= $teens[$number - 10] . " ";
        $number = 0;
    }

    $numberInWords .= $words[$number];

    return $numberInWords;
}
    $type = $row['type'];
    $date_time = $row['date_time'];
    $pic = $row['pic'];
    $trx = $row['trx'];
    $com = $row['com'];
    $textamo = convertNumberToWords($amount);
} else {
    echo "No record found";
}
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

      .container-r {
        display: block;
        background-color: #cccccc70;
        width: 90%;
        position: relative;
        border-radius: 6px;
        overflow: hidden;
        cursor: pointer;
      }

      .container-r .content-zr {
        display: block;
        margin: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .inline-container {
        display: flex;
        align-items: center;
      }

      .inline-container img {
        margin-right: 10px;
      }

      .flex-container {
        display: flex;
        align-items: center;
      }

      .avatar-z {
        margin-left: auto;
        /* Add some space between text and image */
      }

      .avatar-image {
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
      }

      .avatar-image-z {
        width: 60px;
        height: 60px;
        border-radius: 0%;
        object-fit: cover;
      }

      .inline-p {
        display: inline-block;
        margin: 0;
        vertical-align: middle;
      }

      .copy {
        color: blue;
        margin-left: 10px;
        /* Add some space between the paragraphs */
        cursor: pointer;
      }
    </style>
    <script>
    function goBack() {
        window.history.back();
    }
          
</script>
  </head>
  <body class="bg-white no-select" style="font-family: 'Rubik', sans-serif">
    <div>
      <h2 class="p-2 text-xl text-gray-900 mb-2 font-semibold no-select" onclick="goBack()">
        <i class="fad fa-chevron-left"></i> Cashback Received
      </h2>
    </div>
    <hr>
    <div class="p-4">
      <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
      <lottie-player src="https://lottie.host/63d8c4d2-2aea-4bd9-b4e0-8c1ee79c0ab0/RyoQ1oGfU5.json" background="#ffffff" speed="1" style="width: auto; height: 150px" loop autoplay direction="1" mode="normal"></lottie-player>
      <center>
        <h2 class="font-bold text-2xl">₹<?php echo $amount; ?></h2>
        <span>Rupees <?php echo $textamo; ?> Only</span>
      </center>
      <br>
      <center>
        <div class="container-r" id="messageContainer">
          <div class="content-zr"> <?php echo $com; ?> </div>
        </div>
      </center>
      <br>
      <hr>
      <hr class="">
      <div class="flex-container">
        <div><br>
          <h4 style="text-align: start;">From</h4>
          <h3 style="font-size: 20px; text-align: start;"><?php echo $merchant; ?></h3>
        </div>
        <div class="avatar-z">
          <img class="avatar-image" src="<?php echo $pic; ?>" alt="User Avatar">
        </div>
      </div>
      <hr>
      <div class="flex-container">
        <div><br>
          <h4 style="text-align: start;">In Your</h4>
          <h3 style="text-align: start;font-size: 20px;">WEBSITE Wallet</h3>
          <p style="text-align: start;font-style: normal;">Current Balance : ₹<?php echo $balance; ?></p>
        </div>
        <div class="avatar-z">
          <img class="avatar-image-z" src="Vector/p-walle.png" alt="User wallet">
        </div>
      </div>
      <br>
      <p style="text-align: start;font-style: normal;">Received at <?php echo $date_time; ?></p>
      <p class="inline-p" style="text-align: start; font-style: normal;">Ref No : <?php echo $trx; ?></p>
      <p class="inline-p copy">copy</p>
    </div>
    </div>
    </div>
    <script>
      const messageContainer = document.getElementById('messageContainer');
      const content = messageContainer.querySelector('.content-zr');
      messageContainer.addEventListener('click', function() {
        if (content.style.whiteSpace === 'normal') {
          content.style.whiteSpace = 'nowrap';
          content.style.overflow = 'hidden';
          content.style.textOverflow = 'ellipsis';
        } else {
          content.style.whiteSpace = 'normal';
          content.style.overflow = 'auto';
          content.style.textOverflow = 'clip';
        }
      });
    </script>
  </body>
</html>