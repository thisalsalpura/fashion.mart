<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {

?>
    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FASHION.MART | MY SELLING |</title>

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

                <!-- header section ends  -->

                <div class="manageUsers-page">

                    <div class="my-selling-page">

                        <br>
                        <br>
                        <br>
                        <br>
                        <br>

                        <div class="ad-search-content">

                            <h1 class="ad-search-h1">MY SELLING</h1>

                            <p class="file-path-top"><span><a href="index.php">Home</a></span> / <a class="on-page" href="mySelling.php">My Selling</a></p>

                            <div class="input-group col-md-12">
                                <input type="text" class="form-control col-md-10 ipf" placeholder="Search by Invoice ID..." id="searchtxt" onkeyup="searchInvoice();">
                            </div>
                            <hr>

                            <div class="sec-1">
                                <div class="sec-date">
                                    <div class="date-search col-md-12">

                                        <div class="col-md-6">
                                            <p class="col-md-6">From Date : </p>
                                            <div class="prl-1">
                                                <input class="col-md-6" type="date" id="from">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <p class="col-md-6">To Date : </p>
                                            <div class="prl-2">
                                                <input class="col-md-6" type="date" id="to">
                                            </div>
                                        </div>

                                    </div>
                                    <button class="col-md-12" onclick="findSellings();">FIND</button>
                                </div>
                            </div>
                            <hr class="hr">

                        </div>

                        <div class="users-load-sec" id="viewAreaSH">

                            <?php

                            $query = "SELECT *, invoice.product_id AS invoice_product_id, invoice.qty AS invoice_qty, invoice.status AS invoice_status, invoice.user_email AS invoice_user_email FROM `invoice` INNER JOIN `product` ON invoice.product_id = product.id WHERE `product`.`user_email` = '" . $_SESSION["u"]["email"] . "'";
                            $pageno;

                            if (isset($_GET["page"])) {
                                $pageno = $_GET["page"];
                            } else {
                                $pageno = 1;
                            }

                            $product_rs = Database::search($query);
                            $product_num = $product_rs->num_rows;

                            $results_per_page = 12;
                            $number_of_pages = ceil($product_num / $results_per_page);

                            $page_results = ($pageno - 1) * $results_per_page;
                            $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

                            $selected_num = $selected_rs->num_rows;

                            if ($selected_num > 0) {
                            ?>
                                <section class="products-mup">

                                    <div class="box-container-mup">

                                        <?php

                                        for ($x = 0; $x < $selected_num; $x++) {
                                            $selected_data = $selected_rs->fetch_assoc();
                                        ?>

                                            <div class="box-mup">

                                                <div class="num">
                                                    <p><?php echo $selected_data["invoice_id"]; ?></p>
                                                </div>
                                                <div class="hr"></div>

                                                <?php

                                                $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["invoice_product_id"] . "'");
                                                $image_num = $image_rs->num_rows;

                                                if ($image_num == 0) {
                                                    $profile_img_data = $image_rs->fetch_assoc();
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

                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '" . $selected_data["product_id"] . "'");
                                                $product_data = $product_rs->fetch_assoc();

                                                ?>

                                                <div class="content-mup">
                                                    <h3><b>Title &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $product_data["title"]; ?></h3>

                                                    <?php

                                                    $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $selected_data["invoice_user_email"] . "'");
                                                    $user_data = $user_rs->fetch_assoc();

                                                    ?>

                                                    <h3><b>Buyer &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></h3>
                                                    <h3><b>Amount &nbsp;&nbsp; : &nbsp;&nbsp;</b>Rs. <?php echo $selected_data["total"]; ?> .00</h3>
                                                    <h3><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $selected_data["invoice_qty"]; ?> Item</h3>

                                                </div>
                                            </div>

                                        <?php

                                        }

                                        ?>

                                    </div>

                                    <br>
                                    <br>

                                    <div class="product-page col-md-12">
                                        <section class="pagination">
                                            <ul class="page">
                                                <li>
                                                    <a href="<?php if ($pageno <= 1) {
                                                                    echo ("#");
                                                                } else {
                                                                    echo "?page=" . ($pageno - 1);
                                                                } ?>">Previous</a>
                                                </li>
                                                <li>
                                                    <a href="<?php if ($pageno >= $number_of_pages) {
                                                                    echo ("#");
                                                                } else {
                                                                    echo "?page=" . ($pageno + 1);
                                                                } ?>">Next</a>
                                                </li>
                                                <?php
                                                for ($x = 1; $x <= $number_of_pages; $x++) {
                                                    if ($x == $pageno) {
                                                ?>
                                                        <li class="active">
                                                            <a href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                                        </li>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <li>
                                                            <a href="<?php echo "?page=" . ($x); ?>"><?php echo $x; ?></a>
                                                        </li>
                                                <?php
                                                    }
                                                }
                                                ?>

                                            </ul>
                                        </section>
                                    </div>

                                </section>
                            <?php
                            } else {
                                echo ("<p style='text-align: center; font-size: 28px; font-weight: bold; color: white;'>No Selling Product Yet.</p>");

                            ?>
                                <br>
                                <br>
                            <?php
                            }

                            ?>

                        </div>

                    </div>

                </div>

                <!-- footer section starts -->

                <?php include "footer.php"; ?>

                <!-- footer section ends -->

            </div>

        </div>

        <!-- bootstrap js file -->
        <script src="./js/bootstrap.js"></script>
        <script src="./js/bootstrap.bundle.js"></script>

        <!-- custome js file -->
        <script src="./js/script.js"></script>

        <!-- fontawesome js file -->
        <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>

        <!-- ionicons js file -->
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

        <!-- sweetaleart js file -->
        <script src="./js/sweetalert.min.js"></script>

    </body>

    </html>

<?php

} else {
    echo ("You are not a valid user.");
?>
    <script>
        window.location = "signup&signin.php";
    </script>
<?php
}

?>