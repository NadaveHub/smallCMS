<?php
function val()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['loged']) or $_SESSION['loged'] !== true) {
        unset($_SESSION['loged']);
        header("location:/pages/loginPage.php");
        exit();
    }
}
