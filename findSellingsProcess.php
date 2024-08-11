<?php

session_start();

include "connection.php";

if (isset($_GET["f"]) && isset($_GET["t"])) {

    $from = $_GET["f"];
    $to = $_GET["t"];

    if (empty($from) && empty($to)) {
        echo ("<p style='text-align: center; font-size: 28px; font-weight: bold; color: white;'>Please select a date.</p>");
?>
        <br>
        <br>
        <?php
    } else {
        $invoice_rs = Database::search("SELECT *, invoice.product_id AS invoice_product_id, invoice.qty AS invoice_qty, invoice.status AS invoice_status, invoice.user_email AS invoice_user_email FROM `invoice` 
        INNER JOIN `product` ON invoice.product_id = product.id WHERE `product`.`user_email` = '" . $_SESSION["u"]["email"] . "'");
        $invoice_num = $invoice_rs->num_rows;

        if ($invoice_num > 0) {
        ?>
            <section class="products-mup">

                <div class="box-container-mup">

                    <?php

                    for ($x = 0; $x < $invoice_num; $x++) {
                        $invoice_data = $invoice_rs->fetch_assoc();

                        $sold_date = $invoice_data["date"];
                        $date = explode(" ", $sold_date);

                        $d = $date[0];
                        $t = $date[1];

                        if (!empty($from) && empty($to)) {

                            if ($from <= $d) {

                    ?>
                                <div class="box-mup">

                                    <div class="num">
                                        <p><?php echo $invoice_data["invoice_id"]; ?></p>
                                    </div>
                                    <div class="hr"></div>

                                    <?php

                                    $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $invoice_data["invoice_product_id"] . "'");
                                    $image_num = $image_rs->num_rows;

                                    if ($image_num == 0) {
                                    ?>
                                        <div class="image-mup-sq">
                                            <img src="./images/empty-box.png" alt="empty-img">
                                        </div>
                                    <?php
                                    } else {
                                        $image_data = $image_rs->fetch_assoc();
                                    ?>
                                        <div class="image-mup-sq">
                                            <img src="<?php echo $image_data["img_path"]; ?>" alt="empty-img">
                                        </div>
                                    <?php
                                    }

                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $invoice_data["invoice_product_id"] . "'");
                                    $product_data = $product_rs->fetch_assoc();

                                    ?>

                                    <div class="content-mup">
                                        <h3><b>Title &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $product_data["title"]; ?></h3>

                                        <?php

                                        $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $invoice_data["invoice_user_email"] . "'");
                                        $user_data = $user_rs->fetch_assoc();

                                        ?>

                                        <h3><b>Buyer &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></h3>
                                        <h3><b>Amount &nbsp;&nbsp; : &nbsp;&nbsp;</b>Rs. <?php echo $invoice_data["total"]; ?> .00</h3>
                                        <h3><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $invoice_data["invoice_qty"]; ?> Item</h3>

                                    </div>
                                </div>
                            <?php

                            }
                        } else if (empty($from) && !empty($to)) {
                            if ($to >= $d) {

                            ?>
                                <div class="box-mup">

                                    <div class="num">
                                        <p><?php echo $invoice_data["invoice_id"]; ?></p>
                                    </div>
                                    <div class="hr"></div>

                                    <?php

                                    $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $invoice_data["invoice_product_id"] . "'");
                                    $image_num = $image_rs->num_rows;

                                    if ($image_num == 0) {
                                    ?>
                                        <div class="image-mup-sq">
                                            <img src="./images/empty-box.png" alt="empty-img">
                                        </div>
                                    <?php
                                    } else {
                                        $image_data = $image_rs->fetch_assoc();
                                    ?>
                                        <div class="image-mup-sq">
                                            <img src="<?php echo $image_data["img_path"]; ?>" alt="empty-img">
                                        </div>
                                    <?php
                                    }

                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $invoice_data["invoice_product_id"] . "'");
                                    $product_data = $product_rs->fetch_assoc();

                                    ?>

                                    <div class="content-mup">
                                        <h3><b>Title &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $product_data["title"]; ?></h3>

                                        <?php

                                        $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $invoice_data["invoice_user_email"] . "'");
                                        $user_data = $user_rs->fetch_assoc();

                                        ?>

                                        <h3><b>Buyer &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></h3>
                                        <h3><b>Amount &nbsp;&nbsp; : &nbsp;&nbsp;</b>Rs. <?php echo $invoice_data["total"]; ?> .00</h3>
                                        <h3><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $invoice_data["invoice_qty"]; ?> Item</h3>

                                    </div>
                                </div>
                            <?php

                            }
                        } else if (!empty($from) && !empty($to)) {
                            if ($from <= $d && $to >= $d) {

                            ?>
                                <div class="box-mup">

                                    <div class="num">
                                        <p><?php echo $invoice_data["invoice_id"]; ?></p>
                                    </div>
                                    <div class="hr"></div>

                                    <?php

                                    $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $invoice_data["invoice_product_id"] . "'");
                                    $image_num = $image_rs->num_rows;

                                    if ($image_num == 0) {
                                    ?>
                                        <div class="image-mup-sq">
                                            <img src="./images/empty-box.png" alt="empty-img">
                                        </div>
                                    <?php
                                    } else {
                                        $image_data = $image_rs->fetch_assoc();
                                    ?>
                                        <div class="image-mup-sq">
                                            <img src="<?php echo $image_data["img_path"]; ?>" alt="empty-img">
                                        </div>
                                    <?php
                                    }

                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $invoice_data["invoice_product_id"] . "'");
                                    $product_data = $product_rs->fetch_assoc();

                                    ?>

                                    <div class="content-mup">
                                        <h3><b>Title &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $product_data["title"]; ?></h3>

                                        <?php

                                        $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $invoice_data["invoice_user_email"] . "'");
                                        $user_data = $user_rs->fetch_assoc();

                                        ?>

                                        <h3><b>Buyer &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></h3>
                                        <h3><b>Amount &nbsp;&nbsp; : &nbsp;&nbsp;</b>Rs. <?php echo $invoice_data["total"]; ?> .00</h3>
                                        <h3><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $invoice_data["invoice_qty"]; ?> Item</h3>

                                    </div>
                                </div>
                    <?php

                            }
                        }
                    }

                    ?>

                </div>

            </section>

            <br>
            <br>
        <?php
        } else {
            echo ("<p style='text-align: center; font-size: 28px; font-weight: bold; color: white;'>No product found.</p>");
        ?>
            <br>
            <br>
        <?php
        }

        ?>

    <?php
    }
} else {
    echo ("<p style='text-align: center; font-size: 28px; font-weight: bold; color: white;'>Something went wrong.</p>");
    ?>
    <br>
    <br>
<?php
}

?>