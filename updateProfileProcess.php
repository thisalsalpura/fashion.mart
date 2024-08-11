<?php

session_start();

include "connection.php";

$email = $_SESSION["u"]["email"];

$fname = $_POST["f"];
$lname = $_POST["l"];
$mobile = $_POST["m"];
$line1 = $_POST["l1"];
$line2 = $_POST["l2"];
$province = $_POST["p"];
$district = $_POST["d"];
$city = $_POST["c"];
$pcode = $_POST["pc"];

$user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "'");

if (empty($fname)) {
    echo ("Please Enter Your First Name.");
} else if (strlen($fname) > 50) {
    echo ("First Name Must Contain LOWER THAN 50 characters.");
} else if (empty($lname)) {
    echo ("Please Enter Your Last Name.");
} else if (strlen($lname) > 50) {
    echo ("Last Name Must Contain LOWER THAN 50 characters.");
} else if (empty($mobile)) {
    echo ("Please Enter Your Mobile Number.");
} else if (strlen($mobile) != 10) {
    echo ("Mobile Number Must Contain 10 characters.");
} else if (!preg_match("/07[0,1,2,4,5,6,7,8]{1}[0-9]{7}/", $mobile)) {
    echo ("Invalid Mobile Number.");
} else if (empty($line1)) {
    echo ("Please Enter Your Address Line1.");
} else if (strlen($line1) > 50) {
    echo ("Address Line1 Must Contain LOWER THAN 50 characters.");
} else if (!preg_match('/^[A-Za-z0-9. ]+$/', $line1)) {
    echo ("You can use only letters , numbers and full stop mark for Address Line1.");
} else if (empty($line2)) {
    echo ("Please Enter Your Address Line2");
} else if (strlen($line2) > 50) {
    echo ("Address Line2 Must Contain LOWER THAN 50 characters.");
} else if (!preg_match('/^[A-Za-z0-9. ]+$/', $line2)) {
    echo ("You can use only letters , numbers and full stop mark for Address Line2.");
} else if (empty($province)) {
    echo ("Please Select Your Province.");
} else if (empty($district)) {
    echo ("Please Select Your District.");
} else if (empty($city)) {
    echo ("Please Select Your City.");
} else if (empty($pcode)) {
    echo ("Please Enter Your Postal Code.");
} else if (!is_numeric($pcode)) {
    echo ("Please Enter a Valid Postal Code.");
} else if (strlen($pcode) > 10) {
    echo ("Postal Code Must Contain LOWER THAN 10 characters.");
} else if ($user_rs->num_rows == 1) {

    Database::iud("UPDATE `user` SET `fname` = '" . $fname . "' , `lname` = '" . $lname . "' , `mobile` = '" . $mobile . "' 
    WHERE `email` = '" . $email . "'");

    $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '" . $email . "'");

    if ($address_rs->num_rows == 1) {

        Database::iud("UPDATE `user_has_address` SET `city_city_id` = '" . $city . "' , `line1` = '" . $line1 . "',
        `line2` = '" . $line2 . "' , `postal_code` = '" . $pcode . "'  WHERE `user_email` = '" . $email . "'");
    } else {

        Database::iud("INSERT INTO `user_has_address` (`user_email`,`city_city_id`,`line1`,`line2`,`postal_code`)
        VALUES ('" . $email . "','" . $city . "','" . $line1 . "','" . $line2 . "','" . $pcode . "')");
    }

    if (sizeof($_FILES) == 1) {

        $image = $_FILES["i"];
        $image_extention = $image["type"];

        $allowed_image_extention = array("image/jpeg", "image/png", "image/svg+xml");

        if (in_array($image_extention, $allowed_image_extention)) {

            $new_img_extention;

            if ($image_extention == "image/jpeg") {
                $new_img_extention = ".jpeg";
            } else if ($image_extention == "image/png") {
                $new_img_extention = ".png";
            } else if ($image_extention == "image/svg+xml") {
                $new_img_extention = ".svg";
            }

            $file_name = "images//profile_images//" . $fname . "_" . uniqid() . $new_img_extention;
            move_uploaded_file($image["tmp_name"], $file_name);

            $profile_img_rs = Database::search("SELECT * FROM  `profile_img` WHERE `user_email` = '" . $email . "'");
            $profile_img_data = $profile_img_rs->num_rows;
            $profile_img_data_p = $profile_img_rs->fetch_assoc();

            if ($profile_img_data == 1) {

                Database::iud("UPDATE `profile_img`  SET `path` = '" . $file_name . "' WHERE `user_email` = '" . $email . "'");
                unlink($profile_img_data_p["path"]);
                echo ("Updated");
            } else {

                Database::iud("INSERT INTO `profile_img` (`path`,`user_email`) VALUES ('" . $file_name . "','" . $email . "')");
                echo ("Saved");
            }
        }
    } elseif (sizeof($_FILES) == 0) {
        echo ("You have not selected any image.");
    } else {
        echo ("You must select only 01 profile image.");
    }
} else {
    echo ("Invalid User.");
}
