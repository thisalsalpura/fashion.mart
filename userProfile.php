<!DOCTYPE html>

<html lang="en">


<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION.MART | MY PROFILE |</title>

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

    <div id="main-content" style="display: none;">

        <div class="product-page">

            <?php

            session_start();

            include "header.php";

            include "connection.php";

            if (isset($_SESSION["u"])) {

                $email = $_SESSION["u"]["email"];

                $details_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON 
                user.gender_gender_id = gender.gender_id WHERE `email` = '" . $email . "'");

                $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $email . "'");

                $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON 
                user_has_address.city_city_id = city.city_id INNER JOIN `district` ON 
                city.district_district_id = district.district_id INNER JOIN `province` ON 
                district.province_province_id = province.province_id WHERE `user_email` = '" . $email . "'");

                $user_details = $details_rs->fetch_assoc();
                $image_details = $image_rs->fetch_assoc();
                $address_details = $address_rs->fetch_assoc();

            ?>

                <br>
                <p class="file-path"><span><a href="index.php">Home</a></span> / <a class="on-page" href="userProfile.php">Profile</a></p>
                <br>

                <!-- content section starts -->

                <div class="profile-page">

                    <div class="profile-pic-details">

                        <?php

                        if (empty($image_details["path"])) {
                        ?>
                            <a href="#" class="profile-image">
                                <img src="./images/profile_images/sampel-profile-img.png" alt="profile-img" id="img">
                            </a>
                        <?php
                        } else {
                        ?>
                            <a href="#" class="profile-image">
                                <img src="<?php echo $image_details["path"]; ?>" alt="profile-img" id="img">
                            </a>
                        <?php
                        }

                        ?>

                        <br>
                        <br>
                        <p class="profile-name"><?php echo $user_details["fname"] . " " . $user_details["lname"]; ?></p>
                        <p class="profile-email"><?php echo $email; ?></p><br>
                        <input type="file" class="d-none" id="profileimage" />
                        <label for="profileimage" class="upload-profile-pic" onclick="changeProfileImg();">Upload Profile Image</label><br>
                        <p class="user-rating-txt">User Rating</p>
                        <div class="user-rating-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="user-rating-txt2">4.5 Average Based On 297 Reviews.</p><br>
                        <label class="progress-label">5 Star</label><br>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: 75%"></div>
                        </div>
                        <div class="below-num-progress">90</div>
                        <br>
                        <br>
                        <label class="progress-label">4 Star</label><br>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: 25%"></div>
                        </div>
                        <div class="below-num-progress">90</div>
                        <br>
                        <br>
                        <label class="progress-label">3 Star</label><br>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: 50%"></div>
                        </div>
                        <div class="below-num-progress">90</div>
                        <br>
                        <br>
                        <label class="progress-label">2 Star</label><br>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: 75%"></div>
                        </div>
                        <div class="below-num-progress">90</div>
                        <br>
                        <br>
                        <label class="progress-label">1 Star</label><br>
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: 50%"></div>
                        </div>
                        <div class="below-num-progress">90</div>
                    </div>

                    <div class="profile-details-input-section row g-3">
                        <h1>Profile Setting</h1>
                        <div class="col-md-6">
                            <label class="form-label">First Name</label><br>
                            <hr>
                            <input type="text" id="fname" value="<?php echo $user_details["fname"]; ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label><br>
                            <hr>
                            <input type="text" id="lname" value="<?php echo $user_details["lname"]; ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Mobile Number</label><br>
                            <hr>
                            <input type="text" id="mobile" value="<?php echo $user_details["mobile"]; ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Email</label><br>
                            <hr>
                            <input class="readonly" type="email" readonly value="<?php echo $user_details["email"]; ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Password</label><br>
                            <hr>
                            <input class="readonly" type="password" id="password-profs" readonly value="<?php echo $user_details["password"]; ?>">
                            <button class="fa-solid fa-eye-slash hide-unhide-profs" onclick="spwprofs(event);" id="eye-profs"></button>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Registered Date & Time</label><br>
                            <hr>
                            <input class="readonly" type="text" readonly value="<?php echo $user_details["joined_date"]; ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address Line 1</label><br>
                            <hr>

                            <?php

                            if (empty($address_details["line1"])) {
                            ?>
                                <input id="line1" type="text" />
                            <?php
                            } else {
                            ?>
                                <input id="line1" type="text" value="<?php echo $address_details["line1"]; ?>" />
                            <?php
                            }

                            ?>

                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Address Line 2</label><br>
                            <hr>

                            <?php

                            if (empty($address_details["line2"])) {
                            ?>
                                <input id="line2" type="text" />
                            <?php
                            } else {
                            ?>
                                <input id="line2" type="text" value="<?php echo $address_details["line2"]; ?>" />
                            <?php
                            }

                            ?>

                        </div>

                        <?php

                        $province_rs = Database::search("SELECT * FROM `province`");
                        $district_rs = Database::search("SELECT * FROM `district`");
                        $city_rs = Database::search("SELECT * FROM `city`");

                        ?>

                        <div class="col-md-6">
                            <label class="form-label">Province</label><br>
                            <hr>
                            <select class="fcs form-control" id="province">
                                <option class="fco" value="0">Select Province</option>
                                <?php

                                for ($x = 0; $x < $province_rs->num_rows; $x++) {
                                    $province_data = $province_rs->fetch_assoc();
                                ?>
                                    <option class="fco" value="<?php echo $province_data["province_id"]; ?>" <?php
                                                                                                                if (!empty($address_details["province_id"])) {
                                                                                                                    if ($province_data["province_id"] == $address_details["province_id"]) {
                                                                                                                ?>selected<?php
                                                                                                                        }
                                                                                                                    }
                                                                                                                            ?>>
                                        <?php echo $province_data["province_name"]; ?>
                                    </option>
                                <?php
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">District</label><br>
                            <hr>
                            <select class="fcs form-control" id="district">
                                <option class="fco" value="0">Select District</option>
                                <?php

                                for ($x = 0; $x < $district_rs->num_rows; $x++) {
                                    $district_data = $district_rs->fetch_assoc();
                                ?>
                                    <option class="fco" value="<?php echo $district_data["district_id"]; ?>" <?php
                                                                                                                if (!empty($address_details["district_id"])) {
                                                                                                                    if ($district_data["district_id"] == $address_details["district_id"]) {
                                                                                                                ?>selected<?php
                                                                                                                        }
                                                                                                                    }
                                                                                                                            ?>>
                                        <?php echo $district_data["district_name"]; ?>
                                    </option>
                                <?php
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City</label><br>
                            <hr>
                            <select class="fcs form-control" id="city">
                                <option class="fco" value="0">Select City</option>
                                <?php

                                for ($x = 0; $x < $city_rs->num_rows; $x++) {
                                    $city_data = $city_rs->fetch_assoc();
                                ?>
                                    <option class="fco" value="<?php echo $city_data["city_id"]; ?>" <?php
                                                                                                        if (!empty($address_details["city_id"])) {
                                                                                                            if ($city_data["city_id"] == $address_details["city_id"]) {
                                                                                                        ?>selected<?php
                                                                                                                }
                                                                                                            }
                                                                                                                    ?>>
                                        <?php echo $city_data["city_name"]; ?>
                                    </option>
                                <?php
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Postal Code</label><br>
                            <hr>
                            <?php

                            if (empty($address_details["postal_code"])) {
                            ?>
                                <input id="pcode" type="text" />
                            <?php
                            } else {
                            ?>
                                <input id="pcode" type="text" value="<?php echo $address_details["postal_code"]; ?>" />
                            <?php
                            }

                            ?>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Gender</label><br>
                            <hr>
                            <input class="readonly" type="text" readonly value="<?php echo $user_details["gender_name"]; ?>" />
                        </div>
                        <div class="col-md-3 save-details-div">
                            <button class="save-details-btn" onclick="updateProfile();">Update My Profile</button>
                        </div>
                    </div>

                </div>

                <!-- content section ends -->

            <?php

            } else {

            ?>

                <script>
                    window.location = "signup&signin.php";
                </script>

            <?php

            }

            ?>

            <br>
            <br>
            <br>

            <!-- footer section starts -->

            <?php include "footer.php"; ?>

            <!-- footer section ends -->

        </div>

    </div>

    <!-- custome js file -->
    <script src="./js/script.js"></script>

    <!-- fontawesome js file -->
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>

    <!-- ionicons js file -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- sweetaleart js file -->
    <script src="./js/sweetalert.min.js"></script>

</body>

</html>