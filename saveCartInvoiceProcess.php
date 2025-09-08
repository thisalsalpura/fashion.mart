<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {

    $order_id = $_POST["o"];
    $cart_ids = explode(",", $_POST["i"]);
    $mail = $_POST["m"];
    $amount = $_POST["a"];

    $city_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $mail . "'");
    $city_num = $city_rs->num_rows;

    if ($city_num == 1) {
        $city_data = $city_rs->fetch_assoc();

        $district_rs = Database::search("SELECT * FROM `city` WHERE `city_id`='" . $city_data["city_city_id"] . "'");
        $district_data = $district_rs->fetch_assoc();

        $district_id = $district_data["district_district_id"];

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        foreach ($cart_ids as $cid) {
            $cid = intval($cid);

            $cart_rs = Database::search("SELECT * FROM `cart` WHERE `cart_id` = '" . $cid . "' AND `user_email` = '" . $mail . "'");
            $cart_data = $cart_rs->fetch_assoc();

            $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $cart_data["product_id"] . "'");
            $product_data = $product_rs->fetch_assoc();

            $qty = $cart_data["qty"];
            $current_qty = $product_data["qty"];
            $new_qty = intval($current_qty) - intval($qty);

            Database::iud("UPDATE `product` SET `qty` = '" . $new_qty . "' WHERE `id` = '" . $product_data["id"] . "'");

            $delivery = "0";

            if ($district_id == "1") {
                $delivery = $product_data["delivery_fee_colombo"];
            } else {
                $delivery = $product_data["delivery_fee_other"];
            }

            $product_amount = (int)$product_data["price"] + (int)$delivery;

            Database::iud("INSERT INTO `invoice` (`order_id`,`date`,`total`,`qty`,`status`,`product_id`,`user_email`) 
            VALUES ('" . $order_id . "','" . $date . "','" . $product_amount . "','" . $qty . "','0','" . $product_data["id"] . "','" . $mail . "')");

            Database::iud("INSERT INTO `recent` (`order_id`,`date`,`total`,`qty`,`status`,`product_id`,`user_email`) 
            VALUES ('" . $order_id . "','" . $date . "','" . $product_amount . "','" . $qty . "','0','" . $product_data["id"] . "','" . $mail . "')");
        }

        Database::iud("DELETE FROM `cart` WHERE `user_email` = '" . $mail . "'");

        echo ("success");
    }
}
