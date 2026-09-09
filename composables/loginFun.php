<?php
include "../lib/lib.php";
include "checkCalls.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check($username, $password, $db)
{
    $countsql = "SELECT id, password FROM admin WHERE username = :username LIMIT 1";
    $con = $db->prepare($countsql);
    $con->bindValue(":username", $username, PDO::PARAM_STR);
    $con->execute();
    $user = $con->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loged'] = true;
        $_SESSION['activeUser'] = $user['id'];
        /*$logSql = "INSERT INTO loginLog (user_id) VALUES (:user_id)";
        $logCon = $db->prepare($logSql);
        $logCon->bindValue(":user_id", $user['id'], PDO::PARAM_INT);
        $logCon->execute();*/
        header("Location: /index.php");
        exit();
    } else {
        header("Location: /pages/loginPage.php");
        exit();
    }
}


$name = $pass = $job = $message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'], $_POST['job'])) {
        $name = $_POST["username"];
        $pass = $_POST["password"];
        $job = $_POST["job"];

        if (empty($name) or empty($pass)) {
            header("location:/pages/loginPage.php?username={$_POST['username']}");
        } else {
            if (true) {
                if ($job ==="LOGIN") {
                    check($name, $pass, $db);
                }
            } else {
            }
        }
    }
}
