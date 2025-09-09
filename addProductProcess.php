<?php

session_start();

include "connection.php";

$email = $_SESSION["u"]["email"];

$category = $_POST["ca"];
$brand = $_POST["b"];
$model = $_POST["m"];
$title = $_POST["t"];
$condition = $_POST["con"];
$clr = $_POST["col"];
$qty = $_POST["q"];
$cost = $_POST["co"];
$dwc = $_POST["dwc"];
$doc = $_POST["doc"];
$desc = $_POST["de"];
$length = sizeof($_FILES);

if (empty($category)) {
    echo ("Please Select a Product Category.");
} else if (empty($brand)) {
    echo ("Please Select a Product Brand.");
} else if (empty($model)) {
    echo ("Please Select a Product Model.");
} else if (empty($title)) {
    echo ("Please Enter Your Product Title.");
} else if (strlen($title) > 100) {
    echo ("Product Title Must Contain LOWER THAN 50 characters.");
} else if (!preg_match('/^[A-Za-z0-9 ]+$/', $title)) {
    echo ("You can use only letters and numbers for your product Title.");
} else if (empty($condition)) {
    echo ("Please Select a Product Condition.");
} else if (empty($clr)) {
    echo ("Please Select Your Product Colour.");
} else if (empty($qty)) {
    echo ("Please Enter Your Product Quantity.");
} else if (($qty) > 50) {
    echo ("Quantity Must Contain LOWER THAN 50 Items.");
} else if (empty($cost)) {
    echo ("Please Enter Your Product Cost.");
} else if (!is_numeric($cost) || $cost <= 0) {
    echo ("Please Enter a Valid Price.");
} else if (empty($dwc)) {
    echo ("Please Enter Your Colombo Delivery Cost.");
} else if (!is_numeric($dwc) || $dwc <= 0) {
    echo ("Please Enter a Valid Price.");
} else if (empty($doc)) {
    echo ("Please Enter Your Out of Colombo Delivery Cost.");
} else if (!is_numeric($doc) || $doc <= 0) {
    echo "Please Enter a Valid Price.";
} else if (empty($desc)) {
    echo ("Please Enter Your Product Description.");
} else if (strlen($desc) > 500) {
    echo ("Product Description Must Contain LOWER THAN 500 characters.");
} else if (!preg_match('/^[A-Za-z0-9., ]+$/', $desc)) {
    echo ("You can use only letters , numbers and full stop mark for your product description.");
} else if ($length <= 3 && $length > 0) {

    $titleExistsQuery = "SELECT COUNT(*) as count FROM `product` WHERE `title` = '" . $title . "'";
    $titleExistsResult = Database::search($titleExistsQuery);
    $titleExistsData = $titleExistsResult->fetch_assoc();
    if ($titleExistsData['count'] > 0) {
        echo "A product with the same title already exists. Please choose a different title.";
        exit();
    }

    $chb_rs = Database::search("SELECT * FROM `category_has_brand` WHERE `category_cat_id`='" . $category . "' AND 
    `brand_brand_id`='" . $brand . "'");

    if ($chb_rs->num_rows > 0) {
    } else {

        Database::iud("INSERT INTO `category_has_brand` (`category_cat_id`,`brand_brand_id`) VALUES 
        ('" . $category . "','" . $brand . "')");
    }

    $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE `model_model_id`='" . $model . "' AND 
    `brand_brand_id`='" . $brand . "'");

    $model_has_brand_id;

    if ($mhb_rs->num_rows > 0) {

        $mhb_data = $mhb_rs->fetch_assoc();
        $model_has_brand_id = $mhb_data["model_has_brand_id"];
    } else {

        Database::iud("INSERT INTO `model_has_brand`(`model_model_id`,`brand_brand_id`) VALUES 
        ('" . $model . "','" . $brand . "')");
        $model_has_brand_id = Database::$connection->insert_id;
    }

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);

    $date = $d->format("Y-m-d H:i:s");

    $status = 1;

    Database::iud("INSERT INTO `product` (`price`,`qty`,`description`,`title`,`datetime_added`,`delivery_fee_colombo`,`delivery_fee_other`,
    `category_cat_id`,`condition_condition_id`,`model_has_brand_id`,`status_status_id`,`user_email`) 
    VALUES ('" . $cost . "','" . $qty . "','" . $desc . "','" . $title . "','" . $date . "','" . $dwc . "','" . $doc . "','" . $category . "','" . $condition . "','" . $model_has_brand_id . "','" . $status . "','" . $email . "')");

    $product_id = Database::$connection->insert_id;

    Database::iud("INSERT INTO `product_has_color` (`product_id`,`color_clr_id`) VALUES ('" . $product_id . "','" . $clr . "')");

    $length = sizeof($_FILES);

    $allowed_image_extensions = array("image/jpeg", "image/png", "image/svg+xml");

    for ($x = 0; $x < $length; $x++) {

        if (isset($_FILES["image" . $x])) {

            $image_file = $_FILES["image" . $x];
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
                ('" . $file_name . "','" . $product_id . "')");
            } else {
                echo ("Inavid image type.");
            }
        }
    }

    echo ("success");
} else {
    echo ("Please select a image.");
}
