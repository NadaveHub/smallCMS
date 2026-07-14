<?php
function val()
{
    if (!isset($_SESSION['loged']) or $_SESSION['loged'] == false) {
        session_destroy();
        header("location:/pages/loginPage.php");
        exit();
    }
}
