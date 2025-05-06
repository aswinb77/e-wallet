<?php
session_start();

if (!isset($_SESSION['number'])) {
    header("Location: login.html");
    exit();
}
?>
