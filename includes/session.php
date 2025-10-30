<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: ../login/login.php");
        exit;
    }
    $user_id = $_SESSION["user"]["id"];
?>