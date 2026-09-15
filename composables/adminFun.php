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
            echo "<td>" . htmlspecialchars($value2 ?? '') . "</td>";
        }
        echo "<td><a class='edit' href='?page=adminAccounts&edit_id={$value['id']}'> EDIT </a></td>";
        echo "<td><a class='delete' href='../composables/delAdm.php?id={$value['id']}'> DELETE </a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

function addAdmin($user, $pass, $role, $db)
{

    $countsql = "INSERT INTO admin (id, password, username, role) VALUES (NULL, :password, :user, :role)";
    $con = $db->prepare($countsql);
    $con->bindValue(":user", $user, PDO::PARAM_STR);
    $con->bindValue(":password", $pass, PDO::PARAM_STR);
    $con->bindValue(":role", $role, PDO::PARAM_STR);
    $con->execute();
}

function adminForm($db, $editData = null)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adminSubmit'])) {
        $user = $_POST['username'] ?? '';
        $pass = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? '';
        $edit_id = $_POST['edit_id'] ?? '';

        $isUpdate = !empty($edit_id);

        if ($isUpdate) {
            $stmt = $db->prepare("SELECT role FROM admin WHERE id = :id");
            $stmt->execute([':id' => $edit_id]);
            $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($currentUser && $currentUser['role'] === 'owner') {
                $role = 'owner';
            } elseif ($role === 'owner') {
                echo "<p style='color:red;'>Error: You cannot change another user into an owner.</p>";
                return;
            }
        } else {
            if ($role === 'owner') {
                echo "<p style='color:red;'>Error: You cannot set a new role to owner.</p>";
                return;
            }
        }

        $allowed_roles = ['admin', 'content', 'user', 'owner'];
        if (!in_array($role, $allowed_roles)) {
            echo "<p style='color:red;'>Error: Invalid role selected.</p>";
            return;
        }

        if ($isUpdate) {
            if (!empty($user) && !empty($role)) {
                if (!empty($pass)) {
                    $passwordH = password_hash($pass, PASSWORD_DEFAULT);
                    $sql = "UPDATE admin SET username = :user, password = :password, role = :role WHERE id = :id";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        ':user' => $user,
                        ':password' => $passwordH,
                        ':role' => $role,
                        ':id' => $edit_id
                    ]);
                } else {
                    $sql = "UPDATE admin SET username = :user, role = :role WHERE id = :id";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        ':user' => $user,
                        ':role' => $role,
                        ':id' => $edit_id
                    ]);
                }

                echo "<h3 style='color: green;'>Account Updated!</h3>";
                $editData['username'] = $user;
                $editData['role'] = $role;
            }
        } else {
            if (!empty($user) && !empty($pass) && !empty($role)) {
                $passwordH = password_hash($pass, PASSWORD_DEFAULT);
                addAdmin($user, $passwordH, $role, $db);
                echo "<h3 style='color: green;'>Account Added!</h3>";
            } else {
                echo "<p style='color:red;'>Error: All fields are required.</p>";
            }
        }
    }

    $valName = $_POST['username'] ?? ($editData['username'] ?? '');
    $valRole = $_POST['role'] ?? ($editData['role'] ?? 'admin');
    $valId = $editData['id'] ?? '';
    $isOwner = ($valRole === 'owner');
?>

    <form method="POST" action="">
        <input type="hidden" name="edit_id" value="<?= htmlspecialchars($valId) ?>">
        <h3><?= $valId ? 'Edit Admin' : 'Add New Admin' ?></h3>

        <label>Username:
            <input type="text" name="username" value="<?= htmlspecialchars($valName) ?>" required>
        </label><br><br>

        <label>New Password (leave blank to keep unchanged):
            <input type="password" name="password" placeholder="Enter new password">
        </label><br><br>

        <label>Role:
            <?php if ($isOwner): ?>
                <input type="hidden" name="role" value="owner">
                <span style="color:red; font-weight:bold;">OWNER (Cannot be changed)</span>
            <?php else: ?>
                <select name="role" required>
                    <option value="admin" <?= $valRole === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="content" <?= $valRole === 'content' ? 'selected' : '' ?>>Content</option>
                    <option value="user" <?= $valRole === 'user' ? 'selected' : '' ?>>User</option>
                </select>
            <?php endif; ?>
        </label><br><br>

        <input type="submit" name="adminSubmit" value="<?= $valId ? 'Update Account' : 'Add Account' ?>">

        <?php if ($valId): ?>
            <br><br><a href="?page=adminAccounts" style="text-decoration:none;">Cancel Edit</a>
        <?php endif; ?>
    </form>
<?php
}

function updateAdmin($db, $id)
{
    $activeUser = $_SESSION['activeUser'];
}
