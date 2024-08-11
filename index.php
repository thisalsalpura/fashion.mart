<?php

include "connection.php";

session_start();

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASHION.MART | HOME |</title>

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

            <button class="backToTop" id="backToTop"><i class="fa-solid fa-angle-up"></i></button>

            <?php

            if (isset($_SESSION["u"])) {

            ?>
                <button class="messageBtn" onclick="contactAdmin();"><i class="fa-solid fa-message"></i></button>
            <?php

            } else {
            }

            ?>

            <!-- header section starts  -->

            <?php include "header.php"; ?>

            <header class="rounded-navbar-div">

                <div class="nav-rnd container-rnd">
                    <div class="nav-icons-rnd">

                        <?php

                        if (isset($_SESSION["u"])) {
                            $data = $_SESSION["u"];
                        ?>
                            <a href="#" class="welcome-signout"><b class="welcome-text">Welcome</b>&nbsp;&nbsp;&nbsp; <u class="user-name"><?php echo $data["fname"]; ?></u> &nbsp;&nbsp;&nbsp;<b class="signout-button text-decoration-none" onclick="signout();">Sign Out</b></a>
                        <?php

                        } else {

                        ?>
                            <a href="signup&signin.php" class="text-decoration-none signout-button">Sign In or Register</a>
                        <?php

                        }

                        ?>

                        <a href="#" class="user-icon" onclick="gotoFrofile();"><i class="fa-regular fa-user"></i></a>
                        <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>

                    </div>
                </div>

            </header>

            <!-- header section ends -->

            <!-- home section starts  -->

            <main class="top-face" id="home">
                <article>

                    <section class="hero text-center" id="home">

                        <ul class="hero-slider" id="data-hero-slider">

                            <li class="slider-item active" id="data-hero-slider-item">

                                <div class="slider-bg">
                                    <img src="./images/hero_slider_images/hero-slider-1.png" width="1880" height="950" alt="hero-slider-img" class="img-cover">
                                </div>

                                <p class="section-subtitle slider-reveal">WELCOME TO FASHION.MART</p>

                                <h1 class="hero-title slider-reveal">
                                    FASHION.MART
                                </h1>

                                <p class="hero-text slider-reveal">
                                    Better Shopping!
                                </p>

                                <a href="#" class="btn slider-reveal">
                                    <span class="text" onclick="scrollToAboutSection();">About Us</span>
                                </a>

                            </li>

                            <li class="slider-item" id="data-hero-slider-item">

                                <div class="slider-bg">
                                    <img src="./images/hero_slider_images/hero-slider-2.png" width="1880" height="950" alt="hero-slider-img" class="img-cover">
                                </div>

                                <p class="section-subtitle slider-reveal">WELCOME TO FASHION.MART</p>

                                <h1 class="hero-title slider-reveal">
                                    FASHION.MART
                                </h1>

                                <p class="hero-text slider-reveal">
                                    Better Shopping!
                                </p>

                                <a href="#" class="btn slider-reveal">
                                    <span class="text" onclick="scrollToAboutSection();">About Us</span>
                                </a>

                            </li>

                            <li class="slider-item" id="data-hero-slider-item">

                                <div class="slider-bg">
                                    <img src="./images/hero_slider_images/hero-slider-3.png" width="1880" height="950" alt="hero-slider-img" class="img-cover">
                                </div>

                                <p class="section-subtitle slider-reveal">WELCOME TO FASHION.MART</p>

                                <h1 class="hero-title slider-reveal">
                                    FASHION.MART
                                </h1>

                                <p class="hero-text slider-reveal">
                                    Better Shopping!
                                </p>

                                <a href="#" class="btn slider-reveal">
                                    <span class="text" onclick="scrollToAboutSection();">About Us</span>
                                </a>

                            </li>

                            <li class="slider-item" id="data-hero-slider-item">

                                <div class="slider-bg">
                                    <img src="./images/hero_slider_images/hero-slider-4.png" width="1880" height="950" alt="hero-slider-img" class="img-cover">
                                </div>

                                <p class="section-subtitle slider-reveal">WELCOME TO FASHION.MART</p>

                                <h1 class="hero-title slider-reveal">
                                    FASHION.MART
                                </h1>

                                <p class="hero-text slider-reveal">
                                    Better Shopping!
                                </p>

                                <a href="#" class="btn slider-reveal">
                                    <span class="text" onclick="scrollToAboutSection();">About Us</span>
                                </a>

                            </li>

                        </ul>

                        <button class="slider-btn prev" id="data-prev-btn">
                            <ion-icon name="chevron-back"></ion-icon>
                        </button>

                        <button class="slider-btn next" id="data-next-btn">
                            <ion-icon name="chevron-forward"></ion-icon>
                        </button>

                        <a href="#" class="hero-btn has-after">
                            <img src="./images/goToItems.png" width="100%" height="100%" alt="img-in-hero-section">
                        </a>

                    </section>

                </article>
            </main>

            <!-- home section ends -->

            <!-- search bar starts -->

            <section>
                <nav class="search-bar">
                    <ul>
                        <li>
                            <select class="dropdown-search-option form-control" id="basic_search_select">
                                <option class="dropdown-search-option-list" value="0">All Categories</option>

                                <?php

                                $category_rs = Database::search("SELECT * FROM `category`");
                                $category_num = $category_rs->num_rows;

                                for ($x = 0; $x < $category_num; $x++) {
                                    $category_data = $category_rs->fetch_assoc();
                                ?>

                                    <option class="dropdown-search-option-list" value="<?php echo $category_data["cat_id"]; ?>">
                                        <?php echo $category_data["cat_name"]; ?>
                                    </option>

                                <?php

                                }

                                ?>

                            </select>
                        </li>
                        <li>
                            <form action="" class="search-box">
                                <input type="text" placeholder="Search Product" class="search-input" id="basic_search_txt" />
                                <button>
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </li>
                        <li><button class="search-click-btn" onclick="basicSearch(0);">SEARCH</button></li>
                        <li><button class="advanced-search-click-btn" onclick="gotoAdvancedSSearch();">ADVANCED</button></li>
                    </ul>
                </nav>
            </section>

            <!-- search bar ends -->

            <div id="basicSearchResult">

                <span class="blur"></span>
                <span class="blur"></span>

                <!-- image boxes slider starts -->

                <section class="boxImageSlider" id="categories">

                    <div class="containerBIS">
                        <div class="sliderBIS" data-slider>
                            <div class="slider-title">
                                <div>
                                    <p class="title-bis">Shop By Category</p>
                                    <p class="main-title">Our Categories</p>
                                </div>
                                <div class="slider-buttons">
                                    <button class="slider-button" data-slider-prev disabled>
                                        <i class="fa fa-angle-left"></i>
                                    </button>
                                    <button class="slider-button" data-slider-next>
                                        <i class="fa fa-angle-right"></i>
                                    </button>
                                </div>
                            </div>

                            <ul class="slider-track" data-slider-track>
                                <li>
                                    <div class="slideBIS" onclick="loadCategory(this);" id="sleeves">
                                        <img src="./images/categories_images/category-img-1.png" class="slideimg" alt="category-1-image" />
                                        <div class="slide-content">
                                            <p>Sleeves</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="slideBIS" onclick="loadCategory(this);" id="sneakers">
                                        <img src="./images/categories_images/category-img-2.png" class="slideimg" alt="category-3-image" />
                                        <div class="slide-content">
                                            <p>Sneakers</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="slideBIS" onclick="loadCategory(this);" id="caps">
                                        <img src="./images/categories_images/category-img-3.png" class="slideimg" alt="category-3-image" />
                                        <div class="slide-content">
                                            <p>Caps</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="slideBIS" onclick="loadCategory(this);" id="watches">
                                        <img src="./images/categories_images/category-img-4.png" class="slideimg" alt="category-4-image" />
                                        <div class="slide-content">
                                            <p>Watches</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="slideBIS" onclick="loadCategory(this);" id="bags">
                                        <img src="./images/categories_images/category-img-5.png" class="slideimg" alt="category-5-image" />
                                        <div class="slide-content">
                                            <p>Bags</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="slideBIS" onclick="loadCategory(this);" id="jackets">
                                        <img src="./images/categories_images/category-img-6.png" class="slideimg" alt="category-6-image" />
                                        <div class="slide-content">
                                            <p>Jackets</p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="slideBIS" onclick="loadCategory(this);" id="bands">
                                        <img src="./images/categories_images/category-img-7.png" class="slideimg" alt="category-7-image" />
                                        <div class="slide-content">
                                            <p>Bands</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </section>

                <!-- image boxes slider ends -->

                <div id="categorySearchResults">

                    <section class="about-section-pp" id="about">

                        <h1 class="section-heading"> about <span class="section-h-span">us</span> </h1>

                        <div class="row-about-section-pp">

                            <div class="image-about-section-pp">
                                <img src="./images/about-img.png" alt="about-img">
                            </div>

                            <div class="content-about-section-pp">
                                <h3>FASHION.MART</h3>
                                <p>
                                    Passionate about style, we curate fashion essentials that inspire confidence.
                                    Elevate your wardrobe with our handpicked collection of trendy clothing, chic shoes, and stylish accessories.
                                    Welcome to timeless elegance.
                                </p>
                                <a href="#" class="btn-about-section-pp" onclick="learnmore();">learn more</a>
                            </div>

                        </div>

                    </section>

                    <br>
                    <br>
                    <br>

                    <section class="category-deal">
                        <div class="slider">
                            <div class="list">
                                <div class="item active">
                                    <img src="./images/special_deal_images/special-deal-1.png" alt="special-category-img-1">
                                    <div class="content">
                                        <h2>merchandise!</h2>
                                        <p>Hey FootBall Fans, Get Your Favourite FootBall Club Jersy.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="./images/special_deal_images/special-deal-2.png" alt="special-category-img-2">
                                    <div class="content">
                                        <h2>merchandise!</h2>
                                        <p>Hey FootBall Fans, Get Your Favourite FootBall Club Jersy.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="./images/special_deal_images/special-deal-3.png" alt="special-category-img-3">
                                    <div class="content">
                                        <h2>merchandise!</h2>
                                        <p>Hey FootBall Fans, Get Your Favourite FootBall Club Jersy.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="./images/special_deal_images/special-deal-4.png" alt="special-category-img-4">
                                    <div class="content">
                                        <h2>merchandise!</h2>
                                        <p>Hey FootBall Fans, Get Your Favourite FootBall Club Jersy.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="./images/special_deal_images/special-deal-5.png" alt="special-category-img-5">
                                    <div class="content">
                                        <h2>merchandise!</h2>
                                        <p>Hey FootBall Fans, Get Your Favourite FootBall Club Jersy.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="arrows">
                                <button id="prevCd"></button>
                                <button id="nextCd"></button>
                            </div>
                            <div class="thumbnail">
                                <div class="item active">
                                    <img src="./images/special_deal_images/special-deal-1.png" alt="special-category-img-1">
                                </div>
                                <div class="item">
                                    <img src="./images/special_deal_images/special-deal-2.png" alt="special-category-img-2">
                                </div>
                                <div class="item">
                                    <img src="./images/special_deal_images/special-deal-3.png" alt="special-category-img-3">
                                </div>
                                <div class="item">
                                    <img src="./images/special_deal_images/special-deal-4.png" alt="special-category-img-4">
                                </div>
                                <div class="item">
                                    <img src="./images/special_deal_images/special-deal-5.png" alt="special-category-img-5">
                                </div>
                            </div>
                        </div>
                    </section>

                    <br>
                    <br>
                    <br>

                    <?php
                    $category_rs2 = Database::search("SELECT * FROM category");
                    $category_num2 = $category_rs2->num_rows;



                    for ($y = 0; $y < $category_num2; $y++) {
                        $category_data2 = $category_rs2->fetch_assoc();
                    ?>

                        <h1 class="section-heading-cat"> <?php echo $category_data2["cat_name"]; ?></h1>

                        <!-- products section starts -->

                        <section class="products" id="products">

                            <div class="box-container">

                                <?php

                                $product_rs = Database::search("SELECT * FROM `product` WHERE `category_cat_id` = '" . $category_data2["cat_id"] . "' AND `status_status_id` = '1' ORDER BY `datetime_added` DESC LIMIT 3 OFFSET 0");

                                $product_num = $product_rs->num_rows;

                                if ($product_num > 0) {

                                    for ($z = 0; $z < $product_num; $z++) {
                                        $product_data = $product_rs->fetch_assoc();

                                ?>

                                        <div class="box">

                                            <?php
                                            $img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id` = '" . $product_data["id"] . "'");
                                            $img_data = $img_rs->fetch_assoc();
                                            ?>

                                            <div class="image">
                                                <img src="<?php echo $img_data["img_path"]; ?>" alt="product-img">
                                            </div>
                                            <div class="content">
                                                <h3><?php echo $product_data["title"]; ?></h3>
                                                <span class="new-badge">New</span><br /><br />
                                                <div class="price">Rs. <?php echo $product_data["price"]; ?> .00</div>

                                                <?php

                                                if (isset($_SESSION["u"])) {

                                                    if ($product_data["qty"] > 0) {
                                                ?>

                                                        <span class="in-stock-txt">In Stock</span><br />
                                                        <span class="available-items-qty"><?php echo $product_data["qty"]; ?> Items Available</span><br /><br />
                                                        <a href='<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>' target="_blank" class="btn-pb">Buy Now</a><br><br>

                                                        <?php

                                                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id` = '" . $product_data["id"] . "' AND `user_email` = '" . $_SESSION["u"]["email"] . "'");
                                                        $cart_num = $cart_rs->num_rows;

                                                        if ($cart_num == 1) {

                                                        ?>
                                                            <a class="icons watchlisted fas fa-shopping-cart" onclick='addToCart(<?php echo $product_data["id"]; ?>);' id="carti<?php echo $product_data["id"]; ?>"></a>
                                                        <?php

                                                        } else {

                                                        ?>
                                                            <a class="icons not-watchlisted fas fa-shopping-cart" onclick='addToCart(<?php echo $product_data["id"]; ?>);' id="carti<?php echo $product_data["id"]; ?>"></a>
                                                        <?php

                                                        }
                                                    } else {
                                                        ?>

                                                        <span class="out-of-stock-txt">Out Of Stock</span><br />
                                                        <span class="available-items-qty">0 Items Available</span><br /><br />
                                                        <a class="btn-pb-disabled">Buy Now</a><br><br>
                                                        <a class="icons-disabled fas fa-shopping-cart"></a>

                                                    <?php
                                                    }
                                                } else {

                                                    if ($product_data["qty"] > 0) {
                                                    ?>

                                                        <span class="in-stock-txt">In Stock</span><br />
                                                        <span class="available-items-qty"><?php echo $product_data["qty"]; ?> Items Available</span><br /><br />
                                                        <a href='<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>' target="_blank" class="btn-pb">Buy Now</a><br><br>
                                                        <a class="icons-disabled fas fa-shopping-cart"></a>

                                                    <?php
                                                    } else {
                                                    ?>

                                                        <span class="out-of-stock-txt">Out Of Stock</span><br />
                                                        <span class="available-items-qty">0 Items Available</span><br /><br />
                                                        <a class="btn-pb-disabled">Buy Now</a><br><br>
                                                        <a class="icons-disabled fas fa-shopping-cart"></a>

                                                    <?php
                                                    }
                                                }

                                                if (isset($_SESSION["u"])) {

                                                    $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '" . $_SESSION["u"]["email"] . "' AND 
                                                    `product_id` = '" . $product_data["id"] . "'");

                                                    $watchlist_num = $watchlist_rs->num_rows;

                                                    if ($watchlist_num == 1) {

                                                    ?>

                                                        <a class="icons watchlisted fas fa-solid fa-heart" onclick='addToWatchlist(<?php echo $product_data["id"]; ?>);' id="heart<?php echo $product_data["id"]; ?>"></a>

                                                    <?php

                                                    } else {

                                                    ?>

                                                        <a class="icons not-watchlisted fas fa-solid fa-heart" onclick='addToWatchlist(<?php echo $product_data["id"]; ?>);' id="heart<?php echo $product_data["id"]; ?>"></a>

                                                    <?php

                                                    }
                                                } else {

                                                    ?>

                                                    <a class="icons-disabled fas fa-solid fa-heart"></a>

                                                <?php

                                                }

                                                ?>

                                            </div>
                                        </div>

                                    <?php

                                    }
                                } else {
                                    ?>
                                    <p style="text-align: center; margin-left: auto; margin-right: auto; font-size: 28px; font-weight: bold; color: black; background: white; padding: 10px; border: 2px solid white !important; border-radius: 5px; height: auto; width: 50%;">No product yet in this category.</p>
                                <?php
                                }

                                ?>

                            </div>

                        </section>


                    <?php

                    }

                    ?>


                    <br>
                    <br>
                    <br>
                    <br>
                    <br>

                </div>

            </div>

            <hr class="footer-border">

            <br>
            <br>
            <br>
            <br>
            <br>

            <!-- footer section starts -->

            <?php include "footer.php"; ?>

            <!-- footer section ends -->

            <!-- modal 01 -->
            <div class="modal modal-abus" tabindex="-1" id="aboutusModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">fashion.mart</h5>
                        </div>
                        <div class="modal-body">
                            <p>At our core, we're more than just an e-commerce platform; we're a destination for those who
                                live and breathe style. Our journey began with a passion for fashion, a desire to curate
                                pieces that speak volumes without saying a word. As style enthusiasts ourselves, we understand the
                                transformative power of clothing—it's not just about what you wear, but how it makes you feel.
                                That's why we meticulously select each item in our collection, ensuring that every piece exudes
                                confidence, sophistication, and individuality. Whether you're seeking the latest trends or timeless
                                classics, we've got you covered. From head-turning ensembles to subtle accents that elevate any look, our
                                handpicked selection promises to inspire and empower. Welcome to a world where fashion meets expression,
                                where every outfit tells a story, and where your personal style reigns supreme. Join us on this journey
                                to redefine elegance, one stunning piece at a time.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal 01 -->

            <!-- msg modal -->

            <div class="manageUsers-page">
                <div class="modal msg-modal" tabindex="-1" id="contactAdmin">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Contact Admin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
                            </div>
                            <div class="modal-body">

                                <?php
                                $chat_rs = Database::search("SELECT * FROM `chat` WHERE `from` IN('salpurathisal@gmail.com','" . $_SESSION["u"]["email"] . "') AND 
                                `to` IN('salpurathisal@gmail.com','" . $_SESSION["u"]["email"] . "') ORDER BY `date_time` ASC");
                                $chat_num = $chat_rs->num_rows;

                                while ($chat_data = $chat_rs->fetch_assoc()) {
                                    if ($chat_data["to"] == $_SESSION["u"]["email"]) {
                                ?>
                                        <!-- sent -->
                                        <div class="col-12 mt-2">
                                            <div class="row">
                                                <div class="col-8 sent">
                                                    <div class="row">
                                                        <div class="col-12 pt-2">
                                                            <span class="msg-txt"><?php echo $chat_data["content"]; ?></span>
                                                        </div>
                                                        <div class="col-12 text-end pb-2">
                                                            <span class="msg-date"><?php echo $chat_data["date_time"]; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- sent -->
                                    <?php
                                    } else if ($chat_data["from"] == $_SESSION["u"]["email"]) {
                                    ?>
                                        <!-- received -->
                                        <div class="col-12 mt-2">
                                            <div class="row">
                                                <div class="offset-4 col-8 received">
                                                    <div class="row">
                                                        <div class="col-12 pt-2">
                                                            <span class="msg-txt"><?php echo $chat_data["content"]; ?></span>
                                                        </div>
                                                        <div class="col-12 text-end pb-2">
                                                            <span class="msg-date"><?php echo $chat_data["date_time"]; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- received -->
                                <?php
                                    }
                                }

                                ?>

                            </div>
                            <div class="modal-footer">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="msgtxt2" />
                                        </div>
                                        <div class="col-3 d-grid">
                                            <button type="button" class="btn" onclick="sendAdminMsgTwo('<?php echo $_SESSION['u']['email']; ?>');">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- msg modal -->

        </div>

    </div>

    <!-- custome js file -->
    <script src="./js/script.js"></script>

    <!-- bootstrap js file -->
    <script src="./js/bootstrap.js"></script>

    <!-- bootstrap js file -->
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