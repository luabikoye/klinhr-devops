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
                    <div id="dash_userimg"><img src="<?php echo show_img('uploads/documents/' . $profile_row['passport']); ?>" class="img-fluid" style="height: 40px; width: 40px;"></div>
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


                        <form action="proc_job_preference.php" method="post">
                            <?php if ($_GET['succ'] == 'yes') { ?>

                                <p>
                                <div class="alert alert-success">Your work experience has been saved succesfully. </div>
                                </p>

                            <?php } ?>
                            <h3>Job Preference</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Preferred Location</p>
                                    <select class="form-select" name="prefState" id="prefState">
                                        <?php if ($profile_row['prefState']) {
                                            echo '<option>' . $profile_row['prefState'] . '</option>';
                                        }
                                        ?>
                                        <option value="">Choose One</option>
                                        <?php list_state(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Preferred Industry</p>
                                    <select class="form-select" name="prefJob" id="prefJob">
                                        <?php if ($profile_row['prefJob']) {
                                            echo '<option>' . $profile_row['prefJob'] . '</option>';
                                        }
                                        ?>
                                        <option value="">Choose One</option>
                                        <?php list_industry(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Date to Start</p>
                                    <!-- <input placeholder="Choose one" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date"> -->
                                    <select name="availDate" id="availDate" class="textbox-n" aria-placeholder="Willingness to Travel" style="
                              width: 100%;
    border: none;
    outline: none;
    border: 1px solid #e9e7e7;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 30px;
    font-size: 12px;
                          ">

                                        <?php if ($profile_row['availDate']) {
                                            echo '<option>' . $profile_row['availDate'] . '</option>';
                                        }
                                        ?>
                                        <option value="">Select Date</option>
                                        <option value="2 Weeks">2 Weeks</option>
                                        <option value="One Month">One Month</option>
                                        <option value="Two Months">Two Months</option>
                                        <option value="Three Months">Three Months and Above</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Preferred Role</p>
                                    <select class="form-select" name="prefCat" id="prefCat">
                                        <?php if ($profile_row['prefCat']) {
                                            echo '<option>' . $profile_row['prefCat'] . '</option>';
                                        }
                                        ?>
                                        <option value="">Choose One</option>
                                        <?php list_roles(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Salary Expectation</p>
                                    <select class="form-select" name="salary" id="salary">
                                        <?php if ($profile_row['salary']) {
                                            echo '<option>' . $profile_row['salary'] . '</option>';
                                        }
                                        ?>
                                        <option value="">Choose One</option>
                                        <?php list_salary(); ?>
                                    </select>
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