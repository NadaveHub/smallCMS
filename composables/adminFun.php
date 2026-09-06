<?php 
function getUsers($db)
{
    $sql = "SELECT FROM admin ORDER BY id DESC LIMIT 64";
    $con = $db->query($sql);
    return $con->fetchAll(PDO::FETCH_ASSOC);
}

function pagecounter($db)
{
    $countsql = "SELECT COUNT(*) FROM `admin`";
    $con = $db->prepare($countsql);
    $con->execute();

    $data = $con->fetchALL(PDO::FETCH_ASSOC);
    $countdata = $data[0]["COUNT(*)"];
    $pages = ceil($countdata / 5);

    for ($i = 0; $i < $pages; $i++) {
        $a = $i + 1;
        echo "<a class='pages' href='index.php?page=adminAccounts&pages=$i'>$a</a>";
    }
}

function datatable($db)
{
    $page_get = $_GET['pages'] ?? 0;
    $page = $page_get * 5;
    $sql = "SELECT id, username, role, time FROM `admin` LIMIT $page,5";
    $con = $db->prepare($sql);
    $con->execute();
    $data = $con->fetchALL(PDO::FETCH_ASSOC);
    foreach ($data as $key => $value) {
        echo "<tr>";
        foreach ($value as $key => $value2) {
            echo "<td>" . $value2 . "</td>";
        }
        echo "<td><a class='delete' href='../composables/delAdm.php?id={$value['id']}'> DELETE </a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

function addAdmin($user, $pass, $role, $db) {
    $countsql = "INSERT INTO admin (id, password, username, role) VALUES (NULL, :password, :user, :role)";
    $con = $db->prepare($countsql);
    $con->bindValue(":user", $user, PDO::PARAM_STR);
    $con->bindValue(":password", $pass, PDO::PARAM_STR);
    $con->bindValue(":role", $role, PDO::PARAM_STR);
    $con->execute();
}

function adminForm($db) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adminSubmit'])) {
        $user = $_POST['username'] ?? '';
        $pass = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? '';

        if ($role === 'owner') {
            echo "<p>Error: You cannot set the role to owner.</p>";
            return;
        }

        $allowed_roles = ['admin', 'content', 'user'];
        if (!in_array($role, $allowed_roles)) {
            echo "<p>Error: Invalid role selected.</p>";
            return;
        }

        if (!empty($user) && !empty($pass) && !empty($role)) {
            addAdmin($user, $pass, $role, $db); 
        } else {
            echo "<p>Error: All fields are required.</p>";
        }
    }
}