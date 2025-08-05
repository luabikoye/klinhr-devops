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

    <title>Change Password | Job Portal | KlinHR</title>

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
                <div id="dashboard_nav_menu1h">Change Password</div>
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
            <div class="row">
                <div class="col-md-2"></div>
                <form action="proc_change_password" method="post" enctype="multipart/form-data" class="col-md-8">
                    <div id="change_phead">Change Password</div>
                    <!-- <p id="change_pp">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius </p> -->
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
                    <p id="change_pp2">Old Password</p>
                    <div class="loginPageR-field">
                        <div id="loginPageR-fielda"><i class="fa-solid fa-unlock"></i></div>
                        <div id="loginPageR-fieldb"><img src="./dist/images/ll.png" class="img-fluid"></div>
                        <div id="loginPageR-fieldc"><input type="password" name="current_password" placeholder="Enter your old password"></div>
                    </div>

                    <p id="change_pp2">New Password</p>
                    <div class="loginPageR-field">
                        <div id="loginPageR-fielda"><i class="fa-solid fa-unlock"></i></div>
                        <div id="loginPageR-fieldb"><img src="./dist/images/ll.png" class="img-fluid"></div>
                        <div id="loginPageR-fieldc"><input type="password" name="new_pass" placeholder="Enter a new password" value="<?= $new_pass ?>"></div>
                    </div>

                    <p id="change_pp2">Confirm Password</p>
                    <div class="loginPageR-field">
                        <div id="loginPageR-fielda"><i class="fa-solid fa-unlock"></i></div>
                        <div id="loginPageR-fieldb"><img src="./dist/images/ll.png" class="img-fluid"></div>
                        <div id="loginPageR-fieldc"><input type="password" name="confirm_pass" placeholder="Confirm new password" value="<?= $confirm_pass ?>"></div>
                    </div>
                    <div id="change_pp_btn">
                        <button type="submit">Change Password</button>
                    </div>
                </form>
            </div>
        </div>

    </div>






</body>

</html>