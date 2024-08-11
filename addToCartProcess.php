<?php

session_start();

include "connection.php";

$user_log_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '" . $_SESSION["u"]["email"] . "'");
$user_log_num = $user_log_rs->num_rows;

if ($user_log_num == 0) {
    echo ("Please update your profile.");
} else {

    if (isset($_SESSION["u"])) {
        if (isset($_GET["id"])) {

            $pid = $_GET["id"];
            $umail = $_SESSION["u"]["email"];

            $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $pid . "' AND `user_email` = '" . $umail . "'");
            $cart_num = $cart_rs->num_rows;

            $cart_data = $cart_rs->fetch_assoc();

            if ($cart_num >= 1) {

                Database::iud("DELETE FROM `cart` WHERE `cart_id` = '" . $cart_data["cart_id"] . "'");
                echo ("Product is remove from the cart.");
            } else {

                Database::iud("INSERT INTO `cart` (`qty`,`user_email`,`product_id`) VALUES ('1','" . $umail . "','" . $pid . "')");
                echo ("New product added to the cart.");
            }
        } else {
            echo ("Something Went Wrong.");
        }
    } else {
        echo ("Please Login or Signup first.");
    }
}
