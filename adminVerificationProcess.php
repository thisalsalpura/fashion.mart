<?php

include "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST["e"])) {

    $email = $_POST["e"];

    if (empty($email)) {
        echo ("Please Enter Your Email.");
    } else {

        $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "'");
        $admin_num = $admin_rs->num_rows;

        if ($admin_num > 0) {

            $code = uniqid();

            Database::iud("UPDATE `admin` SET `vcode`='" . $code . "' WHERE `email`='" . $email . "'");

            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'thisaloktaloop@gmail.com';
            $mail->Password = 'lxboiehovtwsigvc';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('thisaloktaloop@gmail.com', 'Admin Verification');
            $mail->addReplyTo('thisaloktaloop@gmail.com', 'Admin Verification');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'FASHION.MART Admin Sign In Verification Code.';
            $bodyContent = '<h2 style="color:black;">YOUR VERIFICATION CODE IS <h1 style="color:blue;"> ' . $code . ' </h1></h2>';
            $mail->Body = $bodyContent;

            if (!$mail->send()) {
                echo 'Verification code sending failed.';
            } else {
                echo 'Success';
            }
        } else {
            echo ("You are not a valid user.");
        }
    }
} else {
    echo ("Email field should not be empty.");
}
