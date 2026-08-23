<?php
include "composables/contentFun.php";
$contentType = $_POST['contentType'] ?? 'text';
?>

<div>
    <h1><?= strtoupper(htmlspecialchars($contentType)) ?></h1>
    <br><br>

    <form method="POST" action="">
        <button type="submit" name="contentType" value="text">TEXT</button><br><br>
        <button type="submit" name="contentType" value="card">CARD</button><br><br>
        <button type="submit" name="contentType" value="list">LIST</button>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($contentType === "text") {
        textProc();
    } elseif ($contentType === "card") {
        cardProc();
    } elseif ($contentType === "list") {
        listProc();
    } else {
        echo "jsi kkt";
    }
}
?>