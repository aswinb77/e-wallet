<?php
session_start();
require('secure/session.php');
include('secure/db.php');

$number = $_SESSION['number'];

$stmt = $conn->prepare("SELECT name,password,email,photo FROM merchant WHERE number = ?");
$stmt->bind_param("s", $number);
$stmt->execute();
$stmt->bind_result($name,$pass,$email,$photo);
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
     <section class="max-w-screen-xl mx-auto rounded-b-2xl p-4 bg-indigo-800 shadow-md"> 
        <h2 class="p-2 text-xl text-white mb-2 font-semibold no-select" onclick="goBack()"><i class="text-white fad fa-chevron-left"></i>&nbsp; Account</h2>
        <hr class="my-1 border-indigo-700">
        <div class="p-4">
    <div class="flex items-center mb-4">
        <?php 
        if($photo == 'nil'){
            $pic = "https://ui-avatars.com/api/?name=$name&format=svg&background=random";
        } else {
            $pic = $photo;
        }
        ?>
        <img src="<?php echo $pic; ?>" alt="Profile Picture" class="w-16 h-16 rounded-full mr-4">
        <div class="flex flex-col justify-center">
            <div class="flex items-center">
                <h2 class="text-2xl text-white font-bold mr-2"><?php echo $name; ?></h2>
                <i class="fad fa-check-circle text-green-500 text-lg"></i>
            </div>
            <p class="text-gray-400">Merchant</p> 
        </div>
        </div>
    </div>
</div>
</section>
  <div class="p-4">
<div class="flex items-center mb-2">
            <div class="bg-purple-100 text-white rounded-full p-2 h-8 w-8 flex items-center justify-center">
                <i style="color: rgb(0, 0, 0);" class="fad fa-user"></i>
            </div>
            <span class="ml-2">Account details</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fad fa-chevron-down" id="toggleElements"></i>
        </div>
        <div class="hidden mb-4" id="additionalElements">
           <div class="mb-1 rounded-full p-2  border-gray-200 border">
              <span class="px-2 py-1 rounded inline-flex items-center">
                <i style="color: rgb(255, 42, 120);" class="fad fa-phone"></i>
                <span class="ml-2">Phone: <?php echo $number; ?></span>
              </span>
             </div>
              <div class="mb-1 rounded-full p-2  border-gray-200 border">
              <span class="px-2 py-1 rounded inline-flex items-center">
                <i style="color: rgb(0, 123, 255);" class="fad fa-envelope"></i>
                <span class="ml-2">Email: <?php echo $email; ?></span>
              </span>
              </div>
              <div class="mb-1 rounded-full p-2  border-gray-200 border">
                <span class="px-2 py-1 rounded inline-flex items-center">
                    <i style="color: rgb(0, 172, 92);" class="fad fa-lock"></i>
                    <span class="ml-2">Password: ********</span>
                </span>
            </div>
            </div>
                <div id="changePasswordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-4 rounded">
                <h2 class="text-lg font-semibold mb-4">Change Password</h2>
                <input type="password" id="oldPassword" placeholder="Old Password" class="mb-2 p-2 border rounded">
                <input type="password" id="newPassword" placeholder="New Password" class="mb-4 p-2 border rounded">
                <button onclick="changePassword()" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                <button onclick="closeChangePasswordModal()" class="bg-red-500 text-white px-4 py-2 ml-2 rounded">Cancel</button>
            </div>
        </div>
        <hr class="my-4">
        <div class="flex items-center">
            <div class="bg-yellow-100 text-white rounded-full p-2 h-8 w-8 flex items-center justify-center">
                <i style="color: rgb(255 138 42);" class="fad fa-receipt"></i>
            </div>
           <a href="rhistory.php"><span class="ml-4">Recharge History</span></a> 
        </div>
        <hr class="my-4">
        <div class="flex items-center">
            <div class="bg-red-100 text-white rounded-full p-2 h-8 w-8 flex items-center justify-center">
                <i style="color: rgb(255, 42, 120);" class="fad fa-image"></i>
            </div>
           <a href="alert.php"><span class="ml-4">Logo/Alerts</span></a> 
        </div>
        <hr class="my-4">
        <?php
        $botToken = '1977469600:AAEJmiPTYxpBa7bvoOENuu04ShHZvH9HNcM';
        $channelUsername = '@Jlooter';
        
        $apiUrl = "https://api.telegram.org/bot$botToken/getChat?chat_id=$channelUsername";
        $response = file_get_contents($apiUrl);
        $apiUrl = "https://api.telegram.org/bot$botToken/getChat?chat_id=$channelUsername";
        $response = file_get_contents($apiUrl);
        $channelData = json_decode($response, true);
        
        if ($channelData['ok']) {
            $channelName = $channelData['result']['title'];
            $channelMembers = $channelData['result']['members_count'];
            $channelPhoto = $channelData['result']['photo']['big_file_id'];
            $fileApiUrl = "https://api.telegram.org/bot$botToken/getFile?file_id=$channelPhoto";
            $fileResponse = file_get_contents($fileApiUrl);
            $fileData = json_decode($fileResponse, true);
            $filePath = $fileData['result']['file_path'];
            $imageUrl = "https://api.telegram.org/file/bot$botToken/$filePath";
        }
