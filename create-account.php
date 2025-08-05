<?php

ob_start();
session_start();
include("outsourcehr-admin/connection/connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">

  <title>Create Account | Job Portal | KlinHR</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="dist/css/bootstrap.css">

  <link href="dist/font-awesome/css/all.css" rel="stylesheet" type="text/css">

  <link rel="icon" href="./dist/images/favicon.png" />

  <link href="dist/css/animate.css" rel="stylesheet">

  <link href="dist/css/owl.carousel.css" rel="stylesheet">

  <link href="dist/css/owl.theme.default.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

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
    /* *{
        font-family: "Poppins", sans-serif;
    } */
  </style>
</head>

<body>


  <div class="container-fluid">
    <div class="row loginPage">
      <div class="col-md-6 loginPageL">
        <div id="loginPageLogo"><a href="index"><img src="./dist/images/flogo.png" class="img-fluid" style="width: 150px;"></a></div>
        <div class="loginPageMain">
          <div id="loginPageMainhd">Hello, Friend!</div>
          <p>Welcome to KlinHR an automated HR Business Solution, Create your account to get started.</p>
        </div>
      </div>
      <form action="proc_signup.php" method="post" class="col-md-6 loginPageR" style="padding-top: 78px;">
        <div id="loginPageRhd">Create Account</div>

        <div class="signuoPageimp">
          <?php
          if ($success) echo '<div class="alert alert-success">' . $success . '</div>';
          ?>

          <?php
          if ($error) echo '<div class="alert alert-danger">' . $error . '</div>';
          ?>

          <div class="text-danger signup_result mb-3" id="error">
          </div>

          <div class="mb-3 signup_result" id="error2"></div>


          <div class="form-group">


            <input
              type="text"
              class="form-control"
              id="firstname"
              name="firstname"
              placeholder="First Name" />
          </div>
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              id="lastname"
              name="lastname"
              placeholder="Surname" />
          </div>
          <div class="form-group">
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              placeholder="Email" />
          </div>
          <div class="form-group">
            <input
              type="phone"
              class="form-control"
              id="phone"
              name="phone"
              placeholder="Phone" />
          </div>
          <div class="form-group">
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              placeholder="Password"
              style="margin-bottom: 7px;" />
            <!-- <span 
                style="float: right; margin-top: -30px;  position: relative; z-index: 2;"
                toggle="#password" 
                class="fa fa-fw fa-eye field-icon toggle-password">
              </span> -->
            <span style="font-size: 10px; font-weight: 400;">Minimum of 6 Characters</span>
          </div>
          <div class="form-group">
            <select name="hear_about" id="" style="
              width: 100%;
              border: 1px solid #dedede;
              padding: 10px;
              border-radius: 10px;
              box-shadow: none;
              color: #495057;">
              <option value="">How did you get to know us ?</option>
              <option value="Google">Google</option>
              <option value="Facebook">Facebook</option>
              <option value="Instagram">Instagram</option>
              <option value="Twitter">Twitter</option>
              <option value="LinkedIn">LinkedIn</option>
              <option value="Friend">Friend</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>

        <div class="staySigned">
          <div id="staySignedL"></div>
          <div id="staySignedR" style="font-size: 14px;">Already have an account? <a href="login" style="color: #237FFE; font-size: 14px;">Login</a></div>
        </div>
        <button type="submit">Sign Up</button>
      </form>
    </div>
  </div>


</body>

</html>