<?php
require('secure/session.php');
include('secure/db.php');

$number = $_SESSION['number'];

$stmt = $conn->prepare("SELECT mid,name FROM merchant WHERE number = ?");
$stmt->bind_param("s", $number);
$stmt->execute();
$stmt->bind_result($userMid,$name);
$stmt->fetch();
$stmt->close();

if (empty($userMid)) {
    $newMid = generateRandomMid();
    $updateMidQuery = $conn->prepare("UPDATE merchant SET mid = ? WHERE number = ?");
    $updateMidQuery->bind_param("ss", $newMid, $number);
    $updateMidQuery->execute();
    $updateMidQuery->close();
}
     $checkBalanceQuery = $conn->prepare("SELECT balance FROM balance WHERE number = ?");
    $checkBalanceQuery->bind_param("s", $number);
    $checkBalanceQuery->execute();
    $checkBalanceQuery->bind_result($userBalance);
    $checkBalanceQuery->fetch();
    $checkBalanceQuery->close();

if (!isset($userBalance)) {
    $insertBalanceQuery = $conn->prepare("INSERT INTO balance (number, balance, totalpayout, status, freeze) VALUES (?, 0.00, 0, 'normal', false)");
    $insertBalanceQuery->bind_param("s", $number);
    $insertBalanceQuery->execute();
    $insertBalanceQuery->close();
}
    $sql = "SELECT SUM(amount) AS totalAmount FROM recharge WHERE number = ? AND status = ?";
    $stmt = $conn->prepare($sql);
    $status = 'paid';
    $stmt->bind_param("ss", $number, $status);
    $stmt->execute();
    $stmt->bind_result($totalAmount);
    $stmt->fetch();
    $stmt->close();
    if (empty($totalAmount)) {
         $totalAmount = 0.00;
    }
    
    
    $getm = "SELECT SUM(amount) AS payout FROM transaction_merchant WHERE merchant = ? AND status = ?";
    $stmt = $conn->prepare($getm);
    $stat = 'success';
    $stmt->bind_param("ss", $number, $stat);
    $stmt->execute();
    $stmt->bind_result($payout);
    $stmt->fetch();
    $stmt->close();
    if (empty($payout)) {
         $payout = 0.00;
    }
    $conn->close();
function generateRandomMid() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randomMid = '';
    for ($i = 0; $i < 10; $i++) {
        $randomMid .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomMid;
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
    #alert-container {
    position: absolute;
    top: 10;
    left: 50%;
    width:90%;
    transform: translateX(-50%);
    z-index: 1000;
}
body {
    overflow-y: auto;
}
         .graph-container {
            width: 100%;
            height: 100px; /* Adjust the height as needed */
            background-color: #f0f0f0;
            position: relative;
        }

        .debit-bar {
            background-color: #e74c3c;
            transition: height 0.5s ease; /* Add smooth transition effect */
        }

        .credit-bar {
            background-color: #3498db;
            transition: height 0.5s ease; /* Add smooth transition effect */
        }

        .tooltip {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 8px;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            border-radius: 4px;
            display: none;
        }
        .blue-701 {
            background-color : #000080;
        }
    </style>
  </head>
  <body class="bg-gray-100 overflow-y-auto no-select" style="font-family: 'Rubik', sans-serif">
      

