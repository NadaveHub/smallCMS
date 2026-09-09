<?php
include "../lib/lib.php";
include "../composables/checkCalls.php";
session_start();
if (!isset($_SESSION['loged']) || $_SESSION['loged'] !== true) {
    header("Location: /pages/loginPage.php");
    exit();
}

if (!checkRoleAdmin($db, (int)$_SESSION['activeUser'])) {
    http_response_code(403);
    die("Unauthorized access.");
}


function delete($db, $id)
{
    $sql = "DELETE FROM admin WHERE id = :id";
    $con = $db->prepare($sql);
    $con->bindValue(":id", $id, PDO::PARAM_INT);
    $stav = $con->execute();
    $over = $con->rowCount();
    header("location:/index.php?page=adminAccounts");
}

if (isset($_GET["id"])) {
    $id = (int)$_GET["id"];

    if (!isset($_SESSION['loged']) or $_SESSION['loged'] == false) {
        session_destroy();
        header("location:/pages/loginPage.php");
        exit();
    } elseif ($id !== 1) {
        delete($db, $id);
    } else {
        header("location:/index.php?page=adminAccounts");
    }
}
