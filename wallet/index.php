<?php
   include('bal.php');
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
  <body class="bg-gray-100 no-select" style="font-family: 'Rubik', sans-serif">
    <nav class="bg-white mb-4 dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://ui-avatars.com/api/?name=Avenger&format=svg" class="h-8" alt="Logo">
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Avenger</span>
            </a>
        </div>
    </nav>
    <br>
    <br>
    <br>
    <div class="p-4">
      <h2 class="text-xl font-semibold" id="personName">Hello, <span id="userNamePlaceholder"></span>
        <i style="color: #00a196;" class="fad fa-check-circle"></i>
      </h2>
      <p class="text-sm">Take a Look At Your Dashboard</p>
      <br>
      <img src="Vector/flower.png" class="h-20 top-12 right-6 fixed">
      <div class="relative p-4 bg-blue-100 border rounded-lg">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl text-blue-500 font-semibold" id="accountBalance">
              <i class="fad fa-rupee-sign"></i> <?php echo $balance; ?>
            </h1>
            <h2 class="text-blue-500">Account Balance</h2>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="p-4">
      <h2 class="text-xl font-semibold">Payment History</h2>
      <p class="text-sm ">Powered By Avenger</p>
      <br>
      <div id="transactionContainer">
      </div>
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
          <a href="withdraw.php">
            <div class="flex flex-col items-center text-center">
              <div class="bg-pink-100 text-blue-700 rounded-full p-1 h-8 w-8 flex items-center justify-center mb-1">
                <i style="color: rgb(255, 42, 120);" class="fa fa-bank text-xl"></i>
              </div>
              <span class="text-xs">Withdraw</span>
            </div>
          </a>
          <!-- Third Icon -->
          <div class="flex flex-col items-center text-center">
            <div class="bg-green-100 text-blue-700 rounded-full p-1 h-8 w-8 flex items-center justify-center mb-1">
              <i style="color: rgb(143, 184, 11);" class="fad fa-users text-xl"></i>
            </div>
            <span class="text-xs">Transfer</span>
          </div>
          <!-- Fourth Icon -->
          <a href="more.php">
          <div class="flex flex-col items-center text-center">
            <div class="bg-blue-300 text-white rounded-full p-1 h-8 w-8 flex items-center justify-center mb-1">
              <i style="color: rgb(247, 247, 247);" class="fad fa-bars text-xl"></i>
            </div>
            <span class="text-xs">More</span>
          </div></a>
        </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <script>
        var offset = 0;
        var limit = 10;
        var fetching = false;

        function fetchTransactions() {
          if (fetching) return;
          fetching = true;
          $.ajax({
            type: "GET",
            url: "getTransactions.php",
            data: {
              offset: offset,
              limit: limit
            },
            success: function(response) {
              if (response.trim() === '') {
                addEmptyTransactionsAnimation();
              } else {
                $("#transactionContainer").append(response);
                offset += limit;
              }
              fetching = false;
            },
            error: function() {
              fetching = false;
            },
          });
        }

        function addEmptyTransactionsAnimation() {
          var animationContainer = document.createElement('div');
          var textElement = document.createElement('p');
          textElement.textContent = "No transactions";
          textElement.style.textAlign = "center";
          var dotlottieScript = document.createElement('script');
          dotlottieScript.src = "https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs";
          dotlottieScript.type = "module";
          var dotlottiePlayer = document.createElement('dotlottie-player');
          dotlottiePlayer.src = "https://lottie.host/cb8ddd7d-9ad1-49dc-b2de-7b96be5fb2cd/V4qytVk9Iq.json";
          dotlottiePlayer.background = "transparent";
          dotlottiePlayer.speed = "1";
          dotlottiePlayer.style = "width: 300px; height: 300px; margin: auto; display: block;";
          dotlottiePlayer.loop = true;
          dotlottiePlayer.autoplay = true;
          animationContainer.appendChild(textElement);
          animationContainer.appendChild(dotlottieScript);
          animationContainer.appendChild(dotlottiePlayer);
          $("#transactionContainer").after(animationContainer);
        }
        fetchTransactions();
        $(window).scroll(function() {
          if ($(window).scrollTop() + $(window).height() == $(document).height()) {
            fetchTransactions();
          }
        });
      </script>
  </body>
</html>