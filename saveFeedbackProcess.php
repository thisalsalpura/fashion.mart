<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {

    $mail = $_SESSION["u"]["email"];
    $pid = $_POST["pid"];
    $type = $_POST["t"];
    $feed = $_POST["f"];

    if (!in_array($type, [1, 2, 3])) {
        echo "Please select a valid feedback type.";
    } else if (empty($feed)) {
        echo "Please Enter Your Feedback.";
    } else if (!preg_match('/^[A-Za-z. ]+$/', $feed)) {
        echo ("You can use only letters , numbers and full stop mark for your Feedback.");
    } else {
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `feedback` (`type`,`date`,`feed`,`product_id`,`user_email`) VALUES 
        ('" . $type . "','" . $date . "','" . $feed . "','" . $pid . "','" . $mail . "')");

        echo "success";
    }
}
