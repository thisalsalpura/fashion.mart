<?php

include "connection.php";

$clr = $_GET["clr"];

if (empty($clr)) {
    echo ("Please type a new color.");
} else {

    $clrExistsQuery = "SELECT COUNT(*) as count FROM `color` WHERE `clr_name` = '" . $clr . "'";
    $clrExistsResult = Database::search($clrExistsQuery);
    $clrExistsData = $clrExistsResult->fetch_assoc();
    if ($clrExistsData['count'] > 0) {
        echo "This color is already have in dropdown!";
        exit();
    }

    Database::iud("INSERT INTO `color` (`clr_name`) VALUES ('" . $clr . "')");
    echo ("success");
}
