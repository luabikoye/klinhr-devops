<?php

ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
require_once('outsourcehr-admin/inc/fns.php');

if ($_GET['secured']) {
    $_SESSION['secured'] = $_GET['secured'];
}

if ($_GET['valid']) {
    $id = base64_decode($_GET['valid']);
}

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Set the number of records per page
$records_per_page = 5;

// Calculate the offset
$offset = ($page - 1) * $records_per_page;

$today = today();
$cat = get_val('jobseeker', 'email', $_SESSION['Klin_user'], 'industry');
$search_query = "SELECT * FROM job_post WHERE category = '$cat' AND status = 'Approved' AND deadline > '$today'";
$job_result = $db->query($search_query);
$job_num = mysqli_num_rows($job_result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Job Offers | KlinHR Portal</title>

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
                    <div class="dashboard_body">
                        <div class="dashboard_body_nav">
                            <div class="dashboard_body_navL">
                                <div id="dashboard_body_navLsearch">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" placeholder="Search...">
                                </div>
                            </div>
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
                        <div class="container">
                            <div id="changeph">Job Offers</div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="appliedJobsro">
                                        <div class="appliedJobsro1"><?= $job_num ?> Applied Job</div>
                                    </div>

                                    <?php


                                    // Fetch total number of records
                                    $total_query = "SELECT COUNT(*) FROM job_post WHERE category = '$cat' AND status = 'Approved' AND deadline > '$today'";
                                    $total_result = mysqli_query($db, $total_query);
                                    $total_rows = mysqli_fetch_array($total_result)[0];

                                    // Calculate total pages
                                    $total_pages = ceil($total_rows / $records_per_page);

                                    // Fetch records for the current page                                   
                                    for ($i = 0; $i < $job_num; $i++) {
                                        $row = mysqli_fetch_array($job_result);

                                    ?>

                                        <div class="job_offersTable">
                                            <div class="job_offersTableRow">
                                                <div class="job_offersTableRow1">
                                                    <div id="job_offersTableRow1h"><?= ucwords($row['job_title']) ?></div>
                                                    <button><?= $row['job_type'] ?></button> <i class="fa-solid fa-location-dot"></i> <span><?= $row['state'] ?>.</span>
                                                </div>
                                                <!-- <div class="job_offersTableRow2"><img src="./new_dist/images/j1.png" class="img-fluid"></div> -->
                                            </div>
                                            <div id="job_offersTableRow2">
                                                <?php $qualifications = explode(',', $row['qualification']); // Convert comma-separated string to array
                                                foreach ($qualifications as $value) { ?>
                                                    <div id="job_offersTableRow2-item"><?= htmlspecialchars(trim($value)); ?></div>
                                                <?php } ?>
                                            </div>
                                            <div id="job_offersTableRow3">
                                                <div id="job_offersTableRow3a">Posted: <?= get_time_ago($row['date_posted']) ?></div>
                                                <a href="job-description?valid=<?= base64_encode($row['id']); ?>" id="job_offersTableRow3b"><button>Apply Now</button></a>
                                            </div>
                                        </div>
                                    <?php } ?>


                                    <div class="tablenav">
                                        <?php
                                        $displayRange = 3; // Number of pages to display at the beginning and end
                                        $ellipsisThreshold = 2; // Pages near the current page to always show
                                        if ($page > 1): ?>
                                            <a href="?page=<?= $page - 1; ?>" id="tablenavlista"><i class="fa-solid fa-chevron-left"></i></a>
                                        <?php endif; ?>
                                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                            <!-- <a href="?page=<?= $i; ?>" id="tablenavlist<?= $i == $page ? 'b' : 'c'; ?>"><?= $i; ?></a> -->
                                        <?php endfor; ?>
                                        <?php if ($page < $total_pages): ?>
                                            <a href="?page=<?= $page + 1; ?>" id="tablenavlistd"><i class="fa-solid fa-chevron-right"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>