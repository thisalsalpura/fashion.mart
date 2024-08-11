<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {

    $umail = $_SESSION["u"]["email"];

    Database::iud("DELETE FROM `recent` WHERE `user_email` = '" . $umail . "'");
    echo ("Removed");
} else {
    echo ("Something went wrong.");
}
