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

    <title>Applied Job | KlinHR Portal</title>

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
                            <div id="changeph">Applied Job</div>
                            <div class="appliedJobsro">
                                <div class="appliedJobsro1"><?= $profile_num ?> Applied Job(s)</div>
                            </div>
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
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="border-top: none; border-bottom: none;">Company</th>
                                            <th scope="col" style="border-top: none; border-bottom: none;">Job Title</th>
                                            <th scope="col" style="border-top: none; border-bottom: none;">Qualification</th>
                                            <th scope="col" style="border-top: none; border-bottom: none;">Date Posted</th>
                                            <th scope="col" style="border-top: none; border-bottom: none;">Deadline</th>
                                            <th scope="col" style="border-top: none; border-bottom: none;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                            <tr>
                                                <th scope="row" style="border-top: none;"><?= $notification_row['client_name'] ?></th>
                                                <td style="border-top: none;">
                                                    <div id="apjbh"><?= ucwords($notification_row['job_title']) ?> <br> <button><?= $notification_row['job_type'] ?></button> <i class="fa-solid fa-location-dot"></i> <span><?= $notification_row['state'] ?>.</span></div>
                                                </td>
                                                <td style="border-top: none;"><?= $notification_row['qualification'] ?></td>
                                                <td style="border-top: none;"><?= long_date($notification_row['date_posted']) ?></td>
                                                <td style="border-top: none;"><?= long_date($notification_row['deadline']) ?></td>
                                                <td style="border-top: none;"><button type="button"><a title="Delete Application" href="delete_application?id=<?= base64_encode($notification_row['id']); ?>&status=<?= base64_encode($notification_row['status']); ?>" onclick="return confirm('Are you sure you want to WITHDRAW this application? This action cannot be undone')" style="color:#fff">Withdraw Application</a></button></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

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


</body>

</html>