<?php

include("outsourcehr-admin/connection/connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Forgot Password | Job Portal | KlinHR</title>

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


    <link href="new_dist/style.css" rel="stylesheet" type="text/css" media="all">
    <!-- Main Stylesheet -->
    <link href="dist/style.css" rel="stylesheet" type="text/css" media="all">


    <script src="dist/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
</head>

<body>


    <div class="container-fluid">
        <div class="row loginPage">
            <div class="col-md-6 logRowa">
                <div id="log-logo"><a href="./"><img src="./new_dist/images/log-logo.png" class="img-fluid"></a></div>
                <div id="loghead">You can also login to continue with</div>
                <div id="log-icons">
                    <a href=""><img src="./new_dist/images/log1.svg" class="img-fluid"></a>
                    <a href=""><img src="./new_dist/images/log2.svg" class="img-fluid"></a>
                    <a href=""><img src="./new_dist/images/log3.svg" class="img-fluid"></a>
                </div>
                <div id="dontHave">Don’t have an account? <span><a href="signup">Signup</a></span></div>
            </div>
            <form action="proc_forgot.php" method="post" class="col-md-6 logRowb">
                <div id="loginPageRhd">Get Your Account</div>
                <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>

                <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
                <div class="">
                    <input type="email" name="email" placeholder="Enter your email address">
                </div>
                <div class="staySigned">
                    <div id="staySignedL"><a href="login.php">Remember Now?</a></div>
                    <div id="staySignedR"><a href="create-account.php">Don't have an account? Sign up</a></div>
                </div>
                <button id="logBtn">Send</button>
            </form>
        </div>
    </div>


</body>

</html>