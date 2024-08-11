<?php

session_start();

include "connection.php";

$txt = $_POST["t"];
$select = $_POST["s"];

$query = "SELECT * FROM `product` ";

if (!empty($txt) && $select == 0) {
    $query .= "WHERE `title` LIKE '%" . $txt . "%'";
} else if (empty($txt) && $select != 0) {
    $query .= "WHERE `category_cat_id` = '" . $select . "'";
} else if (!empty($txt) && $select != 0) {
    $query .= "WHERE `title` LIKE '%" . $txt . "%' AND `category_cat_id` = '" . $select . "'";
}

$pageno;

if ("0" != ($_POST["page"])) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$results_per_page = 3;
$number_of_pages = ceil($product_num / $results_per_page);

$page_results = ($pageno - 1) * $results_per_page;
$selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

$selected_num  = $selected_rs->num_rows;

if ($selected_num > 0) {

?>

    <hr class="footer-border">

    <br>
    <br>

    <section class="products" id="products">

        <div class="box-container">

            <?php

            for ($x = 0; $x < $selected_num; $x++) {
                $selected_data = $selected_rs->fetch_assoc();

            ?>

                <div class="box">

                    <?php
                    $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $selected_data["id"] . "'");
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


    <div class="product-page col-md-12">
        <section class="pagination">
            <ul class="page">
                <li>
                    <a <?php if ($pageno <= 1) {
                            echo ("#");
                        } else {
                        ?> onclick="basicSearch(<?php echo ($pageno - 1) ?>);" ; <?php
                                                                                }
                                                                                    ?>>Previous</a>
                </li>
                <li>
                    <a <?php if ($pageno >= $number_of_pages) {
                            echo ("#");
                        } else {
                        ?> onclick="basicSearch(<?php echo ($pageno + 1); ?>);" <?php
                                                                            }
                                                                                ?>>Next</a>
                </li>
                <?php
                for ($x = 1; $x <= $number_of_pages; $x++) {
                    if ($x == $pageno) {
                ?>
                        <li class="active">
                            <a onclick="basicSearch(<?php echo ($x); ?>);"><?php echo $x; ?></a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li>
                            <a onclick="basicSearch(<?php echo ($x); ?>);"><?php echo $x; ?></a>
                        </li>
                <?php
                    }
                }
                ?>

            </ul>
        </section>
    </div>

    <br>
    <br>

    <button onclick="clearSearchResult();" class="clear-btn-h">CLEAR RESULTS</button>

    <br>
    <br>


<?php

} else {
    echo '<p class="no-products-message">No products found.</p>';

?>

    <br>
    <br>

    <button onclick="clearSearchResult();" class="clear-btn-h">CLEAR RESULTS</button>

    <br>
    <br>

<?php

}

?>