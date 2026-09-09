<?php
session_start();

require_once "../composables/loginFun.php";
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

    <form method="POST" action="">
        <label for="username">username</label><br>
        <input type="text" id="username" name="username" required value="<?php echo isset($_GET['username']) ? htmlspecialchars($_GET['username']) : ''; ?>"><br><br>

        <label for="pass">password</label><br>
        <input type="password" id="password" name="password"><br><br>

        <input class="submit" type="submit" value="LOGIN" name="job">
    </form>
    <br>
    <?php
    if (isset($_GET["message"])) {
        echo htmlspecialchars($_GET['message']);
    }
    ?>
</body>

</html>