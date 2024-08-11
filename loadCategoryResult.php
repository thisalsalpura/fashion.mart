<?php

session_start();

include "connection.php";

$catid = $_POST["cid"];

$query = "SELECT * FROM product ";

if ($catid == "sleeves") {
    $query .= "WHERE category_cat_id = '1'";
} else if ($catid == "sneakers") {
    $query .= "WHERE category_cat_id = '2'";
} else if ($catid == "caps") {
    $query .= "WHERE category_cat_id = '3'";
} else if ($catid == "watches") {
    $query .= "WHERE category_cat_id = '4'";
} else if ($catid == "bags") {
    $query .= "WHERE category_cat_id = '6'";
} else if ($catid == "jackets") {
    $query .= "WHERE category_cat_id = '5'";
} else if ($catid == "bands") {
    $query .= "WHERE category_cat_id = '13'";
};

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$selected_rs = $product_rs;

$selected_num  = $selected_rs->num_rows;

if ($selected_num > 0) {

?>

    <hr class="footer-border">

    <br>
    <br>

    <section class="products" id="products">

        <div class="box-container">

            <?php

            while ($selected_data = $selected_rs->fetch_assoc()) {

            ?>

                <div class="box">

                    <?php
                    $img_rs = Database::search("SELECT * FROM product_img WHERE product_id = '" . $selected_data["id"] . "'");
                    $img_data = $img_rs->fetch_assoc();
                    ?>

                    <div class="image">
                        <img src="<?php echo $img_data["img_path"]; ?>" alt="product-img">
                    </div>
                    <div class="content">
                        <h3><?php echo $selected_data["title"]; ?></h3>
                        <span class="new-badge">New</span><br />
                        <div class="price">Rs. <?php echo $selected_data["price"]; ?> .00</div>

                        <?php

                        if (isset($_SESSION["u"])) {

                            if ($selected_data["qty"] > 0) {
                        ?>

                                <span class="in-stock-txt">In Stock</span><br />
                                <span class="available-items-qty"><?php echo $selected_data["qty"]; ?> Items Available</span><br /><br />
                                <a href='<?php echo "singleProductView.php?id=" . ($selected_data["id"]); ?>' target="_blank" class="btn-pb">Buy Now</a><br><br>

                                <?php

                                $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $selected_data["id"] . "' AND `user_email` = '" . $_SESSION["u"]["email"] . "'");
                                $cart_num = $cart_rs->num_rows;

                                if ($cart_num == 1) {

                                ?>
                                    <a class="icons watchlisted fas fa-shopping-cart" onclick='addToCart(<?php echo $selected_data["id"]; ?>);' id="carti<?php echo $selected_data["id"]; ?>"></a>
                                <?php

                                } else {

                                ?>
                                    <a class="icons not-watchlisted fas fa-shopping-cart" onclick='addToCart(<?php echo $selected_data["id"]; ?>);' id="carti<?php echo $selected_data["id"]; ?>"></a>
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

                            if ($selected_data["qty"] > 0) {
                            ?>

                                <span class="in-stock-txt">In Stock</span><br />
                                <span class="available-items-qty"><?php echo $selected_data["qty"]; ?> Items Available</span><br /><br />
                                <a href='<?php echo "singleProductView.php?id=" . ($selected_data["id"]); ?>' target="_blank" class="btn-pb">Buy Now</a><br><br>
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
                            `product_id` = '" . $selected_data["id"] . "'");

                            $watchlist_num = $watchlist_rs->num_rows;

                            if ($watchlist_num == 1) {

                            ?>

                                <a class="icons watchlisted fas fa-solid fa-heart" onclick='addToWatchlist(<?php echo $selected_data["id"]; ?>);' id="heart<?php echo $selected_data["id"]; ?>"></a>

                            <?php

                            } else {

                            ?>

                                <a class="icons not-watchlisted fas fa-solid fa-heart" onclick='addToWatchlist(<?php echo $selected_data["id"]; ?>);' id="heart<?php echo $selected_data["id"]; ?>"></a>

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

    <br>
    <br>

    <button onclick="clearSearchResult();" class="clear-btn-h">CLEAR RESULTS</button>

    <br>
    <br>

<?php

} else {
    echo '<p class="no-products-message">No products found.</p>';

?>

    <button onclick="clearSearchResult();" class="clear-btn-h">CLEAR RESULTS</button>

    <br>
    <br>

<?php

}

?>