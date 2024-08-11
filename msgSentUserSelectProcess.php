<?php
session_start();
include "connection.php";

$email = $_GET["email"];

if (empty($email)) {
    echo json_encode(array("error" => "Please select a user."));
} else {
    $user_details_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "'");
    $user_details_data = $user_details_rs->fetch_assoc();

    if ($user_details_data) {
        echo json_encode($user_details_data);
    } else {
        echo json_encode(array("error" => "User not found."));
    }
}