<section class="max-w-screen-xl mx-auto rounded-b-2xl p-4 bg-indigo-800 shadow-md">
    <nav class="border-gray-200">
        <div class="flex items-center justify-between">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl text-white font-semibold whitespace-nowrap">Merchant</span>
            </a>
            <a href="signout.php"><i class="text-xl text-white fad fa-sign-out"></i></a>
            <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
                <ul class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                    <li>
                        <a href="#" class="block py-2 px-3 md:p-0 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700" aria-current="page">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="p-4">
        <div id="alert-container" class="alert-container">
            <div id="alert" class="p-4 mb-4 text-white text-sm rounded-lg">
                <p id="alert-message"></p>
            </div>
        </div>
        
        <?php
       //if($userBalance < 5) {
            //$text = "Balance Low <a href='recharge.php'>Recharge Now</a>";
            //$hide = "";
            //$icon = "fa-exclamation";
        //} else {
        //    $hide = "hidden";
       // }
        ?>
            <!--<div class="relative p-4 bg-blue-200 border-blue-500 border">
                <span class="absolute top-0 right-0 mt-2 mr-2 text-green-500 cursor-pointer" onmouseover="showTooltip()" onmouseout="hideTooltip()">
                    <i class="fad fa-badge"></i>
                </span>-->
                <br>
            <h2 class="text-lg text-white">Account Balance</h2>
            <div class="flex items-center flex-grow"> 
            <h1 class="text-2xl text-white font-semibold">₹ <?php echo $userBalance; ?></h1>
             
            <div id="tooltip" class="hidden absolute bg-gray-800 text-white p-2 rounded-md mt-2 mr-2">
                Available Fund For Withdrawal!
            </div>
        <a href="recharge.php" class="ml-auto"><i class="text-white text-2xl fad fa-plus-circle"></i></a>
    </div>
        </div>
</section>
    <br>
    <div class="p-4">
  <div class="w-full md:w-1/2 lg:w-1/3">
    <div class="flex">
      <div class="w-full bg-white border-gray-200 border shadow-md p-4 mr-0">
        <h2 class="text-lg mb-0">Recharge</h2>
        <p class="text-2xl text-red-500 font-semibold">₹ <?php echo $totalAmount;?></p>
      </div>
      <div class="w-full bg-white border-gray-200 border shadow-md p-4">
        <h2 class="text-lg mb-0">Payout</h2>
        <p class="text-2xl text-yellow-500 font-semibold">₹ <?php echo $payout; ?></p>
      </div>
    </div>
  </div>
    <br>
<div class="mb-5 bg-white px-4 py-4 rounded-lg">
    <h2 class="text-lg mb-2">Payment Token</h2>
       <p class="text-sm text-gray-500 mb-1">A Secret Token For Payment Api, Never Share This With Any One</p>
  <div class="relative">
  <input
    type="text"
    id="UserEmail"
    placeholder="Secret"
    class="peer h-8 w-full rounded border-none bg-gray-100 p-1 pl-8 placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm"
    value="<?php echo $userMid; ?>"
    disabled
  />
  <button id="resetButton" class="absolute rounded-r text-white inset-y-0 right-0 flex items-center px-2 bg-red-300">
    Reset &nbsp;<i class="fad fa-wrench text-gray-500"></i>
  </button>
  
  <input type="hidden" id="session" value="<?php echo $number; ?>">
</div>
</div>
<div class="mb-5 bg-white px-4 py-4 rounded-lg">
    <h2 class="text-lg mb-2">Payment Api</h2>
       <p class="text-sm text-gray-500 mb-1">Api To Send Money To Your Users</p>
  <div class="relative">
  <input
    type="url"
    id="UserLink"
    placeholder="Secret"
    class="peer h-8 w-full rounded border-none bg-gray-100 p-1 pl-8 placeholder-transparent focus:border-transparent focus:outline-none focus:ring-0 sm:text-sm"
    value="https://color-pix.in/Merchant/secure/auth/s9/?number={number}&amount={amount}&com={comment}&uid=<?php echo $userMid; ?>"
    disabled
  />
  <button id="copyButton" class="absolute rounded-r text-white inset-y-0 right-0 flex items-center px-2 bg-red-300">
    copy &nbsp;<i class="fad fa-copy text-gray-500"></i>
  </button>
