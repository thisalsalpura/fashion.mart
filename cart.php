<?php

session_start();

include "connection.php";

$cartPrId = array();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION.MART | CART |</title>

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

            <?php

            if (isset($_SESSION["u"])) {

                $user = $_SESSION["u"]["email"];

                $total  = 0;
                $subtotal = 0;
                $shipping = 0;

            ?>

                <!-- content section starts -->

                <div class="cart-page-content">

                    <br>
                    <p class="file-path"><span><a href="index.php">Home</a></span> / <a class="on-page" href="cart.php">Cart</a></p>

                    <div class="ad-search-content">

                        <h1 class="ad-search-h1">CART</h1>

                        <div class="input-group col-md-12">
                            <input type="text" class="form-control col-md-10" placeholder="Search in Cart..." id="ctxt">
                            <button class="btn col-md-2" type="button" onclick="searchCart();">Search</button>
                        </div>
                        <hr>

                    </div>

                    <?php

                    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email` = '" . $user . "'");
                    $cart_num = $cart_rs->num_rows;

                    if ($cart_num == 0) {

                    ?>

                        <!-- empty view starts -->

                        <div class="empty-pr-box-c">

                            <div class="cart-img">
                                <img src="./images/cart.png" alt="cart-img">
                            </div>

                            <div class="empty-text">
                                <p>You have no items in your Cart yet.</p>
                            </div>

                            <button onclick="startShopping();"><i class="fas fa-shopping-cart"></i>Start Shopping</button>

                        </div>

                        <!-- empty view ends -->

                    <?php

                    } else {

                    ?>

                        <div class="product-display-box">

                            <div class="col-md-12 row s-p">

                                <!-- product view starts -->

                                <div class="product-view-c col-md-8" id="search_view1">

                                    <div class="col-md-12">

                                        <?php

                                        for ($x = 0; $x < $cart_num; $x++) {

                                            $cart_data = $cart_rs->fetch_assoc();

                                            $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `product_img` ON 
                                            product.id=product_img.product_id INNER JOIN `condition` ON product.condition_condition_id=condition.condition_id 
                                            INNER JOIN `product_has_color` ON product.id=product_has_color.product_id INNER JOIN `color` ON product_has_color.color_clr_id=color.clr_id 
                                            WHERE `id` = '" . $cart_data["product_id"] . "'");
                                            $product_data = $product_rs->fetch_assoc();

                                            $total = $total + ($product_data["price"] * $cart_data["qty"]);

                                            $address_rs = Database::search("SELECT `city_city_id` AS cid FROM `user_has_address` INNER JOIN `city` ON 
                                            user_has_address.city_city_id=city.city_id INNER JOIN `district` ON 
                                            city.district_district_id=district.district_id WHERE `user_email` = '" . $user . "'");

                                            $address_data = $address_rs->fetch_assoc();

                                            $ship = 0;

                                            if ($address_data["cid"] == 1) {
                                                $ship = $product_data["delivery_fee_colombo"];
                                                $shipping = $shipping + $ship;
                                            } else {
                                                $ship = $product_data["delivery_fee_other"];
                                                $shipping = $shipping + $ship;
                                            }

                                            $seller_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $product_data["user_email"] . "'");
                                            $seller_data = $seller_rs->fetch_assoc();
                                            $seller = $seller_data["fname"] . " " . $seller_data["lname"];

                                        ?>

                                            <div class="pr-box row">

                                                <div class="seller col-md-12">
                                                    <p><b>Seller&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $seller; ?></p>
                                                </div>

                                                <span class="pr-img col-md-4" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?php echo $product_data["description"]; ?>" data-bs-title="Product Description">
                                                    <img src="<?php echo $product_data["img_path"]; ?>" alt="product-img">
                                                </span>

                                                <div class="pr-details col-md-5">
                                                    <ul>
                                                        <li class="prd-title"><?php echo $product_data["title"]; ?></li>
                                                        <li class="sub-d prd-color"><b>Colour&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $product_data["clr_name"]; ?></li>
                                                        <li class="sub-d prd-condition"><b>Condition&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $product_data["condition_name"]; ?></li>
                                                        <li class="sub-d prd-price"><b>Price&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b>Rs. <?php echo $product_data["price"]; ?> .00</li>

                                                        <li class="wrapper-qty-cart">
                                                            <span class="minus" onclick='downQTY(<?php echo $cart_data["cart_id"]; ?>);'>-</span>
                                                            <span class="num" id='qty_num_<?php echo $cart_data["cart_id"]; ?>'><?php echo $cart_data["qty"]; ?></span>
                                                            <span class="plus" onclick='upQTY(<?php echo $cart_data["cart_id"]; ?>, <?php echo $product_data["qty"]; ?>);'>+</span>
                                                        </li>

                                                        <li class="sub-d prd-seller"><b>Delivery Fee&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b>Rs. <?php echo $ship; ?> .00</li>
                                                    </ul>
                                                </div>

                                                <div class="pr-btn col-md-3">
                                                    <a class="btn-pb" href='singleProductView.php?id=<?php echo $product_data["id"]; ?>' target="_blank">
                                                        <button class="bn-btn">Buy Now</button>
                                                    </a>
                                                    <button class="r-btn" onclick='deleteFromCart(<?php echo $cart_data["cart_id"]; ?>);'>Remove</button>
                                                </div>

                                                <div class="total-p col-md-12 row">

                                                    <div class="rt-txt col-6 col-md-6">
                                                        <p>Requested Total &nbsp; <i class="fa-solid fa-circle-info"></i></p>
                                                    </div>

                                                    <div class="rt-price col-6 col-md-6">
                                                        <p>Rs. <?php echo ($product_data["price"] * $cart_data["qty"]) + $ship; ?> .00</p>
                                                    </div>

                                                </div>

                                            </div>

                                        <?php

                                        }

                                        ?>

                                    </div>

                                </div>

                                <!-- product view ends -->

                                <!-- summary view starts -->

                                <div class="summary-view-c col-md-4">

                                    <div class="col-md-12">

                                        <h1 class="col-md-12">Summary</h1>
                                        <p class="col-md-12 hr"></p>

                                        <div class="col-md-12 ic-si row">

                                            <?php

                                            $cart_rs2 = Database::search("SELECT * FROM `cart` WHERE `user_email` = '" . $user . "'");
                                            $cart_num2 = $cart_rs2->num_rows;

                                            for ($x = 0; $x < $cart_num2; $x++) {

                                                $cart_data2 = $cart_rs2->fetch_assoc();

                                                $product_rs2 = Database::search("SELECT * FROM `product` WHERE `id` = '" . $cart_data2["product_id"] . "'");

                                                $product_data2 = $product_rs2->fetch_assoc();

                                            ?>

                                                <div class="col-6 col-md-6">
                                                    <p class="name"><?php echo $product_data2["title"]; ?> &nbsp;×&nbsp; (<?php echo $cart_data2["qty"]; ?>)</p>
                                                </div>

                                                <div class="col-6 col-md-6">
                                                    <p class="cost">Rs. <?php echo ($product_data2["price"] * $cart_data2["qty"]); ?> .00</p>
                                                </div>

                                            <?php

                                            }

                                            ?>

                                        </div>

                                        <div class="col-md-12 ic-si row">

                                            <div class="col-6 col-md-6">
                                                <p class="name">Shipping</p>
                                            </div>

                                            <div class="col-6 col-md-6">
                                                <p class="cost">Rs. <?php echo $shipping; ?> .00</p>
                                            </div>

                                        </div>

                                        <p class="col-md-12 hr"></p>

                                        <div class="col-md-12 ic-si row">

                                            <div class="col-6 col-md-6">
                                                <p class="t-name">Total</p>
                                            </div>

                                            <div class="col-6 col-md-6">
                                                <p class="t-cost">Rs. <?php echo $total + $shipping; ?> .00</p>
                                            </div>

                                        </div>

                                        <p class="col-md-12 hr"></p>
                                        <p class="col-md-12 hr"></p>

                                        <?php

                                        $cart_array;

                                        $cart_rs3 = Database::search("SELECT * FROM cart WHERE user_email = '" . $user . "'");
                                        $cart_num3 = $cart_rs3->num_rows;

                                        for ($x = 0; $x < $cart_num3; $x++) {
                                            $cart_data3 = $cart_rs3->fetch_assoc();
                                            $cart_array[$x] = $cart_data3["cart_id"];
                                        }

                                        $cart_id_array = json_encode($cart_array);

                                        $tcost = $total + $shipping;

                                        ?>

                                        <button class="checkout" id="payhere-payment" onclick='checkout(<?php echo $cart_id_array; ?>,<?php echo $tcost ?>);'>CHECKOUT</button>


                                    </div>

                                </div>

                                <!-- summary view ends -->

                            </div>

                        </div>



                    <?php

                    }

                    ?>

                </div>

                <!-- content section ends -->

            <?php

            } else {
                echo ("Please Login or Signup first.");
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

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
                var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl, {
                        template: '<div class="popover my-popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
                    });
                });
            });
        </script>

        <!-- custome js file -->
        <script src="./js/script.js"></script>

        <!-- payhere js file -->
        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>

        <!-- bootstrap js file -->
        <script src="./js/bootstrap.js"></script>

        <!-- bootstrap js file -->
        <script src="./js/bootstrap.bundle.js"></script>

        <!-- fontawesome js file -->
        <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>

        <!-- ionicons js file -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

        <!-- sweetaleart js file -->
        <script src="./js/sweetalert.min.js"></script>

</body>

</html>