?>

        <div class="flex items-center">
            <div class="bg-blue-100 text-white rounded-full p-2 h-8 w-8 flex items-center justify-center">
                <i style="color: rgb(30 104 251);" class="fad fa-paper-plane"></i>
            </div>
            <span class="ml-4">Telegram Channel</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fad fa-chevron-down" id="telegram"></i>
        </div>
        <div class='max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md overflow-hidden' id= 'tg-id' style='display: none;'>
        <div class='flex items-center'>
            <img src='<?php echo $imageUrl; ?>' alt='Channel Photo' class='h-16 w-16 rounded-full'>
            <div class='ml-4'>
                <h2 class='text-xl font-bold'><?php echo $channelName; ?></h2>
                <p class='text-gray-500'><?php echo $channelMembers; ?> Members</p>
            </div>
        </div>
        <div class='mt-4'>
            <button class='bg-blue-500 text-white px-4 py-2 rounded-full'>Join Channel</button>
        </div>
    </div>

<?php
$token = '1977469600:AAEJmiPTYxpBa7bvoOENuu04ShHZvH9HNcM';
$username = '1320785887';

$apiUrl = "https://api.telegram.org/bot$token/getChat?chat_id=$username";

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    $result = json_decode($response, true);

    if ($result['ok']) {
        $user = $result['result'];
        $userPhoto = $user['photo']['big_file_id'] ?? '';
        $userId = $user['id'] ?? '';
        $userName = $user['username'] ?? '';
        if (!empty($userPhoto)) {
            $imageApiUrl = "https://api.telegram.org/bot$token/getFile?file_id=$userPhoto";
            $imageApiResponse = file_get_contents($imageApiUrl);
            $imageResult = json_decode($imageApiResponse, true);

            if ($imageResult['ok']) {
                $fileUrl = 'https://api.telegram.org/file/bot' . $token . '/' . $imageResult['result']['file_path'];
            } else {
                echo "Error fetching image: " . $imageResult['description'];
            }
        }
    } else {
        echo 'Error fetching user details: ' . $result['description'];
    }
}

curl_close($ch);
?>
        <hr class="my-4">
        <div class="flex items-center">
            <div class="bg-yellow-100 text-white rounded-full p-2 h-8 w-8 flex items-center justify-center">
                <i style="color: rgb(0, 0, 0);" class="fad fa-user"></i>
            </div>
            <span class="ml-4">Support</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fad fa-chevron-down" id="user"></i>
        </div>
        <div class='max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md overflow-hidden' id='user-id' style='display: none;'>
            <div class='flex items-center'>
                <img src='<?php echo $fileUrl; ?>' alt='User Photo' class='h-16 w-16 rounded-full'>
                <div class='ml-4'>
                    <h2 class='text-xl font-bold'><?php echo $userName; ?></h2>
                    <p class='text-gray-500'>User ID: <?php echo $userId; ?></p>
                    </div>
                    </div>
                    <div class='mt-4'>
            <button class='bg-blue-500 text-white px-4 py-2 rounded-full'><i class="fad fa-comment-dots"></i> Contact Now</button>
        </div>
                    </div>
        <hr class="my-4">
    </div>
            </div><input type="hidden" id="session" value="<?php echo $number; ?>">
            <div class="p-4">
  <h1 class="mb-2 text-4xl font-extrabold leading-none tracking-tight text-gray-400 md:text-5xl lg:text-6xl">Made With</h1>
  <h1 class="mb-4 text-6xl font-extrabold leading-none tracking-tight text-gray-400 md:text-5xl lg:text-6xl">LOVE</h1>
  
  <p class="text-xl text-gray-400">Crafted With <i class="fa fa-heart text-red-500"></i> By Avenger</p>
</div>
<script>
            function showChangePasswordModal() {
            document.getElementById('changePasswordModal').classList.remove('hidden');
                }

            function closeChangePasswordModal() {
             document.getElementById('changePasswordModal').classList.add('hidden');
}


  </script> 
  <script>
    function goBack() {
        window.history.back();
    }
          
</script>
   <script> 
   document.getElementById('toggleElements').addEventListener('click', function () {
        var additionalElements = document.getElementById('additionalElements');
        additionalElements.classList.toggle('hidden');
    });
    
    document.getElementById('telegram').addEventListener('click', function () {
        var tgCard = document.getElementById('tg-id');
        tgCard.style.display = (tgCard.style.display === 'none' || tgCard.style.display === '') ? 'block' : 'none';
    });
    
    document.getElementById('user').addEventListener('click', function () {
    var usCard = document.getElementById('user-id');
    usCard.style.display = (usCard.style.display === 'none' || usCard.style.display === '') ? 'block' : 'none';
});

</script>

</body>
</html>