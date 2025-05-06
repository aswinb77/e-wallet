<?php

$host = "localhost";
$dbname = "colorpix_merchant";
$username = "colorpix_mer";
$password = "zFZtJB4u}bun";

try {
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password, $options);

    // Your database operations go here...

} catch (PDOException $e) {
    // Handle database connection errors
    die("Connection failed: " . $e->getMessage());
}
?>
