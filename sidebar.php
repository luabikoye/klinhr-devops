<?php


$page = basename($_SERVER['SCRIPT_NAME']);


?>

<div class="dashboard_nav">
    <div class="sidebar" style="background-color: #006BFF;">
        <div id="dashboard_nav_logo">
            <a href="./"><img src="./dist/images/flogo.png" class="img-fluid" width="150px"></a>
        </div>
        <a href="dashboard" class="<?php if($page == 'dashboard.php'){ echo 'active'; } ?>"><i class="fa-brands fa-slack"></i>&nbsp;&nbsp; Dashboard</a>
        
        <a href="credentials" class="<?php if($page == 'credentials.php'){ echo 'active'; } ?>"><i class="fa-solid fa-file-circle-check"></i>&nbsp;&nbsp; Credentials</a>
        <a href="profile?nav=1" class="<?php if($page == 'profile.php'){ echo 'active'; } ?>"><i class="fa-solid fa-circle-user"></i>&nbsp;&nbsp; Profile</a>
        <a href="application-history" class="<?php if($page == 'application-history.php' ){ echo 'active'; } ?>"><i class="fa-solid fa-clock-rotate-left"></i>&nbsp;&nbsp; Application History</a>
        <a href="change-password" class="<?php if($page == 'change-password.php' ){ echo 'active'; } ?>"><i class="fa-solid fa-unlock"></i>&nbsp;&nbsp; Change Password</a>
        <a href="logout"><i class="fa-solid fa-right-from-bracket"></i>&nbsp;&nbsp; Log Out</a>
    </div>
</div>