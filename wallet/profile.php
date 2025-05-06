<?php

include('bal.php');
$user_id = $_SESSION['number']; 
$query = "SELECT * FROM person WHERE number = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);


echo "<h2 class='text-2xl font-bold mb-4'>Welcome, {$user['name']}!</h2>";
echo "<img src='{$user['photo']}' alt='User Photo' class='mb-4 h-25 rounded-full'>";
echo "<p>Email: {$user['email']}</p>";
echo "<p>Balance: {$user['balance']}</p>";
echo "<p>Upi: {$user['upi']}</p>";
?>
