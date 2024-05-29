<?php
session_start();

if (isset($_POST['ip'])) {
    $serverIP = $_POST['ip'];

    if (connectToServer($serverIP)) {
        header("Location: ../view/login.php");
        exit();
    } else {
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['erro'] = true;
    header("Location: ../index.php");
    exit();
}

function connectToServer($serverIP)
{
    $_SESSION['serverIP'] = $serverIP;
    return true;
}
?>
