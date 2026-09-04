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

function valMail($mail)
{
    return filter_var($mail, FILTER_VALIDATE_EMAIL) !== false;
}

function valPassword($pass)
{
    $hasLength = strlen($pass) >= 8;

    $hasNumber = preg_match('/[0-9]/', $pass);

    $hasSpecial = preg_match('/[^a-zA-Z0-9]/', $pass);

    return $hasLength && $hasNumber && $hasSpecial;
}
