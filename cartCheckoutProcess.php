<?php

session_start();

include "connection.php";

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__, '.env.local');
$dotenv->load();

if (isset($_SESSION["u"])) {

    $cart_ids = explode(",", $_GET["cart_ids"]);
    $tcost = $_GET["tcost"];
    $umail = $_SESSION["u"]["email"];

    foreach ($cart_ids as $cid) {
        $cid = intval($cid);

        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `cart_id` = '" . $cid . "' AND `user_email` = '" . $umail . "'");
        $cart_data = $cart_rs->fetch_assoc();

        $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $cart_data["product_id"] . "'");
        $product_data = $product_rs->fetch_assoc();

        if ($product_data["qty"] < $cart_data["qty"]) {
            $error = [
                "status" => "2",
                "title" => $product_data["title"]
            ];
            echo json_encode($error);
            return;
        }
    }

    $array;

    $order_id = uniqid();

    $city_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $umail . "'");
    $city_num = $city_rs->num_rows;

    if ($city_num == 1) {

        $city_data = $city_rs->fetch_assoc();

        $city_id = $city_data["city_city_id"];
        $address = $city_data["line1"] . ", " . $city_data["line2"];

        $district_rs = Database::search("SELECT * FROM `city` WHERE `city_id`='" . $city_id . "'");
        $district_data = $district_rs->fetch_assoc();

        $item = "Cart Items";
        $amount = $tcost;

        $fname = $_SESSION["u"]["fname"];
        $lname = $_SESSION["u"]["lname"];
        $mobile = $_SESSION["u"]["mobile"];
        $uaddress = $address;
        $city = $district_data["city_name"];

        $merchant_id = $_ENV['PAYHERE_MERCHANT_ID'];
        $merchant_secret = $_ENV['PAYHERE_MERCHANT_SECRET'];
        $currency = "LKR";

        $hash = strtoupper(
            md5(
                $merchant_id .
                    $order_id .
                    number_format($amount, 2, '.', '') .
                    $currency .
                    strtoupper(md5($merchant_secret))
            )
        );

        $array["id"] = $order_id;
        $array["item"] = $item;
        $array["amount"] = $amount;
        $array["fname"] = $fname;
        $array["lname"] = $lname;
        $array["mobile"] = $mobile;
        $array["address"] = $uaddress;
        $array["city"] = $city;
        $array["umail"] = $umail;
        $array["mid"] = $merchant_id;
        $array["msecret"] = $merchant_secret;
        $array["currency"] = $currency;
        $array["hash"] = $hash;

        echo json_encode($array);
    } else {
        echo ("3");
    }
} else {
    echo ("1");
}
