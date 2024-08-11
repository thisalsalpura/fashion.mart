<?php

session_start();

include "connection.php";

if (isset($_GET["id"])) {

    $pid = $_GET["id"];

    $product_rs = Database::search("SELECT product.id,product.price,product.qty,product.description,product.title,product.datetime_added,
    product.delivery_fee_colombo,product.delivery_fee_other,product.category_cat_id,product.model_has_brand_id,product.condition_condition_id,
    product.status_status_id,product.user_email,model.model_name AS mname,brand.brand_name AS bname FROM `product` INNER JOIN `model_has_brand` 
    ON model_has_brand.model_has_brand_id=product.model_has_brand_id INNER JOIN `brand` ON brand.brand_id=model_has_brand.brand_brand_id INNER JOIN `model` ON 
    model.model_id=model_has_brand.model_model_id WHERE product.id='" . $pid . "'");

    $product_num = $product_rs->num_rows;

    if ($product_num == 1) {

        $product_data = $product_rs->fetch_assoc();

?>

        <!DOCTYPE html>

        <html lang="en">

        <head>

            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>FASHION.MART | <?php echo $product_data["title"]; ?> |</title>

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

            <div id="waiting2">
                <h1>Waiting...</h1>
                <div class="underline-waiting"><span></span></div>
            </div>

            <div id="main-content" style="display: none;">

                <div class="product-page">

                    <!-- header section starts  -->

                    <?php include "header.php"; ?>

                    <!-- header section ends -->

                    <!-- content section starts -->

                    <div class="single-pr-view-page">

                        <br>
                        <p class="file-path"><span><a href="index.php">Home</a></span></p>
                        <br>

                        <div class="main-wrapper-spv">
                            <div class="container-spv">
                                <div class="product-div">
                                    <div class="product-div-left">

                                        <?php

                                        $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $pid . "'");
                                        $image_num = $image_rs->num_rows;
                                        $img = array();
                                        $firstImagePath = "";

                                        if ($image_num > 0) {
                                            $image_data = $image_rs->fetch_assoc();
                                            $firstImagePath = $image_data["img_path"];
                                        }

                                        ?>

                                        <div class="img-container-spv">
                                            <img src="<?php echo $firstImagePath; ?>">
                                        </div>

                                        <?php

                                        if ($image_num != 0) {

                                        ?>

                                            <div class="hover-container">

                                                <?php

                                                $image_rs->data_seek(0);

                                                for ($x = 0; $x < $image_num; $x++) {

                                                    $image_data = $image_rs->fetch_assoc();
                                                    $img[$x] = $image_data["img_path"];

                                                ?>

                                                    <div><img src="<?php echo $img[$x]; ?>"></div>

                                                <?php

                                                }

                                                ?>

                                            </div>

                                        <?php

                                        } else {

                                            // 

                                        }

                                        ?>

                                    </div>
                                    <div class="product-div-right">
                                        <span class="product-name"><?php echo $product_data["title"]; ?></span>

                                        <?php

                                        $price = $product_data["price"];
                                        $adding_price = ($price / 100) * 10;
                                        $new_price = $price + $adding_price;
                                        $difference = $new_price - $price;

                                        ?>

                                        <span class="product-price"><a class="tp">Rs. <?php echo $price; ?> .00</a> | <a class="sp text-decoration-line-through">Rs. <?php echo $new_price; ?> .00</a> | <a class="sd">Save Rs. <?php echo $difference; ?> .00 (10%)</a></span>
                                        <div class="product-rating">
                                            <span><i class="fas fa-star"></i></span>
                                            <span><i class="fas fa-star"></i></span>
                                            <span><i class="fas fa-star"></i></span>
                                            <span><i class="fas fa-star"></i></span>
                                            <span><i class="fas fa-star-half-alt"></i></span>
                                        </div>
                                        <br>
                                        <span class="review">4.5 Stars | 39 Reviews and Ratings</span>
                                        <p class="product-description"><?php echo $product_data["description"]; ?></p>
                                        <br>
                                        <?php
                                        if ($product_data["qty"] > 0) {
                                        ?>
                                            <span><a class="stock">In Stock&nbsp; :&nbsp; <?php echo $product_data["qty"]; ?> Items Available</a></span>
                                        <?php
                                        } else {
                                        ?>
                                            <span><a class="stock-n">In Stock&nbsp; :&nbsp; <?php echo $product_data["qty"]; ?> Items Available</a></span>
                                        <?php
                                        }
                                        ?>
                                        <br>
                                        <br>
                                        <div class="col-12 my-2 box-se">
                                            <div class="row">

                                                <?php

                                                $seller_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $product_data["user_email"] . "'");
                                                $seller_data = $seller_rs->fetch_assoc();

                                                ?>

                                                <div class="col-12 col-lg-6 box-se-soi text-center">
                                                    <span><b>Seller&nbsp; :&nbsp; </b><?php echo $seller_data["fname"]; ?></span>
                                                </div>
                                                <div class="col-12 col-lg-6 box-se-soi text-center">
                                                    <span><b>Sold&nbsp; :&nbsp; </b>100 Items</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="my-2 col-12 col-lg-12 dis">
                                                        <div class="row">
                                                            <div class="col-3 col-lg-2 dis-icon">
                                                                <img src="./svgs/price_tag.svg" />
                                                            </div>
                                                            <div class="col-9 col-lg-10 dis-txt">
                                                                <span>
                                                                    Stand a chance to get 5% discount by using VISA or MASTER
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php

                                        if (isset($_SESSION["u"])) {

                                        ?>
                                            <div class="wrapper-qty">
                                                <span class="minus" onclick="qty_dec();">-</span>

                                                <?php

                                                $qty_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $pid . "' AND `user_email` = '" . $_SESSION["u"]["email"] . "'");
                                                $qty_num = $qty_rs->num_rows;

                                                if ($qty_num > 0) {
                                                    $qty_data = $qty_rs->fetch_assoc();
                                                ?>
                                                    <span class="num" id="qty_input"> <?php echo $qty_data["qty"]; ?> </span>
                                                <?php
                                                } else {
                                                ?>
                                                    <span class="num" id="qty_input"> 1 </span>
                                                <?php
                                                }

                                                ?>

                                                <span class="plus" onclick='qty_inc(<?php echo $product_data["qty"]; ?>);'>+</span>
                                            </div>
                                        <?php

                                        } else {

                                        ?>
                                            <div class="wrapper-qty">
                                                <span class="minus">-</span>
                                                <span class="num"> 1 </span>
                                                <span class="plus">+</span>
                                            </div>
                                        <?php

                                        }

                                        ?>

                                        <div class="btn-groups-spv">

                                            <?php

                                            if (isset($_SESSION["u"])) {

                                                if ($product_data["qty"] > 0) {

                                                    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $product_data["id"] . "' AND `user_email` = '" . $_SESSION["u"]["email"] . "'");
                                                    $cart_num = $cart_rs->num_rows;

                                                    if ($cart_num == 1) {

                                            ?>
                                                        <button type="button" class="add-cart-btn-no col-md-12" onclick='addToCart(<?php echo $product_data["id"]; ?>);' id="abcarti<?php echo $product_data["id"]; ?>"><i class="fas fa-shopping-cart"></i>remove from cart</button>
                                                    <?php

                                                    } else {

                                                    ?>
                                                        <button type="button" class="add-cart-btn col-md-12" onclick='addToCart(<?php echo $product_data["id"]; ?>);' id="rbcarti<?php echo $product_data["id"]; ?>"><i class="fas fa-shopping-cart"></i>add to cart</button>
                                                    <?php

                                                    }
                                                } else {


                                                    ?>

                                                    <button type="button" class="add-cart-btn-disable col-md-12"><i class="fas fa-shopping-cart"></i>add to cart</button>

                                                <?php

                                                }
                                            } else {

                                                ?>

                                                <button type="button" class="add-cart-btn-disable col-md-12"><i class="fas fa-shopping-cart"></i>add to cart</button>

                                                <?php

                                            }

                                            if (isset($_SESSION["u"])) {

                                                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '" . $_SESSION["u"]["email"] . "' AND 
                                                `product_id` = '" . $product_data["id"] . "'");

                                                $watchlist_num = $watchlist_rs->num_rows;

                                                if ($watchlist_num == 1) {

                                                ?>

                                                    <button class="add-watchlist-btn-added col-md-12" onclick='addToWatchlist(<?php echo $product_data["id"]; ?>);' id="heart<?php echo $product_data["id"]; ?>"><i class="fas fa-solid fa-heart"></i>unwatch</button>

                                                <?php

                                                } else {

                                                ?>

                                                    <button class="add-watchlist-btn-not-added col-md-12" onclick='addToWatchlist(<?php echo $product_data["id"]; ?>);' id="heart<?php echo $product_data["id"]; ?>"><i class="fas fa-solid fa-heart"></i>add to watchlist</button>

                                                <?php

                                                }
                                            } else {

                                                ?>

                                                <button class="add-watchlist-btn-disabled col-md-12"><i class="fas fa-solid fa-heart"></i>add to watchlist</button>

                                                <?php

                                            }

                                            if (isset($_SESSION["u"])) {

                                                if ($product_data["qty"] > 0) {

                                                ?>

                                                    <button type="submit" id="payhere-payment" onclick='payNow(<?php echo $pid; ?>);' class="buy-now-btn col-md-12"><i class="fas fa-solid fa-credit-card"></i>buy now</button>

                                                <?php

                                                } else {

                                                ?>

                                                    <button type="button" class="buy-now-btn-disable col-md-12"><i class="fas fa-solid fa-credit-card"></i>buy now</button>

                                                <?php

                                                }
                                            } else {

                                                ?>

                                                <button type="button" class="buy-now-btn-disable col-md-12"><i class="fas fa-solid fa-credit-card"></i>buy now</button>

                                            <?php

                                            }

                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="realated-i-txt">
                            Related Items
                        </div>

                        <br>

                        <section class="products" id="products">

                            <div class="box-container">

                                <?php

                                $related_rs = Database::search("SELECT * FROM `product` WHERE `model_has_brand_id` = '" . $product_data["model_has_brand_id"] . "' AND `id` != '" . $pid . "' LIMIT 3");

                                $related_num = $related_rs->num_rows;

                                for ($y = 0; $y < $related_num; $y++) {
                                    $related_data = $related_rs->fetch_assoc();

                                ?>

                                    <div class="box">

                                        <?php
                                        $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $related_data["id"] . "'");
                                        $img_data = $img_rs->fetch_assoc();
                                        ?>

                                        <div class="image">
                                            <img src="<?php echo $img_data["img_path"]; ?>" alt="product-img">
                                        </div>
                                        <div class="content">
                                            <h3><?php echo $related_data["title"]; ?></h3>
                                            <span class="new-badge">New</span><br />
                                            <div class="price">Rs. <?php echo $related_data["price"]; ?> .00</div>

                                            <?php

                                            if (isset($_SESSION["u"])) {

                                                if ($related_data["qty"] > 0) {
                                            ?>

                                                    <span class="in-stock-txt">In Stock</span><br />
                                                    <span class="available-items-qty"><?php echo $related_data["qty"]; ?> Items Available</span><br /><br />
                                                    <a href='<?php echo "singleProductView.php?id=" . ($related_data["id"]); ?>' target="_blank" class="btn-pb">Buy Now</a><br><br>

                                                    <?php

                                                    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $related_data["id"] . "' AND `user_email` = '" . $_SESSION["u"]["email"] . "'");
                                                    $cart_num = $cart_rs->num_rows;

                                                    if ($cart_num == 1) {

                                                    ?>
                                                        <a class="icons watchlisted fas fa-shopping-cart" onclick='addToCart(<?php echo $related_data["id"]; ?>);' id="carti<?php echo $related_data["id"]; ?>"></a>
                                                    <?php

                                                    } else {

                                                    ?>
                                                        <a class="icons not-watchlisted fas fa-shopping-cart" onclick='addToCart(<?php echo $related_data["id"]; ?>);' id="carti<?php echo $related_data["id"]; ?>"></a>
                                                    <?php

                                                    }
                                                } else {
                                                    ?>

                                                    <span class="out-of-stock-txt">Out Of Stock</span><br />
                                                    <span class="available-items-qty">0 Items Available</span><br /><br />
                                                    <a class="btn-pb-disabled">Buy Now</a><br><br>
                                                    <a class="icons-disabled fas fa-shopping-cart"></a>

                                                <?php
                                                }
                                            } else {

                                                if ($related_data["qty"] > 0) {
                                                ?>

                                                    <span class="in-stock-txt">In Stock</span><br />
                                                    <span class="available-items-qty"><?php echo $related_data["qty"]; ?> Items Available</span><br /><br />
                                                    <a href='<?php echo "singleProductView.php?id=" . ($related_data["id"]); ?>' target="_blank" class="btn-pb">Buy Now</a><br><br>
                                                    <a class="icons-disabled fas fa-shopping-cart"></a>

                                                <?php
                                                } else {
                                                ?>

                                                    <span class="out-of-stock-txt">Out Of Stock</span><br />
                                                    <span class="available-items-qty">0 Items Available</span><br /><br />
                                                    <a class="btn-pb-disabled">Buy Now</a><br><br>
                                                    <a class="icons-disabled fas fa-shopping-cart"></a>

                                                <?php
                                                }
                                            }

                                            if (isset($_SESSION["u"])) {

                                                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '" . $_SESSION["u"]["email"] . "' AND 
                                                `product_id` = '" . $related_data["id"] . "'");

                                                $watchlist_num = $watchlist_rs->num_rows;

                                                if ($watchlist_num == 1) {

                                                ?>

                                                    <a class="icons watchlisted fas fa-solid fa-heart" onclick='addToWatchlist(<?php echo $related_data["id"]; ?>);' id="heart<?php echo $related_data["id"]; ?>"></a>

                                                <?php

                                                } else {

                                                ?>

                                                    <a class="icons not-watchlisted fas fa-solid fa-heart" onclick='addToWatchlist(<?php echo $related_data["id"]; ?>);' id="heart<?php echo $related_data["id"]; ?>"></a>

                                                <?php

                                                }
                                            } else {

                                                ?>

                                                <a class="icons-disabled fas fa-solid fa-heart"></a>

                                            <?php

                                            }

                                            ?>

                                        </div>
                                    </div>

                                <?php

                                }

                                ?>

                            </div>

                        </section>

                        <div class="realated-i-txt">
                            Item Details
                        </div>

                        <br>
                        <br>
                        <br>

                        <div class="col-md-12 row pr-detai">

                            <div class="p-5">

                                <div class="item-det col-md-12">
                                    <label>Brand : </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <p><?php echo $product_data["bname"]; ?></p>
                                </div>

                                <hr>

                                <div class="item-det col-md-12">
                                    <label>Model : </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <p><?php echo $product_data["mname"]; ?></p>
                                </div>

                                <hr>

                                <div class="col-md-12">
                                    <label class="ies-label">Description : </label><br>
                                    <textarea cols="60" rows="10" class="form-control pr-des-txta" readonly><?php echo $product_data["description"]; ?></textarea>
                                </div>

                            </div>

                        </div>

                        <br>

                        <div class="realated-i-txt">
                            Feedbacks
                        </div>

                        <br>
                        <br>
                        <br>

                        <div class="col-md-12 row pr-feedback scroll-pr">

                            <?php

                            $feedback_rs = Database::search("SELECT *FROM `feedback` INNER JOIN `user` ON feedback.user_email=user.email  
                            WHERE `product_id` = '" . $pid . "' ORDER BY `date` DESC");

                            $feedback_num = $feedback_rs->num_rows;

                            if ($feedback_num >= 1) {

                                for ($y = 0; $y < $feedback_num; $y++) {
                                    $feedback_data = $feedback_rs->fetch_assoc();

                            ?>

                                    <div class="p-4">

                                        <?php

                                        if ($feedback_data["type"] == 1) {
                                        ?>

                                            <div class="positive-msg msg-box">

                                                <p class="uname"><?php echo $feedback_data["fname"] . " " . $feedback_data["lname"]; ?></p>

                                                <p class="ufeedback"><b><?php echo $feedback_data["feed"]; ?></b></p>

                                                <p class="udate"><?php echo $feedback_data["date"]; ?></p>

                                            </div>

                                        <?php
                                        } else if ($feedback_data["type"] == 2) {
                                        ?>

                                            <div class="neutral-msg msg-box">

                                                <p class="uname"><?php echo $feedback_data["fname"] . " " . $feedback_data["lname"]; ?></p>

                                                <p class="ufeedback"><b><?php echo $feedback_data["feed"]; ?></b></p>

                                                <p class="udate"><?php echo $feedback_data["date"]; ?></p>

                                            </div>

                                        <?php
                                        } else if ($feedback_data["type"] == 3) {
                                        ?>

                                            <div class="negative-msg msg-box">

                                                <p class="uname"><?php echo $feedback_data["fname"] . " " . $feedback_data["lname"]; ?></p>

                                                <p class="ufeedback"><b><?php echo $feedback_data["feed"]; ?></b></p>

                                                <p class="udate"><?php echo $feedback_data["date"]; ?></p>

                                            </div>

                                        <?php
                                        }

                                        ?>

                                    </div>

                                <?php

                                }
                            } else {

                                ?>

                                <div class="no-msg-box">

                                    <p class="no-msg-txt">No feedbacks add this product yet.</p>

                                </div>

                            <?php

                            }

                            ?>

                        </div>

                        <!-- content section ends -->

                        <br>
                        <br>
                        <br>

                        <!-- footer section starts -->

                        <?php include "footer.php"; ?>

                        <!-- footer section ends -->

                    </div>

                </div>

            </div>

            <!-- custome js file -->
            <script src="./js/script.js"></script>

            <!-- payhere js file -->
            <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

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

<?php

    } else {
        echo ("Sorry for the inconvenience. Please try again later.");
    }
} else {
    echo ("Something Went Wrong.");
}

?>