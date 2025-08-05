<?php

ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
require_once('outsourcehr-admin/inc/fns.php');

unset($_SESSION['return_id']);

// echo date('l, jS M, Y',strtotime(getNextInterview())); exit;

$search = mysqli_real_escape_string($db, $_POST['search']);
$location = mysqli_real_escape_string($db, $_POST['location']);

$today = today();


if (isset($search)) {

    if ($location != '') {
        $job_query = "select * from job_post where job_title like '%" . $search . "%'&& status = 'Approved' && deadline > '$today' && state = '$location' order by id desc limit 0,50";
    } elseif ($location == '') {
        $job_query = "select * from job_post where job_title like '%" . $search . "%'&& status = 'Approved' && deadline > '$today' order by id desc limit 0,50";
    }
} else {
    $job_query = "select * from job_post where  status = 'Approved' && deadline > '$today' order by id desc limit 0,12";
}


$lastest_result  = mysqli_query($db, $job_query);
$lastest_num = mysqli_num_rows($lastest_result);

$stmt = mysqli_query($db, "SELECT * FROM category ORDER BY RAND() LIMIT 9");
$num = mysqli_num_rows($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>KlinHR Portal</title>

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

    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="bannerbox">
                        <div id="bannerhead">SIMPLE JOB DISCOVERY</div>
                        <p>We offer a superior service for individuals seeking fresh employment opportunities, featuring genuine and current job openings directly sourced from employers and recruiters.</p>
                        <div class="bannersearchbox1">
                            <div class="bannersearchbox">
                                <i class='fa fa-search'></i>
                                <input type="text" placeholder="Job title, keywords, etc">
                            </div>
                            <button>Find Job</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clientLogo">
        <div class="container">
            <section class="customer-logos slider">
                <div class="slide"><img src="./new_dist/images/cl1.png" class="img-fluid"></div>
                <div class="slide"><img src="./new_dist/images/cl2.png" class="img-fluid"></div>
                <div class="slide"><img src="./new_dist/images/cl3.png" class="img-fluid"></div>
                <div class="slide"><img src="./new_dist/images/cl4.png" class="img-fluid"></div>
                <div class="slide"><img src="./new_dist/images/cl5.png" class="img-fluid"></div>
                <div class="slide"><img src="./new_dist/images/cl6.png" class="img-fluid"></div>
                <div class="slide"><img src="./new_dist/images/cl1.png" class="img-fluid"></div>

            </section>
        </div>
    </div>

    <div class="container">
        <div class="row easyrow">
            <div class="col-md-4">
                <div id="easysub">How it works</div>
                <div id="easyh">FOLLOW EASY <br> 4 STEPS</div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-5">
                <p>Lorem ipsum dolor sit amet consectetur. Nibh aenean lacus cras nec imperdiet mauris. Sed laoreet consequat sit ultrices sed cursus enim. Risus.</p>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row resume">
            <div class="col-md-3">
                <div class="resumeRow">
                    <div id="resumeRowicon"><i class="fa-solid fa-magnifying-glass fa-2x"></i></div>
                    <div id="resumeRowh">Search jobs</div>
                    <p>Lorem ipsum dolor sit amet consectetur. Nibh aenean lacus cras nec imperdiet mauris. Sed laoreet consequat sit ultrices sed cursus enim. Risus.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="resumeRow">
                    <div id="resumeRowicon"><i class="fa-regular fa-file-lines fa-2x"></i></div>
                    <div id="resumeRowh">CV/Resume</div>
                    <p>Lorem ipsum dolor sit amet consectetur. Nibh aenean lacus cras nec imperdiet mauris. Sed laoreet consequat sit ultrices sed cursus enim. Risus.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="resumeRow">
                    <div id="resumeRowicon"><i class='fa fa-user-plus fa-2x'></i></div>
                    <div id="resumeRowh">Create Account</div>
                    <p>Lorem ipsum dolor sit amet consectetur. Nibh aenean lacus cras nec imperdiet mauris. Sed laoreet consequat sit ultrices sed cursus enim. Risus.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="resumeRow">
                    <div id="resumeRowicon"><i class="fa-regular fa-circle-check fa-2x"></i></div>
                    <div id="resumeRowh">Apply Them</div>
                    <p>Lorem ipsum dolor sit amet consectetur. Nibh aenean lacus cras nec imperdiet mauris. Sed laoreet consequat sit ultrices sed cursus enim. Risus.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="latestJobs">
        <div class="container">
            <div class="latestJobsRow">
                <div class="latestJobsRow1">
                    <div id="latestJobsh">LATEST JOBS (<?php echo $lastest_num; ?>)</div>
                    <div class="row">
                        <div class="col-md-8">
                            <p>Explore the diverse job categories and submit applications for the ones that capture your interest.</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="latestJobsRow2">
                    <button id="mainBtn">See more</button>
                </div> -->
            </div>
            <div class="row jobsRow">
                <?php
                for ($i = 0; $i < $lastest_num; $i++) {
                    $latest_row = mysqli_fetch_array($lastest_result);
                ?>
                    <div class="col-md-4">
                        <div class="jobsRowbox">
                            <div id="jbrtime">
                                <span><?= $latest_row['job_type'] ?></span>
                            </div>
                            <div id="jobsRowboxlogo">
                                <!-- <div id="jobsRowboxlogoimg"><img src="./new_dist/images/lg.png" class="img-fluid"></div> -->
                                <div id="jobsRowboxlogotext">
                                    <?= $latest_row['job_title'] ?>
                                    <br>
                                    <span><?= get_val('clients', 'id', $latest_row['client_id'], 'client_name') ?></span>
                                </div>
                            </div>
                            <p><?php echo substr($latest_row['description'], 0, 300); ?>...</p>
                            <div id="jobsRowboxapply">
                                <a href="job-description?valid=<?= base64_encode($latest_row['id']); ?>"><button id="mainBtn">Apply Now</button></a>
                                <span><?php echo get_time_ago($latest_row['date_posted']); ?></span>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>

        </div>
    </div>

    <div class="container">
        <div class="jobSearch">
            <div class="row jobSearchRow">
                <div class="col-md-3">
                    <div class="jobSearchRow1">
                        <div id="jobSearchRow1h">Job Search</div>
                        <p>Discover a variety of job categories and apply for the ones that pique your interest.</p>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="jobSearchRow2row">
                        <div class="row">
                            <?php for ($i = 0; $i < $num; $i++) {
                                $row = mysqli_fetch_array($stmt);
                            ?>
                                <div class="col-md-4 mb-4">
                                    <div class="jobSearchRow2">
                                        <div id="jobSearchRow2h"><?= substr($row['industry'], 0, 14) ?>...</div>
                                        <p><?= cat_by_jobs($row['industry']) ?> Posted New Jobs</p>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- <div class="col-md-4">
                                <div class="jobSearchRow3">
                                    <div id="jobSearchRow2h">Load more</div>
                                    <p>100,000+ Jobs Posted</p>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'new_inc/get-in-touch.php'; ?>

    <div class="container">
        <div class="testimonials">
            <div class="col-lg-12 ">
                <div id="client-testimonial-carousel" class="carousel slide" data-ride="carousel" style="height:100%;">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <div class="row carouselRow">
                                <div class="col-md-4">
                                    <div class="carouselRowbox">
                                        <div id="carouselRowboxhead">
                                            <div id="carouselRowboxheadimg"><img src="./new_dist/images/test.png" class="img-fluid"></div>
                                            <div id="carouselRowboxheadtxt">
                                                Oluremi George <br> <span>CEO, George Empire</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur. Adipiscing pellentesque odio morbi cursus a eget feugiat. Orci malesuada morbi nisi sed velit eget sed feugiat elementum. Scelerisque gravida sed ultricies posuere a arcu netus. Venenatis turpis turpis curabitur vitae bibendum lorem arcu fusce egestas.</p>
                                        <div id="qqoo"><img src="./new_dist/images/quu.svg" class="img-fluid"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 crbb">
                                    <div class="carouselRowbox">
                                        <div id="carouselRowboxhead">
                                            <div id="carouselRowboxheadimg"><img src="./new_dist/images/test.png" class="img-fluid"></div>
                                            <div id="carouselRowboxheadtxt">
                                                Oluremi George <br> <span>CEO, George Empire</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur. Adipiscing pellentesque odio morbi cursus a eget feugiat. Orci malesuada morbi nisi sed velit eget sed feugiat elementum. Scelerisque gravida sed ultricies posuere a arcu netus. Venenatis turpis turpis curabitur vitae bibendum lorem arcu fusce egestas.</p>
                                        <div id="qqoo"><img src="./new_dist/images/quu.svg" class="img-fluid"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="carouselRowbox">
                                        <div id="carouselRowboxhead">
                                            <div id="carouselRowboxheadimg"><img src="./new_dist/images/test.png" class="img-fluid"></div>
                                            <div id="carouselRowboxheadtxt">
                                                Oluremi George <br> <span>CEO, George Empire</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur. Adipiscing pellentesque odio morbi cursus a eget feugiat. Orci malesuada morbi nisi sed velit eget sed feugiat elementum. Scelerisque gravida sed ultricies posuere a arcu netus. Venenatis turpis turpis curabitur vitae bibendum lorem arcu fusce egestas.</p>
                                        <div id="qqoo"><img src="./new_dist/images/quu.svg" class="img-fluid"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row carouselRow">
                                <div class="col-md-4">
                                    <div class="carouselRowbox">
                                        <div id="carouselRowboxhead">
                                            <div id="carouselRowboxheadimg"><img src="./new_dist/images/test.png" class="img-fluid"></div>
                                            <div id="carouselRowboxheadtxt">
                                                Oluremi George <br> <span>CEO, George Empire</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur. Adipiscing pellentesque odio morbi cursus a eget feugiat. Orci malesuada morbi nisi sed velit eget sed feugiat elementum. Scelerisque gravida sed ultricies posuere a arcu netus. Venenatis turpis turpis curabitur vitae bibendum lorem arcu fusce egestas.</p>
                                        <div id="qqoo"><img src="./new_dist/images/quu.svg" class="img-fluid"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 crbb">
                                    <div class="carouselRowbox">
                                        <div id="carouselRowboxhead">
                                            <div id="carouselRowboxheadimg"><img src="./new_dist/images/test.png" class="img-fluid"></div>
                                            <div id="carouselRowboxheadtxt">
                                                Oluremi George <br> <span>CEO, George Empire</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur. Adipiscing pellentesque odio morbi cursus a eget feugiat. Orci malesuada morbi nisi sed velit eget sed feugiat elementum. Scelerisque gravida sed ultricies posuere a arcu netus. Venenatis turpis turpis curabitur vitae bibendum lorem arcu fusce egestas.</p>
                                        <div id="qqoo"><img src="./new_dist/images/quu.svg" class="img-fluid"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="carouselRowbox">
                                        <div id="carouselRowboxhead">
                                            <div id="carouselRowboxheadimg"><img src="./new_dist/images/test.png" class="img-fluid"></div>
                                            <div id="carouselRowboxheadtxt">
                                                Oluremi George <br> <span>CEO, George Empire</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur. Adipiscing pellentesque odio morbi cursus a eget feugiat. Orci malesuada morbi nisi sed velit eget sed feugiat elementum. Scelerisque gravida sed ultricies posuere a arcu netus. Venenatis turpis turpis curabitur vitae bibendum lorem arcu fusce egestas.</p>
                                        <div id="qqoo"><img src="./new_dist/images/quu.svg" class="img-fluid"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row carouselRow">
                                <div class="col-md-4">
                                    <div class="carouselRowbox">
                                        <div id="carouselRowboxhead">
                                            <div id="carouselRowboxheadimg"><img src="./new_dist/images/test.png" class="img-fluid"></div>
                                            <div id="carouselRowboxheadtxt">
                                                Oluremi George <br> <span>CEO, George Empire</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur. Adipiscing pellentesque odio morbi cursus a eget feugiat. Orci malesuada morbi nisi sed velit eget sed feugiat elementum. Scelerisque gravida sed ultricies posuere a arcu netus. Venenatis turpis turpis curabitur vitae bibendum lorem arcu fusce egestas.</p>
                                        <div id="qqoo"><img src="./new_dist/images/quu.svg" class="img-fluid"></div>
                                    </div>
                                </div>
                                <div class="col-md-4 crbb">
                                    <div class="carouselRowbox">
                                        <div id="carouselRowboxhead">
                                            <div id="carouselRowboxheadimg"><img src="./new_dist/images/test.png" class="img-fluid"></div>
                                            <div id="carouselRowboxheadtxt">
                                                Oluremi George <br> <span>CEO, George Empire</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur. Adipiscing pellentesque odio morbi cursus a eget feugiat. Orci malesuada morbi nisi sed velit eget sed feugiat elementum. Scelerisque gravida sed ultricies posuere a arcu netus. Venenatis turpis turpis curabitur vitae bibendum lorem arcu fusce egestas.</p>
                                        <div id="qqoo"><img src="./new_dist/images/quu.svg" class="img-fluid"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="carouselRowbox">
                                        <div id="carouselRowboxhead">
                                            <div id="carouselRowboxheadimg"><img src="./new_dist/images/test.png" class="img-fluid"></div>
                                            <div id="carouselRowboxheadtxt">
                                                Oluremi George <br> <span>CEO, George Empire</span>
                                            </div>
                                        </div>
                                        <p>Lorem ipsum dolor sit amet consectetur. Adipiscing pellentesque odio morbi cursus a eget feugiat. Orci malesuada morbi nisi sed velit eget sed feugiat elementum. Scelerisque gravida sed ultricies posuere a arcu netus. Venenatis turpis turpis curabitur vitae bibendum lorem arcu fusce egestas.</p>
                                        <div id="qqoo"><img src="./new_dist/images/quu.svg" class="img-fluid"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ol class="carousel-indicators">
                        <li data-target="#client-testimonial-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#client-testimonial-carousel" data-slide-to="1"></li>
                        <li data-target="#client-testimonial-carousel" data-slide-to="2"></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>






















    <script>
        $(document).ready(function() {
            $('.customer-logos').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1500,
                arrows: false,
                dots: false,
                pauseOnHover: false,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4
                    }
                }, {
                    breakpoint: 520,
                    settings: {
                        slidesToShow: 3
                    }
                }]
            });
        });
    </script>

    <?php include 'new_inc/footer.php'; ?>

</body>

</html>