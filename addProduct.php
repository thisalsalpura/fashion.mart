<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION.MART | PRODUCT REGISTATION |</title>

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

            session_start();

            if (isset($_SESSION["u"])) {

                include "connection.php";

            ?>

                <!-- content section starts -->

                <div class="product-reg-page">

                    <h1 class="pro-reg-h1">PRODUCT REGISTATION</h1>
                    <br>

                    <p class="file-path"><span><a href="index.php">Home</a></span> / <span><a href="myProducts.php">My Products</a></span> / <a class="on-page" href="addProduct.php">Product Registation</a></p>
                    <br>
                    <br>

                    <div class="content-border">

                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-4">
                                    <label class="label-in-prp">Select Product Category</label>
                                    <select class="form-control select-in-prp" id="category">
                                        <option value="0" class="option-in-prp">Select Category</option>
                                        <?php

                                        $category_rs = Database::search("SELECT * FROM `category`");
                                        $category_num = $category_rs->num_rows;

                                        for ($x = 0; $x < $category_num; $x++) {
                                            $category_data = $category_rs->fetch_assoc();
                                        ?>
                                            <option class="option-in-prp" value="<?php echo $category_data["cat_id"]; ?>"><?php echo $category_data["cat_name"]; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="label-in-prp">Select Product Brand</label>
                                    <select class="form-control select-in-prp" id="brand">
                                        <option value="0" class="option-in-prp">Select Brand</option>
                                        <?php

                                        $brand_rs = Database::search("SELECT * FROM `brand`");
                                        $brand_num = $brand_rs->num_rows;

                                        for ($x = 0; $x < $brand_num; $x++) {
                                            $brand_data = $brand_rs->fetch_assoc();
                                        ?>
                                            <option class="option-in-prp" value="<?php echo $brand_data["brand_id"]; ?>"><?php echo $brand_data["brand_name"]; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="label-in-prp">Select Product Model</label>
                                    <select class="form-control select-in-prp" id="model">
                                        <option value="0" class="option-in-prp">Select Model</option>
                                        <?php

                                        $model_rs = Database::search("SELECT * FROM `model`");
                                        $model_num = $model_rs->num_rows;

                                        for ($x = 0; $x < $model_num; $x++) {
                                            $model_data = $model_rs->fetch_assoc();
                                        ?>
                                            <option class="option-in-prp" value="<?php echo $model_data["model_id"]; ?>"><?php echo $model_data["model_name"]; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-12">
                                    <label class="label-in-prp">Add a Title to your Product</label>
                                    <input type="text" placeholder="You can use only letters your product title." class="input-in-prp" id="title">
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-4 radio-btn-box">

                                    <label class="label-in-prp">Select Product Condition</label>
                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="form-check mt-3">
                                                <input class="form-check-input radio-btn" type="radio" type="radio" name="c" id="b" checked>&nbsp;
                                                <label class="form-check-label radio-btn-label" for="b">
                                                    New Fashion
                                                </label>
                                            </div>
                                            <hr>
                                            <div class="form-check mt-4 mb-3">
                                                <input class="form-check-input radio-btn" type="radio" name="c" id="u">&nbsp;
                                                <label class="form-check-label radio-btn-label" for="u">
                                                    Old Fashion
                                                </label>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <label class="label-in-prp">Select Product Colour</label>
                                    <select class="form-control select-in-prp" id="clr">
                                        <option value="0" class="option-in-prp">Select Colour</option>
                                        <?php

                                        $color_rs = Database::search("SELECT * FROM `color`");
                                        $color_num = $color_rs->num_rows;

                                        for ($x = 0; $x < $color_num; $x++) {
                                            $color_data = $color_rs->fetch_assoc();
                                        ?>
                                            <option class="option-in-prp" value="<?php echo $color_data["clr_id"]; ?>"><?php echo $color_data["clr_name"]; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                    <div class="input-group mt-3">
                                        <input type="text" class="clr-input-in-prp" id="newClr" placeholder="Add new Colour">
                                        <button class="input-btn-in-prp" type="button" onclick="addNewClr();">+ Add</button>
                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <label class="label-in-prp">Add a Product Quantity</label>
                                    <input type="number" class="input-in-prp" value="0" min="1" max="50" id="qty">

                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-4">
                                    <label class="label-in-prp">Cost Per Item</label>
                                    <div class="input-group mb-3">
                                        <button class="dcci" type="button">Rs.</button>
                                        <input type="text" class="clr-input-in-prp" id="cost">
                                        <button class="input-btn-in-prp" type="button">.00</button>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="label-in-prp">Delivery cost Within Colombo</label>
                                    <div class="input-group mb-3">
                                        <button class="dcci" type="button">Rs.</button>
                                        <input type="text" class="clr-input-in-prp" id="dwc">
                                        <button class="input-btn-in-prp" type="button">.00</button>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="label-in-prp">Delivery cost out of Colombo</label>
                                    <div class="input-group mb-3">
                                        <button class="dcci" type="button">Rs.</button>
                                        <input type="text" class="clr-input-in-prp" id="doc">
                                        <button class="input-btn-in-prp" type="button">.00</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mt-3">
                            <div class="row">

                                <label class="label-in-prp">Approved Payment Methods</label>

                                <div class="col-md-6 mt-2 payment-method-img">
                                    <img src="./images/payment-method-img.png" alt="payment_method_img">
                                </div>

                                <div class="col-md-6 mt-2 payment-method-list">
                                    <ul class="list-group">
                                        <li class="list-group-item">VISA</li>
                                        <li class="list-group-item">MasterCard</li>
                                        <li class="list-group-item">AMERICAN EXPRESS</li>
                                        <li class="list-group-item">PayPal</li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mt-4">
                            <div class="row">

                                <label class="label-in-prp">Product Description</label>

                                <div class="col-md-12 mt-3">
                                    <textarea placeholder="You can use only letters and full stop mark your product description." cols="30" rows="15" class="form-control txt-area" id="desc"></textarea>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mt-4">
                            <div class="row">

                                <label class="label-in-prp">Add Product Images</label>

                                <div class="col-md-12 mt-3">
                                    <div class="row prod-upl-img-set">
                                        <div class="pro-img-box col-md-4"><img src="./svgs/product-uploading-img.svg" alt="product-uploading-img" id="i0"></div>
                                        <div class="pro-img-box col-md-4"><img src="./svgs/product-uploading-img.svg" alt="product-uploading-img" id="i1"></div>
                                        <div class="pro-img-box col-md-4"><img src="./svgs/product-uploading-img.svg" alt="product-uploading-img" id="i2"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="row upload-btn-row">
                                <input type="file" class="d-none" multiple id="imageuploader" />
                                <label for="imageuploader" class="col-12 btn upload-btn" onclick="changeProductImage();">Upload Images</label>
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mt-4">

                            <div class="notice-add-p">
                                <h2>NOTICE :-</h2>
                                <p>We are taking 5% of the product from price from every product as a service charge.</p>
                            </div>

                        </div>

                        <div class="col-md-12 mt-4">
                            <div class="row upload-btn-row">
                                <button class="upload-btn" onclick="addProduct();">Save Product</button>
                            </div>
                        </div>

                        <hr>

                    </div>

                </div>

                <!-- content section ends -->

            <?php

            } else {

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

    <!-- fontawesome js file -->
    <script src="https://kit.fontawesome.com/c8e4d183c2.js" crossorigin="anonymous"></script>

    <!-- ionicons js file -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- sweetaleart js file -->
    <script src="./js/sweetalert.min.js"></script>

</body>

</html>