<?php

session_start();

include "connection.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION.MART | WATCHLIST |</title>

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

            <!-- header section starts  -->

            <?php include "header.php"; ?>

            <!-- header section ends -->

            <?php

            if (isset($_SESSION["u"])) {

                $watchlist_rs = Database::search("SELECT * FROM `watchlist` INNER JOIN `product` ON 
                watchlist.product_id=product.id INNER JOIN `product_has_color` ON 
                product_has_color.product_id=product.id INNER JOIN `color` ON 
                product_has_color.color_clr_id=color.clr_id INNER JOIN `condition` ON 
                product.condition_condition_id=condition.condition_id INNER JOIN `user` ON 
                product.user_email=user.email WHERE 
                watchlist.user_email = '" . $_SESSION["u"]["email"] . "'");

                $watchlist_num = $watchlist_rs->num_rows;

            ?>

                <!-- content section starts -->

                <div class="watch-page-content">

                    <br>
                    <p class="file-path"><span><a href="index.php">Home</a></span> / <a class="on-page" href="watchlist.php">Watchlist</a></p>

                    <div class="ad-search-content">

                        <h1 class="ad-search-h1">WATCHLIST</h1>

                        <div class="input-group col-md-12">
                            <input type="text" class="form-control col-md-10" placeholder="Search in Watchlist..." id="wtxt">
                            <button class="btn col-md-2" type="button" onclick="searchWatchlist();">Search</button>
                        </div>
                        <hr>

                    </div>

                    <div class="a-s-content-box col-md-12 row">

                        <div class="watchlist-side-navbar col-md-3">

                            <a href="watchlist.php"><button class="active">My Watchlist</button></a>
                            <a href="cart.php"><button>My Cart</button></a>

                        </div>

                        <div class="watchlist-pr-slide col-md-9">

                            <?php

                            if ($watchlist_num == 0) {

                            ?>

                                <!-- empty view -->
                                <div class="empty-view-con">
                                    <img src="./images/empty-box.png" alt="empty-box">
                                    <p>You have no items in your Watchlist yet.</p><br>
                                    <button onclick="startShopping();"><i class="fas fa-shopping-cart"></i>Start Shopping</button>
                                </div>
                                <!-- empty view -->

                            <?php

                            } else {

                            ?>

                                <!-- have products -->
                                <div class="have-pr-con col-md-12 row" id="search_view2">

                                    <?php

                                    for ($x = 0; $x < $watchlist_num; $x++) {
                                        $watchlist_data = $watchlist_rs->fetch_assoc();
                                        $list_id = $watchlist_data["w_id"];

                                    ?>

                                        <div class="pr-box">

                                            <?php

                                            $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $watchlist_data["product_id"] . "'");
                                            $img_data = $img_rs->fetch_assoc();

                                            ?>

                                            <div class="pr-img col-md-3">
                                                <img src="<?php echo $img_data["img_path"]; ?>" alt="product-img">
                                            </div>

                                            <div class="pr-details col-md-6">
                                                <ul>
                                                    <li class="prd-title"><?php echo $watchlist_data["title"]; ?></li>
                                                    <li class="sub-d prd-color"><b>Colour&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $watchlist_data["clr_name"]; ?></li>
                                                    <li class="sub-d prd-condition"><b>Condition&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $watchlist_data["condition_name"]; ?></li>
                                                    <li class="sub-d prd-price"><b>Price&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b>Rs. <?php echo $watchlist_data["price"]; ?> .00</li>

                                                    <?php

                                                    if ($watchlist_data["qty"] > 0) {
                                                    ?>
                                                        <li class="sub-d prd-qty text-success"><b>Quantity&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $watchlist_data["qty"]; ?> Items Available</li>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <li class="sub-d prd-qty text-danger"><b>Quantity&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $watchlist_data["qty"]; ?> Items Available</li>
                                                    <?php
                                                    }

                                                    ?>

                                                    <li class="sub-d prd-seller"><b>Seller&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $watchlist_data["fname"] . " " . $watchlist_data["lname"]; ?></li>
                                                </ul>
                                            </div>

                                            <div class="pr-btn col-md-3">

                                                <?php

                                                if (isset($_SESSION["u"])) {

                                                    if ($watchlist_data["qty"] > 0) {

                                                ?>

                                                        <a href='singleProductView.php?id=<?php echo $watchlist_data["id"]; ?>' target="_blank" class="btn-pb">
                                                            <button class="bn-btn">Buy Now</button>
                                                        </a>
                                                        <br>
                                                        <br>
                                                        <br>

                                                        <?php

                                                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $watchlist_data["id"] . "' AND `user_email` = '" . $_SESSION["u"]["email"] . "'");
                                                        $cart_num = $cart_rs->num_rows;

                                                        if ($cart_num == 1) {

                                                        ?>
                                                            <button class="atc-btn-no" onclick='addToCart(<?php echo $watchlist_data["id"]; ?>);' id="rbbcarti<?php echo $watchlist_data["id"]; ?>">Remove from Cart</button>
                                                        <?php

                                                        } else {

                                                        ?>
                                                            <button class="atc-btn" onclick='addToCart(<?php echo $watchlist_data["id"]; ?>);' id="rbbcarti<?php echo $watchlist_data["id"]; ?>">Add to Cart</button>
                                                        <?php

                                                        }
                                                    } else {
                                                        ?>

                                                        <a class="btn-pb">
                                                            <button class="bn-btn-not-active">Buy Now</button>
                                                        </a>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <button class="atc-btn-not-active">Add to Cart</button>

                                                    <?php
                                                    }
                                                } else {

                                                    if ($watchlist_data["qty"] > 0) {
                                                    ?>
                                                        <a href='singleProductView.php?id=<?php echo $watchlist_data["id"]; ?>' target="_blank" class="btn-pb">
                                                            <button class="bn-btn-not-active">Buy Now</button>
                                                        </a>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <button class="atc-btn-not-active">Add to Cart</button>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a class="btn-pb">
                                                            <button class="bn-btn-not-active">Buy Now</button>
                                                        </a>
                                                        <br>
                                                        <br>
                                                        <br>
                                                        <button class="atc-btn-not-active">Add to Cart</button>
                                                <?php
                                                    }
                                                }

                                                ?>

                                                <br>
                                                <br>
                                                <br>
                                                <button class="r-btn" onclick='removeFromWatchlist(<?php echo $list_id; ?>);'>Remove</button>
                                            </div>

                                        </div>

                                    <?php

                                    }

                                    ?>

                                </div>
                                <!-- have products -->

                            <?php

                            }

                            ?>

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

    <!-- bootstrap js file -->
    <script src="./js/bootstrap.js"></script>

    <!-- fontawesome js file -->
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>

    <!-- ionicons js file -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- sweetaleart js file -->
    <script src="./js/sweetalert.min.js"></script>

</body>

</html>