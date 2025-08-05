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

    <title>Job Description | KlinHR Portal</title>

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

    <?php include 'new_inc/header.php'; ?>

    <div class="jobDes-banner">
        <div class="container">

        </div>
    </div>

    <div class="container">
        <div class="row jobDesrow">
            <div class="col-md-5">
                <div class="jobDesrowbox">
                    <img src="./new_dist/images/jdi.png" class="img-fluid">
                    <span> <?= ucwords($search_row['job_title']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="safe-apply">
            <a href="javascript:;" id="fav" data-id="<?= $_GET['valid'] ?>"><button id="safJb"><i class="fa-regular fa-heart"></i>&nbsp;&nbsp; Save Job</button></a>
            <a href="ProcessApplication?valid=<?php echo base64_encode($id); ?>&app_type=<?php echo base64_encode($search_row['application_type']); ?> "
                onclick="return confirm('Are you sure you want to apply for the role: <?php echo $search_row['job_title']; ?>')"><button id="mainBtn">Apply Now</button></a>
        </div>
    </div>

    <div class="container">
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
        <div class="jobDeslog">
            <div id="jobDesloga"><img src="./new_dist/images/lg1.png" class="img-fluid"></div>
            <div id="jobDeslogb">
                <div id="jobDeslogbh"><?= get_val('clients', 'id', $search_row['client_id'], 'client_name') ?></div>
                <div id="jobDeslogbs"><?= $search_row['job_title'] ?></div>
                <div id="jobDeslogbl"><i class="fa-solid fa-location-dot"></i> <?= $search_row['state'] ?></div>
            </div>
            <div id="jobDeslogc"><?= $search_row['job_type'] ?></div>
        </div>
    </div>

    <div class="container">
        <div class="jobImgsect">
            <div class="row">
                <div class="col-md-8">
                    <div class="jobImgsect1"><img src="./new_dist/images/jdd.webp" class="img-fluid"></div>
                </div>
                <div class="col-md-4">
                    <div class="jobImgsect2">
                        <div class="jobImgsect2a">
                            <div id="jobImgsect2ah">Job Summary</div>
                            <ul>
                                <li>Published on: <?= long_date($search_row['date_posted']) ?></li>
                                <!-- <li>Vacancy: 20</li> -->
                                <li>Employment Status: <?= $search_row['job_type'] ?></li>
                                <li>Experience: <?= $search_row['experience'] ?></li>
                                <li>Job Location: <?= $search_row['state'] ?></li>
                                <li>Salary: N<?= $search_row['salary'] ?></li>
                                <li>Quailification: <?= $search_row['qualification'] ?></li>
                                <li>Application Deadline: <?= long_date($search_row['deadline']) ?></li>
                            </ul>
                        </div>
                        <div class="jobImgsect2b">
                            <div id="jobImgsect2ah">Share</div>
                            <div id="jobImgsect2bicons">
                                <a href=""><i class="fa-brands fa-facebook-f"></i></a>
                                <a href=""><i class="fa-brands fa-x-twitter"></i></a>
                                <a href=""><i class="fa-brands fa-instagram"></i></a>
                                <a href=""><i class="fa-brands fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="jobImgsectB">
                    <div id="jobImgsectBh">Job Description</div>
                    <p><?= $search_row['description'] ?>.</p>
                    <div id="jdln"><img src="./new_dist/images/jl.png" class="img-fluid"></div>

                    <div id="jobImgsectBh">Responsibilities</div>
                    <?= $search_row['responsibilities'] ?>

                    <div id="jdln"><img src="./new_dist/images/jl.png" class="img-fluid"></div>
                    <div id="jobImgsectBh">Requirement & Skills</div>
                    <?= $search_row['qualification_requirement'] ?>
                    <div id="jdln"><img src="./new_dist/images/jl.png" class="img-fluid"></div>
                    <a href="ProcessApplication?valid=<?php echo base64_encode($id); ?>&app_type=<?php echo base64_encode($search_row['application_type']); ?> "
                        onclick="return confirm('Are you sure you want to apply for the role: <?php echo $search_row['job_title']; ?>')"><button id="mainBtn" style="margin-bottom: 157px; margin-top: 50px;">Apply Now</button></a>
                </div>
            </div>
        </div>
    </div>







    <link href="outsourcehr-admin/toastr/toastr.min.css" rel="stylesheet" />
    <script src="outsourcehr-admin/toastr/toastr.js"></script>

    <?php include 'new_inc/get-in-touch.php'; ?>
    <script src="fav.js"></script>



















    <?php include 'new_inc/footer.php'; ?>

</body>

</html>