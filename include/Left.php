<div class="col-md-3" id="profile_banner_a">
    <div class="row">
        <div class="col-9">
            <div id="dash_log">
                <div id="dash_pic">
                    <img style="border-radius: 50px; width: 100px;" src="<?php profile_img();?>" class="img-fluid">
                </div>

                <div id="dash_info">
                    <p> <b><?php echo UserCheck($email);?></b> <br>User</p>
                </div>
            </div>
            <div id="jackline">
                <img src="images/jackline.png" class="img-fluid">
            </div>
        </div>

        <div class="col-3">
            <div id="nav_icon" style="margin-left: 20px;">
                <i class="fa fa-2x fa-bars"> </i>
            </div>
        </div>
    </div>


    <div id="dash_list_board">

        <ul id="nav_list">
            <li><a href="dashboard" class="dash-side">
                    <div class="sidebar-list">
                        <i class="fa fa-home"></i> &nbsp;&nbsp; Dashboard
                    </div>
                </a>
            </li>
            <li><a href="personal" class="dash-side">
                    <div class="sidebar-list">
                        <i class="fa fa-user-circle"></i>&nbsp;&nbsp; <b>My Profile</b>
                    </div>
                </a>
            </li>
            <li><a href="jobs" class="dash-side">
                    <div class="sidebar-list">
                        <i class="fa fa-briefcase"></i>&nbsp;&nbsp; Vacancies
                    </div>
                </a>
            </li>
            <li><a href="my-credentials" class="dash-side">
                    <div class="sidebar-list">
                        <i class="fa fa-file-alt"></i>&nbsp;&nbsp; My Credentials
                    </div>
                </a>
            </li>
            <li><a href="jobs-applied" class="dash-side">
                    <div class="sidebar-list">
                        <i class="fa fa-newspaper"></i>&nbsp;&nbsp; Jobs Applied for
                    </div>
                </a>
            </li>

            <li><a href="job-offers" class="dash-side">
                    <div class="sidebar-list">
                        <i class="fa fa-history"></i>&nbsp;&nbsp; Application History
                    </div>
                </a>
            </li>

            <li><a href="notification" class="dash-side">
                    <div class="sidebar-list">
                        <i class="fa fa-bell"></i>&nbsp;&nbsp; Notifications
                        <?php $count = mysqli_num_rows(mysqli_query($db, "select * from notification where candidate_id = '".$_SESSION['candidate_id']."' and status = 'Unread' "));
                                     if(($count))
                                     {

                                     ?>
                        <span style="background-color: gray;" class="badge badge-dark"
                            style="color: black; font-size: 15px;">
                            <?php 
                                if(($count))
                                {
                                    echo number_format($count);

                                } ;?> </span> <?php } ?>
                    </div>
                </a>
            </li>

            <li><a href="change-password" class="dash-side">
                    <div class="sidebar-list">
                        <i class="fa fa-unlock"></i>&nbsp;&nbsp; Change Password
                    </div>
                </a>
            </li>
            <li><a href="#" class="dash-side">
                    <div class="sidebar-list">
                        <i class="fa fa-video"></i>&nbsp;&nbsp; Quick Guide
                    </div>
                </a>
            </li>
            <li><a data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#exampleModal"
                    href="logout" class="dash-side">
                    <div class="sidebar-list">
                        <i class="fa fa-lock"></i>&nbsp;&nbsp; Logout
                    </div>
                </a>
            </li>


        </ul>
    </div>
</div>


<div style="top: 100px;" id="exampleModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure you want to Log Out?</h5>

                <button type="button" id="checked" class="btn" data-dismiss="modal" type="button"><i
                        class="fa fa-times"></i> </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <button data-href='logout' type="button" id="checked"
                        class="clickable-row btn btn-success text-center" data-dismiss="modal" type="button">Log
                        Out</button>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {
        $(".clickable-row").click(function () {
            window.location = $(this).data("href");
        });
    });
</script>