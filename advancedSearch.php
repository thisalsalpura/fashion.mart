<?php

include "connection.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION.MART | ADVANCED SEARCH |</title>

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

            <!-- content section starts -->

            <div class="ad-search-content">

                <br>
                <p class="file-path"><span><a href="index.php">Home</a></span> / <a class="on-page" href="advancedSearch.php">Advanced Search</a></p>

                <h1 class="ad-search-h1">ADVANCED SEARCH</h1>

                <div class="input-group col-md-12">
                    <input type="text" class="form-control col-md-10" placeholder="Type Keyword to Search..." id="t">
                    <button class="btn col-md-2" type="button" onclick="advancedSearch(0);">Search</button>
                </div>
                <hr>

                <br>
                <div class="ad-search-option-fields row g-3">
                    <div class="col-md-4">
                        <label class="label-in-ad-search">Select a Category</label>
                        <select class="ad-search-option-fields-item form-control" id="c1">
                            <option value="0" class="fco">Select Category</option>
                            <?php

                            $category_rs = Database::search("SELECT * FROM  `category`");
                            $category_num =  $category_rs->num_rows;

                            for ($x = 0; $x < $category_num; $x++) {
                                $category_data = $category_rs->fetch_assoc();
                            ?>
                                <option class="fco" value="<?php echo $category_data["cat_id"]; ?>"><?php echo $category_data["cat_name"]; ?></option>
                            <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="label-in-ad-search">Select a Brand</label>
                        <select class="ad-search-option-fields-item form-control" id="b1">
                            <option value="0" class="fco">Select Brand</option>
                            <?php

                            $brand_rs = Database::search("SELECT * FROM  `brand`");
                            $brand_num =  $brand_rs->num_rows;

                            for ($x = 0; $x < $brand_num; $x++) {
                                $brand_data = $brand_rs->fetch_assoc();
                            ?>
                                <option class="fco" value="<?php echo $brand_data["brand_id"]; ?>"><?php echo $brand_data["brand_name"]; ?></option>
                            <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="label-in-ad-search">Select a Model</label>
                        <select class="ad-search-option-fields-item form-control" id="m">
                            <option value="0" class="fco">Select Model</option>
                            <?php

                            $model_rs = Database::search("SELECT * FROM  `model`");
                            $model_num =  $model_rs->num_rows;

                            for ($x = 0; $x < $model_num; $x++) {
                                $model_data = $model_rs->fetch_assoc();
                            ?>
                                <option class="fco" value="<?php echo $model_data["model_id"]; ?>"><?php echo $model_data["model_name"]; ?></option>
                            <?php
                            }

                            ?>
                        </select>
                    </div>
                    <p class="mark-b"></p>
                    <div class="col-md-6">
                        <label class="label-in-ad-search">Select a Condition</label>
                        <select class="ad-search-option-fields-item form-control" id="c2">
                            <option value="0" class="fco">Select Condition</option>
                            <?php

                            $condition_rs = Database::search("SELECT * FROM  `condition`");
                            $condition_num =  $condition_rs->num_rows;

                            for ($x = 0; $x < $condition_num; $x++) {
                                $condition_data = $condition_rs->fetch_assoc();
                            ?>
                                <option class="fco" value="<?php echo $condition_data["condition_id"]; ?>"><?php echo $condition_data["condition_name"]; ?></option>
                            <?php
                            }

                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="label-in-ad-search">Select a Colour</label>
                        <select class="ad-search-option-fields-item form-control" id="c3">
                            <option value="0" class="fco">Select Colour</option>
                            <?php

                            $color_rs = Database::search("SELECT * FROM  `color`");
                            $color_num =  $color_rs->num_rows;

                            for ($x = 0; $x < $color_num; $x++) {
                                $color_data = $color_rs->fetch_assoc();
                            ?>
                                <option class="fco" value="<?php echo $color_data["clr_id"]; ?>"><?php echo $color_data["clr_name"]; ?></option>
                            <?php
                            }

                            ?>
                        </select>
                    </div>
                    <p class="mark-b"></p>
                    <div class="col-md-6">
                        <label class="label-in-ad-search">Price From</label>
                        <input type="text" placeholder="Price From..." class="ad-search-option-fields-item form-control" id="pf">
                    </div>
                    <div class="col-md-6">
                        <label class="label-in-ad-search">Price To</label>
                        <input type="text" placeholder="Price To..." class="ad-search-option-fields-item form-control" id="pt">
                    </div>
                    <p class="mark-b"></p>
                    <div class="col-md-12">
                        <label class="label-in-ad-search">Select a Sort Option</label>
                        <select class="ad-search-option-fields-item form-control" id="s">
                            <option value="0" class="fco">SORT BY</option>
                            <option value="1" class="fco">PRICE LOW TO HIGH</option>
                            <option value="2" class="fco">PRICE HIGH TO LOW</option>
                            <option value="3" class="fco">QUANTITY LOW TO HIGH</option>
                            <option value="4" class="fco">QUANTITY HIGH TO LOW</option>
                        </select>
                    </div>
                </div>

                <br>
                <div class="ad-search-option-results" id="view_area">

                    <div class="text-center">

                        <i class="fa-solid fa-magnifying-glass no-products-message not-search-icon"></i><br>
                        <p class="no-products-message">No Items Searched Yet.</p>

                    </div>

                    <br>
                    <br>

                </div>

            </div>

            <!-- content section ends -->

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

    <!-- fontawesome js file -->
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>

    <!-- ionicons js file -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- sweetaleart js file -->
    <script src="./js/sweetalert.min.js"></script>

</body>

</html>