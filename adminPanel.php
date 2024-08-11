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
        <title>FASHION.MART | ADMIN PANEL |</title>

        <!-- favicon in the website -->
        <link rel="shortcut icon" href="./icos/favicon.ico" type="image/x-icon">

        <!-- custome css file -->
        <link rel="stylesheet" href="./css/style.css" />

        <!-- bootstrap css file -->
        <link rel="stylesheet" href="./css/bootstrap.css" />

        <!-- fontawesome css file -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    </head>

    <body id="sh-result">

        <!-- loading section starts -->
        <div id="loading" class="center">
            <div class="ring"></div>
            <span>Loading...</span>
        </div>
        <!-- loading section ends -->

        <div id="main-content" style="display: none;">

            <div class="admin-page">

                <div class="active-time-display-box">

                    <div class="title-txt">
                        Total Active Time
                    </div>

                    <div class="countdown-container">
                        <div class="countdown-e years-c">
                            <p class="big-text" id="years">0</p>
                            <span>Years</span>
                        </div>
                        <div class="countdown-e months-c">
                            <p class="big-text" id="months">0</p>
                            <span>Months</span>
                        </div>
                        <div class="countdown-e day-c">
                            <p class="big-text" id="days">0</p>
                            <span>Days</span>
                        </div>
                        <div class="countdown-e hours-c">
                            <p class="big-text" id="hours">0</p>
                            <span>Hours</span>
                        </div>
                        <div class="countdown-e minutes-c">
                            <p class="big-text" id="minutes">0</p>
                            <span>Minutes</span>
                        </div>
                        <div class="countdown-e seconds-c">
                            <p class="big-text" id="seconds">0</p>
                            <span>Seconds</span>
                        </div>
                    </div>

                </div>

                <div class="content-box col-md-12">

                    <div class="side-bar col-md-3">
                        <h3 class="ad-name col-md-12"><?php echo $_SESSION["au"]["fname"] . " " . $_SESSION["au"]["lname"]; ?></h3>
                        <div class="hr-b col-md-12"></div>
                        <a href="#"><button class="dashboard-btn col-md-12"><i class="fa-solid fa-gauge"></i>Dashboard</button></a>
                        <a href="manageUsers.php"><button class="m-users-btn col-md-12">Manage Users</button></a>
                        <a href="manageProducts.php"><button class="m-products-btn col-md-12">Manage Products</button></a>
                        <div class="hr-b col-md-12"></div>
                        <p class="sh-txt col-md-12">Selling History</p>
                        <div class="hr-b col-md-12"></div>
                        <p class="f-date-txt col-md-12">From Date</p>
                        <input type="date" class="form-control col-md-12 date-selecter" id="fromAD" />
                        <p class="t-date-txt col-md-12">To Date</p>
                        <input type="date" class="form-control col-md-12 date-selecter" id="toAD" />
                        <button class="search-btn col-md-12" onclick="findSellingsAD();">Find</button>
                        <div class="hr-b col-md-12"></div>
                        <p class="sh-txt col-md-12" onclick="findDailySellings();">Daily Sellings</p>
                        <div class="hr-b col-md-12"></div>
                    </div>

                    <?php

                    $today = date("Y-m-d");
                    $thismonth = date("m");
                    $thisyear = date("Y");

                    $a = "0";
                    $b = "0";
                    $c = "0";
                    $e = "0";
                    $f = "0";

                    $invoice_rs = Database::search("SELECT * FROM `invoice`");
                    $invoice_num = $invoice_rs->num_rows;

                    for ($x = 0; $x < $invoice_num; $x++) {
                        $invoice_data = $invoice_rs->fetch_assoc();

                        $f = $f + $invoice_data["qty"]; //total qty

                        $d = $invoice_data["date"];
                        $splitDate = explode(" ", $d); //separate the date from time
                        $pdate = $splitDate["0"]; //sold date

                        if ($pdate == $today) {
                            $a = $a + $invoice_data["total"];
                            $c = $c + $invoice_data["qty"];
                        }

                        $splitMonth = explode("-", $pdate); //separate date as year,month & day
                        $pyear = $splitMonth["0"]; //year
                        $pmonth = $splitMonth["1"]; //month

                        if ($pyear == $thisyear) {
                            if ($pmonth == $thismonth) {
                                $b = $b + $invoice_data["total"];
                                $e = $e + $invoice_data["qty"];
                            }
                        }
                    }

                    $user_rs = Database::search("SELECT * FROM `user`");
                    $user_num = $user_rs->num_rows;

                    $todaySellings = $c;
                    $monthlySellings = $e;
                    $totalSellings = $f;
                    $totalEngagements = $user_num;

                    ?>

                    <div class="dashboard-box col-md-9 justify-content-center align-items-center" id="refreshContainer">
                        <canvas id="myChart" height="180"></canvas>
                        <div class="earnings col-md-12">
                            <div class="d-earnings col-md-6">
                                <p class="col-md-12">Daily Earnings</p>
                                <p class="col-md-12">Rs. <?php echo $a; ?> .00</p>
                            </div>
                            <div class="m-earnings col-md-6">
                                <p class="col-md-12">Monthly Earnings</p>
                                <p class="col-md-12">Rs. <?php echo $b; ?> .00</p>
                            </div>
                        </div>
                        <div class="fps col-md-12">
                            <div class="fp col-md-6">
                                <h3 class="col-md-12">Mostly Sold Item Today</h3>

                                <?php

                                $freq_rs = Database::search("SELECT `product_id`,COUNT(`product_id`) AS `value_occurence` FROM `invoice` 
                                WHERE `date` LIKE '%" . $today . "%' GROUP BY `product_id` ORDER BY `value_occurence` DESC LIMIT 1");

                                $freq_num = $freq_rs->num_rows;

                                if ($freq_num > 0) {

                                    $freq_data = $freq_rs->fetch_assoc();

                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $freq_data["product_id"] . "'");
                                    $product_data = $product_rs->fetch_assoc();

                                    $image_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $freq_data["product_id"] . "'");
                                    $image_data = $image_rs->fetch_assoc();

                                    $qty_rs = Database::search("SELECT SUM(`qty`) AS `qty_total` FROM `invoice` WHERE 
                                    `product_id`='" . $freq_data["product_id"] . "' AND `date` LIKE '%" . $today . "%'");
                                    $qty_data = $qty_rs->fetch_assoc();

                                ?>

                                    <div class="img col-md-12">
                                        <img src="<?php echo $image_data["img_path"]; ?>" alt="pr-img">
                                    </div>
                                    <div class="col-md-12 hr"></div>
                                    <p class="col-md-12"><?php echo $product_data["title"]; ?></p>
                                    <span class="col-md-12"><?php echo $qty_data["qty_total"]; ?> Items</span><br>
                                    <span class="col-md-12">Rs. <?php echo $qty_data["qty_total"] * $product_data["price"]; ?> .00</span><br>

                                <?php

                                } else {

                                ?>

                                    <div class="img col-md-12">
                                        <img src="./images/empty-box.png" alt="emp-pr-img">
                                    </div>
                                    <div class="col-md-12 hr"></div>
                                    <p class="col-md-12">-----</p>
                                    <span class="col-md-12">--- Items</span><br>
                                    <span class="col-md-12">Rs. ---- .00</span><br>

                                <?php

                                }

                                ?>

                                <div class="col-md-12 hr"></div>
                                <img class="svg" src="./svgs/first_place.svg" alt="first_place">

                            </div>
                            <div class="fs col-md-6">
                                <h3 class="col-md-12">Most Famouse Seller Today</h3>

                                <?php

                                if ($freq_num > 0) {

                                    $profile_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email`='" . $product_data["user_email"] . "'");
                                    $profile_data = $profile_rs->fetch_assoc();

                                    $user_rs1 = Database::search("SELECT * FROM `user` WHERE `email`='" . $product_data["user_email"] . "'");
                                    $user_data1 = $user_rs1->fetch_assoc();

                                ?>

                                    <div class="br-img col-md-12">
                                        <img src="<?php echo $profile_data["path"]; ?>" alt="user-img">
                                    </div>
                                    <div class="col-md-12 hr"></div>
                                    <p class="col-md-12"><?php echo $user_data1["fname"] . " " . $user_data1["lname"]; ?></p>
                                    <span class="col-md-12"><?php echo $user_data1["email"]; ?></span><br>
                                    <span class="col-md-12"><?php echo $user_data1["mobile"]; ?></span><br>

                                <?php

                                } else {

                                ?>

                                    <div class="br-img col-md-12">
                                        <img src="./images/profile_images/sampel-profile-img.png" alt="pr-img">
                                    </div>
                                    <div class="col-md-12 hr"></div>
                                    <p class="col-md-12">----- -----</p>
                                    <span class="col-md-12">-----</span><br>
                                    <span class="col-md-12">----------</span><br>

                                <?php

                                }

                                ?>

                                <div class="col-md-12 hr"></div>
                                <img class="svg" src="./svgs/first_place.svg" alt="first_place">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- custome js file -->
        <script src="./js/script.js"></script>

        <!-- chart js file -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            // js for date and time countdown in adminPanel.php
            function updateCountdown(response) {
                document.getElementById("years").innerHTML = response.years;
                document.getElementById("months").innerHTML = response.months;
                document.getElementById("days").innerHTML = response.days;
                document.getElementById("hours").innerHTML = response.hours;
                document.getElementById("minutes").innerHTML = response.minutes;
                document.getElementById("seconds").innerHTML = response.seconds;
            }

            function countdown() {
                var request = new XMLHttpRequest();

                request.onreadystatechange = function() {
                    if (request.status == 200 && request.readyState == 4) {
                        var response = JSON.parse(request.responseText);
                        updateCountdown(response);
                    }
                };

                request.open("GET", "countdownProcess.php", true);
                request.send();
            }

            setInterval(countdown, 1000);

            // js for display a chart in adminPanel.php
            var todaySellings = <?php echo $todaySellings; ?>;
            var monthlySellings = <?php echo $monthlySellings; ?>;
            var totalSellings = <?php echo $totalSellings; ?>;
            var totalEngagements = <?php echo $totalEngagements; ?>;

            console.log("todaySellings:", todaySellings);
            console.log("monthlySellings:", monthlySellings);
            console.log("totalSellings:", totalSellings);
            console.log("totalEngagements:", totalEngagements);

            var data = {
                labels: ["Today Sellings", "Monthly Sellings", "Total Sellings", "Total Engagements"],
                datasets: [{
                    label: "Dashboard",
                    backgroundColor: ["#aba796", "#2f2f35", "#aba796", "#2f2f35"],
                    borderColor: "#000",
                    borderWidth: 2,
                    data: [todaySellings, monthlySellings, totalSellings, totalEngagements],
                }],
            };

            var options = {
                responsive: true,
                scales: {
                    x: {
                        ticks: {
                            color: '#000',
                            font: {
                                size: 8,
                                weight: 'bold',
                                family: 'Poller One',
                            },
                            borderColor: "#000",
                            borderWidth: 1
                        }
                    },
                    y: {
                        ticks: {
                            color: '#000',
                            font: {
                                size: 8,
                                weight: 'bold',
                                family: 'Poller One',
                            },
                            borderColor: "#000",
                            borderWidth: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Dashboard',
                        font: {
                            size: 20,
                            weight: 'bold',
                            family: 'Poller One',
                        },
                        color: '#000'
                    }
                }
            };

            var ctx = document.getElementById("myChart").getContext("2d");

            var myChart = new Chart(ctx, {
                type: "bar",
                data: data,
                options: options
            });
        </script>

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