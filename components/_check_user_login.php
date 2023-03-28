<?php
    session_start();
    if (!isset($_SESSION['logedin']) || $_SESSION['logedin']!=1) {
        header("Location: login.php");
        exit;
    }
    $login = $_SESSION['logedin'];
    $logged_username = $_SESSION['username'];
?>