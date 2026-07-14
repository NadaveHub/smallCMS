<?php
$host = 'mysql';
$db   = 'Test';
$user = 'root';
$pass = 'root';

$dsn = "mysql:host=$host;dbname=$db";

try {
    // Attempt to connect to the database
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<h1>Connected to the database successfully!</h1>";
} catch (PDOException $e) {
    echo "<h1>Database connection failed:</h1> <p>" . $e->getMessage() . "</p>";
}
