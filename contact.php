<?php

ob_start();
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Contact Us | Job Portal | KlinHR</title>

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

    <?php include 'inc/header2.php'; ?>

    <div class="jb-banner">
        <div class="row">
            <div class="col-md-6 jb-bannerL">
                <div class="jb-bannerLt">
                    <div id="jb-bannerLh">Contact Us</div>
                </div>
            </div>
            <div class="col-md-6 jb-bannerR">
                <img src="./dist/images/jban.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>

    <div class="container">
        <div id="contactHd" style="margin-bottom: 20px;">Keep in Touch with Us</div>

        <form action="proc-contact" method="post" class="row">
            <div class="col-md-12 contact_row">
                <?php if ($error) { ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php } ?>
                <?php if ($success) { ?>
                    <div class="alert alert-success"><?= $success ?></div>
                <?php } ?>
                <br>
                <br>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="name" placeholder="Name">
                    </div>
                    <div class="col-md-4">
                        <input type="email" name="email" placeholder="Email ID">
                    </div>
                    <div class="col-md-4">
                        <input type="phone" name="phone" placeholder="Phone">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <textarea name="message" id="" cols="30" rows="5" placeholder="Type your message"></textarea>
                    </div>
                </div>
            </div>
            <div id="contactpgbtn" style="width: 100%;">
                <button type="submit">Send Message</button>
            </div>
        </form>


    </div>


    <?php include 'inc/footer.php'; ?>

</body>

</html>