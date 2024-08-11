<?php

session_start();

include "connection.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION.MART | PURCHASE HISTORY |</title>

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
                $mail = $_SESSION["u"]["email"];

                $invoice_rs = Database::search("SELECT * FROM `recent` WHERE `user_email` = '" . $mail . "'");
                $invoice_num = $invoice_rs->num_rows;

            ?>

                <!-- content section starts -->

                <div class="p-history-page-content">

                    <br>
                    <p class="file-path"><span><a href="index.php">Home</a></span> / <a class="on-page" href="purchaseHistory.php">Purchased History</a></p>

                    <div class="ad-search-content">

                        <h1 class="ad-search-h1">PURCHASE HISTORY</h1>

                    </div>

                    <?php

                    if ($invoice_num == 0) {

                    ?>

                        <!-- empty view starts -->

                        <div class="empt-box">

                            <div class="empt-img">
                                <img src="./images/empty-box.png" alt="empty-img">
                            </div>

                            <div class="empt-text">
                                <p>You have not purchased any item yet...</p>
                            </div>

                            <button onclick="startShopping();"><i class="fas fa-shopping-cart"></i>Start Shopping</button>

                        </div>

                        <!-- empty view ends -->

                    <?php

                    } else {

                    ?>

                        <!-- have product starts -->

                        <div class="ph-have-pr-sec">

                            <?php

                            for ($x = 0; $x < $invoice_num; $x++) {
                                $invoice_data = $invoice_rs->fetch_assoc();

                            ?>

                                <div class="ph-pr-box col-md-12">

                                    <div class="row">

                                        <div class="ph-num col-md-2">
                                            <p><?php echo $invoice_data["r_id"]; ?></< /p>
                                        </div>

                                        <div class="col-md-10">

                                        </div>

                                        <div class="hr col-md-12"></div>

                                        <?php

                                        $details_rs = Database::search("SELECT * FROM `product` INNER JOIN `product_img` ON product.id=product_img.product_id 
                                        INNER JOIN `user` ON product.user_email=user.email WHERE `id` = '" . $invoice_data["product_id"] . "'");

                                        $product_data = $details_rs->fetch_assoc();

                                        ?>

                                        <div class="ph-pr-img col-md-3">
                                            <img src="<?php echo $product_data["img_path"]; ?>" alt="product_img">
                                        </div>

                                        <div class="ph-pr-details col-md-9">

                                            <div class="ph-title col-md-9">
                                                <p><?php echo $product_data["title"]; ?></p>
                                            </div>

                                            <div class="ph-seller col-md-9">
                                                <p><b>Seller&nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $product_data["fname"] . " " . $product_data["lname"]; ?></p>
                                            </div>

                                            <div class="ph-price col-md-9">
                                                <p><b>Price&nbsp;&nbsp; : &nbsp;&nbsp;</b>Rs. <?php echo $product_data["price"]; ?> .00</p>
                                            </div>

                                            <div class="ph-qty col-md-9">
                                                <p><b>Quantity&nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $invoice_data["qty"]; ?></p>
                                            </div>

                                            <div class="ph-amount col-md-9">
                                                <p><b>Amount&nbsp;&nbsp; : &nbsp;&nbsp;</b>Rs. <?php echo $invoice_data["total"]; ?> .00</p>
                                            </div>

                                            <div class="ph-date col-md-9">
                                                <p><b>Purchased Date & Time&nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $invoice_data["date"]; ?></p>
                                            </div>

                                            <?php

                                            if ($invoice_data["status"] == 0) {
                                            ?>
                                                <button class="btn-pb-mup-g-1">Order Confirmed</button>
                                            <?php
                                            } else if ($invoice_data["status"] == 1) {
                                            ?>
                                                <button class="btn-pb-mup-g-2">Packing in Progress</button>
                                            <?php
                                            } else if ($invoice_data["status"] == 2) {
                                            ?>
                                                <button class="btn-pb-mup-g-3">Dispatched</button>
                                            <?php
                                            } else if ($invoice_data["status"] == 3) {
                                            ?>
                                                <button class="btn-pb-mup-g-4">Shipped</button>
                                            <?php
                                            } else if ($invoice_data["status"] == 4) {
                                            ?>
                                                <button class="btn-pb-mup-g-5">Delivered</button>
                                            <?php
                                            }

                                            ?>

                                        </div>

                                        <div class="hr col-md-12"></div>

                                        <div class="btn-group col-md-6">
                                            <button class="feedback-btn" onclick="addFeedbackOne('<?php echo $invoice_data['product_id']; ?>');"><i class="fa-solid fa-circle-info"></i>Feedback</button>
                                        </div>

                                        <div class="btn-group col-md-6">
                                            <button class="delete-btn" onclick='deleteOneProduct(<?php echo $invoice_data["r_id"]; ?>);'><i class="fa-solid fa-trash"></i>Delete</button>
                                        </div>

                                    </div>

                                </div>

                                <!-- model 01 -->
                                <div class="modal" tabindex="-1" id="feedbackmodalOne">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold">Add New Feedback</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-12">
                                                    <div class="col-12 hr"></div>
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <label class="form-label fb-op">User's Email</label>
                                                            </div>
                                                            <div class="col-9">
                                                                <input type="text" class="form-control mail-input" disabled id="mail" value="<?php echo $mail; ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 hr"></div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn close-btn col-6" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn s-fb-btn" onclick="saveFeedbackOne();">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- model 01 -->

                            <?php

                            }

                            ?>

                        </div>

                        <div class="deleteall">
                            <button onclick="deleteAllProducts();"><i class="fa-solid fa-trash"></i>Delete All Records</button>
                        </div>

                        <!-- model 02 -->
                        <div class="modal" tabindex="-1" id="feedbackmodalTwo">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Add New Feedback</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <label class="form-label fb-op">Type</label>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="type" id="type1" />
                                                                <label class="form-check-label text-success fw-bold" for="type1">
                                                                    Positive
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="type" id="type2" checked />
                                                                <label class="form-check-label text-warning fw-bold" for="type2">
                                                                    Neutral
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="type" id="type3" />
                                                                <label class="form-check-label text-danger fw-bold" for="type3">
                                                                    Negative
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 hr"></div>
                                                <div class="col-12 mt-2">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <label class="form-label fb-op">Feedback</label>
                                                        </div>
                                                        <div class="col-9">
                                                            <textarea class="form-control fb-txt" cols="50" rows="5" id="feed"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 hr"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn close-btn col-6" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn s-fb-btn" onclick="saveFeedbackTwo();">Save Feedback</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- model 02 -->

                        <!-- have product starts -->

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

    </div>

    <!-- custome js file -->
    <script src="./js/script.js"></script>

    <!-- bootstrap js file -->
    <script src="./js/bootstrap.js"></script>
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