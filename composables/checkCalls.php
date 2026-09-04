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
