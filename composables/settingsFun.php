<?php
function updateSettings($userID, $mainColour, $secColour, $siteName, $defText, $email, $contact, $layout, $db)
{
    $countsql = "UPDATE settings SET userID = :userID, mainColour = :mainColour, name = :name, secColour = :secColour, siteName = :siteName, defText = :defText, email = :email, contact = :contact WHERE id = 1";
    $con = $db->prepare($countsql);

    $con->bindValue(":userID", $userID, PDO::PARAM_INT);
    $con->bindValue(":mainColour", $mainColour, PDO::PARAM_STR);
    $con->bindValue(":secColour", $secColour, PDO::PARAM_STR);
    $con->bindValue(":siteName", $siteName, PDO::PARAM_STR);
    $con->bindValue(":defText", $defText, PDO::PARAM_STR);
    $con->bindValue(":email", $email, PDO::PARAM_STR);
    $con->bindValue(":contact", $contact, PDO::PARAM_STR);

    $con->execute();
    return true;
}
