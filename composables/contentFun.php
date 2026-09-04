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

function textProc($db, $editData = null)
{
    if (isset($_POST['action']) && $_POST['action'] === 'saveText') {
        $name = $_POST['Name'] ?? '';
        $content = $_POST['content'] ?? '';
        $edit_id = $_POST['edit_id'] ?? '';

        if ($edit_id) { 
            $con = $db->prepare("UPDATE textContent SET name = :name, content = :content WHERE id = :id");
            $con->execute([':name' => $name, ':content' => $content, ':id' => $edit_id]);
            echo "<h3 style='color: green;'>Text Updated!</h3>";
        } else { 
            sendText($_SESSION['activeUser'], $content, $name, $db);
            echo "<h3 style='color: green;'>Text Saved!</h3>";
        }
    }

    $valName = $_POST['Name'] ?? ($editData['name'] ?? '');
    $valContent = $_POST['content'] ?? ($editData['content'] ?? '');
    $valId = $editData['id'] ?? '';
?>
    <form method="POST" action="">
        <input type="hidden" name="contentType" value="text">
        <input type="hidden" name="edit_id" value="<?= $valId ?>">
        
        <label for="Name">Name:</label><br>
        <input type="text" id="Name" name="Name" placeholder="Enter Name..." value="<?= htmlspecialchars($valName) ?>" required><br><br>
        
        <label for="content">Enter Content:</label><br>
        <textarea id="content" name="content" rows="8" cols="50" placeholder="Type your text here..."><?= htmlspecialchars($valContent) ?></textarea>
        <br><br>
        
        <button type="submit" name="action" value="saveText">
            <?= $valId ? 'Update Text' : 'Submit Text' ?>
        </button>
    </form>
<?php
}

function cardProc($db, $editData = null)
{
    if (isset($_POST['action']) && $_POST['action'] === 'save') {
        $title = $_POST['title'] ?? '';
        $prefix = $_POST['prefix'] ?? '';
        $content = $_POST['content'] ?? '';
        $edit_id = $_POST['edit_id'] ?? '';

        if ($edit_id) { 
            $con = $db->prepare("UPDATE cardContent SET name = :name, prefix = :prefix, content = :content WHERE id = :id");
            $con->execute([':name' => $title, ':prefix' => $prefix, ':content' => $content, ':id' => $edit_id]);
            echo "<h3 style='color: green;'>Card Updated!</h3>";
        } else { 
            sendCard($_SESSION['activeUser'], $content, $title, $prefix, $db);
            echo "<h3 style='color: green;'>Card Saved!</h3>";
        }
    }

    $valTitle = $_POST['title'] ?? ($editData['name'] ?? '');
    $valPrefix = $_POST['prefix'] ?? ($editData['prefix'] ?? '');
    $valContent = $_POST['content'] ?? ($editData['content'] ?? '');
    $valId = $editData['id'] ?? '';
?>
    <form method="POST" action="">
        <input type="hidden" name="contentType" value="card">
        <input type="hidden" name="edit_id" value="<?= $valId ?>">

        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" placeholder="Enter title..." value="<?= htmlspecialchars($valTitle) ?>" required><br><br>

        <label for="prefix">Prefix:</label><br>
        <input type="text" id="prefix" name="prefix" placeholder="Enter prefix..." value="<?= htmlspecialchars($valPrefix) ?>"><br><br>

        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="6" cols="50" placeholder="Enter content here..." required><?= htmlspecialchars($valContent) ?></textarea><br><br>

        <button type="submit" name="action" value="save">
            <?= $valId ? 'Update Card' : 'Save Form' ?>
        </button>
    </form>
<?php
}

function listProc($db, $editData = null)
{
    $action = $_POST['action'] ?? '';
    $edit_id = $_POST['edit_id'] ?? ($editData['id'] ?? '');

    if ($editData && empty($_POST)) {
        $name = $editData['name'] ?? '';
        $prefix = $editData['prefix'] ?? '';
        $highlight = $editData['highlight'] ?? 0;
        $data = json_decode($editData['content'], true) ?: [];
        $num_rows = count($data) > 0 ? count($data) : 2;
        $num_cols = count($data[0] ?? []) > 0 ? count($data[0]) : 2;
    } else {
        $name = $_POST['list_name'] ?? '';
        $prefix = $_POST['list_prefix'] ?? '';
        $highlight = isset($_POST['highlight']) ? 1 : 0;
        $data = $_POST['list_data'] ?? [];
        $num_rows = isset($_POST['num_rows']) ? (int)$_POST['num_rows'] : 2;
        $num_cols = isset($_POST['num_cols']) ? (int)$_POST['num_cols'] : 2;
    }

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
        if ($edit_id) {
            $con = $db->prepare("UPDATE listContent SET name = :name, prefix = :prefix, highlight = :highlight, content = :content WHERE id = :id");
            $con->execute([':name' => $name, ':prefix' => $prefix, ':highlight' => $highlight, ':content' => $json_content, ':id' => $edit_id]);
            echo "<h3 style='color: green;'>List Updated!</h3>";
        } else { 
            sendList($_SESSION['activeUser'], $json_content, $name, $prefix, $highlight, $db);
            echo "<h3 style='color: green;'>List successfully saved!</h3>";
        }
    }
