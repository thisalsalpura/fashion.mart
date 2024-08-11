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

        $result_rs = Database::search("SELECT * FROM `watchlist` INNER JOIN `product` ON watchlist.product_id = product.id INNER JOIN `product_has_color` ON 
        product_has_color.product_id=product.id INNER JOIN `color` ON 
        product_has_color.color_clr_id=color.clr_id INNER JOIN `condition` ON 
        product.condition_condition_id=condition.condition_id INNER JOIN `user` ON 
        product.user_email=user.email WHERE `watchlist`.`user_email` = '" . $user . "' AND `title` LIKE '%" . $search_txt . "%'");
        $result_num = $result_rs->num_rows;

        if ($result_num > 0) {

            for ($x = 0; $x < $result_num; $x++) {

                $result_data = $result_rs->fetch_assoc();

                $list_id = $result_data["w_id"];

        ?>

                <div class="pr-box">

                    <?php

                    $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $result_data["product_id"] . "'");
                    $img_data = $img_rs->fetch_assoc();

                    ?>

                    <div class="pr-img col-md-3">
                        <img src="<?php echo $img_data["img_path"]; ?>" alt="product-img">
                    </div>

                    <div class="pr-details col-md-6">
                        <ul>
                            <li class="prd-title"><?php echo $result_data["title"]; ?></li>
                            <li class="sub-d prd-color"><b>Colour&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $result_data["clr_name"]; ?></li>
                            <li class="sub-d prd-condition"><b>Condition&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $result_data["condition_name"]; ?></li>
                            <li class="sub-d prd-price"><b>Price&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b>Rs. <?php echo $result_data["price"]; ?> .00</li>

                            <?php

                            if ($result_data["qty"] > 0) {
                            ?>
                                <li class="sub-d prd-qty text-success"><b>Quantity&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $result_data["qty"]; ?> Items Available</li>
                            <?php
                            } else {
                            ?>
                                <li class="sub-d prd-qty text-danger"><b>Quantity&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $result_data["qty"]; ?> Items Available</li>
                            <?php
                            }

                            ?>

                            <li class="sub-d prd-seller"><b>Seller&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;&nbsp; </b><?php echo $result_data["fname"] . " " . $result_data["lname"]; ?></li>
                        </ul>
                    </div>

                    <div class="pr-btn col-md-3">

                        <?php

                        if (isset($_SESSION["u"])) {

                            if ($result_data["qty"] > 0) {

                        ?>

                                <a href='singleProductView.php?id=<?php echo $result_data["id"]; ?>' target="_blank" class="btn-pb">
                                    <button class="bn-btn">Buy Now</button>
                                </a>
                                <br>
                                <br>
                                <br>

                                <?php

                                $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $result_data["id"] . "' AND `user_email` = '" . $_SESSION["u"]["email"] . "'");
                                $cart_num = $cart_rs->num_rows;

                                if ($cart_num == 1) {

                                ?>
                                    <button class="atc-btn-no" onclick='addToCart(<?php echo $result_data["id"]; ?>);' id="rbbcarti<?php echo $result_data["id"]; ?>">Remove from Cart</button>
                                <?php

                                } else {

                                ?>
                                    <button class="atc-btn" onclick='addToCart(<?php echo $result_data["id"]; ?>);' id="rbbcarti<?php echo $result_data["id"]; ?>">Add to Cart</button>
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

                            if ($result_data["qty"] > 0) {
                            ?>
                                <a href='singleProductView.php?id=<?php echo $result_data["id"]; ?>' target="_blank" class="btn-pb">
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

                <br>
                <br>

                <button onclick="clearSearchResult();" class="clear-btn-h">CLEAR RESULTS</button>

                <br>
                <br>

            <?php

            }

            ?>

            </div>

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