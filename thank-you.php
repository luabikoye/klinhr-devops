<?php

ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
if (isset($_GET['secured'])) {
    $_SESSION['secured'] = $_GET['secured'];
}

if (isset($_GET['valid'])) {
    $id = base64_decode($_GET['valid']);
}

if (isset($_SESSION['return_id'])) {
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

    <title>Apply Form | Job Portal | KlinHR</title>

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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

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
    <style>
        .but {
            border: none;
            outline: none;
            color: #000;
            background-color: #fff;
            padding: 10px;
            border-radius: 20px;
        }
    </style>
</head>

<body>


    <div class="container-fluid">
        <div class="row loginPage">
            <div class="col-md-12 loginPageL">
                <div id="loginPageLogo"><a href="index"><img src="./dist/images/flogo.png" class="img-fluid"
                            style="width: 150px;"></a></div>
                <form action="login" method="post" class="loginPageMain">
                    <div id="loginPageMainhd">Thank you for applying</div>
                    <p>We've received your application and are currently reviewing it. If your qualifications and
                        experience match what we're looking for, we'll be in touch to discuss next steps.</p>
                    <input type="hidden" name="email" class="form-control" value="<?= $email ?>" id="email"
                        placeholder="Email address">
                    <input type="hidden" name="password" value="<?= $password ?>" class="form-control" id="password"
                        placeholder="Password">
                    <button type="submit" name="btn_login" class="but" id="btn_login">Login To Complete Your
                        Profile</button>
                    <button type="submit" name="btn_apply" class="but" value="apply" id="btn_login">Login To Apply For
                        More Jobs</button>
                </form>
            </div>
        </div>
    </div>


</body>

</html>