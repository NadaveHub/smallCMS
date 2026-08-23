<?php
function sendText($userID, $content, $name, $db)
{
    $countsql = "INSERT INTO textContent (name, userID, content) VALUES (:name, :userID, :content)";
    $con = $db->prepare($countsql);

    $con->bindValue(":userID", $userID, PDO::PARAM_INT);
    $con->bindValue(":content", $content, PDO::PARAM_STR);
    $con->bindValue(":name", $name, PDO::PARAM_STR);

    $con->execute();
    return true;
}

function sendCard($userID, $content, $name, $prefix, $db)
{
    $countsql = "INSERT INTO cardContent (name, userID, content, prefix) VALUES (:name, :userID, :content, :prefix)";
    $con = $db->prepare($countsql);

    $con->bindValue(":userID", $userID, PDO::PARAM_INT);
    $con->bindValue(":content", $content, PDO::PARAM_STR);
    $con->bindValue(":name", $name, PDO::PARAM_STR);
    $con->bindValue(":prefix", $prefix, PDO::PARAM_STR);

    $con->execute();
    return true;
}

function sendList($userID, $content, $name, $prefix, $highlight, $db)
{
    $countsql = "INSERT INTO listContent (name, userID, content, prefix, highlight) VALUES (:name, :userID, :content, :prefix, :highlight)";
    $con = $db->prepare($countsql);

    $con->bindValue(":userID", $userID, PDO::PARAM_INT);
    $con->bindValue(":content", $content, PDO::PARAM_STR);
    $con->bindValue(":name", $name, PDO::PARAM_STR);
    $con->bindValue(":prefix", $prefix, PDO::PARAM_STR);
    $con->bindValue(":highlight", $highlight, PDO::PARAM_INT);

    $con->execute();
    return true;
}

function textProc($db)
{
    if (isset($_POST['action']) && $_POST['action'] === 'saveText') {
        $name = $_POST['Name'] ?? '';
        $content = $_POST['content'] ?? '';

        sendText($_SESSION['activeUser'], $content, $name, $db);
        echo "<h3 style='color: green;'>Text Saved!</h3>";
    }
?>
    <form method="POST" action="">
        <input type="hidden" name="contentType" value="text">
        <label for="title">Name:</label><br>
        <input type="text" id="Name" name="Name" placeholder="Enter Name..." required><br><br>
        <label for="content">Enter Content:</label><br>

        <textarea id="content" name="content" rows="8" cols="50" placeholder="Type your text here..."></textarea>
        <br><br>
        <button type="submit" name="action" value="saveText">Submit Text</button>
    </form>
<?php
}

function cardProc($db)
{
    if (isset($_POST['action']) && $_POST['action'] === 'save') {
        $title = $_POST['title'] ?? '';
        $prefix = $_POST['prefix'] ?? '';
        $content = $_POST['content'] ?? '';

        sendCard($_SESSION['activeUser'], $content, $title, $prefix, $db);
        echo "<h3 style='color: green;'>Card Saved!</h3>";
    }

?>
    <form method="POST" action="">
        <input type="hidden" name="contentType" value="card">

        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" placeholder="Enter title..." required><br><br>

        <label for="prefix">Prefix:</label><br>
        <input type="text" id="prefix" name="prefix" placeholder="Enter prefix..."><br><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="6" cols="50" placeholder="Enter content here..." required></textarea><br><br>

        <button type="submit" name="action" value="save">Save Form</button>
    </form>
<?php
}


function listProc($db)
{
    $num_rows = isset($_POST['num_rows']) ? (int)$_POST['num_rows'] : 2;
    $num_cols = isset($_POST['num_cols']) ? (int)$_POST['num_cols'] : 2;

    $name   = $_POST['list_name'] ?? '';
    $prefix = $_POST['list_prefix'] ?? '';
    $data   = $_POST['list_data'] ?? [];
    $highlight = isset($_POST['highlight']) ? 1 : 0;
    $action = $_POST['action'] ?? '';

    if ($action === 'add_row') {
        $num_rows++;
    } elseif ($action === 'add_col') {
        $num_cols++;
    } elseif ($action === 'rem_row' && $num_rows > 1) {
        $num_rows--;
    } elseif ($action === 'rem_col' && $num_cols > 1) {
        $num_cols--;
    } elseif ($action === 'save') {
        $json_content = json_encode($data);
        sendList($_SESSION['activeUser'], $json_content, $name, $prefix, $highlight, $db);

        echo "<h3 style='color: green;'>List successfully saved to the database!</h3>";
    }

?>
    <form method="POST" action="">
        <input type="hidden" name="contentType" value="list">
        <input type="hidden" name="num_rows" value="<?= $num_rows ?>">
        <input type="hidden" name="num_cols" value="<?= $num_cols ?>">

        <label>List Name:</label>
        <input type="text" name="list_name" value="<?= htmlspecialchars($name) ?>"><br><br>

        <label>List Prefix:</label>
        <input type="text" name="list_prefix" value="<?= htmlspecialchars($prefix) ?>"><br><br>

        <h4>List Data</h4>
        <table border="1" cellpadding="5">
            <?php for ($r = 0; $r < $num_rows; $r++): ?>
                <tr>
                    <?php for ($c = 0; $c < $num_cols; $c++): ?>
                        <td>
                            <input type="text"
                                name="list_data[<?= $r ?>][<?= $c ?>]"
                                value="<?= htmlspecialchars($data[$r][$c] ?? '') ?>"
                                placeholder="R<?= $r + 1 ?> C<?= $c + 1 ?>">
                        </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
        </table>
        <br>

        <button type="submit" name="action" value="add_row">Add Row</button>
        <button type="submit" name="action" value="rem_row">Remove Last Row</button>
        <br><br>
        <button type="submit" name="action" value="add_col">Add Column</button>
        <button type="submit" name="action" value="rem_col">Remove Last Column</button>

        <br><br>
        <label>
            <input type="checkbox" name="highlight" value="1">. Hightlight top row as name of column
        </label><br><br>
        <button type="submit" name="action" value="save">Save Final List</button>
    </form>
<?php
}
