<?php

session_start();

include "connection.php";

if (isset($_SESSION["p"])) {

    $pid = $_SESSION["p"]["id"];

    $title = $_POST["t"];
    $qty = $_POST["q"];
    $dwc = $_POST["dwc"];
    $doc = $_POST["doc"];
    $desc = $_POST["d"];
    $length = sizeof($_FILES);

    function isTitleAvailable($title, $currentProductId)
    {
        $result = Database::search("SELECT `id` FROM `product` WHERE `title`='" . $title . "' AND `id`<>'" . $currentProductId . "'");
        return $result->num_rows == 0;
    }

    if (empty($title)) {
        echo ("Please Enter Your Product Title.");
    } else if (strlen($title) > 100) {
        echo ("Product Title Must Contain LOWER THAN 50 characters.");
    } else if (!preg_match('/^[A-Za-z0-9 ]+$/', $title)) {
        echo ("You can use only letters and numbers for your product Title.");
    } else if (!isTitleAvailable($title, $pid)) {
        echo ("This Product Title is already in use. Please choose a different title.");
    } else if (empty($qty)) {
        echo ("Please Enter Your Product Quantity.");
    } else if (($qty) > 50) {
        echo ("Quantity Must Contain LOWER THAN 50 Items.");
    } else if (empty($dwc)) {
        echo ("Please Enter Your Colombo Delivery Cost.");
    } else if (!is_numeric($dwc) || $dwc <= 0) {
        echo ("Please Enter a Valid Price.");
    } else if (empty($doc)) {
        echo ("Please Enter Your Out of Colombo Delivery Cost.");
    } else if (!is_numeric($doc) || $doc <= 0) {
        echo ("Please Enter a Valid Price.");
    } else if (empty($desc)) {
        echo ("Please Enter Your Product Description.");
    } else if (strlen($desc) > 500) {
        echo ("Product Description Must Contain LOWER THAN 500 characters.");
    } else if (!preg_match('/^[A-Za-z0-9., ]+$/', $desc)) {
        echo ("You can use only letters , numbers and full stop mark for your product description.");
    } else if ($length <= 3 && $length >= 0) {

        Database::iud("UPDATE `product` SET `title`='" . $title . "',`qty`='" . $qty . "',`delivery_fee_colombo`='" . $dwc . "',
        `delivery_fee_other`='" . $doc . "',`description`='" . $desc . "' WHERE `id`='" . $pid . "'");

        echo ("Product has been Updated.");

        $allowed_image_extensions = array("image/jpeg", "image/png", "image/svg+xml");

        $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $pid . "'");
        $img_num = $img_rs->num_rows;

        if ($length == 0) {
        } else {

            for ($y = 0; $y < $img_num; $y++) {
                $img_data = $img_rs->fetch_assoc();

                unlink($img_data["img_path"]);
                Database::iud("DELETE FROM `product_img` WHERE `product_id`='" . $pid . "'");
            }
        }

        for ($x = 0; $x < $length; $x++) {
            if (isset($_FILES["i" . $x])) {

                $image_file = $_FILES["i" . $x];
                $file_extension = $image_file["type"];

                if (in_array($file_extension, $allowed_image_extensions)) {

                    $new_img_extension;

                    if ($file_extension == "image/jpeg") {
                        $new_img_extension = ".jpeg";
                    } else if ($file_extension == "image/png") {
                        $new_img_extension = ".png";
                    } else if ($file_extension == "image/svg+xml") {
                        $new_img_extension = ".svg";
                    }

                    $file_name = "images//add_products//" . $title . "_" . $x . "_" . uniqid() . $new_img_extension;
                    move_uploaded_file($image_file["tmp_name"], $file_name);

                    Database::iud("INSERT INTO `product_img`(`img_path`,`product_id`) VALUES 
                    ('" . $file_name . "','" . $pid . "')");
                } else {
                    echo ("Inavid image type.");
                }
            }
        }
    }
}
