<?php
session_start();
include "../composables/loginFun.php";
include "../composables/check.php";
val();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <H1>REGISTER</H1>
    <form method="POST" action="">
        <label for="email">email</label><br>
        <input type="text" id="email" name="email" required><br><br>

        <label for="pass">password</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="pass">confirm password</label><br>
        <input type="password" id="password2" name="password2" required><br><br>


        <input class="submit" type="submit" value="REGISTER" name="job">
    </form>
    <br>
    <a class="switch" href="loginPage.php">LOGIN</a>
</body>
</html>