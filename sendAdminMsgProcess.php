<?php

session_start();

include "connection.php";

$msg_txt = $_POST["t"];
$email = $_POST["r"];

if (empty($email)) {
    echo ("Something Went Wrong");
} else if (empty($msg_txt)) {
    echo ("Please enter your message");
} else if (!preg_match('/^[A-Za-z0-9,-—(). ]+$/', $msg_txt)) {
    echo ("You can use only letters , numbers and these symbols [.,-—()] for your Message.");
} else {

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    if (isset($msg_txt) && isset($email)) {

        $user_exists_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "'");
        $user_exists_num = $user_exists_rs->num_rows;

        if ($user_exists_num == 1) {

            if (isset($_SESSION["u"]["email"])) {
                Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`) VALUES 
                ('" . $msg_txt . "','" . $date . "','0','" . $email . "','salpurathisal@gmail.com')");

                echo ("sent");
            } else if (isset($_SESSION["au"]["email"])) {
                Database::iud("INSERT INTO `chat`(`content`,`date_time`,`status`,`from`,`to`) VALUES 
                ('" . $msg_txt . "','" . $date . "','0','salpurathisal@gmail.com','" . $email . "')");

                echo ("sent");
            }
        } else {
            echo ("User not found.");
        }
    } else {
        echo ("Something Went Wrong.");
    }
}
