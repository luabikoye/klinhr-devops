<?php

ob_start();
session_start();

include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();


$profile_query = "select * from jobseeker where candidate_id = '" . $_SESSION['candidate_id'] . "' ";
$profile_result = $db->query($profile_query);
$profile_num = mysqli_num_rows($profile_result);
$profile_row = mysqli_fetch_array($profile_result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Change Password | KlinHR Portal</title>

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
                            <div id="changeph">Change Password</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="proc_change_password" method="post" enctype="multipart/form-data" class="changepFld">
                                        <?php
                                        if ($success) echo '<div  class="alert alert-success alert-dismissible mt-2">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                            <strong>
                                            ' . $success . '
                                            </strong>
                                            </div>';
                                        ?>

                                        <?php
                                        if ($error) echo '<div  class="alert alert-danger alert-dismissible mt-2">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>
                                            ' . $error . '
                                            </strong>
                                            </div>';
                                        ?>
                                        <input type="password" name="current_password" placeholder="Old Password">
                                        <input type="password" placeholder="New Password" name="new_pass">
                                        <input type="password" placeholder="Confirm Password" name="confirm_pass">
                                        <button>Update Password</button>
                                    </form>
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