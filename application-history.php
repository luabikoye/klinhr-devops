<?php

ob_start();
session_start();

include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();
$today = today();


$profile_query = "select * from jobseeker where candidate_id = '" . $_SESSION['candidate_id'] . "' ";
$profile_result = $db->query($profile_query);
$profile_num = mysqli_num_rows($profile_result);
$profile_row = mysqli_fetch_array($profile_result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Application History | Job Portal | KlinHR</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="dist/css/bootstrap.css">

    <link href="dist/font-awesome/css/all.css" rel="stylesheet" type="text/css">

    <link rel="icon" href="./dist/images/favicon.png" />

    <link href="dist/css/animate.css" rel="stylesheet">

    <link href="dist/css/owl.carousel.css" rel="stylesheet">

    <link href="dist/css/owl.theme.default.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                <div id="dashboard_nav_menu1h">Application History</div>
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
                    <div id="dash_userimg"><img src="<?php echo show_img('uploads/documents/' . $profile_row['passport']); ?>" class="img-fluid" style="height: 40px; width: 40px;"></div>
                    <div id="dash_username">Hello <?php echo get_info($_SESSION['candidate_id'], 'firstname'); ?></div>
                </div>
            </div>
        </div>

        <div class="content_body">
            <div id="app_history">Manage and Track the Status of Your Job Applications</div>
            <?php if ($update_error) echo $update_error; ?>
            <?php if ($error) echo $error; ?>
            <?php if ($success) {
                echo $success;
            } ?>
            <?php if ($update_success) {
                echo $update_success;
            }
            ?>
            <?php if ($_GET['del'] == 'success') {
                echo '<div class="alert alert-success alert-dismissible mt-2">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Application Withdrawn successfully</strong>
                             </div>';
            }
            ?>
            <?php if ($_GET['del'] == 'failed') {
                echo '<div class="alert alert-danger alert-dismissible mt-2">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Unable to withdraw Application. You have been moved beyond the application stage</strong>
                             </div>';
            }
            ?>
            <?php
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

            // Set the number of records per page
            $records_per_page = 5;

            // Calculate the offset
            $offset = ($page - 1) * $records_per_page;

            // Fetch total number of records
            $total_query = "SELECT COUNT(*) FROM jobs_applied WHERE candidate_id = '" . $_SESSION['candidate_id'] . "'";
            $total_result = mysqli_query($db, $total_query);
            $total_rows = mysqli_fetch_array($total_result)[0];

            // Calculate total pages
            $total_pages = ceil($total_rows / $records_per_page);

            // Fetch records for the current page
            $notification_query = "SELECT * FROM jobs_applied WHERE candidate_id = '" . $_SESSION['candidate_id'] . "' LIMIT $offset, $records_per_page";
            $notification_result = mysqli_query($db, $notification_query);

            // Display job applications
            while ($notification_row = mysqli_fetch_assoc($notification_result)) {
            ?>
                <div class="app_historyBox">
                    <div class="app_historyBoxnav">
                        <div class="app_historyBoxnav1"><?= $notification_row['job_title']; ?></div>
                        <div class="app_historyBoxnav2">
                            <a data-toggle="tooltip" data-placement="top" title="Delete Application" href="delete_application?id=<?= base64_encode($notification_row['id']); ?>&status=<?= base64_encode($notification_row['status']); ?>" onclick="return confirm('Are you sure you want to WITHDRAW this application? This action cannot be undone')">
                                <button>Withdraw Application</button>
                            </a>
                        </div>
                    </div>
                    <div id="app_historyBoxsub"><?= $notification_row['client_name']; ?></div>
                    <p style="font-size: 10px; font-weight: 300; color: #5D5A5A; margin-bottom: 14px;">Posted on <?= long_date($notification_row['date_posted']); ?></p>
                    <div class="latest_jobspageBoxmenu">
                        <div class="latest_jobspageBoxmenu1">
                            <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-briefcase"></i></div>
                            <div class="latest_jobspageBoxmenu1b"><?= $notification_row['job_type']; ?></div>
                        </div>
                        <div class="latest_jobspageBoxmenu1">
                            <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-dollar-sign"></i></div>
                            <div class="latest_jobspageBoxmenu1b"><?= get_job_salary($notification_row['job_id']); ?></div>
                        </div>
                        <div class="latest_jobspageBoxmenu1">
                            <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="latest_jobspageBoxmenu1b"><?= $notification_row['state']; ?></div>
                        </div>
                    </div>
                    <div class="app_historyBoxapp-date">
                        <p>Application Date: <span><?= long_date($notification_row['date_applied']); ?></span></p>
                        <p>Monthly Salary Expectation (Gross): <span><i class="fa-solid fa-dollar-sign"></i><?= $notification_row['expected_salary']; ?></span></p>
                        <p>Status: <span><?= $notification_row['status']; ?></span></p>
                    </div>
                </div>
            <?php } ?>

            <!-- Pagination Links -->
            <div class="latest_jobspageBox_navi">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1; ?>"><button id="latest_jobspageBox_btn"><i class="fa-solid fa-chevron-left"></i> Prev</button></a>
                <?php endif; ?>
                <!-- <div id="myDIV">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?= $i; ?>"><button class="btn <?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></button></a>
                    <?php endfor; ?>
                </div> -->
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?= $page + 1; ?>"><button id="latest_jobspageBox_btn">Next <i class="fa-solid fa-chevron-right"></i></button></a>
                <?php endif; ?>
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