?>
    <form method="POST" action="">
        <input type="hidden" name="contentType" value="list">
        <input type="hidden" name="edit_id" value="<?= htmlspecialchars($edit_id) ?>">
        <input type="hidden" name="num_rows" value="<?= $num_rows ?>">
        <input type="hidden" name="num_cols" value="<?= $num_cols ?>">

        <label>List Name:</label>
        <input type="text" name="list_name" value="<?= htmlspecialchars($name) ?>"><br><br>

        <label>List Prefix:</label>
        <input type="text" name="list_prefix" value="<?= htmlspecialchars($prefix) ?>"><br><br>

        <h4>List Data</h4>
        <table border="1" cellpadding="5">
            <?php for ($r = 0; $r < $num_rows; $r++) { ?>
                <tr>
                    <?php for ($c = 0; $c < $num_cols; $c++) { ?>
                        <td>
                            <input type="text"
                                name="list_data[<?= $r ?>][<?= $c ?>]"
                                value="<?= htmlspecialchars($data[$r][$c] ?? '') ?>"
                                placeholder="R<?= $r + 1 ?> C<?= $c + 1 ?>">
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
        <br>

        <button type="submit" name="action" value="add_row">Add Row</button>
        <button type="submit" name="action" value="rem_row">Remove Last Row</button>
        <br><br>
        <button type="submit" name="action" value="add_col">Add Column</button>
        <button type="submit" name="action" value="rem_col">Remove Last Column</button>

        <br><br>
        <label>
            <input type="checkbox" name="highlight" value="1" <?= $highlight ? 'checked' : '' ?>> Highlight top row as name of column
        </label><br><br>
        
        <button type="submit" name="action" value="save">
            <?= $edit_id ? 'Update Final List' : 'Save Final List' ?>
        </button>
    </form>
<?php
}

function getAllBoardContent($db, $limit = 5)
{
    $active = $_GET['active'] ?? "all";
    $texts = [];
    $cards = [];
    $lists = [];

    if ($active === "all" || $active === "text") {
        $con1 = $db->prepare("SELECT id, name as title, content, time, 'text' as type FROM textContent ORDER BY time DESC LIMIT :limit");
        $con1->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $con1->execute();
        $texts = $con1->fetchAll(PDO::FETCH_ASSOC);
    }

    if ($active === "all" || $active === "card") {
        $con2 = $db->prepare("SELECT id, name as title, content, time, 'card' as type FROM cardContent ORDER BY time DESC LIMIT :limit");
        $con2->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $con2->execute();
        $cards = $con2->fetchAll(PDO::FETCH_ASSOC);
    }

    if ($active === "all" || $active === "list") {
        $con3 = $db->prepare("SELECT id, name as title, content, time, 'list' as type FROM listContent ORDER BY time DESC LIMIT :limit");
        $con3->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $con3->execute();
        $lists = $con3->fetchAll(PDO::FETCH_ASSOC);
    }

    $allContent = array_merge($texts, $cards, $lists);

    usort($allContent, function ($a, $b) {
        return strtotime($b['time']) - strtotime($a['time']);
    });

    return array_slice($allContent, 0, $limit);
}

function getTableNameByType($type)
{
    if ($type === 'text') return 'textContent';
    if ($type === 'card') return 'cardContent';
    if ($type === 'list') return 'listContent';
    return null;
}

function deleteContent($db, $id, $type)
{
    $table = getTableNameByType($type);
    if ($table) {
        $con = $db->prepare("DELETE FROM $table WHERE id = :id");
        $con->bindValue(':id', $id, PDO::PARAM_INT);
        $con->execute();
    }
}

function toggleVisibility($db, $id, $type)
{
    $table = getTableNameByType($type);
    if ($table) {
        $con = $db->prepare("UPDATE $table SET is_public = NOT is_public WHERE id = :id");
        $con->bindValue(':id', $id, PDO::PARAM_INT);
        $con->execute();
    }
}
