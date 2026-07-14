<?php
session_start();

include "../composables/loginFun.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINECRAFT WORLDS</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <H1>LOGIN</H1>
    <?php login($db) ?>
    <form method="POST" action="">
        <label for="email">email</label><br>
        <input type="text" id="email" name="email" required value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>"><br><br>

        <label for="pass">password</label><br>
        <input type="password" id="password" name="password"><br><br>

        <input class="submit" type="submit" value="LOGIN" name="job">
    </form>
    <br>
    <a class="switch" href="registerPage.php">REGISTER</a>

    <?php
    if (isset($_GET["message"])) {
        echo $_GET['message'];
    }
    ?>
</body>

</html>