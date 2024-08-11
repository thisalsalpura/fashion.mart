<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION.MART | PRODUCT UPDATING |</title>

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

            <!-- sweetaleart js file -->
            <script src="./js/sweetalert.min.js"></script>

            <?php

            session_start();

            if (isset($_SESSION["u"])) {

                if (isset($_SESSION["p"])) {

                    include "connection.php";
                    $product = $_SESSION["p"];

            ?>

                    <!-- content section starts -->

                    <div class="product-reg-page">

                        <h1 class="pro-reg-h1">UPDATE PRODUCT</h1>
                        <br>

                        <p class="file-path"><span><a href="index.php">Home</a></span> / <span><a href="myProducts.php">My Products</a></span> / <a class="on-page" href="updateProduct.php">Update Product</a></p>
                        <br>
                        <br>

                        <div class="content-border">

                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-4">
                                        <label class="label-in-prp">Product Category</label>
                                        <select class="form-control select-in-prp disable-prp" disabled>
                                            <?php
                                            $category_rs = Database::search("SELECT * FROM `category` WHERE `cat_id`='" . $product["category_cat_id"] . "'");
                                            $category_data = $category_rs->fetch_assoc();
                                            ?>
                                            <option class="option-in-prp"><?php echo $category_data["cat_name"]; ?></option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="label-in-prp">Product Brand</label>
                                        <select class="form-control select-in-prp disable-prp" disabled>
                                            <?php
                                            $brand_rs = Database::search("SELECT * FROM `brand` WHERE `brand_id` IN 
                                            (SELECT `brand_brand_id` FROM `model_has_brand` WHERE `model_has_brand_id`='" . $product["model_has_brand_id"] . "')");
                                            $brand_data = $brand_rs->fetch_assoc();
                                            ?>
                                            <option class="option-in-prp"><?php echo $brand_data["brand_name"]; ?></option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="label-in-prp">Select Product Model</label>
                                        <select class="form-control select-in-prp disable-prp" disabled>
                                            <?php
                                            $model_rs = Database::search("SELECT * FROM `model` WHERE `model_id` IN 
                                            (SELECT `model_model_id` FROM `model_has_brand` WHERE `model_has_brand_id`='" . $product["model_has_brand_id"] . "')");
                                            $model_data = $model_rs->fetch_assoc();
                                            ?>
                                            <option class="option-in-prp"><?php echo $model_data["model_name"]; ?></option>
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-12">
                                        <label class="label-in-prp">Product Title</label>
                                        <input type="text" placeholder="You can use only letters your product title." class="input-in-prp" value="<?php echo $product["title"]; ?>" id="t">
                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-4 radio-btn-box">

                                        <label class="label-in-prp">Product Condition</label>

                                        <?php

                                        if ($product["condition_condition_id"] == 1) {
                                        ?>
                                            <div class="col-md-12">
                                                <div class="row">

                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input radio-btn" type="radio" type="radio" name="c" id="b" checked disabled>&nbsp;
                                                        <label class="form-check-label radio-btn-label" for="b">
                                                            New Fashion
                                                        </label>
                                                    </div>
                                                    <hr>
                                                    <div class="form-check mt-4 mb-3">
                                                        <input class="form-check-input radio-btn" type="radio" name="c" id="u" disabled>&nbsp;
                                                        <label class="form-check-label radio-btn-label" for="u">
                                                            Old Fashion
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="col-md-12">
                                                <div class="row">

                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input radio-btn" type="radio" type="radio" name="c" id="b" disabled>&nbsp;
                                                        <label class="form-check-label radio-btn-label" for="b">
                                                            New Fashion
                                                        </label>
                                                    </div>
                                                    <hr>
                                                    <div class="form-check mt-4 mb-3">
                                                        <input class="form-check-input radio-btn" type="radio" name="c" id="u" checked disabled>&nbsp;
                                                        <label class="form-check-label radio-btn-label" for="u">
                                                            Old Fashion
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php
                                        }

                                        ?>

                                    </div>

                                    <div class="col-md-4">

                                        <label class="label-in-prp">Product Colour</label>
                                        <select class="form-control select-in-prp disable-prp" disabled>
                                            <?php
                                            $color_rs = Database::search("SELECT * FROM `color` INNER JOIN `product_has_color` ON 
                                            color.clr_id=product_has_color.color_clr_id WHERE `product_id`='" . $product["id"] . "'");
                                            $color_data = $color_rs->fetch_assoc();
                                            ?>
                                            <option class="option-in-prp"><?php echo $color_data["clr_name"]; ?></option>
                                        </select>
                                        <div class="input-group mt-3">
                                            <input type="text" class="clr-input-in-prp disable-prp-c" placeholder="Add new Colour" disabled>
                                            <button class="input-btn-in-prp disable-bor" type="button" disabled>+ Add</button>
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <label class="label-in-prp">Product Quantity</label>
                                        <input type="number" class="input-in-prp" value="<?php echo $product["qty"]; ?>" min="1" max="50" id="q">

                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-4">
                                        <label class="label-in-prp">Cost Per Item</label>
                                        <div class="input-group mb-3">
                                            <button class="dcci disable-bor" type="button">Rs.</button>
                                            <input type="text" class="clr-input-in-prp disable-prp-c" disabled value="<?php echo $product["price"]; ?>">
                                            <button class="input-btn-in-prp disable-bor" type="button">.00</button>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="label-in-prp">Delivery cost Within Colombo</label>
                                        <div class="input-group mb-3">
                                            <button class="dcci" type="button">Rs.</button>
                                            <input type="text" class="clr-input-in-prp" value="<?php echo $product["delivery_fee_colombo"]; ?>" id="dwc">
                                            <button class="input-btn-in-prp" type="button">.00</button>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="label-in-prp">Delivery cost out of Colombo</label>
                                        <div class="input-group mb-3">
                                            <button class="dcci" type="button">Rs.</button>
                                            <input type="text" class="clr-input-in-prp" value="<?php echo $product["delivery_fee_other"]; ?>" id="doc">
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
                                        <textarea placeholder="You can use only letters and full stop mark your product description." cols="30" rows="15" class="form-control txt-area" id="d"><?php echo $product["description"]; ?></textarea>
                                    </div>

                                </div>
                            </div>

                            <hr>

                            <div class="col-md-12 mt-4">
                                <div class="row">

                                    <label class="label-in-prp">Add Product Images</label>

                                    <?php

                                    $img = array();

                                    $img[0] = "./svgs/product-uploading-img.svg";
                                    $img[1] = "./svgs/product-uploading-img.svg";
                                    $img[2] = "./svgs/product-uploading-img.svg";

                                    $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product["id"] . "'");
                                    $product_img_num = $product_img_rs->num_rows;

                                    for ($x = 0; $x < $product_img_num; $x++) {
                                        $product_img_data = $product_img_rs->fetch_assoc();

                                        $img[$x] = $product_img_data["img_path"];
                                    }

                                    ?>

                                    <div class="col-md-12 mt-3">
                                        <div class="row prod-upl-img-set">
                                            <div class="pro-img-box col-md-4"><img src="<?php echo $img[0]; ?>" alt="product-uploading-img" id="i0"></div>
                                            <div class="pro-img-box col-md-4"><img src="<?php echo $img[1]; ?>" alt="product-uploading-img" id="i1"></div>
                                            <div class="pro-img-box col-md-4"><img src="<?php echo $img[2]; ?>" alt="product-uploading-img" id="i2"></div>
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

                            <br>

                            <div class="col-md-12 mt-4">
                                <div class="row upload-btn-row">
                                    <button class="upload-btn" onclick="updateProduct();">Update Product</button>
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
                        swal({
                            title: "Error",
                            text: "Please select a product to update.",
                            icon: "error",
                            buttons: {
                                confirm: {
                                    text: "OK",
                                    value: true,
                                    visible: true,
                                    className: "swal-ok-button",
                                    closeModal: true,
                                },
                            },
                            className: "custom-swal",
                        });
                        window.location = "myProducts.php";
                    </script>
                <?php
                }
            } else {
                ?>
                <script>
                    swal({
                        title: "Error",
                        text: "You have to signin to the system for access this function.",
                        icon: "error",
                        buttons: {
                            confirm: {
                                text: "OK",
                                value: true,
                                visible: true,
                                className: "swal-ok-button",
                                closeModal: true,
                            },
                        },
                        className: "custom-swal",
                    });
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

</body>

</html>