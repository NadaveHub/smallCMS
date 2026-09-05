<?php
require_once "lib/lib.php";
include "composables/adminFun.php";

?>
<div>
    <?php
    pagecounter($db);
    ?>
    <br>
    <table class="datatable">
        <tr>
            <td>id</td>
            <td>username</td>
            <td>role</td>
            <td>created</td>
            <td colspan=2>actions</td>

        </tr>
        <?php
        datatable($db);
        ?>

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
        border-radius: 6px;
    }
</style>