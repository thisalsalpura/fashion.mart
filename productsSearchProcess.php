<?php

session_start();

include "connection.php";

if (isset($_GET["txt"])) {

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

        <div class="button-container">
            <button onclick="clearSearchResult();" class="clear-btn-h-ad">CLEAR RESULTS</button>
        </div>

        <br>
        <br>
        <?php
    } else {

        $result_rs = Database::search("SELECT * FROM `product` WHERE `title` LIKE '%" . $search_txt . "%'");
        $result_num = $result_rs->num_rows;

        if ($result_num > 0) {

        ?>

            <div class="box-container-mup">

                <?php

                for ($x = 0; $x < $result_num; $x++) {
                    $result_data = $result_rs->fetch_assoc();

                ?>

                    <div class="box-mup" onclick="viewProductModal('<?php echo $result_data['id']; ?>');">

                        <div class="num">
                            <p><?php echo $result_data["id"]; ?></p>
                        </div>
                        <div class="hr"></div>

                        <?php

                        $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $result_data["id"] . "'");
                        $image_num = $image_rs->num_rows;

                        if ($image_num == 0) {
                            $profile_img_data = $profile_img_rs->fetch_assoc();
                        ?>
                            <div class="image-mup-sq">
                                <img src="./images/empty-box.png" alt="user-img">
                            </div>
                        <?php
                        } else {
                            $image_data = $image_rs->fetch_assoc();
                        ?>
                            <div class="image-mup-sq">
                                <img src="<?php echo $image_data["img_path"]; ?>" alt="user-img">
                            </div>
                        <?php
                        }
                        ?>

                        <div class="content-mup">
                            <h3><b>Title &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $result_data["title"]; ?></h3>
                            <h3><b>Price &nbsp;&nbsp; : &nbsp;&nbsp;</b>Rs . <?php echo $result_data["price"]; ?> .00</h3>

                            <?php

                            if ($result_data["qty"] == 0) {
                            ?>
                                <h3 class="isn"><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $result_data["qty"]; ?> Items</h3>
                            <?php
                            } else {
                            ?>
                                <h3 class="is"><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $result_data["qty"]; ?> Items</h3>
                            <?php
                            }

                            ?>

                            <?php
                            $splitDate = explode(" ", $result_data["datetime_added"]);
                            ?>

                            <h3><b>Registered Date &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $splitDate[0]; ?></h3>

                            <?php
                            if ($result_data["status_status_id"] == 1) {
                            ?>
                                <button id="pb<?php echo $result_data['id']; ?>" onclick="blockProduct('<?php echo $result_data['id']; ?>');" class="btn-pb-mup">deactive</button>
                            <?php
                            } else {
                            ?>
                                <button id="pb<?php echo $result_data['id']; ?>" onclick="blockProduct('<?php echo $result_data['id']; ?>');" class="btn-pb-mup-g">active</button>
                            <?php
                            }
                            ?>

                        </div>
                    </div>

                    <!-- modal 01 -->
                    <div class="modal modal-1" tabindex="-1" id="viewProductModal<?php echo $result_data['id']; ?>">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?php echo $result_data['title']; ?></h5>
                                </div>
                                <div class="modal-body">
                                    <div>

                                        <?php
                                        $image_rs1 = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $result_data["id"] . "'");
                                        $image_num1 = $image_rs1->num_rows;
                                        if ($image_num1 == 0) {
                                        ?>
                                            <div class="image-mup-sq">
                                                <img src="./images/empty-box.png" alt="user-img">
                                            </div>
                                        <?php
                                        } else {
                                            $image_data1 = $image_rs1->fetch_assoc();
                                        ?>
                                            <div class="image-mup-sq">
                                                <img src="<?php echo $image_data["img_path"]; ?>" alt="user-img">
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                    <div class="col-12">
                                        <h3><b>Price &nbsp;&nbsp; : &nbsp;&nbsp;</b>Rs . <?php echo $result_data["price"]; ?> .00</h3>
                                        <?php

                                        if ($result_data["qty"] == 0) {
                                        ?>
                                            <h3 class="isn"><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $result_data["qty"]; ?> Products Left</h3>
                                        <?php
                                        } else {
                                        ?>
                                            <h3 class="is"><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $result_data["qty"]; ?> Products Left</h3>
                                        <?php
                                        }

                                        $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $result_data['user_email'] . "'");
                                        $seller_data = $seller_rs->fetch_assoc();
                                        ?>

                                        <h3><b>Seller &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $seller_data["fname"] . " " . $seller_data["lname"]; ?></h3>
                                        <h3><b>Description &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $result_data['description']; ?></h3>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal 01 -->

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

            <div class="button-container">
                <button onclick="clearSearchResult();" class="clear-btn-h-ad">CLEAR RESULTS</button>
            </div>

            <br>
            <br>

<?php

        }
    }
}
