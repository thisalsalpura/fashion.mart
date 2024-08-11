<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {
    $email = $_SESSION["u"]["email"];
    $pageno;

?>

    <!DOCTYPE html>

    <html lang="en">


    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FASHION.MART | MY PRODUCTS |</title>

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
                <!-- header section starts -->

                <?php include "header.php"; ?>

                <!-- header section ends -->
            </div>

            <div class="my-product-page">

                <h1 class="mmp-title">My Products</h1>

                <p class="file-path"><span><a href="index.php">Home</a></span> / <a class="on-page" href="myProducts.php">My Products</a></p>
                <br>

                <div class="user-details">

                    <div class="profile-pic">
                        <?php

                        $profile_img_rs =  Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $email . "'");
                        $profile_img_num = $profile_img_rs->num_rows;

                        if ($profile_img_num == 1) {
                            $profile_img_data = $profile_img_rs->fetch_assoc();
                        ?>
                            <img src="<?php echo $profile_img_data["path"]; ?>" alt="profile-pic">
                        <?php
                        } else {
                        ?>
                            <img src="./images/profile_images/sampel-profile-img.png" alt="profile-pic">
                        <?php
                        }

                        ?>

                    </div>

                    <div class="profile-details">
                        <p><?php echo $_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]; ?></p>
                        <p><?php echo $email; ?></p>
                    </div>

                    <div class="add-product-btn">
                        <button onclick="window.location='addProduct.php'">Add Products</button>
                    </div>

                </div>

                <div class="mmp-body-con row">

                    <div class="sort-sec col-md-3">

                        <h2>Sort Products</h2>

                        <form action="" class="mmp-search-box">
                            <input type="text" name="search" placeholder="search..." class="mmp-search-input" id="s" />
                            <button type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>

                        <h6>Category</h6>

                        <select class="form-select" id="sort-select">
                            <option value="0">All Categories</option>

                            <?php

                            $category_rs = Database::search("SELECT * FROM `category`");
                            $category_num = $category_rs->num_rows;

                            for ($x = 0; $x < $category_num; $x++) {
                                $category_data = $category_rs->fetch_assoc();
                            ?>

                                <option value="<?php echo $category_data["cat_id"]; ?>">
                                    <?php echo $category_data["cat_name"]; ?>
                                </option>

                            <?php

                            }

                            ?>

                        </select>

                        <h6>Active Time</h6>

                        <div class="radio-group col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="r1" id="n">&nbsp;&nbsp;
                                <label class="form-check-label" for="n">
                                    Newest to oldest
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="r1" id="o">&nbsp;&nbsp;
                                <label class="form-check-label" for="o">
                                    Oldest to newest
                                </label>
                            </div>
                        </div>

                        <h6>By Quantity</h6>

                        <div class="radio-group col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="r2" id="h">&nbsp;&nbsp;
                                <label class="form-check-label" for="h">
                                    High to low
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="r2" id="l">&nbsp;&nbsp;
                                <label class="form-check-label" for="l">
                                    Low to High
                                </label>
                            </div>
                        </div>

                        <h6>By Condition</h6>

                        <div class="radio-group col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="r3" id="nf">&nbsp;&nbsp;
                                <label class="form-check-label" for="nf">
                                    New Fashion
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="r3" id="of">&nbsp;&nbsp;
                                <label class="form-check-label" for="of">
                                    Old Fashion
                                </label>
                            </div>
                        </div>

                        <h6>By Price</h6>

                        <div class="radio-group col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="r4" id="hp">&nbsp;&nbsp;
                                <label class="form-check-label" for="hp">
                                    High to low
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="r4" id="lp">&nbsp;&nbsp;
                                <label class="form-check-label" for="lp">
                                    Low to High
                                </label>
                            </div>
                        </div>

                        <br>
                        <br>

                        <button class="sort-clear-btn" onclick="sort1(0);">Sort</button>
                        <button class="sort-clear-btn" onclick="clearSort();">Clear</button>

                    </div>

                    <div class="product-load-sec col-md-9">

                        <div class="col-md-12 row" id="sort" style="justify-content: center;">

                            <?php

                            if (isset($_GET["page"])) {
                                $pageno = $_GET["page"];
                            } else {
                                $pageno = 1;
                            }

                            $product_rs = Database::search("SELECT * FROM `product` WHERE `user_email` = '" . $email . "'");
                            $product_num = $product_rs->num_rows;

                            $results_per_page = 6;
                            $number_of_pages = ceil($product_num / $results_per_page);

                            $page_results = ($pageno - 1) * $results_per_page;
                            $selected_rs = Database::search("SELECT * FROM `product` WHERE `user_email` = '" . $email . "' 
                            LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

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
                                                <a href="
                                        <?php if ($pageno <= 1) {
                                            echo ("#");
                                        } else {
                                            echo "?page=" . ($pageno - 1);
                                        } ?>">Previous</a>
                                            </li>
                                            <li>
                                                <a href="
                                        <?php if ($pageno >= $number_of_pages) {
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

                            <?php

                            } else {
                                echo '<p class="no-products-message">No products found.</p>';
                            }

                            ?>

                        </div>

                    </div>

                </div>

                <br>
                <br>
                <br>
                <br>
                <br>

            </div>

            <div class="product-page">
                <!-- footer section starts -->

                <?php include "footer.php"; ?>

                <!-- footer section ends -->
            </div>

        </div>

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
    header("Location:signup&signin.php");
}

?>