</div>
</div>
<br>
<br>
<br>
<div class="fixed bottom-3 left-3 right-3 bg-white border-gray-100 border rounded-full text-black font-semibold px-3 py-2 ">
        <div class="flex justify-around">
          <!-- First Icon -->
          <div class="flex flex-col items-center text-center">
            <div class="bg-yellow-100 text-blue-700 rounded-full p-1 h-8 w-8 flex items-center justify-center mb-1">
              <i style="color: rgb(210, 122, 40);" class="fad fa-home text-xl"></i>
            </div>
            <span class="text-xs">Home</span>
          </div>
          <!-- Second Icon -->
          <a href="recharge.php">
            <div class="flex flex-col items-center text-center">
              <div class="bg-pink-100 text-blue-700 rounded-full p-1 h-8 w-8 flex items-center justify-center mb-1">
                <i style="color: rgb(255, 42, 120);" class="fad fa-rupee-sign text-xl"></i>
              </div>
              <span class="text-xs">Recharge</span>
            </div>
          </a>
          <a href="profile.php">
          <div class="flex flex-col items-center text-center">
            <div class="bg-blue-300 text-white rounded-full p-1 h-8 w-8 flex items-center justify-center mb-1">
              <i style="color: rgb(247, 247, 247);" class="fad fa-user text-xl"></i>
            </div>
            <span class="text-xs">Profile</span>
          </div></a>
        </div>
      </div>
      </div>
      
      <div id="resetModal" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

  <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
          <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
              <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
              <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Reset MerchantId</h3>
              <div class="mt-2">
                <p class="text-sm text-gray-500">Are you sure you want to reset? This action cannot be undone.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
          <button onclick="resetMid()" type="button" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Reset</button>
          <button onclick="closeResetModal()" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">No</button>
        </div>
      </div>
    </div>
  </div>
  </div>
      <!--<div id="resetModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <center><div class="bg-white p-4 rounded">
        <p>Are you sure you want to reset?</p>
        <button onclick="resetMid()" class="bg-green-500 text-white px-4 py-2 m-2 reset-button">Yes</button>
        <button onclick="closeResetModal()" class="bg-red-500 text-white px-4 py-2 m-2 reset-button">No</button>
    </div></center>
</div>-->



</div>
      <script>
        document.getElementById('copyButton').addEventListener('click', function() {
    var copyText = document.getElementById("UserLink");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
    showAlert('Copied To Clipboard', 'success', 2000);
});

function showAlert(message, type, delay) {
    var alertContainer = document.getElementById('alert-container');
    var alertMessage = document.getElementById('alert-message');
    var alertElement = document.getElementById('alert');

    alertMessage.innerHTML = message;

    if (type === 'success') {
        alertElement.classList.add('bg-green-500');
    } else if (type === 'error') {
        alertElement.classList.add('bg-red-500');
    }

    alertContainer.classList.remove('hidden');

    if (delay > 0) {
        setTimeout(function() {
            alertContainer.classList.add('hidden');
        }, delay);
    }
}

document.getElementById('resetButton').addEventListener('click', function() {
    document.getElementById('resetModal').classList.remove('hidden');
});

function close() {
    document.getElementById('warn').classList.add('hidden');
}

function closeResetModal() {
    document.getElementById('resetModal').classList.add('hidden');
}

function resetMid() {
    closeResetModal();

    var sessionNumber = document.getElementById('session').value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            console.log(response);
            if (response.status === 'success') {
                document.getElementById('UserEmail').value = response.newMid;
                showAlert('Merchant Id Reset Success !', 'success', 2000);
            } else {
                console.error('Failed to reset mid.');
            }
        }
    };
    xhr.open('POST', 'secure/reset_mid.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('number=' + sessionNumber);
}

function generateMid() {
    return 'NewMid123'; 
}

</script>
<script>
    function showTooltip() {
        var tooltip = document.querySelector('.tooltip');
        tooltip.style.display = 'block';
    }

    function hideTooltip() {
        var tooltip = document.querySelector('.tooltip');
        tooltip.style.display = 'none';
    }
</script>
      </body>
      </html>