<?php
session_start();
$_SESSION = [];
session_destroy();
$_SESSION['loged'] = false;
header("location:/pages/loginPage.php");
exit;
