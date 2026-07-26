<?php
include "../lib/lib.php";
session_start();
function delete($db, $id)
{
    $sql = "DELETE FROM usersAuth WHERE id = :id";
    $con = $db->prepare($sql);
    $con->bindValue(":id", $id, PDO::PARAM_INT);
    $stav = $con->execute();
    $over = $con->rowCount();
}

if (isset($_GET["id"])) {
    $id = (int)$_GET["id"];
    if (!isset($_SESSION['loged']) or $_SESSION['loged'] == false) {
        session_destroy();
        header("location:/pages/loginPage.php");
        exit();
    } else {
        delete($db, $id);
    }
}
