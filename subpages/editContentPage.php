<?php
include "composables/contentFun.php";
$activeTab = $_GET['active'] ?? 'all';
$editData = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = (int)($_POST['id'] ?? 0);
    $type = $_POST['type'] ?? '';

    if ($action === 'delete') {
        deleteContent($db, $id, $type);
    } elseif ($action === 'toggle_visibility') {
        toggleVisibility($db, $id, $type);
    }
}

if (isset($_GET['edit_id']) && isset($_GET['edit_type'])) {
    $editId = (int)$_GET['edit_id'];
    $editType = $_GET['edit_type'];
    
    $table = getTableNameByType($editType);
    if ($table) {
        $stmt = $db->prepare("SELECT * FROM $table WHERE id = :id");
        $stmt->bindValue(':id', $editId, PDO::PARAM_INT);
        $stmt->execute();
        $editData = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    $activeTab = $editType; 
}

$currentLimit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;
$nextLimit = $currentLimit + 5;

$feed = getAllBoardContent($db, $currentLimit);



?>

<div style="display: flex; height: 100%;">
    <div style="width: 50%; height: 100%;">
        <h1><?= strtoupper(htmlspecialchars($activeTab)) ?></h1>
        <br><br>

        <a href="?page=editContent&active=text">
            <button type="button">TEXT</button>
        </a><br><br>

        <a href="?page=editContent&active=card">
            <button type="button">CARD</button>
        </a><br><br>

        <a href="?page=editContent&active=list">
            <button type="button">LIST</button>
        </a><br><br>

        <a href="?page=editContent&active=all">
            <button type="button">ALL</button>
        </a><br><br>

        <div style="margin-top: 40px; padding: 20px; background: #f9f9f9; border-radius: 8px;">
            <?php
            if ($activeTab === 'text') {
                textProc($db, $editData);
            } elseif ($activeTab === 'card') {
                cardProc($db, $editData);
            } elseif ($activeTab === 'list') {
                listProc($db, $editData);
            }
            ?>
        </div>

    </div>
    <div style="width: 50%; height: 100%;">
        <?php


        if (empty($feed)) { ?>
            <p style="text-align: center; color: #777;">Zatím zde nejsou žádné příspěvky.</p>
        <?php } else { ?>
            <?php foreach ($feed as $post) { ?>
                <div class="post-card">
                    <div class="post-time">
                        <?= date('d.m.Y H:i', strtotime($post['time'])) ?>
                    </div>

                    <h3 class="post-title"><?= htmlspecialchars($post['title']) ?></h3>

                    <div class="post-preview">
                        <?php
                        if ($post['type'] !== "list") {
                            $previewText = strip_tags($post['content']);
                            echo htmlspecialchars(mb_strimwidth($previewText, 0, 80, "..."));
                        }
                        ?>
                    </div>

                    <div class="post-actions" style="margin-top: 15px; display: flex; gap: 10px; border-top: 1px solid #eee; padding-top: 10px;">

                        <a href="?page=editContent&active=<?= $activeTab ?>&edit_id=<?= $post['id'] ?>&edit_type=<?= $post['type'] ?>">
                            <button type="button">Edit</button>
                        </a>

                        <form method="POST" style="margin: 0;">
                            <input type="hidden" name="action" value="toggle_visibility">
                            <input type="hidden" name="id" value="<?= $post['id'] ?>">
                            <input type="hidden" name="type" value="<?= $post['type'] ?>">
                            <button type="submit">
                                <?= isset($post['is_public']) && $post['is_public'] == 0 ? 'Make Public' : 'Make Private' ?>
                            </button>
                        </form>

                        <form method="POST" style="margin: 0;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $post['id'] ?>">
                            <input type="hidden" name="type" value="<?= $post['type'] ?>">
                            <button type="submit" onclick="return confirm('Opravdu smazat tento příspěvek? (Are you sure?)');" style="color: red;">Delete</button>
                        </form>

                    </div>
                </div>
            <?php } 
        }
        if (count($feed) === $currentLimit) { ?>
            <div style="text-align: center; margin-top: 20px;">
                <a href="?page=editContent&active=<?= $activeTab ?>&limit=<?= $nextLimit ?>">
                    <button type="button" style="padding: 10px 20px; cursor: pointer;">
                        Nacist vic...
                    </button>
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<style>
    .post-card {
        background: #ffffff;
        border: 1px solid #eaeaea;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .post-time {
        font-size: 0.8rem;
        color: #888;
        margin-bottom: 10px;
    }

    .post-title {
        font-size: 1.3rem;
        margin: 0 0 10px 0;
        color: #222;
    }

    .post-preview {
        font-size: 0.95rem;
        color: #444;
        margin-bottom: 20px;
    }
</style>