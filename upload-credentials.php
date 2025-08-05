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

$query = "select * from credentials where candidate_id = '" . $_SESSION['candidate_id'] . "' order by id desc ";
$result = $db->query($query);
$num = mysqli_num_rows($result);
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
                        <?php if ($personal) echo '<div class="alert alert-warning">' . $personal . '</div>'; ?>

                        <form action="save_credentials2.php" method="post" enctype="multipart/form-data">
                            <?php if ($_GET['succ'] == 'yes') { ?>

                                <p>
                                <div class="alert alert-success">Your career information has been saved succesfully. </div>
                                </p>

                            <?php } ?>



                            <?php if ($_GET['succ'] == 'yes2') { ?>

                                <p>
                                <div class="alert alert-success">Your document has been uploaded succesfully. </div>
                                </p>

                            <?php } ?>


                            <?php if ($update_error) echo $update_error; ?>
                            <?php if ($error) echo $error; ?>
                            <?php if ($success) {
                                echo $success;
                            } ?>
                            <?php if ($update_success) {
                                echo $update_success;
                            }
                            ?>
                            <?php if ($_GET['cv'] == 'null') {
                                $_SESSION['cv'] = 'null';
                                echo '<div class="alert alert-danger alert-dismissible mt-2">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Kindly upload your CV to complete your profile</strong>
                      </div>';
                            }
                            ?>
                            <?php if ($_GET['del'] == 'success') {
                                echo '<div class="alert alert-success alert-dismissible mt-2">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Document successfully  deleted</strong>
                      </div>';
                            }
                            ?>
                            <?php if ($_GET['del'] == 'failed') {
                                echo '<div class="alert alert-danger alert-dismissible mt-2">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <strong>Unable to delete document, try again later</strong>
                      </div>';
                            }
                            ?>
                            <h3>Upload Credentials</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Choose Document</p>
                                    <select class="form-select" name="document" id="document_list">
                                        <option value="choose_option">Choose an option</option>
                                        <option value="CV">CV</option>
                                        <option value="SSCE / WAEC / NECO / NAPTECH">SSCE / WAEC / NECO / NAPTECH</option>
                                        <option value="Means of Identification">Means of Identification</option>
                                        <option value="BVN Printout">BVN Printout</option>
                                        <option value="BSC / BA / BTECH / B Eng Certificate">BSC / BA / BTECH / B Eng Certificate</option>
                                        <option value="NCE Certificate">NCE Certificate</option>
                                        <option value="National Diploma">National Diploma</option>
                                        <option value="Higher National Diploma">Higher National Diploma</option>
                                        <option value="NYSC Certificate">NYSC Certificate</option>
                                        <option value="Birth Certificate">Birth Certificate</option>
                                        <option value="Others">Other Document</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Upload Document</p>
                                    <input type="file" name="document_other">
                                </div>
                            </div>
                            <div id="profileBody-btn">
                                <button name="btn_credentials">Save and Continue</button>
                            </div>
                        </form>
                        <div class="table-responsive" style="margin-top: 2rem;">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col" style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">ID</th>
                                        <th scope="col" style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">Document </th>
                                        <th scope="col" style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">Filepath</th>
                                        <th scope="col" style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < $num; $i++) {
                                        $row = mysqli_fetch_array($result);
                                    ?>
                                        <tr>
                                            <td style="font-size: 12px;" scope="row" style="background-color:#fff;"><?= $i + 1; ?></td>
                                            <td style="font-size: 12px;"><?= $row['document']; ?></td>
                                            <td style="font-size: 12px;"><?= $row['filepath']; ?> </td>


                                            <td style="font-size: 12px;">
                                                <a style="margin-right: 15px; " data-toggle="tooltip" data-placement="top" title="View Document" class="btn btn-sm btn-outline-success" href="outsourcehr-admin/document/<?= $row['filepath']; ?>" target="_blank"><i style="margin-right: 5px; " class="fa fa-eye"></i>
                                                </a>

                                                <a style="margin-right: 15px; " data-toggle="tooltip" data-placement="top" title="Delete Document" class="btn btn-sm btn-outline-danger" href="delete-upload?id=<?php echo base64_encode($row['id']); ?>&tab=<?php echo base64_encode('credentials'); ?>&section=<?php echo base64_encode('my-credentials'); ?>&return=<?php echo base64_encode('upload-credentials'); ?>" onclick="return confirm('Are you sure you want to delete this document, this action cannot be undone')"><i class="fa fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>


                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>

                        <!--<div id="reference" class="">
                            <h3>Reference</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Referee Name</p>
                                    <input type="text" placeholder="Name of Referee">
                                </div>
                                <div class="col-md-6">
                                    <p>Email</p>
                                    <input type="email" placeholder="Enter Referee email">
                                </div>
                                <div class="col-md-6">
                                    <p>Phone</p>
                                    <input type="phone" placeholder="Enter Referee phone number">
                                </div>
                                <div class="col-md-6">
                                    <p>City</p>
                                    <select class="form-select">
                                        <option selected>Choose one</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>State</p>
                                    <select class="form-select">
                                        <option selected>Choose one</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Address</p>
                                    <input type="text" placeholder="Enter Address">
                                </div>
                            </div>
                            <h3>Second Referee</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Referee Name</p>
                                    <input type="text" placeholder="Name of Referee">
                                </div>
                                <div class="col-md-6">
                                    <p>Email</p>
                                    <input type="email" placeholder="Enter Referee email">
                                </div>
                                <div class="col-md-6">
                                    <p>Phone</p>
                                    <input type="phone" placeholder="Enter Referee phone number">
                                </div>
                                <div class="col-md-6">
                                    <p>City</p>
                                    <select class="form-select">
                                        <option selected>Choose one</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>State</p>
                                    <select class="form-select">
                                        <option selected>Choose one</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Address</p>
                                    <input type="text" placeholder="Enter Address">
                                </div>
                            </div>
                            <div id="profileBody-btn">
                                <button>Save and Continue</button>
                            </div>
                        </div>

                        <div id="job-role" class="">
                            <h3>Job Preference</h3>
                            <div class="row personal-info-inp">
                                <div class="col-md-6">
                                    <p>Preferred Role</p>
                                    <select class="form-select">
                                        <option selected>Choose one</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Preferred Industry</p>
                                    <select class="form-select">
                                        <option selected>Choose one</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Preferred Location</p>
                                    <select class="form-select">
                                        <option selected>Choose one</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <p>Date to Start</p>
                                    <input placeholder="Choose one" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date">
                                </div>
                                <div class="col-md-6">
                                    <p>Salary Expectation</p>
                                    <select class="form-select">
                                        <option selected>Choose one</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                            </div>
                            <div id="profileBody-btn">
                                <button>Save and Continue</button>
                            </div>
                        </div> -->
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