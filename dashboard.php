<?php
ob_start();
session_start();

include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
unset($_SESSION['return_id']);
if (!isset($_SESSION['Klin_user'])) {
    include('logout.php');
    exit;
}
// echo '3';
// exit;

// include('timeout.php');
// SessionCheck();


$new_notification_query = "select * from notification where candidate_id = '" . $_SESSION['candidate_id'] . "' && status = 'Unread' order by id desc ";
$new_notification_result = mysqli_query($db, $new_notification_query);
$new_notification_num = mysqli_num_rows($new_notification_result);
$new_notification_row = mysqli_fetch_array($new_notification_result);

$application_query = "select * from jobs_applied where candidate_id = '" . $_SESSION['candidate_id'] . "' order by id desc ";
$application_result = mysqli_query($db, $application_query);
$application_num = mysqli_num_rows($application_result);
$application_row = mysqli_fetch_array($application_result);

$profile_query = "select * from jobseeker where candidate_id = '" . $_SESSION['candidate_id'] . "' ";
$profile_result = $db->query($profile_query);
$profile_num = mysqli_num_rows($profile_result);
$profile_row = mysqli_fetch_array($profile_result);

if (!isset($_GET['glo_search'])) {
    $job_query = "select * from job_post where  status = 'Approved' and deadline > '$today' order by id desc limit 0,5";
} else {
    $job_query = "select * from job_post where job_title like '%" . $_GET['glo_search'] . "%' and status = 'Approved' and deadline > '$today' order by id desc limit 0,20";
}
$job_result = $db->query($job_query);
$job_num = mysqli_num_rows($job_result);


$job_all = "select * from job_post where  status = 'Approved' && deadline > '$today'";
$job_all_result = $db->query($job_all);
$job_all_num = mysqli_num_rows($job_all_result);


$saved = "select * from favourite where  candidate_id = '" . $_SESSION['candidate_id'] . "'";
$saved_result = $db->query($saved);
$saved_num = mysqli_num_rows($saved_result);

$activity = mysqli_query($db, "SELECT * FROM activity_log WHERE author = '" . $_SESSION['Klin_user'] . "' ORDER BY id DESC");
$act = mysqli_num_rows($activity);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Dashboard | KlinHR Portal</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="new_dist/css/bootstrap.css">

    <link href="new_dist/font-awesome/css/all.css" rel="stylesheet" type="text/css">

    <link rel="icon" href="./new_dist/images/fav.png" />

    <link href="new_dist/css/animate.css" rel="stylesheet">

    <link href="new_dist/css/owl.carousel.css" rel="stylesheet">

    <link href="new_dist/css/owl.theme.default.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="new_dist/js/jquery.3.4.1.min.js"></script>

    <script src="new_dist/js/popper.js" type="text/javascript"></script>

    <script src="new_dist/js/bootstrap.js" type="text/javascript"></script>

    <script src="new_dist/js/owl.carousel.js"></script>

    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>




    <!-- Main Stylesheet -->

    <link href="new_dist/style.css" rel="stylesheet" type="text/css" media="all">

    <script src="new_dist/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
</head>

