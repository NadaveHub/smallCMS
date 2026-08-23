<?php
function sendContentText($userIDF, $contentF, $db)
{

    $countsql = "INSERT INTO defContent (type, userID, content) VALUES ('text', :userIDP, :contentP)";
    $con = $db->prepare($countsql);

    $con->bindValue(":userIDP", $userIDF, PDO::PARAM_INT);
    $con->bindValue(":contentP", $contentF, PDO::PARAM_STR);

    $con->execute();
    exit;
}

function sendContentCard($userIDF, $contentF, $db)
{

    $countsql = "INSERT INTO defContent (type, userID, content) VALUES ('card', :userIDP, :contentP)";
    $con = $db->prepare($countsql);

    $con->bindValue(":userIDP", $userIDF, PDO::PARAM_INT);
    $con->bindValue(":contentP", $contentF, PDO::PARAM_STR);

    $con->execute();
    exit;
}

function sendContentList($userIDF, $contentF, $db)
{

    $countsql = "INSERT INTO defContent (type, userID, content) VALUES ('list', :userIDP, :contentP)";
    $con = $db->prepare($countsql);

    $con->bindValue(":userIDP", $userIDF, PDO::PARAM_INT);
    $con->bindValue(":contentP", $contentF, PDO::PARAM_STR);

    $con->execute();
    exit;
}

function textProc()
{
    echo '
    <form method="POST" action="">
        <input type="hidden" name="contentType" value="text">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" placeholder="Enter title..." required><br><br>
        <label for="content">Enter Content:</label><br>

        <textarea id="content" name="content" rows="8" cols="50" placeholder="Type your text here..."></textarea>
        <br><br>
        <input type="submit" value="Submit">
    </form>
    ';
}

function cardProc()
{
    if (isset($_POST['action']) && $_POST['action'] === 'save') {
        $title = $_POST['title'] ?? '';
        $prefix = $_POST['prefix'] ?? '';
        $content = $_POST['content'] ?? '';

        echo "<h3>Card Saved!</h3>";
        echo "Title: " . htmlspecialchars($title) . "<br>";
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


function listProc()
{
    $num_rows = isset($_POST['num_rows']) ? (int)$_POST['num_rows'] : 2;
    $num_cols = isset($_POST['num_cols']) ? (int)$_POST['num_cols'] : 2;

    $name   = $_POST['list_name'] ?? '';
    $prefix = $_POST['list_prefix'] ?? '';
    $data   = $_POST['list_data'] ?? [];

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
        echo "<h3>Saved Variables Output:</h3>";
        echo "<b>Name:</b> " . htmlspecialchars($name) . "<br>";
        echo "<b>Prefix:</b> " . htmlspecialchars($prefix) . "<br>";
        echo "<b>Data Array:</b> <pre>" . print_r($data, true) . "</pre><hr>";
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

        <button type="submit" name="action" value="save">Save Final List</button>
    </form>
<?php
}
