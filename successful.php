<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    
<title>Successful | Job Portal  | KlinHR</title>
    
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


<div class="dashboard_nav">
    <div class="sidebar">
        <div id="dashboard_nav_logo">
            <a href="./"><img src="./dist/images/f-logo.png" class="img-fluid"></a>
        </div>
        <a class="active" href="dashboard"><i class="fa-brands fa-slack"></i>&nbsp;&nbsp; Dashboard</a>
        <a href="credentials"><i class="fa-solid fa-file-circle-check"></i>&nbsp;&nbsp; Credentails</a>
        <a href="profile"><i class="fa-solid fa-circle-user"></i>&nbsp;&nbsp; Profile</a>
        <a href="application-history"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;&nbsp; Application History</a>
        <a href="change-password"><i class="fa-solid fa-unlock"></i>&nbsp;&nbsp; Change Passord</a>
        <a href="index"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp; Log Out</a>
    </div>
</div>

<div class="content">
    <div class="dashboard_nav_menu">
        <div class="dashboard_nav_menu1">
            <div id="dashboard_nav_menu1h">Dashboard</div>
        </div>
        <div class="dashboard_nav_menu2">
            <i class="fa-solid fa-magnifying-glass"></i>
            <form action="dashboard" method="GET">
<input type="text" placeholder="Search for Job..." name="glo_search">
</form>
        </div>
        <div class="dashboard_nav_menu3">
            <div id="dashboard_nav_menu31">
                <a href="notifications">
                <div id="dashboard_nav_menu31a">
                    <i class="fa-solid fa-bell"></i>
                    <span>10</span>
                </div>
                </a>
                <div id="dashboard_nav_menu31b"><img src="./dist/images/dnl.png" class="img-fluid"></div>                            
            </div>
            <div id="dashboard_nav_menu32">
                <div id="dash_userimg"><img src="<?php echo show_img('uploads/documents/'.$profile_row['passport']); ?>" class="img-fluid" style="height: 40px; width: 40px;"></div>
                <div id="dash_username">Hello <?php echo get_info($_SESSION['candidate_id'],'firstname'); ?></div>                
            </div>
        </div>
    </div>    

    <div class="content_body">
        <div class="row">
            <div class="col-md-10">
                <div class="successP">
                    <img src="./dist/images/succ.png" class="img-fluid">
                    <div id="successPhd">Application Submitted</div>
                    <p>Lead Quality Assurance Manager</p>
                </div>
            </div>
        </div> 
    </div>

</div>






</body>
</html>