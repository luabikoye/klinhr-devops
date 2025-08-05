<?php

ob_start();
session_start();

include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// // include('timeout.php');
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

    <title>Profile | Job Portal | KlinHR</title>

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
                <div id="dashboard_nav_menu1h">Profile</div>
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
            <div class="profile_banner"></div>
            <div class="row">
                <!-- <div class="col-md-1"></div> -->
                <div class="col-md-11">
                    <div class="profile_bodyBox">
                        <?php include('tab.php') ?>
                        <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
                        <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
                        <?php if ($personal) echo '<div class="alert alert-warning">' . $personal . '</div>'; ?>

                        <form action="proc_reference.php" method="post">
                            <?php
                            if ($_GET['updated'] == 'no' || $profile_row['completed'] != 'updated') {
                            ?>
                                <div data-dismiss="alert" class="alert alert-danger">Your profile needs to be updated before
                                    you can apply for a job. . Please <a href="profile">complete your profile</a> before you
                                    can apply for a job</div>

                            <?php
                            }
                            ?>
                            <?php if ($_GET['succ'] == 'yes') { ?>

                                <p>
                                <div class="alert alert-success">Your social media links have been saved succesfully. </div>
                                </p>

                            <?php } ?>
                            <h3>First Reference</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Referee Name</p>
                                    <input type="text" name="refName" placeholder="Name of Referee"
                                        value="<?php echo $profile_row['refName']; ?>" autocomplete="new-password">

                                </div>
                                <div class="col-md-6">
                                    <p>Email</p>
                                    <input type="email" placeholder="Enter Referee email" name="refEmail"
                                        value="<?php echo $profile_row['refEmail']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Phone</p>
                                    <input type="phone" placeholder="Enter Referee phone number" name="refPhone"
                                        value="<?php echo $profile_row['refPhone']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Position</p>
                                    <input type="text" placeholder="Enter Position" name="refPosition"
                                        value="<?php echo $profile_row['refPosition']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>City</p>
                                    <input type="text" placeholder="Enter City" name="refCity"
                                        value="<?php echo $profile_row['refCity']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>State</p>
                                    <select class="form-select" name="refState" id="refState">
                                        <?php if ($profile_row['refState']) {
                                            echo '<option>' . $profile_row['refState'] . '</option>';
                                        }
                                        ?>
                                        <?php list_state(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Company</p>
                                    <input type="text" placeholder="Enter Company" name="refCompany"
                                        value="<?php echo $profile_row['refCompany']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Address</p>
                                    <input type="text" placeholder="Enter Address" name="refAddress"
                                        value="<?php echo $profile_row['refAddress']; ?>" autocomplete="new-password">
                                </div>
                            </div>
                            <h3>Second Referee</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Referee Name</p>
                                    <input type="text" placeholder="Name of Referee" name="refName2"
                                        value="<?php echo $profile_row['refName2']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Email</p>
                                    <input type="email" placeholder="Enter Referee email" name="refEmail2"
                                        value="<?php echo $profile_row['refEmail2']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Phone</p>
                                    <input type="phone" placeholder="Enter Referee phone number" name="refPhone2"
                                        value="<?php echo $profile_row['refPhone2']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Position</p>
                                    <input type="text" placeholder="Enter Position" name="refPosition2"
                                        value="<?php echo $profile_row['refPosition2']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>City</p>
                                    <input type="text" placeholder="Enter City" name="refCity2"
                                        value="<?php echo $profile_row['refCity2']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>State</p>
                                    <select class="form-select" name="refState2" id="refState2">
                                        <?php if ($profile_row['refState2']) {
                                            echo '<option>' . $profile_row['refState2'] . '</option>';
                                        }
                                        ?>
                                        <?php list_state(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Company</p>
                                    <input type="text" placeholder="Enter Company" name="refCompany2"
                                        value="<?php echo $profile_row['refCompany2']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Address</p>
                                    <input type="text" placeholder="Enter Address" name="refAddress2"
                                        value="<?php echo $profile_row['refAddress2']; ?>" autocomplete="new-password">
                                </div>
                            </div>
                            <div id="profileBody-btn">
                                <button>Save and Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

</body>

</html>