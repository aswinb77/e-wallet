<?php
require('session.php');
    include("db.php");
    
    $number = $_SESSION['number'];

    $sql = "SELECT balance, name FROM person WHERE number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $number);
    $stmt->execute();
    $stmt->bind_result($balance, $name); 
    $stmt->fetch();
    $stmt->close();
    
    ?>