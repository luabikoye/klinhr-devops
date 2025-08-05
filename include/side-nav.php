 <?php
    $page = 'class="active"';
    $pagename = basename($_SERVER['SCRIPT_NAME']);
    ?>
 <div class="col-md-3 dashboardNavLeft">
     <div class="dashboardNav">
         <div id="dashboardNavlogo">
             <a href="./"><img src="./new_dist/images/dlogo.png" class="img-fluid"></a>
         </div>
         <div class="sidebar-list">
             <a <?= $pagename == 'dashboard.php' ? $page : ''  ?> href="dashboard"><i class='fa fa-th-large'></i> Dashboard</a>
             <a <?= $pagename == 'applied-job.php' ? $page : ''  ?> href="applied-job"><i class="fa-solid fa-briefcase"></i> Applied Job</a>
             <a <?= $pagename == 'job-offers.php' ? $page : ''  ?> href="job-offers"><i class="fa-solid fa-briefcase"></i> Job Offers</a>
             <a <?= $pagename == 'saved-jobs.php' ? $page : ''  ?> href="saved-jobs"><i class="fa-regular fa-heart"></i> Saved Jobs</a>
             <a <?= $pagename == 'my-profile.php' ? $page : ''  ?> href="my-profile"><i class="fa-solid fa-user-tie"></i> My Profile</a>
             <a <?= $pagename == 'my-credentials.php' ? $page : ''  ?> href="my-credentials"><i class="fa-regular fa-address-book"></i> My Credentials</a>
             <!-- <a href="job-alerts"><i class="fa-solid fa-briefcase"></i> Job Alerts</a> -->
             <a <?= $pagename == 'change-password.php' ? $page : ''  ?> href="change-password"><i class="fa-solid fa-unlock-keyhole"></i> Change Password</a>
             <a href="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
         </div>
     </div>
 </div>