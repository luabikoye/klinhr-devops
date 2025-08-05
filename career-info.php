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
                        <?php if ($_GET['succ'] == 'yes') echo '<div class="alert alert-success">Your personal info have been saved succesfully.</div>'; ?>
                        <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
                        <?php if ($personal) echo '<div class="alert alert-warning">' . $personal . '</div>'; ?>

                        <form action="proc_career" method="post" enctype="multipart/form-data">
                            <h3>Senior School Certificate Examination</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>School Attended*</p>
                                    <input type="text" name="sec_school" placeholder="Name of School" value="<?php echo $profile_row['sec_school']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <p>Year Completed*</p>
                                    <input type="text" name="sec_year" placeholder="Year Graduated from School" value="<?php echo $profile_row['sec_year']; ?>">
                                </div>
                            </div>
                            <h3 style="margin-top: 30px;">First Qualification</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Qualification*</p>
                                    <select id="first_qualification" name="first_qualification" class="form-select" aria-placeholder="choose one">
                                        <?php if ($profile_row['first_qualification']) {
                                            echo '<option>' . $profile_row['first_qualification'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option selected>Choose one</option> -->
                                        <?php list_qualifications(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Institution*</p>
                                    <select name="first_institution" id="first_institution" placeholder="Name of School" style="width: 100%;
    border: none;
    outline: none;
    border: 1px solid #e9e7e7;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 30px;
    font-size: 12px;">
                                        <?php if ($profile_row['first_institution']) {
                                            echo '<option>' . $profile_row['first_institution'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option value="">Choose one</option> -->
                                        <?php list_institution(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Class of Degree*</p>
                                    <select name="first_degree" id="first_degree" class="form-select">
                                        <?php if ($profile_row['first_degree']) {
                                            echo '<option>' . $profile_row['first_degree'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option selected>Choose class of Degree</option> -->
                                        <?php list_degree(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Course of Study*</p>
                                    <select name="first_course" id="first_course" class="form-select">
                                        <?php if ($profile_row['first_course']) {
                                            echo '<option>' . $profile_row['first_course'] . '</option>';
                                        }
                                        ?>
                                        <option value="">Choose one</option>
                                        <?php list_course(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Year Graduated*</p>
                                    <input type="text" name="q1_year" placeholder="Year Graduated from School" value="<?php echo $profile_row['q1_year']; ?>">
                                </div>
                            </div>
                            <h3 style="margin-top: 30px;">Second Qualification</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Qualification*</p>
                                    <select id="first_qualification" name="qualification_2" class="form-select" aria-placeholder="choose one">
                                        <?php if ($profile_row['qualification_2']) {
                                            echo '<option>' . $profile_row['qualification_2'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option selected>Choose one</option> -->
                                        <?php list_qualifications(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Institution*</p>
                                    <select name="institution2" id="first_institution" placeholder="Name of School" style="width: 100%;
    border: none;
    outline: none;
    border: 1px solid #e9e7e7;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 30px;
    font-size: 12px;">
                                        <?php if ($profile_row['institution2']) {
                                            echo '<option>' . $profile_row['institution2'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option value="">Choose one</option> -->
                                        <?php list_institution(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Class of Degree*</p>
                                    <select name="degree2" id="first_degree" class="form-select">
                                        <?php if ($profile_row['degree2']) {
                                            echo '<option>' . $profile_row['degree2'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option selected>Choose class of Degree</option> -->
                                        <?php list_degree(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Course of Study*</p>
                                    <select name="course2" id="first_course" class="form-select">
                                        <?php if ($profile_row['course2']) {
                                            echo '<option>' . $profile_row['course2'] . '</option>';
                                        }
                                        ?>
                                        <option value="">Choose one</option>
                                        <?php list_course(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Year Graduated*</p>
                                    <input type="text" name="q2_year" placeholder="Year Graduated from School" value="<?php echo $profile_row['q2_year']; ?>">
                                </div>
                            </div>
                            <h3 style="margin-top: 30px;">Third Qualification</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Qualification*</p>
                                    <select id="first_qualification" name="qualification_3" class="form-select" aria-placeholder="choose one">
                                        <?php if ($profile_row['qualification_3']) {
                                            echo '<option>' . $profile_row['qualification_3'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option selected>Choose one</option> -->
                                        <?php list_qualifications(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Institution*</p>
                                    <select name="institution3" id="first_institution" placeholder="Name of School" style="width: 100%;
    border: none;
    outline: none;
    border: 1px solid #e9e7e7;
    border-radius: 10px;
    padding: 10px;
    margin-bottom: 30px;
    font-size: 12px;">
                                        <?php if ($profile_row['institution3']) {
                                            echo '<option>' . $profile_row['institution3'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option value="">Choose one</option> -->
                                        <?php list_institution(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Class of Degree*</p>
                                    <select name="degree3" id="first_degree" class="form-select">
                                        <?php if ($profile_row['degree3']) {
                                            echo '<option>' . $profile_row['degree3'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option selected>Choose class of Degree</option> -->
                                        <?php list_degree(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Course of Study*</p>
                                    <select name="course3" id="first_course" class="form-select">
                                        <?php if ($profile_row['course3']) {
                                            echo '<option>' . $profile_row['course3'] . '</option>';
                                        }
                                        ?>
                                        <option value="">Choose one</option>
                                        <?php list_course(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Year Graduated*</p>
                                    <input type="text" name="q3_year" placeholder="Year Graduated from School" value="<?php echo $profile_row['q3_year']; ?>">
                                </div>
                            </div>
                            <h3 style="margin-top: 30px;">Professional Certificate</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Certificate</p>
                                    <select class="form-select" name="professional3">
                                        <?php if ($profile_row['profCert3']) {
                                            echo '<option>' . $profile_row['profCert3'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option selected>Choose one</option> -->
                                        <?php list_cert(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Year Obtained</p>
                                    <input type="text" name="professional3_year" placeholder="Year Of Certificate" value="<?php echo $profile_row['professional3_year']; ?>">
                                </div>
                            </div>
                            <h3 style="margin-top: 30px;">Second Professional Certificate</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Certificate</p>
                                    <select class="form-select" name="first_professional">
                                        <?php if ($profile_row['profCert']) {
                                            echo '<option>' . $profile_row['profCert'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option selected>Choose one</option> -->
                                        <?php list_cert(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Year Obtained</p>
                                    <input type="text" name="first_professional_year" placeholder="Year Of Certificate" value="<?php echo $profile_row['first_professional_year']; ?>">
                                </div>
                            </div>
                            <h3 style="margin-top: 30px;">Third Professional Certificate</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Certificate</p>
                                    <select class="form-select" name="professional2">
                                        <?php if ($profile_row['profCert2']) {
                                            echo '<option>' . $profile_row['profCert2'] . '</option>';
                                        }
                                        ?>
                                        <!-- <option selected>Choose one</option> -->
                                        <?php list_cert(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Year Obtained</p>
                                    <input type="text" name="professional2_year" placeholder="Year Of Certificate" value="<?php echo $profile_row['professional2_year']; ?>">
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