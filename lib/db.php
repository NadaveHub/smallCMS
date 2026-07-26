<?php
define('DB_NAME', 'minecraft');
define('DB_USER', 'mc');
define('DB_PASSWORD', 'UxaiD*l(BlaPDuR-');
define('DB_HOST', 'mysql');

global $db;
$db = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
    DB_USER,
    DB_PASSWORD,
);
