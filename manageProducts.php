<?php

session_start();

include "connection.php";

if (isset($_SESSION["au"])) {

?>
    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FASHION.MART | MANAGE PRODUCTS |</title>

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

        <div id="waiting">
            <h1>Waiting...</h1>
            <div class="underline-waiting"><span></span></div>
        </div>

        <div id="main-content" style="display: none;">

            <div class="product-page">

                <div class="manageUsers-page">

                    <div class="manageProducts-page">

                        <div class="ad-search-content">

                            <h1 class="ad-search-h1">MANAGE ALL PRODUCTS</h1>

                            <p class="file-path-top"><span><a href="adminPanel.php">Admin Panel</a></span> / <a class="on-page" href="manageProducts.php">Manage Products</a></p>

                            <div class="input-group col-md-12">
                                <input type="text" class="form-control col-md-10" placeholder="Type Keyword to Search..." id="ptxt">
                                <button class="btn col-md-2" type="button" onclick="searchProducts();">Search Product</button>
                            </div>
                            <hr>

                        </div>

                        <div class="users-load-sec">

                            <?php

                            $query = "SELECT * FROM `product`";
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
                                <section class="products-mup" id="search_view4">

                                    <div class="box-container-mup">

                                        <?php

                                        for ($x = 0; $x < $selected_num; $x++) {
                                            $selected_data = $selected_rs->fetch_assoc();
                                        ?>

                                            <div class="box-mup" onclick="viewProductModal('<?php echo $selected_data['id']; ?>');">

                                                <div class="num">
                                                    <p><?php echo $selected_data["id"]; ?></p>
                                                </div>
                                                <div class="hr"></div>

                                                <?php

                                                $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["id"] . "'");
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
                                                ?>

                                                <div class="content-mup">
                                                    <h3><b>Title &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $selected_data["title"]; ?></h3>
                                                    <h3><b>Price &nbsp;&nbsp; : &nbsp;&nbsp;</b>Rs . <?php echo $selected_data["price"]; ?> .00</h3>

                                                    <?php

                                                    if ($selected_data["qty"] == 0) {
                                                    ?>
                                                        <h3 class="isn"><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $selected_data["qty"]; ?> Items</h3>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <h3 class="is"><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $selected_data["qty"]; ?> Items</h3>
                                                    <?php
                                                    }

                                                    ?>

                                                    <?php
                                                    $splitDate = explode(" ", $selected_data["datetime_added"]);
                                                    ?>

                                                    <h3><b>Registered Date &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $splitDate[0]; ?></h3>

                                                    <?php
                                                    if ($selected_data["status_status_id"] == 1) {
                                                    ?>
                                                        <button id="pb<?php echo $selected_data['id']; ?>" onclick="blockProduct('<?php echo $selected_data['id']; ?>');" class="btn-pb-mup">deactive</button>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button id="pb<?php echo $selected_data['id']; ?>" onclick="blockProduct('<?php echo $selected_data['id']; ?>');" class="btn-pb-mup-g">active</button>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <!-- modal 01 -->
                                            <div class="modal modal-1" tabindex="-1" id="viewProductModal<?php echo $selected_data['id']; ?>">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo $selected_data['title']; ?></h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div>

                                                                <?php
                                                                $image_rs1 = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $selected_data["id"] . "'");
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
                                                                <h3><b>Price &nbsp;&nbsp; : &nbsp;&nbsp;</b>Rs . <?php echo $selected_data["price"]; ?> .00</h3>
                                                                <?php

                                                                if ($selected_data["qty"] == 0) {
                                                                ?>
                                                                    <h3 class="isn"><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $selected_data["qty"]; ?> Products Left</h3>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <h3 class="is"><b>Quantity &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $selected_data["qty"]; ?> Products Left</h3>
                                                                <?php
                                                                }

                                                                $seller_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $selected_data['user_email'] . "'");
                                                                $seller_data = $seller_rs->fetch_assoc();
                                                                ?>

                                                                <h3><b>Seller &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $seller_data["fname"] . " " . $seller_data["lname"]; ?></h3>
                                                                <h3><b>Description &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $selected_data['description']; ?></h3>
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
                                echo ("<p style='text-align: center; font-size: 28px; font-weight: bold; color: white;'>No Product Yet.</p>");

                            ?>
                                <br>
                                <br>
                            <?php
                            }

                            ?>

                        </div>

                        <div class="ad-search-content">

                            <hr class="mt-hr">
                            <h1 class="ad-search-h1">MANAGE ALL CATEGORIES</h1>

                            <div class="cat-box-sec col-12">

                                <div class="row gap-3 justify-content-center">

                                    <?php
                                    $category_rs = Database::search("SELECT * FROM `category`");
                                    $category_num = $category_rs->num_rows;

                                    for ($x = 0; $x < $category_num; $x++) {
                                        $category_data = $category_rs->fetch_assoc();

                                    ?>
                                        <div class="c-box col-12 col-lg-3">

                                            <p><b><?php echo $category_data["cat_name"]; ?></b></p>

                                        </div>
                                    <?php

                                    }

                                    ?>

                                    <div class="c-box-r col-12 col-lg-3">

                                        <p><b>Add new Category</b> <i onclick="addNewCategory();" class="fa-solid fa-plus"></i></p>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- modal 02 -->
                        <div class="modal modal-2" tabindex="-1" id="addCategoryModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Add New Category</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-12">
                                            <label class="form-label">New Category Name : </label>
                                            <input type="text" class="form-control" id="n" />
                                        </div>
                                        <div class="col-12 mcol12two">
                                            <label class="form-label">Enter Your Email : </label>
                                            <input type="text" class="form-control" id="e" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-cl" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-verify" onclick="verifyCategory();">Save New Category</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal 02 -->

                        <!-- modal 03 -->
                        <div class="modal modal-3" tabindex="-1" id="addCategoryVerificationModal">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Verification</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-12">
                                            <label class="form-label">Enter Your Verification Code : </label>
                                            <input type="text" class="form-control" id="txt" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-cl" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-verify" onclick="saveCategory();">Verify & Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- modal 03 -->

                    </div>

                </div>

            </div>

            <br>

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
        window.location = "adminSignin.php";
    </script>
<?php
}

?>