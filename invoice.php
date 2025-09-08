<?php

session_start();

include "connection.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION.MART | INVOICE |</title>

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
                $umail = $_SESSION["u"]["email"];

                if (isset($_GET["id"])) {
                    $oid = $_GET["id"];

            ?>

                    <!-- content section starts -->

                    <div class="invoice-page-content">

                        <br>
                        <p class="file-path"><span><a href="index.php">Return to Home</a></span></p>
                        <p class="file-path mt-4"><span><a href="purchaseHistory.php">Go to Purchase History</a></span></p>

                        <div class="print-btn-sec col-md-12 row">

                            <button class="print-btn col-md-5" onclick="printInvoice();"><i class="fa-solid fa-print"></i>PRINT</button>
                            <button class="spdf-btn col-md-5">EXPORT AS PDF</button>

                        </div>

                        <div class="invoice-sec">

                            <div class="c-details col-md-12">

                                <div class="c-title">FASHION. <span>MART</span></div>
                                <div class="c-address">St Mary's Road, Mount Lavinia.</div>
                                <div class="c-number">0112345678</div>
                                <div class="c-email">fashionamart@gmail.com</div>

                            </div>

                            <div class="col-md-12 in-details row">

                                <?php

                                $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '" . $umail . "'");
                                $address_data = $address_rs->fetch_assoc();

                                ?>

                                <div class="col-6 col-md-6 sec sec1">
                                    <p class="in-to txt col-6 col-md-6">INVOICE TO : </p>
                                    <p class="in-to name col-6 col-md-6"><?php echo $_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]; ?></p>
                                    <p class="in-to address col-6 col-md-6"><?php echo $address_data["line1"] . " " . $address_data["line2"]; ?></p>
                                    <p class="in-to email col-6 col-md-6"><?php echo $umail; ?></p>
                                </div>

                                <?php

                                $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id` = '" . $oid . "'");
                                $invoice_data = $invoice_rs->fetch_assoc();

                                ?>

                                <div class="col-6 col-md-6 sec">
                                    <p class="in num">INVOICE <?php echo $invoice_data["invoice_id"]; ?></p>
                                    <p class="in date-time"><b>Date & Time of Invoice :</b> <?php echo $invoice_data["date"]; ?></p>
                                </div>

                            </div>

                            <div class="col-12 table-sec">
                                <table class="table">
                                    <thead>
                                        <tr class="th-border">
                                            <th class="br">#</th>
                                            <th class="br bl">Order ID & Product</th>
                                            <th class="br bl">Unit Price</th>
                                            <th class="br bl">Quantity</th>
                                            <th class="bl">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $invoice_rs2 = Database::search("SELECT * FROM `invoice` WHERE `order_id` = '" . $oid . "'");
                                        $invoice_num2 = $invoice_rs2->num_rows;

                                        for ($x = 0; $x < $invoice_num2; $x++) {
                                            $invoice_row_data = $invoice_rs2->fetch_assoc();
                                        ?>
                                            <tr class="td-border">
                                                <td class="i-id br"><?php echo $x + 1 ?></td>
                                                <td class="br bl i-pr-tu">
                                                    <span class="i-uid"><?php echo $oid; ?></span>
                                                    <br /><br />

                                                    <?php

                                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $invoice_row_data["product_id"] . "'");
                                                    $product_data = $product_rs->fetch_assoc();

                                                    ?>

                                                    <span class="i-title"><?php echo $product_data["title"]; ?></span>
                                                </td>
                                                <td class="i-uprice br bl">Rs. <?php echo $product_data["price"]; ?> .00</td>
                                                <td class="i-qty br bl"><?php echo $invoice_row_data["qty"]; ?></td>

                                                <?php

                                                $row_total = (int)$product_data["price"] * (int)$invoice_row_data["qty"];

                                                ?>

                                                <td class="i-total bl">Rs. <?php echo $row_total; ?> .00</td>
                                            </tr>
                                        <?php
                                        }

                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <?php
                                        $city_rs = Database::search("SELECT * FROM  `city` WHERE `city_id` = '" . $address_data["city_city_id"] . "'");
                                        $city_data = $city_rs->fetch_assoc();
                                        $district_id = $city_data["district_district_id"];
                                        ?>
                                        <tr>
                                            <?php
                                            $invoice_rs3 = Database::search("SELECT * FROM `invoice` WHERE `order_id` = '" . $oid . "'");
                                            $invoice_num3 = $invoice_rs3->num_rows;

                                            $sub_total = 0;
                                            $delivery_fee = 0;

                                            for ($x = 0; $x < $invoice_num3; $x++) {
                                                $invoice_row_data2 = $invoice_rs3->fetch_assoc();

                                                $product_rs2 = Database::search("SELECT * FROM `product` WHERE `id` = '" . $invoice_row_data2["product_id"] . "'");
                                                $product_data2 = $product_rs2->fetch_assoc();

                                                $sub_total += (int)$product_data2["price"] * (int)$invoice_row_data2["qty"];

                                                $delivery = 0;

                                                if ($district_id == 1) {
                                                    $delivery = $product_data2["delivery_fee_colombo"];
                                                } else {
                                                    $delivery = $product_data2["delivery_fee_other"];
                                                }

                                                $delivery_fee += (int)$delivery;
                                            }
                                            ?>
                                            <td colspan="3"></td>
                                            <td class="tf-txt tb">SUBTOTAL</td>
                                            <td class="tf-detai tb2 tbr">Rs. <?php echo $sub_total; ?> .00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="tf-txt tb">DELIVERY FEE</td>
                                            <td class="tf-detai tb2 tbr">Rs. <?php echo $delivery_fee; ?> .00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td class="tf-txt">GRAND TOTAL</td>
                                            <td class="tf-detai tb2 tbr">Rs. <?php echo $sub_total + $delivery_fee; ?> .00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="tnx col-md-12">
                                <p>THANK TOU !</p>
                            </div>

                        </div>

                        <div class="hr">

                        </div>

                        <div class="col-md-12">

                            <div class="notice-add-p">
                                <h2>NOTICE :-</h2>
                                <p>Purchased items can return befor 7 days of Delivery.</p>
                            </div>

                        </div>

                        <div class="hr">

                        </div>

                        <div class="n-label">
                            <label>Invoice was created on a computer and is valid without the Signature and Seal.</label>
                        </div>

                        <hr class="hr-2">

                    </div>

                    <!-- content section ends -->

                <?php

                } else {
                    echo ("Something went Wrong.");
                ?>
                    <script>
                        window.location = "index.php";
                    </script>
                <?php
                }

                ?>

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

            <div id="invoice_page" style="display: none;">

                <div class="invoice-page-content">

                    <div class="invoice-sec">

                        <div class="c-details col-md-12">

                            <div class="c-title">FASHION. <span>MART</span></div>
                            <div class="c-address">St Mary's Road, Mount Lavinia.</div>
                            <div class="c-number">0112345678</div>
                            <div class="c-email">fashionamart@gmail.com</div>

                        </div>

                        <div class="col-md-12 in-details row">

                            <?php

                            $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '" . $umail . "'");
                            $address_data = $address_rs->fetch_assoc();

                            ?>

                            <div class="col-6 col-md-6 sec sec1">
                                <p class="in-to txt col-6 col-md-6">INVOICE TO : </p>
                                <p class="in-to name col-6 col-md-6"><?php echo $_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]; ?></p>
                                <p class="in-to address col-6 col-md-6"><?php echo $address_data["line1"] . " " . $address_data["line2"]; ?></p>
                                <p class="in-to email col-6 col-md-6"><?php echo $umail; ?></p>
                            </div>

                            <?php

                            $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id` = '" . $oid . "'");
                            $invoice_data = $invoice_rs->fetch_assoc();

                            ?>

                            <div class="col-6 col-md-6 sec">
                                <p class="in num">INVOICE <?php echo $invoice_data["invoice_id"]; ?></p>
                                <p class="in date-time"><b>Date & Time of Invoice :</b> <?php echo $invoice_data["date"]; ?></p>
                            </div>

                        </div>

                        <div class="col-12 table-sec">
                            <table class="table">
                                <thead>
                                    <tr class="th-border">
                                        <th class="br">#</th>
                                        <th class="br bl">Order ID & Product</th>
                                        <th class="br bl">Unit Price</th>
                                        <th class="br bl">Quantity</th>
                                        <th class="bl">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $invoice_rs2 = Database::search("SELECT * FROM `invoice` WHERE `order_id` = '" . $oid . "'");
                                    $invoice_num2 = $invoice_rs2->num_rows;

                                    for ($x = 0; $x < $invoice_num2; $x++) {
                                        $invoice_row_data = $invoice_rs2->fetch_assoc();
                                    ?>
                                        <tr class="td-border">
                                            <td class="i-id br"><?php echo $x + 1 ?></td>
                                            <td class="br bl i-pr-tu">
                                                <span class="i-uid"><?php echo $oid; ?></span>
                                                <br /><br />

                                                <?php

                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $invoice_row_data["product_id"] . "'");
                                                $product_data = $product_rs->fetch_assoc();

                                                ?>

                                                <span class="i-title"><?php echo $product_data["title"]; ?></span>
                                            </td>
                                            <td class="i-uprice br bl">Rs. <?php echo $product_data["price"]; ?> .00</td>
                                            <td class="i-qty br bl"><?php echo $invoice_row_data["qty"]; ?></td>

                                            <?php

                                            $row_total = (int)$product_data["price"] * (int)$invoice_row_data["qty"];

                                            ?>

                                            <td class="i-total bl">Rs. <?php echo $row_total; ?> .00</td>
                                        </tr>
                                    <?php
                                    }

                                    ?>
                                </tbody>
                                <tfoot>
                                    <?php
                                    $city_rs = Database::search("SELECT * FROM  `city` WHERE `city_id` = '" . $address_data["city_city_id"] . "'");
                                    $city_data = $city_rs->fetch_assoc();
                                    $district_id = $city_data["district_district_id"];
                                    ?>
                                    <tr>
                                        <?php
                                        $invoice_rs3 = Database::search("SELECT * FROM `invoice` WHERE `order_id` = '" . $oid . "'");
                                        $invoice_num3 = $invoice_rs3->num_rows;

                                        $sub_total = 0;
                                        $delivery_fee = 0;

                                        for ($x = 0; $x < $invoice_num3; $x++) {
                                            $invoice_row_data2 = $invoice_rs3->fetch_assoc();

                                            $product_rs2 = Database::search("SELECT * FROM `product` WHERE `id` = '" . $invoice_row_data2["product_id"] . "'");
                                            $product_data2 = $product_rs2->fetch_assoc();

                                            $sub_total += (int)$product_data2["price"] * (int)$invoice_row_data2["qty"];

                                            $delivery = 0;

                                            if ($district_id == 1) {
                                                $delivery = $product_data2["delivery_fee_colombo"];
                                            } else {
                                                $delivery = $product_data2["delivery_fee_other"];
                                            }

                                            $delivery_fee += (int)$delivery;
                                        }
                                        ?>
                                        <td colspan="3"></td>
                                        <td class="tf-txt tb">SUBTOTAL</td>
                                        <td class="tf-detai tb2 tbr">Rs. <?php echo $sub_total; ?> .00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="tf-txt tb">DELIVERY FEE</td>
                                        <td class="tf-detai tb2 tbr">Rs. <?php echo $delivery_fee; ?> .00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="tf-txt">GRAND TOTAL</td>
                                        <td class="tf-detai tb2 tbr">Rs. <?php echo $sub_total + $delivery_fee; ?> .00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="tnx col-md-12">
                            <p>THANK TOU !</p>
                        </div>

                    </div>

                </div>

            </div>

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

    <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>

    <!-- fontawesome js file -->
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>

    <!-- ionicons js file -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- sweetaleart js file -->
    <script src="./js/sweetalert.min.js"></script>

</body>

</html>