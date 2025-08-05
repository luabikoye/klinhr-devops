<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Apply form | Job Portal | Klinsheet Consulting</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="dist/css/bootstrap.css">

    <link href="dist/font-awesome/css/all.css" rel="stylesheet" type="text/css">

    <link rel="icon" href="./dist/images/favicon.ico" />

    <link href="dist/css/animate.css" rel="stylesheet">

    <link href="dist/css/owl.carousel.css" rel="stylesheet">

    <link href="dist/css/owl.theme.default.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="dist/js/jquery.3.4.1.min.js"></script>

    <script src="dist/js/popper.js" type="text/javascript"></script>

    <script src="dist/js/bootstrap.js" type="text/javascript"></script>

    <script src="dist/js/owl.carousel.js"></script>


    <!-- Main Stylesheet -->
    <link href="new_dist/style.css" rel="stylesheet" type="text/css" media="all">

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
                <div id="loghead">Welcome to KlinHR. Create your account to get started.</div>
                <div id="log-icons">
                    <a href=""><img src="./new_dist/images/log1.svg" class="img-fluid"></a>
                    <a href=""><img src="./new_dist/images/log2.svg" class="img-fluid"></a>
                    <a href=""><img src="./new_dist/images/log3.svg" class="img-fluid"></a>
                </div>
                <div id="dontHave">Don’t have an account? <span><a href="signup">Signup</a></span></div>
            </div>
            <form action="applied" method="post" enctype="multipart/form-data" class="col-md-6 logRowb"
                style="padding-top: 78px;">
                <div id="loginPageRhd">Personal Information</div>
                <div class="staySigned">
                    <div id="staySignedL"></div>
                    <div id="staySignedR" style="font-size: 14px;">Already have an account? <a
                            href="login?return=<?= $return ?>" style="color: #237FFE; font-size: 14px;">Login</a></div>
                </div>
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


                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name"
                            value="<?= $firstname ?>" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Surname"
                            value="<?= $lastname ?>" />
                        <input type="hidden" name="return" value="<?= $return ?>">
                        <input type="hidden" name="id" value="<?= $_SESSION['return_id'] ?>">
                    </div>
                    <div class="form-group">
                        <select name="country_code" id="" style="
              width: 100%;
              border: 1px solid #dedede;
              padding: 10px;
              border-radius: 10px;
              box-shadow: none;
              color: #495057;">
                            <?php if ($country_code) {
                                echo "<option>$country_code</option>";
                            } ?>
                            <option value="">Choose Country Code</option>
                            <?= country_code() ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="phone" class="form-control" id="phone" name="phone" placeholder="Phone"
                            value="<?= $phone ?>" />
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                            value="<?= $email ?>" />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            style="margin-bottom: 7px;" value="<?= $password ?>" />
                        <span style="font-size: 10px; font-weight: 400;">Minimum of 6 Characters</span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="password" name="address" placeholder="Address"
                            style="margin-bottom: 7px;" value="<?php echo $address; ?>" />
                    </div>
                    <div class="form-group">
                        <select name="state" id="" style="
              width: 100%;
              border: 1px solid #dedede;
              padding: 10px;
              border-radius: 10px;
              box-shadow: none;
              color: #495057;">
                            <?php if ($state) {
                                echo "<option>$state</option>";
                            } ?>
                            <option value="">Choose one</option>
                            <?= list_state() ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select name="country" id="" style="
              width: 100%;
              border: 1px solid #dedede;
              padding: 10px;
              border-radius: 10px;
              box-shadow: none;
              color: #495057;">
                            <?php if ($country) {
                                echo "<option>$country</option>";
                            } ?>
                            <option value="Nigeria">Nigeria</option>
                            <?= country() ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" onfocus="this.type='date'" class="form-control" id="password" name="dob"
                            placeholder="Date Of Birth" style="margin-bottom: 7px;" value="<?= $dob ?>" />
                    </div>
                    <div class="form-group">
                        <select name="gender" id="" style="
              width: 100%;
              border: 1px solid #dedede;
              padding: 10px;
              border-radius: 10px;
              box-shadow: none;
              color: #495057;">
                            <?php if ($gender) {
                                echo "<option>$gender</option>";
                            } ?>
                            <option value="">Choose Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <button type="button" class="next mt-4" id="logBtn"> Continue to Qualification >></button>
                </div>
                <div class="second">
                    <div id="loginPageRhd">Qualifications</div>
                    <div class="">
                        <div class="form-group">
                            <select name="first_qualification" id="" style="
              width: 100%;
              border: 1px solid #dedede;
              padding: 10px;
              border-radius: 10px;
              box-shadow: none;
              color: #495057;">
                                <?php if ($first_qualification) {
                                    echo "<option>$first_qualification</option>";
                                } ?>
                                <option value="">Select Highest Qualification</option>
                                <?= list_qualifications() ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="class_degree" id="" style="
              width: 100%;
              border: 1px solid #dedede;
              padding: 10px;
              border-radius: 10px;
              box-shadow: none;
              color: #495057;">
                                <?php if ($class_degree) {
                                    echo "<option>$class_degree</option>";
                                } ?>
                                <option value="">Select Class of Degree</option>
                                <?= list_class_degree() ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <input type="text" class="form-control" id="password" name="first_institution"
                                placeholder="Name of School/Institution" style="margin-bottom: 7px;"
                                value="<?php echo $first_institution; ?>" />
                        </div>


                        <div class="form-group">
                            <select name="experience_1" id="" style="
              width: 100%;
              border: 1px solid #dedede;
              padding: 10px;
              border-radius: 10px;
              box-shadow: none;
              color: #495057;">
                                <?php if ($experience_1) {
                                    echo "<option>$experience_1</option>";
                                } ?>
                                <option value="">Select Years of Experience</option>

                                <option value="Entry Level">Entry Level</option>
                                <option value="0 - 1 year">0 - 1 year</option>
                                <option value="1 - 3 years">1 - 3 years</option>
                                <option value="3 - 5 years">3 - 5 years</option>
                                <option value="5 - 7 years">5 - 7 years</option>
                                <option value="7 - 10 years">7 - 10 years</option>
                                <option value="10 - 15 years">10 - 15 years</option>
                                <option value="15+">15+</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="email" name="position"
                                placeholder="Current Job Function" value="<?= $position ?>" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="phone" name="desire"
                                placeholder="Desired Job Function" value="<?= $desire ?>" />
                        </div>
                        <div class="form-group">
                            <input type="text" onfocus="this.type='date'" class="form-control" id="password"
                                name="available" placeholder="Availability" style="margin-bottom: 7px;"
                                value="<?= $available ?>" />
                        </div>
                        <div class="form-group">
                            <input type="text" onfocus="this.type='file'" class="form-control" id="" name="file"
                                placeholder="Upload CV" style="margin-bottom: 7px;" value="<?= $cv ?>" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="button" id="logBtn" style="background-color: grey;" class="btn back">
                            << Back </button>
                                <button id="logBtn" type="submit">Apply Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</body>

