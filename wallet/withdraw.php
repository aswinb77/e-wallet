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
        <h2 class="p-2 text-xl text-gray-900 mb-2 font-semibold no-select" onclick="goBack()"><i class="fad fa-chevron-left"></i> Withdraw</h2>
</div>
<script>
    function goBack() {
        window.history.back();
    }
          
</script>
<style>
 /* Add your custom styles here */
        #withdrawBtn.loading {
            pointer-events: none; /* Disable button during loading */
            opacity: 0.7;
        }

        #withdrawBtn .spinner {
            display: none;
        }

        #withdrawBtn.loading .spinner {
            display: inline-block;
            margin-right: 2px;
        }

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
               <div id="successAlert" class="mt-4">
        </div>
        <br>
            <h2 class="text-xl text-center font-semibold">Balance : <?php echo $balance; ?></h2>
            <br>
            <form>
            <div class="input-container">
                <input id="amount" type="number" class="p-3 border-b border-transparent bg-transparent w-full text-2xl font-semibold text-center transition duration-300 focus:outline-none focus:border-b-2 focus:border-blue-500" placeholder="₹ 10 ~ 100">
            </div>
            
            <div class="payment-options p-5 flex flex-col gap-4 max-w-[400px] mx-auto">
                <div class="payment-option">
                    <input id="paytm" type="radio" name="payment-type" class="hidden" value="paytm"/>
                    <label for="paytm" class="cursor-pointer w-full px-3 py-2 bg-white rounded-lg border border-gray-300 text-center transition-all duration-200 block select-outline focus-within:border-green-500" onclick="handleRadioClick('paytm')">
                        Paytm
                    </label>
                </div>
            
                <div class="payment-option">
                    <input id="bank" type="radio" name="payment-type" class="hidden" value="bank"/>
                    <label for="bank" class="cursor-pointer w-full px-3 py-2 bg-white rounded-lg border border-gray-300 text-center transition-all duration-200 block select-outline focus-within:border-green-500" onclick="handleRadioClick('bank')">
                        UPI
                    </label>
                </div>
            
                <div class="payment-option">
                    <input id="upi" type="radio" name="payment-type" class="hidden" disabled />
                    <input id="userNumber" type="hidden" value="<?php echo $_SESSION['number'];?>">
                    <label for="upi" class="w-full px-3 py-2 bg-gray-400 rounded-lg border border-gray-300 text-center transition-all duration-200 block select-outline focus-within:border-green-500" onclick="handleRadioClick('upi')">
                        UPI
                    </label>
                </div>
            </div>
            
            <!--<div id="additionalInputs" class="hidden p-5">
                 Additional inputs will be dynamically added here based on the selected option 
            </div>-->
            
            <div class="fixed bottom-3 left-3 right-3 bg-green-300 border-gray-100 border rounded-full font-semibold px-3 py-2 shadow-md">
                <button  id="withdrawBtn" type="button" class="cursor-pointer flex items-center justify-center w-full px-3 py-2 bg-white rounded-full text-green-700 border border-gray-300 transition-all duration-200 focus:outline-none focus:border-green-500" onclick="withdraw()">
                    <i class="fad fa-arrow-down text-xl mr-2"></i> Withdraw
                </button>
            </div>
    </form>
    <div class="p-6">
         <div class="flex p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
  <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
  </svg>
  <span class="sr-only">Info</span>
  <div>
    <span class="font-medium"> Ensure that these requirements are met:</span>
      <ul class="mt-1.5 list-disc list-inside">
        <li>On Paytm Request Above ₹10</li>
        <li>Upi Request Above ₹100</li>
        <li>It Might May Take Upto 1-3 hours to Process after that contact Support</li>
    </ul>
  </div>
</div>
         </div>  
            <script>
                function handleRadioClick(selectedOption) {
                    const additionalInputsContainer = document.getElementById('additionalInputs');
                    additionalInputsContainer.innerHTML = ''; // Clear existing inputs
            
                   if (selectedOption === 'upi') {
                        const accountNumberInput = createInput('text', 'Account Number', 'accountNumber');
                        const ifscInput = createInput('text', 'IFSC', 'ifsc');
                        const holderNameInput = createInput('text', 'Holder Name', 'holderName');
            
                        additionalInputsContainer.appendChild(accountNumberInput);
                        additionalInputsContainer.appendChild(ifscInput);
                        additionalInputsContainer.appendChild(holderNameInput);
                    }
            
                    additionalInputsContainer.classList.toggle('hidden', selectedOption === 'upi');
                }
            
                function createInput(type, placeholder, id) {
                    const input = document.createElement('input');
                    input.type = type;
                    input.placeholder = placeholder;
                    input.id = id;
                    input.className = 'mb-2 w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5';
                    return input;
                }
            </script>
<script>
       function withdraw() {
            $('#withdrawBtn').addClass('loading');

            var amount = $('#amount').val();
            var paymentType = $('input[name="payment-type"]:checked').val();
           var userNumber = $('#userNumber').val();

            $.ajax({
                type: 'POST',
                url: './Ess/withdraw.php',
                data: { amount: amount, paymentType: paymentType, userNumber: userNumber }, 
                success: function(response) {
                    if (response.includes("successful")) {
                        $('#successAlert').html('<div class="alert-success">' + response + '</div>').fadeIn().delay(2000).fadeOut();
                    } else {
                        $('#successAlert').html('<div class="alert-error">' + response + '</div>').fadeIn().delay(2000).fadeOut();
                    }
                },
                error: function() {
                    $('#successAlert').html('<div class="alert-error">Error in Ajax request</div>').fadeIn().delay(2000).fadeOut();
                },
                complete: function() {
                    $('#withdrawBtn').removeClass('loading');
                }
            });
        }
    </script>

</body>
</html>