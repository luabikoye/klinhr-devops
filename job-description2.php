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

if ($_SESSION['return_id']) {
    $search_query = "select * from job_post where id = '" . $_SESSION['return_id'] . "' ";
} else {
    $search_query = "select * from job_post where id = '$id' ";
}

$job_result = $db->query($search_query);
$job_num = mysqli_num_rows($job_result);
$search_row = mysqli_fetch_array($job_result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Job Description | Job Portal | KlinHR</title>

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

    <?php include 'inc/header2.php'; ?>

    <div class="jb-banner">
        <div class="row">
            <div class="col-md-6 jb-bannerL">
                <div class="jb-bannerLt">
                    <div id="jb-bannerLh"><?= $search_row['job_title']; ?> </div>
                </div>
            </div>
            <div class="col-md-6 jb-bannerR">
                <img src="./dist/images/jban.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="detailsBody">
            <?php if ($error) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php }
            ?>

            <?php if ($offer) { ?>
            <div class="alert alert-success"><?php echo $offer; ?></div>
            <?php }
            ?>

            <?php if ($_GET['offer']) { ?>
            <div class="alert alert-success"><?php echo base64_decode($_GET['offer']); ?></div>
            <?php }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="detailsBodyL1">
                        <div class="detailsBodyL1a"><img src="./dist/images/f1.png" alt="" class="img-fluid"
                                width="60px"></div>
                        <div class="detailsBodyL1b">
                            <?= $search_row['job_title']; ?> <br>
                            <span><i class="fa-solid fa-location-dot"></i> <?= $search_row['state']; ?> </span>
                            <span>
                                <!-- <i class="fa-solid fa-naira-sign"></i> -->
                                <?= $search_row['salary']; ?>
                            </span>
                            <span><i class="fa-solid fa-briefcase"></i> <?= $search_row['category']; ?></span>
                        </div>
                    </div>

                    <div id="detailsBodyL1h">Job Description</div>
                    <?= $search_row['description']; ?>

                    <div id="detailsBodyL1h">Responsibilities</div>
                    <?= $search_row['responsibilities']; ?>
                    <!-- <ul>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                </ul> -->

                    <div id="detailsBodyL1h">Requirements</div>
                    <?= $search_row['qualification_requirement']; ?>
                    <!-- <ul>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce varius faucibus massa.</li>
                </ul> -->

                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="detailsBody2">
                        <div id="detailsBody2h">Job Overview</div>
                        <div class="detailsBody2Row">
                            <div id="detailsBody2Row1">Posted Date:</div>
                            <div id="detailsBody2Row1"><?= $search_row['date_posted']; ?></div>
                        </div>
                        <div class="detailsBody2Row">
                            <div id="detailsBody2Row1">Location:</div>
                            <div id="detailsBody2Row1"><?= $search_row['state']; ?></div>
                        </div>
                        <div class="detailsBody2Row">
                            <div id="detailsBody2Row1">Job Nature</div>
                            <div id="detailsBody2Row1"><?= $search_row['state']; ?></div>
                        </div>
                        <div class="detailsBody2Row">
                            <div id="detailsBody2Row1">Salary:</div>
                            <div id="detailsBody2Row1">
                                <!-- <i class="fa-solid fa-naira-sign"></i> -->
                                <?= $search_row['salary']; ?>
                            </div>
                        </div>
                        <div class="detailsBody2Row">
                            <div id="detailsBody2Row1">Application Deadline:</div>
                            <div id="detailsBody2Row1"><?= $search_row['deadline']; ?></div>
                        </div>
                        <a href="ProcessApplication?valid=<?php echo base64_encode($id); ?>&app_type=<?php echo base64_encode($search_row['application_type']); ?> "
                            onclick="return confirm('Are you sure you want to apply for the role: <?php echo $search_row['job_title']; ?>');"><button>Apply</button></a>
                    </div>
                    <div id="detailsBody2h">About Company</div>
                    <p id="dbp">KlinHR is an automated HR Business Solution that helps you take care of your HR needs
                        from Recruitment to the point of disengagement. This solution has been used and proven to be a
                        very valuable tool by most of the largest HR firms in Nigeria.</p>
                </div>
            </div>
        </div>
    </div>









    <?php include 'inc/footer.php'; ?>

</body>

</html>