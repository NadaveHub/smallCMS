<?php
require_once "lib/lib.php";

function getUsers($db)
{
    $sql = "SELECT FROM usersAuth ORDER BY id DESC LIMIT 64";
    $con = $db->query($sql);
    return $con->fetchAll(PDO::FETCH_ASSOC);
}
function pagecounter($db)
{
    $countsql = "SELECT COUNT(*) FROM `usersAuth`";
    $con = $db->prepare($countsql);
    $con->execute();

    $data = $con->fetchALL(PDO::FETCH_ASSOC);
    $countdata = $data[0]["COUNT(*)"];
    $pages = ceil($countdata / 5);

    for ($i = 0; $i < $pages; $i++) {
        $a = $i + 1;
        echo "<a class='pages' href='index.php?page=accounts&pages=$i'>$a</a>";
    }
}
function datatable($db)
{
    $page_get = $_GET['pages'] ?? 0;
    $page = $page_get * 5;
    $sql = "SELECT * FROM `usersAuth` LIMIT $page,5";
    $con = $db->prepare($sql);
    $con->execute();
    $data = $con->fetchALL(PDO::FETCH_ASSOC);
    foreach ($data as $key => $value) {
        echo "<tr>";
        foreach ($value as $key => $value2) {
            echo "<td>" . $value2 . "</td>";
        }
        echo "<td><a class='delete' href='../composables/del.php?id={$value['id']}&page={$page_get}'> DELETE </a></td>";
    }
    echo "</table>";
}

?>
<div>
    <?php
    pagecounter($db);
    ?>
    <table class="datatable">
        <tr>
            <td>id</td>
            <td>name</td>
            <td>email</td>
            <td>password</td>
            <td>role</td>
            <td>rank</td>
            <td>created</td>
            <td>note</td>
            <td colspan=2>actions</td>

        </tr>
        <?php
        datatable($db);

        ?>
</div>
</div>
</body>

</html>

<style>
    .datatable {
        margin-top: 20px;
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid black;
    }
    .pages {
    display: inline-block;
    padding: 8px 12px;
    margin-left: 5px;
    font-weight: 600;
    text-decoration: none; 
    text-align: center;
    /*background-color: #007bff;
    color: #ffffff; */
    border-radius: 6px;
}
</style>