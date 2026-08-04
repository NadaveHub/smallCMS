<?php
function addCard($amound)
{
    for ($i = $amound; $i > 0; $i--) {
        echo "<div class=box>" . include 'components/card.php'; "</div>";
    }
}
?>
<div class=fullbox>
    <?php addCard(12) ?>

</div>

<style>
    .fullbox {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(7, 1fr);
        gap: 5%;
        width: 100%;
    }
</style>