<body>

    <div class="container-fluid">
        <div class="dashboard-section">
            <div class="row">
                <?php include('include/side-nav.php') ?>
                <div class="col-md-9 dashboardNavRight">
                    <div id="dashboardNavRightprofile">
                        <div class="dashboard_body_navR">
                            <div class="dashboard_body_navR1">
                                <i class="fa-regular fa-bell"></i>
                                <span></span>
                            </div>
                            <div class="dashboard_body_navR2">
                                <div class="dashboard_body_navR2a">
                                    <img src="./new_dist/images/d1.png" class="img-fluid">
                                </div>
                                <div class="dashboard_body_navR2b">
                                    <div id="dashboard_body_navR2bh"><?php echo get_info($_SESSION['candidate_id'], 'firstname'); ?> <br> <span>Online</span> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dashboardNavRightBhd">Hello <span><?php echo get_info($_SESSION['candidate_id'], 'firstname'); ?></span>, we are glad to see you again!</div>

                    <div class="row dashboardNavRightC">
                        <div class="col-md-8">
                            <div class="dashboardNavRightCa">
                                <div id="dashboardNavRightCai">Dashboard</div>
                                <div id="dashboardNavRightCaii">
                                    <div class="dashboard_body_navL">
                                        <div id="dashboard_body_navLsearch2">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                            <input type="text" placeholder="Search...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($_GET['updated'] == 'no' || $profile_row['completed'] != 'updated') {
                            ?>
                                <div class="alert alert-danger">Your profile needs to be updated before you can
                                    apply for a job. . Please <a href="my-profile">complete your profile</a> before you can apply for
                                    a job
                                </div>

                            <?php
                            }
                            ?>
                            <div class="row dash_chartboxRow">
                                <div class="col-md-6">
                                    <a href="">
                                        <div class="dash_chartbox">
                                            <div id="dash_chartboxh">Active Job Listings</div>
                                            <span><?php echo $job_all_num; ?></span>
                                            <div class="dash_chartbox2">
                                                <div class="dash_chartbox21">
                                                    <div class="circular-progress" data-inner-circle-color="#369FFF" data-percentage="100" data-progress-color="white" data-bg-color="#006BFF">
                                                        <div class="inner-circle" style="background-color: transparent;"></div>
                                                        <p class="percentage" style="color: #006bff;">0%</p>
                                                    </div>
                                                </div>
                                                <div class="dash_chartbox22">
                                                    <i class="fa-solid fa-briefcase"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="applied-job">
                                        <div class="dash_chartbox" style="background-color: #8AC53E;">
                                            <div id="dash_chartboxh">Applied Job</div>
                                            <span><?php echo $application_num; ?></span>
                                            <div class="dash_chartbox2">
                                                <div class="dash_chartbox21">
                                                    <div class="circular-progress" data-inner-circle-color="#8AC53E" data-percentage="<?= progress_percentage($job_all_num,$application_num)?>" data-progress-color="white" data-bg-color="#006838">
                                                        <div class="inner-circle"></div>
                                                        <p class="percentage">0%</p>
                                                    </div>
                                                </div>
                                                <div class="dash_chartbox22">
                                                    <i class="fa-solid fa-briefcase"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row dash_chartboxRow">
                                <div class="col-md-6">
                                    <a href="saved-jobs">
                                        <div class="dash_chartbox" style="background-color: #171717;">
                                            <div id="dash_chartboxh">Saved Jobs</div>
                                            <span><?= $saved_num?></span>
                                            <div class="dash_chartbox2">
                                                <div class="dash_chartbox21">
                                                    <div class="circular-progress" data-inner-circle-color="#171717" data-percentage="<?= progress_percentage($job_all_num,$saved_num)?>" data-progress-color="white" data-bg-color="black">
                                                        <div class="inner-circle"></div>
                                                        <p class="percentage">0%</p>
                                                    </div>
                                                </div>
                                                <div class="dash_chartbox22">
                                                    <i class="fa-regular fa-heart"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="dash_recent">
                                <div class="dash_recent1">
                                    <span><i class="fa-regular fa-bell"></i></span> Recent Activities
                                </div>
                                <div class="dash_recent2">
                                    <span><i class="fa-regular fa-calendar-days"></i></span> <?= long_date(date('Y-m-d'))?>
                                </div>
                            </div>

                            <?php                            
                            
                            for ($i = 0; $i < $act; $i++) {
                                $act_row = mysqli_fetch_array($activity);
                                ?>
                            <div class="dash_recentact">
                                <div class="dash_recentacta"><i class="fa-solid fa-briefcase"></i></div>
                                <div class="dash_recentactb"><?= $act_row['action_taken']?>.</div>
                                <div class="dash_recentactc"><?= get_time_ago($act_row['date'])?></div>
                            </div>
                            <?php }?>
                        </div>
                        <div class="col-md-4">
                            <div id="dashstat">Statistics</div>

                            <div id="dashstats">Job Rating</div>
                            <p id="jbrp">Lorem ipsum dolor sit amet, consectetur</p>

                            <div class="dashstatsRow">
                                <div class="dashstatsRow1">
                                    <div class="block">
                                        <div class="box" style="background-color: #6463D6; box-shadow: 0 0 5px 3px #6463D6;">
                                            <p class="number">
                                                <span class="num">85</span>
                                                <span class="sub">%</span>
                                            </p>
                                            <p class="title">Listings</p>
                                        </div>
                                        <span class="dots"></span>
                                        <svg class="svg">
                                            <defs>
                                                <linearGradient id="gradientStyle">
                                                    <stop offset="0%" stop-color="#6463D6" />
                                                    <stop offset="100%" stop-color="#6463D6" />
                                                </linearGradient>
                                            </defs>
                                            <circle class="circle" cx="90" cy="90" r="80" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="dashstatsRow2">
                                    <div class="block">
                                        <div class="box" style="background-color: #F99C30; box-shadow: 0 0 5px 3px #F99C30;">
                                            <p class="number">
                                                <span class="num">85</span>
                                                <span class="sub">%</span>
                                            </p>
                                            <p class="title">Saved</p>
                                        </div>
                                        <span class="dots"></span>
                                        <svg class="svg">
                                            <defs>
                                                <linearGradient id="gradientStyle2">
                                                    <stop offset="0%" stop-color="#F99C30" />
                                                    <stop offset="100%" stop-color="#2FBFDE" />
                                                </linearGradient>
                                            </defs>
                                            <circle class="circle" cx="90" cy="90" r="80" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="dashstatsRow3">
                                    <div class="block">
                                        <div class="box" style="background-color: #2FBFDE; box-shadow: 0 0 5px 3px #2FBFDE">
                                            <p class="number">
                                                <span class="num">92</span>
                                                <span class="sub">%</span>
                                            </p>
                                            <p class="title">Job Alert</p>
                                        </div>
                                        <span class="dots"></span>
                                        <svg class="svg">
                                            <defs>
                                                <linearGradient id="gradientStyle">
                                                    <stop offset="0%" stop-color="#565656" />
                                                    <stop offset="100%" stop-color="#b7b5b5" />
                                                </linearGradient>
                                            </defs>
                                            <circle class="circle" cx="90" cy="90" r="80" />
                                        </svg>
                                    </div>
                                </div>
                            </div>


                            <div id="actVt">
                                <div id="actVt1">Activity</div>
                                <div id="actVt2">
                                    <div id="actVt21">Day</div>
                                    <div id="actVt22">Week</div>
                                    <div id="actVt21">Month</div>
                                </div>
                            </div>
                            <canvas id="myChart" style="width:100%;max-width:600px;height:30%;"></canvas>
                            <!-- <div id="statImg2"><img src="./new_dist/images/stat2.png" class="img-fluid"></div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        const block = document.querySelectorAll('.block');
        window.addEventListener('load', function() {
            block.forEach(item => {
                let numElement = item.querySelector('.num');
                let num = parseInt(numElement.innerText);
                let count = 0;
                let time = 2000 / num;
                let circle = item.querySelector('.circle');
                setInterval(() => {
                    if (count == num) {
                        clearInterval();
                    } else {
                        count += 1;
                        numElement.innerText = count;
                    }
                }, time)
                circle.style.strokeDashoffset = 503 - (503 * (num / 100));
                let dots = item.querySelector('.dots');
                dots.style.transform =
                    `rotate(${360 * (num / 100)}deg)`;
                if (num == 100) {
                    dots.style.opacity = 0;
                }
            })
        });
    </script>






    <script>
        const circularProgress = document.querySelectorAll(".circular-progress");

        Array.from(circularProgress).forEach((progressBar) => {
            const progressValue = progressBar.querySelector(".percentage");
            const innerCircle = progressBar.querySelector(".inner-circle");
            let startValue = 0,
                endValue = Number(progressBar.getAttribute("data-percentage")),
                speed = 50,
                progressColor = progressBar.getAttribute("data-progress-color");

            // Handle the case where endValue is 0
            if (endValue === 0) {
                progressValue.textContent = "0%";
                progressValue.style.color = progressColor;
                innerCircle.style.backgroundColor = progressBar.getAttribute("data-inner-circle-color");
                progressBar.style.background = `conic-gradient(${progressColor} 0deg, ${progressBar.getAttribute("data-bg-color")} 0deg)`;
                return; // Exit the function early
            }

            const progress = setInterval(() => {
                startValue++;
                progressValue.textContent = `${startValue}%`;
                progressValue.style.color = `${progressColor}`;

                innerCircle.style.backgroundColor = `${progressBar.getAttribute(
                "data-inner-circle-color"
            )}`;

                progressBar.style.background = `conic-gradient(${progressColor} ${
                startValue * 3.6
            }deg, ${progressBar.getAttribute("data-bg-color")} 0deg)`;

                if (startValue === endValue) {
                    clearInterval(progress);
                }
            }, speed);
        });
    </script>


    <script>
        const xValues = ["Mon", "Tues", "Wed", "Thurs", "Fri", "Sat", "Sun"];
        const yValues = [46, 44, 43, 50, 49, 48, 46];
        const barColors = ["#2FBFDE", "#2FBFDE", "#2FBFDE", "#006BFF", "#2FBFDE", "#2FBFDE", "#2FBFDE"];

        new Chart("myChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    //   text: "World Wine Production 2018"
                }
            }
        });
    </script>



</body>

</html>