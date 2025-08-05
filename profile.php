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
                        <form action="proc_profile" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div id="personal-info_pic">
                                <div id="personal-info_pic1">
                                    <img src="<?php echo show_img('uploads/documents/' . $profile_row['passport']); ?>"
                                        alt="" class="img-fluid" id="output">

                                </div>
                                <div id="personal-info_pic2">
                                    <div id="personal-info_pic2hd">
                                        <?php echo get_info($_SESSION['candidate_id'], 'firstname'); ?>
                                        <?php echo get_info($_SESSION['candidate_id'], 'lastname'); ?></div>
                                </div>
                            </div>
                            <?php
                            if ($_GET['updated'] == 'no' || $profile_row['completed'] != 'updated') {
                            ?>
                            <div data-dismiss="alert" class="alert alert-danger">Your profile needs to be updated before
                                you can apply for a job. . Please complete your profile before you can apply for a job
                            </div>

                            <?php
                            }
                            ?>
                            <?php if ($_GET['succ'] == 'yes') { ?>

                            <p>
                            <div class="alert alert-success">Your profile update it complete. </div>
                            </p>

                            <?php } ?>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>First Name</p>
                                    <input type="text" name="firstname" placeholder="Alicia"
                                        value="<?php echo $profile_row['firstname']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Last Name</p>
                                    <input type="text" name="lastname" placeholder="Johnson"
                                        value="<?php echo $profile_row['lastname']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Middle Name</p>
                                    <input type="text" name="middlename" placeholder="Johnson"
                                        value="<?php echo $profile_row['middlename']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Email</p>
                                    <input type="email" name="email" placeholder="aliciajohnson@gmail.com"
                                        value="<?php echo $profile_row['email']; ?>" readonly
                                        autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Phone</p>
                                    <input type="number" name="phone" placeholder="+234 123 4567 890"
                                        value="<?php echo $profile_row['phone']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Gender</p>
                                    <select name="gender" id="gender" class="form-select" aria-placeholder="choose one">

                                        <?php if ($profile_row['gender']) {
                                            echo '<option>' . $profile_row['gender'] . '</option>';
                                        }
                                        ?>
                                        <option value="">Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Date of Birth</p>
                                    <input type="date" class="form-select" name="dob"
                                        value="<?php echo $profile_row['dob']; ?>"></input autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Closest B/Stop</p>
                                    <input class="form-select" name="bustop"
                                        value="<?php echo $profile_row['bustop']; ?>"
                                        autocomplete="new-password"></input>
                                </div>
                                <div class="col-md-6">
                                    <p>State</p>
                                    <select name="state" class="form-select">
                                        <option selected value="<?php echo $profile_row['state']; ?>">
                                            <?php echo $profile_row['state']; ?></option>
                                        <?= list_state(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>City</p>
                                    <input class="form-select" name="local_govt"
                                        value="<?php echo $profile_row['local_govt']; ?>"
                                        autocomplete="new-password"></input>
                                </div>
                                <div class="col-md-6">
                                    <p>Current Address</p>
                                    <input class="form-select" name="address"
                                        value="<?php echo $profile_row['address']; ?>"
                                        autocomplete="new-password"></input>
                                </div>
                                <div class="col-md-6">
                                    <p>BVN</p>
                                    <input type="text" name="bvn" placeholder="BVN" maxlength="11"
                                        value="<?php echo $profile_row['bvn']; ?>" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <p>Upload Passport</p>
                                    <input type="file" placeholder="Upload Passport" class="profile-input p-2 px-3"
                                        name="passport" />
                                    <br>
                                    <img src="<?php echo show_img('uploads/documents/' . $profile_row['passport']); ?>"
                                        style="width:100px; border-radius:50%">
                                </div>
                            </div>
                            <div id="profileBody-btn">
                                <button>Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>



    <!-- <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script> -->




</body>

</html>