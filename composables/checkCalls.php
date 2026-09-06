<?php
function checkMail($email, $db)
{
    if (valMail($email)) {
        $sql = "SELECT 1 FROM usersAuth WHERE email = :email LIMIT 1";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $exists = $stmt->fetchColumn();

        if ($exists) {
            return true;
        } else {
            return false;
        }
    }
}

function checkRole($db, $id, $subpage)
{
    $sql = "SELECT role FROM admin WHERE id = :id LIMIT 1";
    
    $con = $db->prepare($sql);
    $con->bindValue(':id', $id, PDO::PARAM_STR);
    $con->execute();
    $role = $con->fetchColumn();

    if ($role === "owner") {
        return true;
    } else {
        switch ($subpage) {
            case "dash":
                return true;

            case "acco":
                if ($role === "user" || $role === "admin") {
                    return true;
                } else {
                    return false;
                }

            case "admi":
                if ($role === "admin") {
                    return true;
                } else {
                    return false;
                }

            case "bans":
                if ($role === "user" || $role === "admin") {
                    return true;
                } else {
                    return false;
                }
            
            case "addC":
                if ($role === "content" || $role === "admin") {
                    return true;
                } else {
                    return false;
                }

            case "ediC":
                if ($role === "content" || $role === "admin") {
                    return true;
                } else {
                    return false;
                }

            case "dbSe":
                if ($role === "admin") {
                    return true;
                } else {
                    return false;
                }
            case "otSe":
                if ($role === "admin") {
                    return true;
                } else {
                    return false;
                }
        }
    }
}
