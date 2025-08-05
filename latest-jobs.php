<?php

ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
require_once('outsourcehr-admin/inc/fns.php');

$search = mysqli_real_escape_string($db, $_POST['search']);
$location = mysqli_real_escape_string($db, $_POST['location']);

$today = today();


if ($search) {

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Latest Jobs | Job Portal | KlinHR</title>

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
<style>
    #myDIV .btn {
        color: #565759;
        font-size: 16px;
        font-weight: 400;
        border: none;
        outline: none;
    }

    #myDIV .btn:focus,
    .btn.focus {
        box-shadow: none;
    }

    #myDIV .active,
    .btn:hover {
        color: #009788;
        background-color: #C5D5EC;
        border-radius: 10px;
    }
</style>

<body>

    <?php include 'inc/header2.php'; ?>

    <div class="jb-banner">
        <div class="row">
            <div class="col-md-6 jb-bannerL">
                <div class="jb-bannerLt">
                    <div id="jb-bannerLh">Latest Jobs</div>
                </div>
            </div>
            <div class="col-md-6 jb-bannerR">
                <img src="./dist/images/jban.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="latest_jobspage">
            <div id="latest_jobspagehd">Recent job vacancies (<?php echo $lastest_num; ?>)</div>

            <?php
            for ($i = 0; $i < $lastest_num; $i++) {
                $latest_row = mysqli_fetch_array($lastest_result);
            ?>
                <div class="latest_jobspageBox">
                    <div class="latest_jobspageBoxnav">
                        <div class="latest_jobspageBoxnavR"><?php echo $latest_row['job_title']; ?></div>
                        <div class="latest_jobspageBoxnavL"><i class="fa-regular fa-bookmark"></i></div>
                    </div>

                    <div id="latest_jobspagesb"><?php echo $latest_row['client_name']; ?></div>

                    <div class="latest_jobspageBoxmenu">
                        <div class="latest_jobspageBoxmenu1">
                            <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-briefcase"></i></div>
                            <div class="latest_jobspageBoxmenu1b"><?php echo $latest_row['job_type']; ?></div>
                        </div>
                        <div class="latest_jobspageBoxmenu1">
                            <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-briefcase"></i></div>
                            <div class="latest_jobspageBoxmenu1b"><i class="fa-solid fa-dollar-sign"></i><?php echo $latest_row['salary']; ?></div>
                        </div>
                        <div class="latest_jobspageBoxmenu1">
                            <div class="latest_jobspageBoxmenu1a"><i class="fa-solid fa-location-dot"></i></div>
                            <div class="latest_jobspageBoxmenu1b"><?php echo $latest_row['state']; ?></div>
                        </div>
                    </div>

                    <p><?php echo substr($latest_row['description'], 0, 300); ?>... </p>

                    <img src="./dist/images/ljl.png" alt="" class="img-fluid">

                    <div class="latest_jobspageBoxft">
                        <div class="latest_jobspageBoxft1" style="font-weight: 500;"><?php echo get_time_ago($latest_row['date_posted']); ?></div>
                        <div class="latest_jobspageBoxft2"><a href="job-description?valid=<?= base64_encode($latest_row['id']); ?>"><button>Apply</button></a></div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <br><br><br>

    <script>
        var header = document.getElementById("myDIV");
        var btns = header.getElementsByClassName("btn");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function() {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";
            });
        }
    </script>








    <?php include 'inc/footer.php'; ?>

</body>

</html>