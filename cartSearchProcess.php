<?php

session_start();

include "connection.php";

if (isset($_GET["txt"])) {

    $user = $_SESSION["u"]["email"];
    $search_txt = $_GET["txt"];

    if (empty($search_txt)) {
?>
        <br>
        <br>

        <?php

        echo '<p class="no-products-message">No products found.</p>';

        ?>

        <br>
        <br>

        <button onclick="clearSearchResult();" class="clear-btn-h">CLEAR RESULTS</button>

        <br>
        <br>
        <?php
    } else {

        $result_rs = Database::search("SELECT * FROM `cart` INNER JOIN `product` ON cart.product_id = product.id WHERE `cart`.`user_email` = '" . $user . "' AND `title` LIKE '%" . $search_txt . "%'");
        $result_num = $result_rs->num_rows;

        if ($result_num > 0) {

        ?>

            <div class="col-md-12">

                <?php

                for ($x = 0; $x < $result_num; $x++) {

                    $result_data = $result_rs->fetch_assoc();

                    $total  = 0;
                    $subtotal = 0;
                    $shipping = 0;

                    $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `product_img` ON
                    product.id=product_img.product_id INNER JOIN `condition` ON product.condition_condition_id=condition.condition_id
                    INNER JOIN `product_has_color` ON product.id=product_has_color.product_id INNER JOIN `color` ON product_has_color.color_clr_id=color.clr_id
                    WHERE `id` = '" . $result_data["product_id"] . "'");

                    $product_data = $product_rs->fetch_assoc();

                    $total = $total + ($product_data["price"] * $result_data["qty"]);

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
                                    <span class="minus" onclick='downQTY(<?php echo $result_data["cart_id"]; ?>);'>-</span>

                                    <?php

                                    $cart_qty_rs = Database::search("SELECT * FROM `cart` WHERE `cart_id` = '" . $result_data["cart_id"] . "'");
                                    $cart_qty_data = $cart_qty_rs->fetch_assoc();

                                    ?>

                                    <span class="num" id='qty_num_<?php echo $result_data["cart_id"]; ?>'><?php echo $cart_qty_data["qty"]; ?></span>
                                    <span class="plus" onclick='upQTY(<?php echo $result_data["cart_id"]; ?>, <?php echo $product_data["qty"]; ?>);'>+</span>
                                </li>

                                <li class="sub-d prd-seller"><b>Delivery Fee&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b>Rs. <?php echo $ship; ?> .00</li>
                            </ul>
                        </div>

                        <div class="pr-btn col-md-3">
                            <a class="btn-pb" href='singleProductView.php?id=<?php echo $product_data["id"]; ?>' target="_blank">
                                <button class="bn-btn">Buy Now</button>
                            </a>
                            <button class="r-btn" onclick='deleteFromCart(<?php echo $result_data["cart_id"]; ?>);'>Remove</button>
                        </div>

                        <div class="total-p col-md-12 row">

                            <div class="rt-txt col-6 col-md-6">
                                <p>Requested Total &nbsp; <i class="fa-solid fa-circle-info"></i></p>
                            </div>

                            <div class="rt-price col-6 col-md-6">
                                <p>Rs. <?php echo ($product_data["price"] * $cart_qty_data["qty"]) + $ship; ?> .00</p>
                            </div>

                        </div>

                    </div>

                <?php

                }

                ?>


            </div>

            <br>
            <br>

            <button onclick="clearSearchResult();" class="clear-btn-h">CLEAR RESULTS</button>

            <br>
            <br>

        <?php

        } else {

        ?>

            <br>
            <br>

            <?php

            echo '<p class="no-products-message">No products found.</p>';

            ?>

            <br>
            <br>

            <button onclick="clearSearchResult();" class="clear-btn-h">CLEAR RESULTS</button>

            <br>
            <br>

<?php

        }
    }
}

?>