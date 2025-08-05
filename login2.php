<?php
ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
if (isset($_GET['return'])) {
    $return = ($_GET['return']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Login | Job Portal | KlinHR</title>

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
</head>

<body>


    <div class="container-fluid">
        <div class="row loginPage">
            <div class="col-md-6 loginPageL">
                <div id="loginPageLogo"><a href="index"><img src="./dist/images/flogo.png" class="img-fluid"
                            style="width: 150px;"></a></div>
                <div class="loginPageMain">
                    <div id="loginPageMainhd">Welcome Back!</div>
                    <p>Hey there, welcome back! We've been waiting for your return. Your presence adds an extra spark to
                        our platform!</p>
                </div>
            </div>
            <form action="proc_login.php" method="post" class="col-md-6 loginPageR" enctype="multipart/form-data">
                <div id="loginPageRhd">Login to Your Account</div>
                <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>

                <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
                <div class="loginPageR-field">
                    <div id="loginPageR-fielda"><i class="fa-solid fa-envelope"></i></div>
                    <div id="loginPageR-fieldb"><img src="./dist/images/ll.png" class="img-fluid"></div>
                    <div id="loginPageR-fieldc"><input type="email" id="email" name="email"
                            placeholder="Enter your email address" value="<?php echo $email; ?>"></div>
                </div>
                <div class="loginPageR-field">
                    <div id="loginPageR-fielda"><i class="fa-solid fa-user-lock"></i></div>
                    <div id="loginPageR-fieldb"><img src="./dist/images/ll.png" class="img-fluid"></div>
                    <div id="loginPageR-fieldc"><input type="password" id="password" name="password"
                            placeholder="Enter your password"></div>
                </div>
                <div class="staySigned">
                    <?php
                    if ($return) {
                    ?>
                    <div id="staySignedL"><input type="checkbox" id="cv" name=""> Do you want to change Cv</div>
                    <?php } ?>
                    <div id="staySignedL"><a href="forgot.php">I’ve forgotten my password</a></div>
                </div>
                <div class="loginPageR-field d-none cv">
                    <div id="loginPageR-fielda"><i class="fa-solid fa-file"></i></div>
                    <div id="loginPageR-fieldb"><img src="./dist/images/ll.png" class="img-fluid"></div>
                    <div id="loginPageR-fieldc"><input type="text" id="" onfocus="this.type='file'" name="cv"
                            placeholder="Upload CV"></div>
                </div>
                <input type="hidden" name="return" value="<?php echo $return; ?>">
                <button type="submit"><?php if($return){ echo 'Login to Apply'; } else { echo 'Login'; } ?></button>
            </form>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#cv').click(function() {
            if ($(this).is(':checked')) {
                $('.cv').removeClass('d-none')
            } else {
                $('.cv').addClass('d-none')
                $('.cv input[type="file"]').attr('type', 'text')
            }
        })
    })
    </script>

</body>

</html>