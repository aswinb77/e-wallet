<?php
require('secure/session.php');
include('secure/db.php');

$number = $_SESSION['number'];
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    #alert-container {
    position: absolute;
    top: 10;
    left: 50%;
    width:90%;
    transform: translateX(-50%);
    z-index: 1000;
}
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
  .bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 9;
    padding-left: 20px;
    padding-right: 20px;
    padding-bottom: 10px;
    padding-top: 10px;
    max-width: 500px;
    backdrop-filter: blur(20px);
    margin-left: auto;
    margin-right: auto;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    box-shadow: -1px 20px 20px 15px rgb(0 0 0 / 20%);
}

.bottom-nav {
    header-bg) !important;
    backdrop-filter: blur(20px);
    border-top-left-radius: 15px !important;
    border-top-right-radius: 15px !important;
    max-width: 462px !important;
    display: flex;
    align-content: stretch;
    justify-content: center;
    align-items: center;
    transition: all .5s;
}

*, *:before, *:after {
    box-sizing: inherit;/*for all Page Note */
}

  .button {
        font-family: Barlow, sans-serif !important;
        cursor: pointer;
        overflow: hidden;
        position: relative;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        font-weight: 900 !important;
        -webkit-tap-highlight-color: transparent;
    }
    .button{
        padding: 0 25px 0 25px;
        height: 50px;
        width: 100%;
        border: 0;
        border-radius: 4px;
        background: rgb(26 220 48);
        font-family: 'Segoe UI';
        font-size: 18px;
        font-weight: 400;
        text-transform: capitalize;
        letter-spacing: 0;
        color: #FFFFFF;
        cursor: pointer;
        outline: none;
        word-wrap: 5px;
        letter-spacing: 0px;
        box-shadow: rgba(0, 0, 0, 0.2) 0px 2px 8px 0px;
        transition: transform 0.9s ease-out;
    }
    button{
        text-shadow: none !important;
    }
</style>
  </head>
  <body class="bg-white no-select" style="font-family: 'Rubik', sans-serif">
      <section class="max-w-screen-xl mx-auto rounded-b-2xl p-4 bg-indigo-800 shadow-md">
       <div>
        <h2 class="p-2 text-xl text-white mb-2 font-semibold no-select" onclick="goBack()"><i class="text-white fad fa-chevron-left"></i>&nbsp; Recharge</h2>
</div>
<script>
    function goBack() {
        window.history.back();
    }
          
</script>
        <hr class="my-1 border-indigo-700">
        
    <div class="p-4">
    <h1 class="text-2xl text-white font-semibold">Add Fund</h1>
    <p class="text-sm text-white start">Service Provided By Avenger</p>
    </section>
    <div class="p-4">
        <div id="alert-container" class="alert-container">
            <div id="alert" class="p-4 mb-4 text-white text-sm rounded-lg">
                <p id="alert-message"></p>
            </div>
        </div>
    <p class="text-sm"><span class="font-bold">Notice</span>: Recharge Amount will be Increased as per System charges</p><br>
      <center>
    <div class="relative w-64 h-64 overflow-hidden bg-gray-200 rounded-lg item-center">
      <button onclick="showImage()" class="absolute inset-0 flex items-center justify-center bg-blur w-full h-full focus:outline-none">
        <span class="text-white">Show Image</span>
      </button>
      <img id="image" src="https://via.placeholder.com/300" alt="Image" class="item-center hidden w-full h-full object-cover">
    </div>

    <ul class="text-left list-disc mt-4 ml-6">
      <li>Kindly Scan The Above Qr And Pay</li>
      <li>Upload the Screenshot and wait</li>
      <li>We will Add other Systems As Soon As Possible</li>
    </ul>

  </center>
  <br>
  <center>
     <form id="myForm" class="p-4" enctype="multipart/form-data">
    <input type="number" class="mb-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter Amount">
    <input class="mb-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" id="file_input" type="file">
    <br>
    <input type="hidden" id="session" value="<?php echo $number; ?>">
    <br>
    <div class="container">
        <div class="bottom-nav">
            <button class="button" type="button" onclick="submitForm()">Submit</button>
        </div>
    </div>
</form>
</center>
  </div>
 </div>       

  <script>
    function showImage() {
      document.getElementById("image").classList.remove("hidden");
      document.querySelector("button").classList.add("hidden");
    }

    function downloadImage() {
      alert("Download initiated!");
    }
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
  </script>
  <script>
function submitForm() {
    $('.button').text('Processing');

    var formData = new FormData($('#myForm')[0]);
    var inputFile = $('#file_input')[0].files[0];
    var amountValue = $('#myForm input[type=number]').val();
    var sessionValue = $('#session').val();

    if (!inputFile || amountValue === '' || sessionValue === '') {
        showAlert('Invalid Input', 'error', 2000);
        $('.button').text('Fail');
        return;
    }

    if (inputFile && !isValidImageFormat(inputFile)) {
        showAlert('Error: Invalid image format. Please upload a png, jpg, or gif file.', 'error', 2000);
        $('.button').text('Fail');
        return;
    }

    formData.append('amount', amountValue);
    formData.append('session', sessionValue);
    formData.append('file_input', inputFile);

    $.ajax({
        type: 'POST',
        url: 'secure/recharge.php',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            showAlert('Recharge Success ! Will take Some time To Reflect', 'success', 2000);
            $('.button').text('Success');
            setTimeout(function() {
        location.reload();
    }, 2000); 
},
        error: function (error) {
            showAlert('Unsuccessful', 'error', 2000);
            $('.button').text('Fail');
        }
    });
}


function isValidImageFormat(file) {
    var allowedFormats = ['image/png', 'image/jpeg', 'image/gif'];
    return allowedFormats.includes(file.type);
}
</script>

  </body>
  </html>