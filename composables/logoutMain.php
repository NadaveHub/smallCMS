<?php
session_start();
$_SESSION = [];
session_destroy();
$_SESSION['loged'] = false;
// EDIT TO REAL MAIN PAGE!!!!!!!!!!!!!!!    header("location:/pages/loginPage.php");
exit;