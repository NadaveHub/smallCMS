<?php
include "../lib/lib.php";
session_start();
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
