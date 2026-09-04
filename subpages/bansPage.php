<?php
require_once "lib/lib.php";

function getUsers($db)
{
    $sql = "SELECT FROM banLog ORDER BY id DESC LIMIT 64";
    $con = $db->query($sql);
    return $con->fetchAll(PDO::FETCH_ASSOC);
}
function pagecounter($db)
{
    $countsql = "SELECT COUNT(*) FROM `banLog`";
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
    $sql = "SELECT * FROM `banLog` LIMIT $page,5";
    $con = $db->prepare($sql);
    $con->execute();
    $data = $con->fetchALL(PDO::FETCH_ASSOC);
    $count = count($data);
    if ($count !== 0) {
        foreach ($data as $key => $value) {
            echo "<tr>";
            foreach ($value as $key => $value2) {
                if ($key == "expire" and $value2 == null ) {
                    $value2 = "NEVER";
                }
                echo "<td>" . $value2 . "</td>";
            }
            echo "<td><a class='delete' href='../composables/unban.php?id={$value['id']}&page={$page_get}'> Disable </a></td>";
        }
    } else {
        echo ('<h2>No Accounts Baned</h2>');
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
            <td>ID</td>
            <td>user ID</td>
            <td>ip</td>
            <td>EXPIRE</td>
            <td>TIME</td>
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
    .noBan {
        font-size: 80px;
    }
</style>