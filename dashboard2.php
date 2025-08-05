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

if(!isset($_GET['glo_search']))
{
    $job_query = "select * from job_post where  status = 'Approved' and deadline > '$today' order by id desc limit 0,5";
}else{
     $job_query = "select * from job_post where job_title like '%".$_GET['glo_search']."%' and status = 'Approved' and deadline > '$today' order by id desc limit 0,20";
}
$job_result = $db->query($job_query);
$job_num = mysqli_num_rows($job_result);


$job_all = "select * from job_post where  status = 'Approved' && deadline > '$today'";
$job_all_result = $db->query($job_all);
$job_all_num = mysqli_num_rows($job_all_result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Dashboard | Job Portal | KlinHR</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="dist/css/bootstrap.css">

    <link href="dist/font-awesome/css/all.css" rel="stylesheet" type="text/css">

    <link rel="icon" href="./dist/images/favicon.png" />

    <link href="dist/css/animate.css" rel="stylesheet">

    <link href="dist/css/owl.carousel.css" rel="stylesheet">

    <link href="dist/css/owl.theme.default.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="dist/js/jquery.3.4.1.min.js"></script>

    <script src="dist/js/popper.js" type="text/javascript"></script>

    <script src="dist/js/bootstrap.js" type="text/javascript"></script>

    <script src="dist/js/owl.carousel.js"></script>


    <!-- Main Stylesheet -->

    <link href="dist/style.css" rel="stylesheet" type="text/css" media="all">

    <script src="dist/js/wow.min.js"></script>
    <script>
    new WOW().init();
    </script>
</head>

<body>


    <?php include('sidebar.php') ?>

    <div class="content">
        <div class="dashboard_nav_menu">
            <div class="dashboard_nav_menu1">
                <div id="dashboard_nav_menu1h">Dashboard</div>
            </div>
            <div class="dashboard_nav_menu2">
                <i class="fa-solid fa-magnifying-glass"></i>
                <form action="dashboard" method="GET">
                    <input type="text" placeholder="Search for Job..." name="glo_search">
                </form>
            </div>
            <div class="dashboard_nav_menu3">
                <div id="dashboard_nav_menu31">
                    <?php include('notify-bell.php'); ?>
                    <div id="dashboard_nav_menu31b"><img src="./dist/images/dnl.png" class="img-fluid"></div>
                </div>
                <div id="dashboard_nav_menu32">
                    <div id="dash_userimg"><img
                            src="<?php echo show_img('uploads/documents/' . $profile_row['passport']); ?>"
                            class="img-fluid" style="height: 40px; width: 40px;"></div>
                    <div id="dash_username">Hello <?php echo get_info($_SESSION['candidate_id'], 'firstname'); ?></div>
                </div>
            </div>
        </div>

        <div class="content_body">
            <div class="dashboard-chart">
                <?php
                if ($_GET['updated'] == 'no' || $profile_row['completed'] != 'updated') {
                ?>
                <div data-dismiss="alert" class="alert alert-danger">Your profile needs to be updated before you can
                    apply for a job. . Please <a href="profile?nav=1">complete your profile</a> before you can apply for
                    a job
                </div>

                <?php
                }
                ?>
                <?php

                if(!isset($_GET['glo_search']))
                {
                    ?>
                <div class="row">
                    <div class="col-md-7">

                        <div class="dashboard-chart_box">
                            <div id="dashboard-chart_boxhd">New Updates</div>
                            <p style="font-size: 12px;">Quick run down on your dashboard</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="dashboard-chart_box2">
                                        <div class="dashboard-chart_box2a"><i
                                                class="fa-solid fa-circle-exclamation"></i></div>
                                        <div class="dashboard-chart_box2b"><?php echo $job_all_num; ?> Jobs
                                            Vacancies<br><span>Open</span></div>
                                    </div>
                                    <div class="dashboard-chart_box2">
                                        <div class="dashboard-chart_box2a"
                                            style="background-color: #BFE4F8; color: #093F68;"><i
                                                class="fa-solid fa-eye"></i></div>
                                        <div class="dashboard-chart_box2b"><?php echo $application_num; ?> Job
                                            Applications <br><span>Applied</span></div>
                                    </div>
                                    <div class="dashboard-chart_box2">
                                        <div class="dashboard-chart_box2a"
                                            style="background-color: #B6E6D9; color: #006E33;"><i
                                                class="fa-solid fa-briefcase"></i></div>
                                        <div class="dashboard-chart_box2b"><?php echo $new_notification_num; ?> Messages
                                            <br><span>Unread</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 dashboard-chart_box3">
                                    <img src="./dist/images/dban.png" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="dashboard-chart_boxx">
                            <div class="dashboard-chart_box4">
                                <div class="dashboard-chart_box4a">Total Applications <br> <span>Weekly Application
                                        updates</span></div>
                                <div class="dashboard-chart_box4b">This week</div>
                            </div>
                            <br>
                            <img src="./dist/images/chart.png" class="img-fluid">
                        </div>
                    </div>
                </div>

                <?php } ?>

                <div id="latest_jobspageBoxrec" style="margin-top: 60px;">
                    <?php if(!isset($_GET['glo_search'])) {
                        ?>
                    Latest Jobs
                    <?php } else { ?>

                    Serach Result for: <?php echo $_GET['glo_search']; ?>
                    <?php } ?>
                </div> | <a href="./latest-jobs.php">View all vacancies</a>

                <?php
                for (
                    $i = 0;
                    $i < $job_num;
                    $i++
                ) {
                    $row = mysqli_fetch_array($job_result);

                ?>
                <div class="latest_jobspageBox">
                    <img src="./dist/images/rec.png" class="img-fluid">
                    <div class="latest_jobspageBoxnav">
                        <div class="latest_jobspageBoxnavR"><?php echo $row['job_title'] ?></div>
                        <!-- <div class="latest_jobspageBoxnavR">Software Engineer</div> -->
                        <!-- <div class="latest_jobspageBoxnavL"><i class="fa-solid fa-heart"></i>
                        </div> -->
                    </div>

                    <div id="latest_jobspagesb"><?php echo get_client_name($row['client_id']); ?></div>

                    <div class="latest_jobspageBoxmenu">
                        <div class="latest_jobspageBoxmenu1">
                            <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-briefcase"></i></div>
                            <div class="latest_jobspageBoxmenu1b"><?php echo $row['job_type'] ?></div>
                        </div>
                        <div class="latest_jobspageBoxmenu1">
                            <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-briefcase"></i></div>
                            <div class="latest_jobspageBoxmenu1b"><i
                                    class="fa-solid fa-dollar-sign"></i><?php echo $row['salary'] ?></div>
                        </div>
                        <div class="latest_jobspageBoxmenu1">
                            <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="latest_jobspageBoxmenu1b"><?php echo $row['state'] ?></div>
                        </div>
                    </div>

                    <p><?php echo $row['description'] ?></p>

                    <img src="./dist/images/rec1.png" alt="" class="img-fluid">

                    <div class="latest_jobspageBoxft">
                        <div class="latest_jobspageBoxft1" style="font-weight: 500;">
                            <?php echo get_time_ago($row['date_posted']); ?></div>
                        <!-- <div class="latest_jobspageBoxft2"><a href="job-description"><button>Apply</button></a></div> -->
                        <div class="priceApp2"><a href="job-description?valid=<?= base64_encode($row['id']); ?>"
                                target="_blank"><button id="ftBtn">Apply</button></a></div>
                    </div>
                </div>
                <?php } ?>

                <!-- <div class="latest_jobspageBox">
                <div class="latest_jobspageBoxnav">
                    <div class="latest_jobspageBoxnavR">Software Engineer</div>
                    <div class="latest_jobspageBoxnavL" style="color: #237FFE;"><i class="fa-regular fa-heart"></i></div>
                </div>

                <div id="latest_jobspagesb">Upwork Community</div>  

                <div class="latest_jobspageBoxmenu">
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a" ><i class="fa-solid fa-briefcase"></i></div>
                        <div class="latest_jobspageBoxmenu1b">Part Time</div>
                    </div>
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-briefcase"></i></div>
                        <div class="latest_jobspageBoxmenu1b"><i class="fa-solid fa-dollar-sign"></i>48 - 50/hour</div>
                    </div>
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="latest_jobspageBoxmenu1b">Lagos</div>
                    </div>
                </div>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa sollicitudin amet augue. Nibh metus a semper purus mauris duis. </p>

                <img src="./dist/images/rec1.png" alt="" class="img-fluid">

                <div class="latest_jobspageBoxft">
                    <div class="latest_jobspageBoxft1" style="font-weight: 500;">5 Days</div>
                    <div class="latest_jobspageBoxft2"><a href="apply"><button>Apply</button></a></div>
                </div>
            </div>

            <div class="latest_jobspageBox">
                <div class="latest_jobspageBoxnav">
                    <div class="latest_jobspageBoxnavR">Software Engineer</div>
                    <div class="latest_jobspageBoxnavL" style="color: #237FFE;"><i class="fa-regular fa-heart"></i></div>
                </div>

                <div id="latest_jobspagesb">Upwork Community</div>  

                <div class="latest_jobspageBoxmenu">
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a" ><i class="fa-solid fa-briefcase"></i></div>
                        <div class="latest_jobspageBoxmenu1b">Part Time</div>
                    </div>
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-briefcase"></i></div>
                        <div class="latest_jobspageBoxmenu1b"><i class="fa-solid fa-dollar-sign"></i>48 - 50/hour</div>
                    </div>
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="latest_jobspageBoxmenu1b">Lagos</div>
                    </div>
                </div>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa sollicitudin amet augue. Nibh metus a semper purus mauris duis. </p>

                <img src="./dist/images/rec1.png" alt="" class="img-fluid">

                <div class="latest_jobspageBoxft">
                    <div class="latest_jobspageBoxft1" style="font-weight: 500;">5 Days</div>
                    <div class="latest_jobspageBoxft2"><a href="apply"><button>Apply</button></a></div>
                </div>
            </div>

            <div class="latest_jobspageBox">
                <div class="latest_jobspageBoxnav">
                    <div class="latest_jobspageBoxnavR">Software Engineer</div>
                    <div class="latest_jobspageBoxnavL" style="color: #237FFE;"><i class="fa-regular fa-heart"></i></div>
                </div>

                <div id="latest_jobspagesb">Upwork Community</div>  

                <div class="latest_jobspageBoxmenu">
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a" ><i class="fa-solid fa-briefcase"></i></div>
                        <div class="latest_jobspageBoxmenu1b">Part Time</div>
                    </div>
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-briefcase"></i></div>
                        <div class="latest_jobspageBoxmenu1b"><i class="fa-solid fa-dollar-sign"></i>48 - 50/hour</div>
                    </div>
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="latest_jobspageBoxmenu1b">Lagos</div>
                    </div>
                </div>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa sollicitudin amet augue. Nibh metus a semper purus mauris duis. </p>

                <img src="./dist/images/rec1.png" alt="" class="img-fluid">

                <div class="latest_jobspageBoxft">
                    <div class="latest_jobspageBoxft1" style="font-weight: 500;">5 Days</div>
                    <div class="latest_jobspageBoxft2"><a href="apply"><button>Apply</button></a></div>
                </div>
            </div>

            <div class="latest_jobspageBox">
                <div class="latest_jobspageBoxnav">
                    <div class="latest_jobspageBoxnavR">Software Engineer</div>
                    <div class="latest_jobspageBoxnavL" style="color: #237FFE;"><i class="fa-regular fa-heart"></i></div>
                </div>

                <div id="latest_jobspagesb">Upwork Community</div>  

                <div class="latest_jobspageBoxmenu">
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a" ><i class="fa-solid fa-briefcase"></i></div>
                        <div class="latest_jobspageBoxmenu1b">Part Time</div>
                    </div>
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-briefcase"></i></div>
                        <div class="latest_jobspageBoxmenu1b"><i class="fa-solid fa-dollar-sign"></i>48 - 50/hour</div>
                    </div>
                    <div class="latest_jobspageBoxmenu1">
                        <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="latest_jobspageBoxmenu1b">Lagos</div>
                    </div>
                </div>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa sollicitudin amet augue. Nibh metus a semper purus mauris duis. </p>

                <img src="./dist/images/rec1.png" alt="" class="img-fluid">

                <div class="latest_jobspageBoxft">
                    <div class="latest_jobspageBoxft1" style="font-weight: 500;">5 Days</div>
                    <div class="latest_jobspageBoxft2"><a href="apply"><button>Apply</button></a></div>
                </div>
            </div>

            <div class="latest_jobspageBox_navi">
                <button id="latest_jobspageBox_btn"><i class="fa-solid fa-chevron-left"></i> Prev</button>
                <div id="myDIV">
                        <button class="btn active">1</button>
                        <button class="btn">2</button>
                        <button class="btn">3</button>
                        <button class="btn">4</button>
                </div>
                <button id="latest_jobspageBox_btn">Next <i class="fa-solid fa-chevron-right"></i></button>
            </div> -->

            </div>
        </div>

    </div>


    <script>
    var header = document.getElementById("myDIV");
    var btns = header.getElementsByClassName("btn");
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            this.className += " active";
        });
    }
    </script>



</body>

</html>