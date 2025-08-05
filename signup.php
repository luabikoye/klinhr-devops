<?php

ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Signup | KlinHR Portal</title>

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

    <div class="logArea">
        <div class="row">
            <div class="col-md-6 logRowa">
                <div id="log-logo"><a href="./"><img src="./new_dist/images/log-logo.png" class="img-fluid"></a></div>
                <div id="loghead">You can also login to continue with</div>
                <div id="log-icons">
                    <a href=""><img src="./new_dist/images/log1.svg" class="img-fluid"></a>
                    <a href=""><img src="./new_dist/images/log2.svg" class="img-fluid"></a>
                    <a href=""><img src="./new_dist/images/log3.svg" class="img-fluid"></a>
                </div>
                <div id="dontHave">Already have an account? <span><a href="login">Login</a></span></div>
            </div>
            <form action="proc_signup.php" method="post" class="col-md-6 logRowb" style="padding-top: 50px;">
                <div id="logRowbh" style="margin-bottom: 10px;">Signup</div>
                <p style="margin-bottom: 60px; font-size: 16px;">Create an acccount to get started</p>
                <?php
                if ($success) echo '<div class="alert alert-success">' . $success . '</div>';
                ?>

                <?php
                if ($error) echo '<div class="alert alert-danger">' . $error . '</div>';
                ?>
                <div class="row">
                    <div class="col-md-10">
                        <input type="text" placeholder="Firstname" name="firstname">
                        <input type="text" placeholder="Lastname" name="lastname">
                        <input type="email" placeholder="Email Address" name="email">
                        <input type="text" placeholder="Phone" name="phone">
                        <input type="password" name="password" id="password-field" placeholder="Create Password">
                        <span toggle="#password-field" class="fa-solid fa-eye-slash field-icon toggle-password"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div id="logMin">Mininmum of 8 characters</div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-10">
                        <input type="text" placeholder="How did you get to know us?" name="hear_about">
                    </div>
                </div>

                <button id="logBtn" disabled>Signup</button>

            </form>
        </div>
    </div>

    <script>
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-regular fa-eye");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $('#password-field').on('input', function() {
            const password = $(this).val();
            const passwordLength = password.length;

            if (passwordLength < 8) {
                $('#logBtn').prop('disabled', true)
            } else {
                $('#logBtn').prop('disabled', false)
            }

            $('#logMin').css('color', passwordLength >= 8 ? 'green' : 'red');
        });
    </script>

</body>

</html>