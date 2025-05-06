<?php
session_start();
require('secure/session.php');
include('secure/db.php');

$number = $_SESSION['number'];

$stmt = $conn->prepare("SELECT name,photo,tgid FROM merchant WHERE number = ?");
$stmt->bind_param("s", $number);
$stmt->execute();
$stmt->bind_result($name,$photo,$tgid);
$stmt->fetch();
$stmt->close();
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
        <h2 class="p-2 text-xl text-gray-900 mb-2 font-semibold no-select" onclick="goBack()"><i class="fad fa-chevron-left"></i> Settings</h2>
</div>
<hr>
<div class="p-4">
        <div id="alert-container" class="alert-container">
            <div id="alert" class="z-50 p-4 mb-4 text-white text-sm rounded-lg">
                <p id="alert-message"></p>
            </div>
        </div>
   <form id="myForm">
    <div class="mb-6">
        <label for="telegramId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telegram Id</label>
        <input type="text" id="telegramId" class="bg-gray-50 rounded border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Telegram Id" value="<?php echo $tgid; ?>">
       <a class="text-blue-500" href="https://telegram.me/botlink"> need id ?</a>
    </div>
    <div class="mb-6">
        <label for="link" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Logo Link</label>
        <input type="text" id="link" class="bg-gray-50 rounded border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Photo Link" value="<?php echo $photo; ?>">
        <a class="text-blue-500" href="https://telegram.me/botlink">need link ?</a>
        <br>
        <br>
        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
  <span class="font-medium">Notification</span> 
  <br>if You Want Defualt Logo Again put the link <br> 
  <?php
        $avatarUrl = "https://ui-avatars.com/api/?name=" . urlencode($name) . "&format=svg&background=random";
    ?>
     <button id="copyButton" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1.5 me-2 mb-2" data-clipboard-text="<?php echo $avatarUrl; ?>">Copy</button>
     </div>
    <input type="hidden" value="<?php echo $_SESSION['number']; ?>" id="session">
    <button type="button" onclick="submitForm()" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 w-full">Submit</button>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script>
        var clipboard = new ClipboardJS('#copyButton');

        clipboard.on('success', function (e) {
            alert('Copied to clipboard!');
            e.clearSelection();
        });

        clipboard.on('error', function (e) {
            console.error('Unable to copy to clipboard', e);
        });
    </script>
<script>
function submitForm() {
    var telegramId = document.getElementById('telegramId').value;
    var link = document.getElementById('link').value;
    var sessionValue = document.getElementById('session').value;

    var xhr = new XMLHttpRequest();
    var url = 'secure/alert.php';

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                console.log(response);

                showAlert('Update Success', 'success', 2000);
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else {
                showAlert('Unsuccessful', 'error', 2000);
            }
        }
    };

    var data = 'telegramId=' + encodeURIComponent(telegramId) + '&link=' + encodeURIComponent(link) + '&session=' + encodeURIComponent(sessionValue);
    xhr.send(data);
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

 function goBack() {
        window.history.back();
    }
</script>
</body>
</html>