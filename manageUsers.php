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
        <title>FASHION.MART | MANAGE USERS |</title>

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

                <div class="manageUsers-page">

                    <div class="ad-search-content">

                        <h1 class="ad-search-h1">MANAGE ALL USERS</h1>

                        <p class="file-path-top"><span><a href="adminPanel.php">Admin Panel</a></span> / <a class="on-page" href="manageUsers.php">Manage Users</a></p>

                        <div class="input-group col-md-12">
                            <input type="text" class="form-control col-md-10" placeholder="Type Keyword to Search..." id="utxt">
                            <button class="btn col-md-2" type="button" onclick="searchUsers();">Search User</button>
                        </div>
                        <hr>

                    </div>

                    <div class="users-load-sec">

                        <?php

                        $query = "SELECT * FROM `user`";
                        $pageno;

                        if (isset($_GET["page"])) {
                            $pageno = $_GET["page"];
                        } else {
                            $pageno = 1;
                        }

                        $user_rs = Database::search($query);
                        $user_num = $user_rs->num_rows;

                        $results_per_page = 10;
                        $number_of_pages = ceil($user_num / $results_per_page);

                        $page_results = ($pageno - 1) * $results_per_page;
                        $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");

                        $selected_num = $selected_rs->num_rows;

                        if ($selected_num > 0) {
                        ?>
                            <section class="products-mup" id="search_view3">

                                <div class="box-container-mup">

                                    <?php

                                    for ($x = 0; $x < $selected_num; $x++) {
                                        $selected_data = $selected_rs->fetch_assoc();

                                    ?>

                                        <div class="box-mup">

                                            <div class="num">
                                                <p><?php echo $x + 1; ?></p>
                                            </div>
                                            <div class="hr"></div>

                                            <?php
                                            $profile_img_rs = Database::search("SELECT * FROM `profile_img` WHERE 
                                            `user_email`='" . $selected_data["email"] . "'");
                                            $profile_img_num = $profile_img_rs->num_rows;

                                            if ($profile_img_num == 1) {
                                                $profile_img_data = $profile_img_rs->fetch_assoc();
                                            ?>
                                                <div class="image-mup">
                                                    <img src="<?php echo $profile_img_data["path"]; ?>" alt="user-img">
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="image-mup">
                                                    <img src="./images/profile_images/sampel-profile-img.png" alt="user-img">
                                                </div>
                                            <?php
                                            }
                                            ?>

                                            <div class="content-mup">
                                                <h3><b>User Name &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?></h3>
                                                <h3><b>Email &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $selected_data["email"]; ?></h3>
                                                <h3><b>Mobile &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $selected_data["mobile"]; ?></h3>

                                                <?php
                                                $splitDate = explode(" ", $selected_data["joined_date"]);
                                                ?>

                                                <h3><b>Registered Date &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $splitDate[0]; ?></h3>

                                                <?php
                                                if ($selected_data["status_status_id"] == 1) {
                                                ?>
                                                    <button id="ub<?php echo $selected_data["email"]; ?>" onclick="blockUser('<?php echo $selected_data['email']; ?>');" class="btn-pb-mup">block</button>
                                                <?php
                                                } else {
                                                ?>
                                                    <button id="ub<?php echo $selected_data["email"]; ?>" onclick="blockUser('<?php echo $selected_data['email']; ?>');" class="btn-pb-mup-g">unblock</button>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>

                                    <?php

                                    }

                                    ?>

                                </div>

                                <!-- msg modal -->
                                <div class="modal msg-modal" tabindex="-1" id="userMsgModalOne">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Contact User</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
                                            </div>
                                            <div class="modal-body mb">
                                                <div class="col-12 hr"></div>
                                                <br>
                                                <div class="col-12">
                                                    <input type="text" class="form-control mail-input" disabled id="mail" value="If you want to sent a message to user?" />
                                                </div>
                                                <br>
                                                <div class="col-12 hr"></div>
                                            </div>
                                            <div class="modal-footer mf">
                                                <div class="col-12">
                                                    <button type="button" class="btn fm-btn" onclick="openSendAdminMsg();">Yes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- msg modal -->

                                <?php

                                ?>

                                <!-- msg modal -->
                                <div class="modal msg-modal" tabindex="-1" id="userMsgModal">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title mtjs"></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
                                            </div>
                                            <div class="modal-body">

                                                <?php

                                                $chat_rs = Database::search("SELECT * FROM `chat` WHERE `from` = '" . $_SESSION["au"]["email"] . "' OR `to` = '" . $_SESSION["au"]["email"] . "' 
                                                ORDER BY `date_time` ASC");
                                                $chat_num = $chat_rs->num_rows;

                                                while ($chat_data = $chat_rs->fetch_assoc()) {
                                                    if ($chat_data["from"] == $_SESSION["au"]["email"]) {
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
                                                    } else if ($chat_data["to"] == $_SESSION["au"]["email"]) {
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
                                                    }
                                                }
                                                ?>

                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <input type="text" class="form-control" id="msgtxt" />
                                                        </div>
                                                        <div class="col-3 d-grid">
                                                            <button type="button" class="btn" onclick="sendAdminMsg();">Send</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- msg modal -->

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
                            echo ("<p style='text-align: center; font-size: 28px; font-weight: bold; color: white;'>No User Yet.</p>");

                        ?>
                            <br>
                            <br>
                        <?php
                        }

                        ?>

                    </div>

                    <div class="msg-to-user">
                        <h1>Message to user</h1>
                        <div class="col-md-12 row">
                            <span class="col-md-3">Select a user :- </span>
                            <select class="col-md-9 form-control" id="msgSentUser">
                                <option value="0">Select a User</option>
                                <?php
                                $select_rs = Database::search("SELECT * FROM `user`");
                                $select_num = $select_rs->num_rows;
                                for ($z = 0; $z < $select_num; $z++) {
                                    $selected_data = $select_rs->fetch_assoc();
                                ?>
                                    <option value="<?php echo $selected_data["email"]; ?>">
                                        <?php echo $selected_data["fname"] . " " . $selected_data["lname"]; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <button onclick="viewMsgModal();">Send a message</button>
                        </div>
                    </div>

                </div>

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
        window.location = "adminSignin.php";
    </script>
<?php
}

?>