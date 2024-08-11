<?php

session_start();

include "connection.php";

if (isset($_GET["txt"])) {

    $search_txt = $_GET["txt"];

    if (empty($search_txt)) {
?>
        <br>
        <br>

        <?php

        echo '<p class="no-products-message">No users found.</p>';

        ?>

        <br>
        <br>

        <div class="button-container">
            <button onclick="clearSearchResult();" class="clear-btn-h-ad">CLEAR RESULTS</button>
        </div>

        <br>
        <br>
        <?php
    } else {

        $result_rs = Database::search("SELECT * FROM `user` WHERE `fname` LIKE '%" . $search_txt . "%' OR `lname` LIKE '%" . $search_txt . "%' OR CONCAT(`fname`, ' ', `lname`) LIKE '%" . $search_txt . "%'");
        $result_num = $result_rs->num_rows;

        if ($result_num > 0) {

        ?>

            <div class="box-container-mup">

                <?php

                for ($x = 0; $x < $result_num; $x++) {
                    $result_data = $result_rs->fetch_assoc();

                ?>

                    <div class="box-mup" onclick="viewMsgModal('<?php echo $result_data['email']; ?>');">

                        <div class="num">
                            <p><?php echo $x + 1; ?></p>
                        </div>
                        <div class="hr"></div>

                        <?php
                        $profile_img_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email`='" . $result_data["email"] . "'");
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
                            <h3><b>User Name &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $result_data["fname"] . " " . $result_data["lname"]; ?></h3>
                            <h3><b>Email &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $result_data["email"]; ?></h3>
                            <h3><b>Mobile &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $result_data["mobile"]; ?></h3>

                            <?php
                            $splitDate = explode(" ", $result_data["joined_date"]);
                            ?>

                            <h3><b>Registered Date &nbsp;&nbsp; : &nbsp;&nbsp;</b><?php echo $splitDate[0]; ?></h3>

                            <?php
                            if ($result_data["status_status_id"] == 1) {
                            ?>
                                <button id="ub<?php echo $result_data["email"]; ?>" onclick="blockUser('<?php echo $result_data['email']; ?>');" class="btn-pb-mup">block</button>
                            <?php
                            } else {
                            ?>
                                <button id="ub<?php echo $result_data["email"]; ?>" onclick="blockUser('<?php echo $result_data['email']; ?>');" class="btn-pb-mup-g">unblock</button>
                            <?php
                            }
                            ?>

                        </div>
                    </div>

                    <!-- msg modal -->
                    <div class="modal msg-modal" tabindex="-1" id="userMsgModal<?php echo $result_data["email"]; ?>">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><?php echo $result_data["fname"] . " " . $result_data["lname"]; ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><ion-icon name="close-outline"></ion-icon></button>
                                </div>
                                <div class="modal-body">
                                    <!-- received -->
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-8 received">
                                                <div class="row">
                                                    <div class="col-12 pt-2">
                                                        <span class="msg-txt">Hello there!!!</span>
                                                    </div>
                                                    <div class="col-12 text-end pb-2">
                                                        <span class="msg-date">2022-11-9 00:00:00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- received -->
                                    <!-- sent -->
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="offset-4 col-8 sent">
                                                <div class="row">
                                                    <div class="col-12 pt-2">
                                                        <span class="msg-txt">Hello there!!!</span>
                                                    </div>
                                                    <div class="col-12 text-end pb-2">
                                                        <span class="msg-date">2022-11-9 00:00:00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- sent -->
                                    <!-- received -->
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-8 received">
                                                <div class="row">
                                                    <div class="col-12 pt-2">
                                                        <span class="msg-txt">Hello there!!!</span>
                                                    </div>
                                                    <div class="col-12 text-end pb-2">
                                                        <span class="msg-date">2022-11-9 00:00:00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- received -->
                                    <!-- sent -->
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="offset-4 col-8 sent">
                                                <div class="row">
                                                    <div class="col-12 pt-2">
                                                        <span class="msg-txt">Hello there!!!</span>
                                                    </div>
                                                    <div class="col-12 text-end pb-2">
                                                        <span class="msg-date">2022-11-9 00:00:00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- sent -->
                                </div>
                                <div class="modal-footer">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="msgtxt" />
                                            </div>
                                            <div class="col-3 d-grid">
                                                <button type="button" class="btn btn-primary">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- msg modal -->

                <?php

                }

                ?>

            </div>

        <?php

        } else {

        ?>

            <br>
            <br>

            <?php

            echo '<p class="no-products-message">No users found.</p>';

            ?>

            <br>
            <br>

            <div class="button-container">
                <button onclick="clearSearchResult();" class="clear-btn-h-ad">CLEAR RESULTS</button>
            </div>

            <br>
            <br>

<?php

        }
    }
}
