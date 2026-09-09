<?php
session_start();
$_SESSION = [];
session_destroy();
$_SESSION['loged'] = false;
exit;