<?php

include "connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FASHION.MART | SIGN IN | SIGN UP |</title>

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

                <div class="forms-container-ssp">
                    <div class="signin-signup">
                        <form action="#" class="sign-in-form">
                            <h2 class="title">Sign In</h2>

                            <?php

                            $email = "";
                            $password = "";

                            if (isset($_COOKIE["email"])) {
                                $email = $_COOKIE["email"];
                            }

                            if (isset($_COOKIE["password"])) {
                                $password = $_COOKIE["password"];
                            }

                            ?>

                            <div class="input-field">
                                <i class="fas fa-envelope"></i>
                                <input type="email" placeholder="Email" id="email2" value="<?php echo $email; ?>">
                            </div>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Password" id="password2" value="<?php echo $password; ?>">
                                <button class="fa-solid fa-eye-slash hide-unhide" onclick="spw2(event);" id="eye2"></button>
                            </div>
                            <div>
                                <div class="remember-me">
                                    <input class="checkbox" type="checkbox" id="rememberme" />&nbsp;&nbsp;
                                    <label class="">Remember Me</label>
                                </div>
                            </div>
                            <div class="forgot-password">
                                <a onclick="forgotPassword();" href="#" class="fp-txt">Forgotten Password?</a>
                            </div>
                            <button class="btn-ssp solid" onclick="signin(event);">Sign In</button>
                        </form>
                        <form action="#" class="sign-up-form">
                            <h2 class="title">Sign Up</h2>
                            <label class="form-lable">First Name</label>
                            <div class="input-field">
                                <i class="fas fa-user"></i>
                                <input type="text" placeholder="Ex:- John" id="fname">
                            </div>
                            <label class="form-lable">Last Name</label>
                            <div class="input-field">
                                <i class="fas fa-user"></i>
                                <input type="text" placeholder="Ex:- Doe" id="lname">
                            </div>
                            <label class="form-lable">Email</label>
                            <div class="input-field">
                                <i class="fas fa-envelope"></i>
                                <input type="email" placeholder="Ex:- john@gmail.com" id="email">
                            </div>
                            <label class="form-lable">Password</label>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Ex:- **********" id="password">
                                <button class="fa-solid fa-eye-slash hide-unhide" onclick="spw1(event);" id="eye1"></button>
                            </div>
                            <label class="form-lable">Mobile</label>
                            <div class="input-field">
                                <i class="fa-solid fa-phone"></i>
                                <input type="text" placeholder="Ex:- 0771234568" id="mobile">
                            </div>
                            <label class="form-lable">Gender</label>
                            <select class="form-control gen-selecter" id="gender">

                                <?php

                                $rs = Database::search("SELECT * FROM `gender`");
                                $num = $rs->num_rows;

                                for ($x = 0; $x < $num; $x++) {
                                    $data = $rs->fetch_assoc();
                                ?>

                                    <option value="<?php echo $data["gender_id"]; ?>">
                                        <?php echo $data["gender_name"]; ?>
                                    </option>

                                <?php
                                }

                                ?>

                            </select>
                            <button class="btn-ssp solid" onclick="signup(event);">Sign Up</button>
                        </form>
                    </div>
                </div>

                <div class="panels-container">

                    <div class="panel left-panel">
                        <div class="content">
                            <h3>FASHION<span class="H3-ssp">.MART</h3>
                            <p>
                                Doesn't have an account? Sign Up
                            </p>
                            <button class="btn-panel transparent" id="sign-up-btn">Sign Up</button>
                            <br>
                            <br>
                            <!-- alert section starts  -->
                            <div class="col-12 d-none" id="msgdiv">
                                <div class="alert alert-danger msgdivbox" role="alert" id="msg">

                                </div>
                            </div>
                            <!-- alert section ends  -->
                            <img src="./svgs/signup&in-section-img-1.svg" class="image-ssp" alt="image-in-signup">
                        </div>
                    </div>

                    <div class="panel right-panel">
                        <div class="content">
                            <h3>FASHION<span class="H3-ssp">.MART</h3>
                            <p>
                                Already have an account? Sign In
                            </p>
                            <button class="btn-panel transparent" id="sign-in-btn">Sign In</button>
                            <br>
                            <br>
                            <!-- alert section starts  -->
                            <div class="col-12 d-none" id="msgdiv1">
                                <div class="alert alert-danger msgdivbox" role="alert" id="msg1">

                                </div>
                            </div>
                            <!-- alert section ends  -->
                            <img src="./svgs/signup&in-section-img-2.svg" class="image-ssp" alt="image-in-signin">
                        </div>
                    </div>

                </div>

            </div>

            <!-- forgot password model starts -->

            <div class="modal fade" tabindex="-1" id="fpModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Forgot Password</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <label for="form-label">New Password</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" id="np">
                                        <button id="npb" class="btn btn-outline-secondary" type="button" onclick="showPassword1();">Show</button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="form-label">Re-type Password</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" id="rnp">
                                        <button id="rnpb" class="btn btn-outline-secondary" type="button" onclick="showPassword2();">Show</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Verification Code</label>
                                    <input type="text" class="form-control" id="vcode">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="resetPassword();">Reset</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- forgot password model ends -->

        </div>

    </div>

    <!-- custome js file -->
    <script defer src="./js/script.js"></script>

    <script>
        // js for changing signin & signup section in signup&signin.php
        const sign_in_btn = document.querySelector(".signin-signup-page .container-ssp .panels-container .right-panel #sign-in-btn");
        const sign_up_btn = document.querySelector(".signin-signup-page .container-ssp .panels-container .left-panel #sign-up-btn");
        const containerssp = document.querySelector(".signin-signup-page .container-ssp");

        sign_up_btn.addEventListener('click', () => {
            containerssp.classList.add("sign-up-mode");
        });

        sign_in_btn.addEventListener('click', () => {
            containerssp.classList.remove("sign-up-mode");
        });
    </script>

    <!-- bootstrap js file -->
    <script src="./js/bootstrap.js"></script>

    <!-- fontawesome js file -->
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>

    <!-- sweetaleart js file -->
    <script src="./js/sweetalert.min.js"></script>

</body>

</html>