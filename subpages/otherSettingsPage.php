<?php
include "composables/settingsFun.php";

if (isset($_POST['act']) && $_POST['act'] === 'save') {
    $mainColor = $_POST['mainColor'] ?? '#002fff';
    $secColor = $_POST['secColor'] ?? '#ffffff';
    $userID = $_POST['userID'] ?? '';
    $siteName = $_POST['siteName'] ?? '';
    $defText = $_POST['defText'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $layout = $_POST['layout'] ?? '';



    updateSettings($userID, $mainColor, $secColor, $siteName, $defText, $email, $contact, $layout, $db);
}

?>



<form method="POST" action="">
    <input type="hidden" name="contentType" value="card">

    <label for="siteName">Site Name:</label><br>
    <input type="text" id="siteName" name="siteName" placeholder="Enter name of your site..." required><br><br>

    <label for="email">email</label><br>
    <input type="text" id="email" name="email" placeholder="Enter email..." required><br><br>

    <label for="contact">contact</label><br>
    <input type="text" id="contact" name="contact" placeholder="Enter your contact (phonenumber)" required><br><br>

    <label for="favcolor">Pick a main color:</label>
    <input type="color" id="mainColor" name="mainColor" value="#002fff"><br><br>

    <label for="favcolor">Pick a secondary color:</label>
    <input type="color" id="secColor" name="secColor" value="#ffffff"><br><br>

    <button type="submit" name="act" value="save">Save Form</button>
</form>