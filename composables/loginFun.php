<?php
include "../lib/lib.php";
include "checkCalls.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check($email, $password, $db)
{
    $countsql = "SELECT id, password FROM usersAuth WHERE email = :email LIMIT 1";
    $con = $db->prepare($countsql);
    $con->bindValue(":email", $email, PDO::PARAM_STR);
    $con->execute();
    $user = $con->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loged'] = true;
        $_SESSION['activeUser'] = $user['id'];
        $logSql = "INSERT INTO loginLog (user_id) VALUES (:user_id)";
        $logCon = $db->prepare($logSql);
        $logCon->bindValue(":user_id", $user['id'], PDO::PARAM_INT);
        $logCon->execute();
        header("Location: /index.php");
        exit();
    } else {
        header("Location: /pages/loginPage.php");
        exit();
    }
}

function register($email, $password, $db)
{
    if (!checkMail($email, $db) && valPassword($password)) {
        $countsql = "INSERT INTO usersAuth (id, password, email) VALUES (NULL, :password, :email)";
        $con = $db->prepare($countsql);
        $con->bindValue(":email", $email, PDO::PARAM_STR);
        $con->bindValue(":password", $password, PDO::PARAM_STR);
        $con->execute();
        $newUserId = $db->lastInsertId();
        $_SESSION['loged'] = true;

        $logSql = "INSERT INTO loginLog (user_id) VALUES (:user_id)";
        $logCon = $db->prepare($logSql);
        $logCon->bindValue(":user_id", $newUserId, PDO::PARAM_INT);
        $logCon->execute();
        header("location:/index.php");
        exit;
    } else {
        header("Location: /pages/registerPage.php?error=email exists");
        exit;
    }
}


$mail = $pass = $job = $message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'], $_POST['password'], $_POST['job'])) {
        $mail = $_POST["email"];
        $pass = $_POST["password"];
        $job = $_POST["job"];

        if (empty($mail) or empty($pass)) {
            header("location:/pages/loginPage.php?email={$_POST['email']}");
        } else {
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {

                switch ($job) {
                    case "LOGIN":
                        check($mail, $pass, $db);
                        break;
                    case "REGISTER":
                        $pass2 = $_POST['password2'] ?? '';
                        if ($pass === $pass2) {
                            $passwordH = password_hash($pass, PASSWORD_DEFAULT);
                            register($mail, $passwordH, $db);
                        } else {
                            header("Location: /pages/registerPage.php?error=passwords are not the same");
                        }
                        break;
                }
            } else {
            }
        }
    }
}
