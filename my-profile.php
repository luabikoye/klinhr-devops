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

    <title>My Profile | KlinHR Portal</title>

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
    <style>
        #tabcontentsc button {
            border: none;
            outline: none;
            background-color: transparent;
            font-size: 14px;
            font-weight: 500;
            color: rgb(255, 0, 0);
            margin-bottom: 50px;
        }
    </style>
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
                            <div id="changeph">My Profile</div>


                            <div class="row my_profilerow">
                                <div class="col-md-4">
                                    <div class="my_profilerowL">
                                        <div class="profile-tab">
                                            <button class="tablinks" onclick="openCity(event, 'Personal-information')" id="defaultOpen"> <span><i class="fa-solid fa-users"></i></span> Personal Information</button>
                                            <button class="tablinks" onclick="openCity(event, 'Career-information')"><i class="fa-solid fa-briefcase"></i> Career Information</button>
                                            <button class="tablinks" onclick="openCity(event, 'Work-experience')"><i class="fa-solid fa-briefcase"></i> Work Experience</button>
                                            <button class="tablinks" onclick="openCity(event, 'Job-preference')"><i class="fa-solid fa-gear"></i> Job Preference</button>
                                            <button class="tablinks" onclick="openCity(event, 'Social-media')"><i class="fa-solid fa-icons"></i> Social Media Links</button>
                                            <button class="tablinks" onclick="openCity(event, 'Reference')"><i class="fa-solid fa-gear"></i> Reference</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
                                    <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
                                    <?php if ($personal) echo '<div class="alert alert-warning">' . $personal . '</div>'; ?>
                                    <div class="my_profilerowL">
                                        <div id="Personal-information" class="tabcontent">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" readonly value="<?= $profile_row['firstname'] ?>" id="firstname" placeholder="First Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" readonly value="<?= $profile_row['lastname'] ?>" id="lastname" placeholder="Last Name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" readonly value="<?= $profile_row['middlename'] ?>" id="middlename" placeholder="Middle Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" readonly value="<?= $profile_row['email'] ?>" id="email" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="number" value="<?= $profile_row['phone'] ?>" id="phone" placeholder="Phone Number">
                                                </div>
                                                <div class="col-md-6">
                                                    <select id="gender" class="form-select">
                                                        <?php if ($profile_row['gender']) {
                                                            echo '<option>' . $profile_row['gender'] . '</option>';
                                                        }
                                                        ?>
                                                        <option value="">Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input placeholder="Date of Birth" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" value="<?= $profile_row['dob'] ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="bus" placeholder="Closest B/Stop" value="<?= $profile_row['bustop'] ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select id="state" class="form-select">
                                                        <option selected value="<?php echo $profile_row['state']; ?>">
                                                            <?php echo $profile_row['state']; ?></option>
                                                        <option value="">Choose Residence State</option>
                                                        <?= list_state(); ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <input value="<?= $profile_row['address'] ?>" type="text" id="address" placeholder="Current Address">
                                                </div>
                                            </div>
                                            <div class="row">
                                            </div>
                                            <div class="my_profilerow_btn">
                                                <button id="personal">Save</button>
                                            </div>
                                        </div>

                                        <div id="Career-information" class="tabcontent">
                                            <div class="qual1">
                                                <div id="tabcontenthd">Qualification</div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select id="first_qualification" class="form-select" aria-placeholder="choose one">
                                                            <?php if ($profile_row['first_qualification']) {
                                                                echo '<option>' . $profile_row['first_qualification'] . '</option>';
                                                            }
                                                            ?>
                                                            <option value="">Choose Qualification</option>
                                                            <?php list_qualifications(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-select" id="first_institution">
                                                            <option value="">Choose Institution</option>
                                                            <?php if ($profile_row['first_institution']) {
                                                                echo '<option selected>' . $profile_row['first_institution'] . '</option>';
                                                            }
                                                            ?>
                                                            <?php list_institution(); ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select id="first_degree" class="form-select">
                                                            <option value="">Choose Degree</option>
                                                            <?php if ($profile_row['first_degree']) {
                                                                echo '<option selected>' . $profile_row['first_degree'] . '</option>';
                                                            }
                                                            ?>
                                                            <?php list_degree(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-select" id="first_course">
                                                            <?php if ($profile_row['first_course']) {
                                                                echo '<option>' . $profile_row['first_course'] . '</option>';
                                                            }
                                                            ?>
                                                            <option value="">Choose one</option>
                                                            <?php list_course(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" value="<?= $profile_row['q1_year'] ?>" id="q1_year" placeholder="Year Graduated">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div id="tabcontentsb" class="show1"><button>Add more qualification <i class="fa-regular fa-square-plus"></i></button></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="qual2">
                                                <div id="tabcontenthd">Second Qualification</div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select id="qualification_2" class="form-select" aria-placeholder="choose one">
                                                            <?php if ($profile_row['qualification_2']) {
                                                                echo '<option>' . $profile_row['qualification_2'] . '</option>';
                                                            }
                                                            ?>
                                                            <option value="">Choose Qualification</option>
                                                            <?php list_qualifications(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-select" id="institution2">
                                                            <option value="">Choose Institution</option>
                                                            <?php if ($profile_row['institution2']) {
                                                                echo '<option selected>' . $profile_row['institution2'] . '</option>';
                                                            }
                                                            ?>
                                                            <?php list_institution(); ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select id="degree2" class="form-select">
                                                            <option value="">Choose Degree</option>
                                                            <?php if ($profile_row['degree2']) {
                                                                echo '<option selected>' . $profile_row['degree2'] . '</option>';
                                                            }
                                                            ?>
                                                            <?php list_degree(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-select" id="course2">
                                                            <?php if ($profile_row['course2']) {
                                                                echo '<option>' . $profile_row['course2'] . '</option>';
                                                            }
                                                            ?>
                                                            <option value="">Choose one</option>
                                                            <?php list_course(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" value="<?= $profile_row['q2_year'] ?>" id="q2_year" placeholder="Year Graduated">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div id="tabcontentsb" class="show2"><button>Add more qualification <i class="fa-regular fa-square-plus"></i></button></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="tabcontentsc" class="hide2"><button>Remove qualification <i class="fa-regular fa-square-minus"></i></button></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="qual3">
                                                <div id="tabcontenthd">Third Qualification</div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select id="qualification_3" class="form-select" aria-placeholder="choose one">
                                                            <?php if ($profile_row['qualification_3']) {
                                                                echo '<option>' . $profile_row['qualification_3'] . '</option>';
                                                            }
                                                            ?>
                                                            <option value="">Choose Qualification</option>
                                                            <?php list_qualifications(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-select" id="institution3">
                                                            <option value="">Choose Institution</option>
                                                            <?php if ($profile_row['institution3']) {
                                                                echo '<option selected>' . $profile_row['institution3'] . '</option>';
                                                            }
                                                            ?>
                                                            <?php list_institution(); ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select id="degree3" class="form-select">
                                                            <option value="">Choose Degree</option>
                                                            <?php if ($profile_row['degree3']) {
                                                                echo '<option selected>' . $profile_row['degree3'] . '</option>';
                                                            }
                                                            ?>
                                                            <?php list_degree(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-select" id="course3">
                                                            <?php if ($profile_row['course3']) {
                                                                echo '<option>' . $profile_row['course3'] . '</option>';
                                                            }
                                                            ?>
                                                            <option value="">Choose one</option>
                                                            <?php list_course(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" value="<?= $profile_row['q3_year'] ?>" id="q3_year" placeholder="Year Graduated">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div id="tabcontentsc" class="hide3"><button>Remove qualification <i class="fa-regular fa-square-minus"></i></button></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="cert1">

                                                <div id="tabcontenthd">Professional Certificate</div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select id="first_professional" class="form-select">
                                                            <?php if ($profile_row['profCert']) {
                                                                echo '<option>' . $profile_row['profCert'] . '</option>';
                                                            }
                                                            ?>
                                                            <option value="">Choose one</option>
                                                            <?php list_cert(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" value="<?= $profile_row['first_professional_year'] ?>" id="first_professional_year" placeholder="Year Of Certificate">
                                                    </div>
                                                </div>

                                                <div id="tabcontentsb" class="show4"><button>Add more certificate <i class="fa-regular fa-square-plus"></i></button></div>

                                            </div>
                                            <div class="cert2">

                                                <div id="tabcontenthd">Professional Certificate</div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select id="professional2" class="form-select">
                                                            <?php if ($profile_row['profCert2']) {
                                                                echo '<option>' . $profile_row['profCert2'] . '</option>';
                                                            }
                                                            ?>
                                                            <option value="">Choose one</option>
                                                            <?php list_cert(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" value="<?= $profile_row['professional2_year'] ?>" id="professional2_year" placeholder="Year Of Certificate">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div id="tabcontentsb" class="show5"><button>Add more qualification <i class="fa-regular fa-square-plus"></i></button></div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="tabcontentsc" class="hide5"><button>Remove qualification <i class="fa-regular fa-square-minus"></i></button></div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="cert3">

                                                <div id="tabcontenthd">Professional Certificate</div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select id="professional3" class="form-select">
                                                            <?php if ($profile_row['profCert3']) {
                                                                echo '<option>' . $profile_row['profCert3'] . '</option>';
                                                            }
                                                            ?>
                                                            <option value="">Choose one</option>
                                                            <?php list_cert(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" value="<?= $profile_row['professional3_year'] ?>" id="professional3_year" placeholder="Year Of Certificate">
                                                    </div>
                                                </div>

                                                <div id="tabcontentsc" class="hide6"><button>Remove qualification <i class="fa-regular fa-square-minus"></i></button></div>

                                            </div>
                                            <div class="my_profilerow_btn">
                                                <button id="career">Save</button>
                                            </div>
                                        </div>

                                        <div id="Work-experience" class="tabcontent">
                                            <div id="tabcontenthd">Past/Present Experience</div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select class="form-select" id="industry">
                                                        <option value="">Choose Industry</option>
                                                        <?php if ($profile_row['industry']) {
                                                            echo '<option selected>' . $profile_row['industry'] . '</option>';
                                                        }
                                                        ?>

                                                        <?php list_industry(); ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-select" id="experience_1">
                                                        <option value="">Choose years of experience</option>
                                                        <?php if ($profile_row['experience_1']) {
                                                            echo '<option selected>' . $profile_row['experience_1'] . '</option>';
                                                        }
                                                        ?>

                                                        <?php list_experience();  ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <textarea name="" id="achievement" cols="30" rows="5" placeholder="Work Achievement"><?php echo $profile_row['achievement']; ?></textarea>
                                                </div>
                                            </div>


                                            <div class="my_profilerow_btn">
                                                <button id="work">Save</button>
                                            </div>
                                        </div>

                                        <div id="Job-preference" class="tabcontent">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select class="form-select" name="prefState" id="prefState">
                                                        <?php if ($profile_row['prefState']) {
                                                            echo '<option>' . $profile_row['prefState'] . '</option>';
                                                        }
                                                        ?>
                                                        <option value="">Choose preferred Location</option>
                                                        <?php list_state(); ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-select" name="prefJob" id="prefJob">
                                                        <?php if ($profile_row['prefJob']) {
                                                            echo '<option>' . $profile_row['prefJob'] . '</option>';
                                                        }
                                                        ?>
                                                        <option value="">Choose preferred Industry</option>
                                                        <?php list_industry(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select name="availDate" id="availDate" class="form-select" aria-placeholder="Willingness to Travel">

                                                        <?php if ($profile_row['availDate']) {
                                                            echo '<option>' . $profile_row['availDate'] . '</option>';
                                                        }
                                                        ?>
                                                        <option value="">Select date to Start</option>
                                                        <option value="2 Weeks">2 Weeks</option>
                                                        <option value="One Month">One Month</option>
                                                        <option value="Two Months">Two Months</option>
                                                        <option value="Three Months">Three Months and Above</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-select" name="prefCat" id="prefCat">
                                                        <?php if ($profile_row['prefCat']) {
                                                            echo '<option>' . $profile_row['prefCat'] . '</option>';
                                                        }
                                                        ?>
                                                        <option value="">Choose preferred Role</option>
                                                        <?php list_roles(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
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
                                            <div class="my_profilerow_btn">
                                                <button id="prefer">Save</button>
                                            </div>
                                        </div>

                                        <div id="Social-media" class="tabcontent">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" id="facebook" value="<?php echo $profile_row['facebook']; ?>" placeholder="www.facebook.com/iretiabimbola">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="twitter" value="<?php echo $profile_row['twitter']; ?>" placeholder="www.twitter.com/iretiabimbola">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" id="linkedin" value="<?php echo $profile_row['linkedin']; ?>" placeholder="www.linkedin.com/iretiabimbola">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="instagram" value="<?php echo $profile_row['instagram']; ?>" placeholder="www.instagram.com/iretiabimbola">
                                                </div>
                                            </div>
                                            <div class="my_profilerow_btn">
                                                <button id="social">Save</button>
                                            </div>
                                        </div>

                                        <div id="Reference" class="tabcontent">
                                            <div id="tabcontenthd">First Referee</div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" id="refName" value="<?php echo $profile_row['refName']; ?>" placeholder="Referee Name">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" id="refEmail"
                                                        value="<?php echo $profile_row['refEmail']; ?>" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="phone" id="refPhone"
                                                        value="<?php echo $profile_row['refPhone']; ?>" placeholder="Phone Number">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" id="refPosition"
                                                        value="<?php echo $profile_row['refPosition']; ?>" placeholder="Position">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="Enter City" id="refCity"
                                                        value="<?php echo $profile_row['refCity']; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-select" id="refState">
                                                        <option value="">Choose State</option>
                                                        <?php if ($profile_row['refState']) {
                                                            echo '<option selected>' . $profile_row['refState'] . '</option>';
                                                        }
                                                        ?>
                                                        <?php list_state(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="phone" placeholder="Company" id="refCompany"
                                                        value="<?php echo $profile_row['refCompany']; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="Physical Address" id="refAddress"
                                                        value="<?php echo $profile_row['refAddress']; ?>">
                                                </div>
                                            </div>

                                            <div id="tabcontenthd" style="margin-top: 20px;">Second Referee</div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="Referee Name" id="refName2"
                                                        value="<?php echo $profile_row['refName2']; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="email" placeholder="Email" id="refEmail2"
                                                        value="<?php echo $profile_row['refEmail2']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="phone" placeholder="Phone Number" id="refPhone2"
                                                        value="<?php echo $profile_row['refPhone2']; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="Position" id="refPosition2"
                                                        value="<?php echo $profile_row['refPosition2']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="Enter City" id="refCity2"
                                                        value="<?php echo $profile_row['refCity2']; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-select" id="refState2">
                                                        <option value="">Choose State</option>
                                                        <?php if ($profile_row['refState2']) {
                                                            echo '<option selected>' . $profile_row['refState2'] . '</option>';
                                                        }
                                                        ?>
                                                        <?php list_state(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="phone" placeholder="Company" id="refCompany2"
                                                        value="<?php echo $profile_row['refCompany2']; ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" placeholder="Physical Address" id="refAddress2"
                                                        value="<?php echo $profile_row['refAddress2']; ?>">
                                                </div>
                                            </div>

                                            <div class="my_profilerow_btn">
                                                <button id="referee">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>



    <script>
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
    </script>
    <link href="outsourcehr-admin/toastr/toastr.min.css" rel="stylesheet" />
    <script src="outsourcehr-admin/toastr/toastr.js"></script>

    <script src="profile.js"></script>



</body>

</html>