<?php

session_start();

include "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST["email"]) && isset($_POST["name"])) {

    $cname = $_POST["name"];
    $umail = $_POST["email"];

    if (empty($cname)) {
        echo ("Please give a new category name.");
    } else if (!preg_match('/^[A-Za-z ]+$/', $cname)) {
        echo ("You can use only letters for your Category Name.");
    } else if (empty($umail)) {
        echo ("Please give your email.");
    } else {

        if ($_SESSION["au"]["email"] == $_POST["email"]) {

            $category_rs = Database::search("SELECT * FROM `category` WHERE `cat_name` LIKE '%" . $cname . "%'");
            $category_num = $category_rs->num_rows;

            if ($category_num == 0) {

                $code = uniqid();
                Database::iud("UPDATE `admin` SET `vcode`='" . $code . "' WHERE `email`='" . $umail . "'");

                $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = '------';
                $mail->Password = '------';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('------', 'Admin Verification');
                $mail->addReplyTo('------', 'Admin Verification');
                $mail->addAddress($umail);
                $mail->isHTML(true);
                $mail->Subject = 'FASHION.MART Admin Sign In Verification Code For Add New Category.';
                $bodyContent = '<h2 style="color:black;">YOUR VERIFICATION CODE IS <h1 style="color:blue;"> ' . $code . ' </h1></h2>';
                $mail->Body    = $bodyContent;

                if (!$mail->send()) {
                    echo 'Verification code sending failed.';
                } else {
                    echo 'Success';
                }
            } else {
                echo ("This category already exists.");
            }
        } else {
            echo ("Invalid user.");
        }
    }
} else {
    echo ("Something is missing.");
}
