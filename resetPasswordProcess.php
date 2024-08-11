<?php

include "connection.php";

$email = $_POST["e"];
$newpw = $_POST["n"];
$retypepw = $_POST["r"];
$vcode = $_POST["v"];

if (empty($newpw)) {
    echo ("Please Enter Your New Password.");
} else  if (strlen($newpw) < 5 || strlen($newpw) > 20) {
    echo ("Password Must Contain 5 to 20 Characters.");
} else if (empty($retypepw)) {
    echo ("Please Enter Your Re-type Password.");
} else if (strlen($retypepw) < 5 || strlen($retypepw) > 20) {
    echo ("Password Must Contain 5 to 20 Characters.");
} else if (empty($vcode)) {
    echo ("Please Enter Your Verification Code.");
} else if ($newpw != $retypepw) {
    echo ("Password does not match.");
} else {

    $rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "' AND `verification_code` = '" . $vcode . "'");
    $num = $rs->num_rows;

    if ($num == 1) {

        Database::iud("UPDATE `user` SET `password` = '" . $retypepw . "' WHERE `email` = '" . $email . "'");
        echo ("success");
    } else {
        echo ("Invalid Email Adddress or Verification Code");
    }
}
