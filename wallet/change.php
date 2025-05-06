<?php
include('bal.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['number'];

   $new_upi = isset($_POST["upi"]) ? $_POST["upi"] : null;


    if ($new_upi !== null) {
        $query_upi = "UPDATE person SET upi = '$new_upi' WHERE number = $user_id";
        mysqli_query($conn, $query_upi);
        echo "UPI updated successfully!";
    }

    $photo_name = $_FILES["photo"]["name"];
    $photo_temp = $_FILES["photo"]["tmp_name"];
    $photo_path = "photos/$photo_name"; 

    move_uploaded_file($photo_temp, $photo_path);

    $query_photo = "UPDATE person SET photo = '$photo_path' WHERE number = $user_id";
    mysqli_query($conn, $query_photo);
    echo " Photo changed successfully!";
}
?>
