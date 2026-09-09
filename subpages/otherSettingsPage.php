<?php
include "composables/settingsFun.php";

if (isset($_POST['act']) && $_POST['act'] === 'save') {
    $mainColor = $_POST['mainColor'] ?? '#002fff';
    $secColor  = $_POST['secColor'] ?? '#ffffff';
    $userID    = $_POST['userID'] ?? '';
    $siteName  = $_POST['siteName'] ?? '';
    $defText   = $_POST['defText'] ?? '';
    $email     = $_POST['email'] ?? '';
    $contact   = $_POST['contact'] ?? '';
    $layout    = $_POST['layout'] ?? '';

    updateSettings($userID, $mainColor, $secColor, $siteName, $defText, $email, $contact, $layout, $db);
}

$con = $db->prepare("SELECT * FROM settings WHERE id = 1");
$con->execute();
$currentSettings = $con->fetch(PDO::FETCH_ASSOC);

$valSiteName  = $currentSettings['siteName'] ?? '';
$valEmail     = $currentSettings['email'] ?? '';
$valContact   = $currentSettings['contact'] ?? '';
$valMainColor = $currentSettings['mainColour'] ?? '#002fff';
$valSecColor  = $currentSettings['secColour'] ?? '#ffffff';
?>

<form method="POST" action="">
    <input type="hidden" name="contentType" value="card">
    <input type="hidden" name="userID" value="<?= htmlspecialchars($_SESSION['activeUser'] ?? '') ?>">

    <label for="siteName">Site Name:</label><br>
    <input type="text" id="siteName" name="siteName" placeholder="Enter name of your site..." value="<?= htmlspecialchars($valSiteName) ?>" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" placeholder="Enter email..." value="<?= htmlspecialchars($valEmail) ?>" required><br><br>

    <label for="contact">Contact:</label><br>
    <input type="text" id="contact" name="contact" placeholder="Enter your contact (phonenumber)" value="<?= htmlspecialchars($valContact) ?>" required><br><br>

    <label for="mainColor">Pick a main color:</label>
    <input type="color" id="mainColor" name="mainColor" value="<?= htmlspecialchars($valMainColor) ?>"><br><br>

    <label for="secColor">Pick a secondary color:</label>
    <input type="color" id="secColor" name="secColor" value="<?= htmlspecialchars($valSecColor) ?>"><br><br>

    <button type="submit" name="act" value="save">Save settings</button>
</form>