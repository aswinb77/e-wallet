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

    <body class="bg-white" style="font-family: 'Rubik', sans-serif">

       <div>
        <h2 class="p-2 text-xl text-gray-900 mb-2 font-semibold no-select" onclick="goBack()"><i class="fad fa-chevron-left"></i> Account</h2>
</div>
<script>
    function goBack() {
        window.history.back();
    }
          
</script>
<style>
        #successAlert {
            display: none;
        }

        .alert-success {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 50px;
        }

        .alert-error {
            background-color: #FF4500;
            color: white;
            padding: 10px;
            border-radius: 50px;
        }
        </style>

        <hr class="">
           <div class="p-2">
    <div id="profile-container" class="max-w-md mx-auto bg-white p-8 rounded-md shadow-md">
        <?php include 'profile.php'; ?>
        <form id="change-photo-form" class="mt-4" enctype="multipart/form-data">
            <label for="photo" class="block text-gray-700 font-bold">Change Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" class="border border-gray-300 p-2 w-full" required>
            <button type="submit" class="mt-2 bg-green-500 text-white p-2 rounded">Change Photo</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
    document.getElementById("change-photo-form").addEventListener("submit", function(event) {
    event.preventDefault();
    
    const fileInput = document.getElementById("photo");
    const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;

    if (!allowedExtensions.exec(fileInput.value)) {
        alert("Invalid file type. Please upload a file with a valid extension (JPG, JPEG, PNG, GIF).");
        return false;
    }

    const formData = new FormData();
    formData.append("photo", fileInput.files[0]);

    const upiInput = document.getElementById("upi");
    formData.append("upi", upiInput.value);

    axios.post("change.php", formData)
        .then(response => {
            console.log(response.data);
            if (response.data.includes("successfully")) {
                showAlert("Success", "bg-green-500", "text-white");
            } else {
                showAlert("Failed", "bg-red-500", "text-white");
            }
        })
        .catch(error => {
            console.error(error);
            showAlert("Failed", "bg-red-500", "text-white");
        });
});

function showAlert(message, backgroundClass, textClass) {
    const alertContainer = document.createElement("div");
    alertContainer.className = `fixed top-0 left-0 right-0 mx-auto p-4 ${backgroundClass} ${textClass} font-bold text-center`;

    alertContainer.textContent = message;

    document.body.appendChild(alertContainer);

    setTimeout(() => {
        alertContainer.remove();
    }, 3000);
}

</script>
</body>
</html>