<?php

session_start();

include "connection.php";

if (isset($_POST["c"])) {

    $v = $_POST["c"];

    if (empty($v)) {
        echo ("Please Enter Your Verification Code.");
    } else {

        $admin_rs = Database::search("SELECT * FROM `admin` WHERE `vcode`='" . $v . "'");
        $admin_num = $admin_rs->num_rows;

        if ($admin_num == 1) {

            $admin_data = $admin_rs->fetch_assoc();
            $_SESSION["au"] = $admin_data;
            echo ("success");
        } else {
            echo ("Invalid Verification Code.");
        }
    }
} else {
    echo ("Please enter the verification code.");
}
