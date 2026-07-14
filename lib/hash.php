<?php
function hashing($data) {
    $dataH1 = hash("ripemd256", $data, false,);
    $dataH2 = hash("whirlpool", $dataH1, false,);
    $dataH3 = hash("gost", $dataH2, false,);
    $dataH4 = hash("haval192,4", $data, false,);
    return $dataH3 . $dataH4;
}
?>