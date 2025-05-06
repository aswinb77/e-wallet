<?php
session_start();
unset($_SESSION['number']);

header("Location: login.html");
exit();
?>
