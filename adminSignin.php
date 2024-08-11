<?php

include "connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FASHION.MART | ADMIN SIGN IN |</title>

    <!-- favicon in the website -->
    <link rel="shortcut icon" href="./icos/favicon.ico" type="image/x-icon">

    <!-- custome css file -->
    <link rel="stylesheet" href="./css/style.css" />

    <!-- bootstrap css file -->
    <link rel="stylesheet" href="./css/bootstrap.css" />

    <!-- fontawesome css file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>

    <!-- loading section starts -->
    <div id="loading" class="center">
        <div class="ring"></div>
        <span>Loading...</span>
    </div>
    <!-- loading section ends -->

    <div id="waiting">
        <h1>Waiting...</h1>
        <div class="underline-waiting"><span></span></div>
    </div>

    <div id="main-content" style="display: none;">

        <div class="signin-signup-page">

            <div class="container-ssp">

                <div class="forms-container-ssp ad-ad">
                    <div class="signin-signup">
                        <form action="#" class="sign-in-form">
                            <h2 class="title">Sign In</h2>

                            <div class="input-field">
                                <i class="fas fa-envelope"></i>
                                <input type="email" placeholder="Email" id="e">
                            </div>
                            <button class="btn-ssp-ad solid" onclick="adminVerification(event);">Send Verification Code</button>
                        </form>
                    </div>
                </div>

                <div class="panels-container">

                    <div class="panel left-panel">
                        <div class="content">
                            <br>
                            <h3>FASHION<span class="H3-ssp">.MART</h3>
                            <br>
                            <br>
                            <p>
                                Welcome to, the Admin Sign In. If you are not a Admin, click a Back to Customer Login button.
                            </p>
                            <br>
                            <a href="signup&signin.php"><button class="btn-panel btcl">Back to Customer Login</button></a>
                            <br>
                            <br>
                            <img src="./svgs/signup&in-section-img-1.svg" class="image-ssp" alt="image-in-signup">
                        </div>
                    </div>

                </div>

            </div>

            <!-- model -->
            <div class="modal modal-avc" tabindex="-1" id="verificationModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content modal-content-avc">
                        <div class="modal-header avc">
                            <h5 class="modal-title fw-bold">Admin Verification</h5>
                        </div>
                        <div class="modal-body avc">
                            <label class="form-label">Enter Your Verification Code</label>
                            <input type="text" class="form-control" id="vcode">
                        </div>
                        <div class="modal-footer avc">
                            <button type="button" class="btn avcbtn1" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn avcbtn2" onclick="verify();">Verify</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- model -->

        </div>

    </div>

    <!-- custome js file -->
    <script src="./js/script.js"></script>

    <!-- bootstrap js file -->
    <script src="./js/bootstrap.js"></script>
    <script src="./js/bootstrap.bundle.js"></script>

    <!-- fontawesome js file -->
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>

    <!-- sweetaleart js file -->
    <script src="./js/sweetalert.min.js"></script>

</body>

</html>