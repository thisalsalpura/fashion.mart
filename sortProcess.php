<?php

session_start();

include "connection.php";

$user = $_SESSION["u"]["email"];

$search = $_POST["s"];
$select = $_POST["se"];
$time = $_POST["t"];
$qty = $_POST["q"];
$condition = $_POST["c"];
$price = $_POST["p"];

$query = "SELECT * FROM `product` WHERE `user_email` = '" . $user . "'";

if ($select != 0 && !empty($search)) {
    $query .= " AND `category_cat_id` = '" . $select . "' AND `title` LIKE '%" . $search . "%'";
} else if ($select != 0) {
    $query .= " AND `category_cat_id` = '" . $select . "'";
} else if (!empty($search)) {
    $query .= " AND `title` LIKE '%" . $search . "%'";
}

if ($condition != "0") {
    $query .= " AND `condition_condition_id` = '" . $condition . "'";
}

if ($time != "0") {
    if ($time == "1") {
        $query .= " ORDER BY `datetime_added` DESC";
    } else if ($time == "2") {
        $query .= " ORDER BY `datetime_added` ASC";
    }
}

if ($time != "0" && $qty != "0") {
    if ($qty == "1") {
        $query .= " , `qty` DESC";
    } else if ($qty == "2") {
        $query .= " , `qty` ASC";
    }
} else if ($time == "0" && $qty != "0") {
    if ($qty == "1") {
        $query .= " ORDER BY `qty` DESC";
    } else if ($qty == "2") {
        $query .= " ORDER BY `qty` ASC";
    }
}

if ($price != "0") {
    if ($price == "1") {
        $query .= " ORDER BY `price` DESC";
    } else if ($price == "2") {
        $query .= " ORDER BY `price` ASC";
    }
}

?>

<div class="col-md-12 row" id="sort" style="justify-content: center;">

    <?php

    if ("0" != ($_POST["page"])) {
        $pageno = $_POST["page"];
    } else {
        $pageno = 1;
    }

    $product_rs = Database::search($query);
    $product_num = $product_rs->num_rows;

    $results_per_page = 6;
    $number_of_pages = ceil($product_num / $results_per_page);

    $page_results = ($pageno - 1) * $results_per_page;
    $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

    $selected_num  = $selected_rs->num_rows;

    if ($selected_num > 0) {

        for ($x = 0; $x < $selected_num; $x++) {
            $selected_data = $selected_rs->fetch_assoc();

    ?>

            <div class="product-box col-md-3">
                <div class="head">

                    <?php
                    $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $selected_data["id"] . "'");
                    $product_img_data = $product_img_rs->fetch_assoc();
                    ?>

                    <img src="<?php echo $product_img_data["img_path"]; ?>" alt="product_imag">
                </div>
                <div class="body">
                    <h6><?php echo $selected_data["title"]; ?></h6>
                    <p><?php echo $selected_data["price"]; ?><span> .00</span></p>

                    <?php
                    if ($selected_data["qty"] > 0) {
                    ?>
                        <p class="qtynotnone"><?php echo $selected_data["qty"]; ?><span> Items Left</span></p>
                    <?php
                    } else {
                    ?>
                        <p class="qtynone"><?php echo $selected_data["qty"]; ?><span> Items Left</span></p>
                    <?php
                    }
                    ?>

                    <div class="a-d-box">
                        <div class="form-check form-switch active-d-rad">
                            <input class="form-check-input" type="checkbox" role="switch" id="toggle<?php echo $selected_data["id"]; ?>" onchange="changeStatus(<?php echo $selected_data['id']; ?>);" <?php if ($selected_data["status_status_id"] == 2) {
                                                                                                                                                                                                        ?> checked <?php
                                                                                                                                                                                                                } ?>>
                        </div>
                        <p for="toggle<?php echo $selected_data["id"]; ?>">
                            <?php if ($selected_data["status_status_id"] == 1) {
                            ?>
                                Make Your Product Deactive
                            <?php
                            } else {
                            ?>
                                Make Your Product Active
                            <?php
                            }
                            ?>
                        </p>
                    </div>
                    <button onclick="sendid(<?php echo $selected_data['id']; ?>);">Update</button>
                </div>
            </div>

        <?php
        }
        ?>

        <div class="product-page col-md-12">
            <section class="pagination">
                <ul class="page">
                    <li>
                        <a <?php if ($pageno <= 1) {
                                echo ("#");
                            } else {
                            ?> onclick="sort1(<?php echo ($pageno - 1) ?>);" ; <?php
                                                                            }
                                                                                ?>>Previous</a>
                    </li>
                    <li>
                        <a <?php if ($pageno >= $number_of_pages) {
                                echo ("#");
                            } else {
                            ?> onclick="sort1(<?php echo ($pageno + 1); ?>);" <?php
                                                                            }
                                                                                ?>>Next</a>
                    </li>
                    <?php
                    for ($x = 1; $x <= $number_of_pages; $x++) {
                        if ($x == $pageno) {
                    ?>
                            <li class="active">
                                <a onclick="sort1(<?php echo ($x); ?>);"><?php echo $x; ?></a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li>
                                <a onclick="sort1(<?php echo ($x); ?>);"><?php echo $x; ?></a>
                            </li>
                    <?php
                        }
                    }
                    ?>

                </ul>
            </section>
        </div>

</div>

<?php

    } else {
        echo '<p class="no-products-message">No products found.</p>';
    }

?>