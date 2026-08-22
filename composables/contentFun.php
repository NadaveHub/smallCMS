<?php
function sendContent($userIDF, $contentF, $typeF, $db)
{
    if ($typeF !== "text" or $typeF !== "card" or $typeF !== "list") {
        return ("no");
    } else {
        $countsql = "INSERT INTO defContent (type, userID, content) VALUES (:typeP, :userID, :content)";
        $con = $db->prepare($countsql);
        $con->bindValue(":typeP", $typeF, PDO::PARAM_STR);
        $con->bindValue(":userIDP", $userIDF, PDO::PARAM_INT);
        $con->bindValue(":contentP", $contentF, PDO::PARAM_STR);

        $con->execute();
        
        exit;
    }
}
