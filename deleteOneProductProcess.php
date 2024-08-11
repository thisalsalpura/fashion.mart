<?php

include "connection.php";

if (isset($_GET["id"])) {

    $cid = $_GET["id"];

    $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `invoice_id` = '" . $cid . "'");
    $invoice_data = $invoice_rs->fetch_assoc();

    Database::iud("DELETE FROM `recent` WHERE `r_id` = '" . $cid . "'");

    echo ("Removed");
} else {
    echo ("Something went wrong.");
}