</html>
<option value="5 - 7 years">5 - 7 years</option>
<option value="7 - 10 years">7 - 10 years</option>
<option value="10 - 15 years">10 - 15 years</option>
<option value="15+">15+</option>
</select>
</div>
<div class="form-group">
    <input type="text" class="form-control" id="email" name="position"
        placeholder="Current Job Function" value="<?= $position ?>" />
</div>
<div class="form-group">
    <input type="text" class="form-control" id="phone" name="desire"
        placeholder="Desired Job Function" value="<?= $desire ?>" />
</div>
<div class="form-group">
    <input type="text" onfocus="this.type='date'" class="form-control" id="password"
        name="available" placeholder="Availability" style="margin-bottom: 7px;"
        value="<?= $available ?>" />
</div>
<div class="form-group">
    <input type="text" onfocus="this.type='file'" class="form-control" id="" name="file"
        placeholder="Upload CV" style="margin-bottom: 7px;" value="<?= $cv ?>" />
</div>
</div>
<div class="mt-4">
    <button type="button" style="background-color: grey;" class="btn back">
        << Back </button>
            <button type="submit">Apply Now</button>
</div>
</div>
</form>
</div>
</div>
<script>
    $(document).ready(function() {
        $('.second').hide()
        $('.next').click(function() {
            $('.next').hide()
            $('.second').show()
            $('.signuoPageimp').hide()
            $('#loginPageRhd').hide()
        })
        $('.back').click(function() {
            $('.next').show()
            $('.second').hide()
            $('.signuoPageimp').show()
            $('#loginPageRhd').show()
        })
    })
</script>

</body>

</html>