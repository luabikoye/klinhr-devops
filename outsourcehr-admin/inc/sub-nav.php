<aside
    class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered bg-white  ">
    <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
            <!-- Logo -->

            <a class="navbar-brand" href="dashboard" aria-label="Front">
                <img class="navbar-brand-logo" src="./assets/img/logo.png" alt="Logo"
                    data-hs-theme-appearance="default">
            </a>

            <!-- End Logo -->

            <!-- Navbar Vertical Toggle -->
            <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                <i class="bi-arrow-bar-left navbar-toggler-short-align"
                    data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
                <i class="bi-arrow-bar-right navbar-toggler-full-align"
                    data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
                    data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
            </button>

            <!-- End Navbar Vertical Toggle -->

            <!-- Content -->
            <div class="navbar-vertical-content">
                <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">
                    <div class="nav-item">
                        <a class="nav-link active" href="dashboard" data-placement="left">
                            <i class="bi-house-door nav-icon"></i>
                            <span class="nav-link-title">Dashboard</span>
                        </a>
                    </div>

                    <!-- Collapse -->
                    <?php if (check_module($_SESSION['privilege'], 'Vacancies') == 'yes') {
                    ?>
                        <div id="navbarVerticalMenuPagesMenu">
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesUsersMenu" role="button"
                                    data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesUsersMenu"
                                    aria-expanded="false" aria-controls="navbarVerticalMenuPagesUsersMenu">
                                    <i class="bi-briefcase nav-icon"></i>
                                    <span class="nav-link-title">Vacancies</span>
                                </a>

                                <div id="navbarVerticalMenuPagesUsersMenu" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenuPagesMenu">
                                    <a class="nav-link " href="add-job">
                                        <i class="bi-plus-square-fill nav-icon"></i>
                                        Add Job Post</a>
                                    <a class="nav-link " href="./job-posted?valid=<?php echo date('Y-m-d'); ?>">
                                        <i class="bi-file-earmark-fill nav-icon"></i>
                                        Job Posted<span class="badge bg-info rounded-pill ms-1"><?php $count = mysqli_num_rows(mysqli_query($db, "select * from job_post where deadline >= '" . date('Y-m-d') . "' and account_token = '".$_SESSION['account_token']."' order by id desc"));
                                                                                                echo  number_format($count); ?></span></a>
                                    <a class="nav-link " href="./job-posted?expired=<?php echo date('Y-m-d'); ?>">
                                        <i class="bi-stopwatch-fill nav-icon"></i>
                                        Job Expired <span class="badge bg-info rounded-pill ms-1"><?php $count = mysqli_num_rows(mysqli_query($db, "select * from job_post where deadline < '" . date('Y-m-d') . "' and account_token = '" . $_SESSION['account_token'] . "' order by id desc"));
                                                                                                    echo number_format($count); ?></span></a>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>
                        <?php if (check_module($_SESSION['privilege'], 'Job Seeker') == 'yes') {
                        ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesUserProfileMenu"
                                    role="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarVerticalMenuPagesUserProfileMenu" aria-expanded="false"
                                    aria-controls="navbarVerticalMenuPagesUserProfileMenu">
                                    <i class="bi-person nav-icon"></i>
                                    <span class="nav-link-title">Job Seekers <span
                                            class="badge bg-primary rounded-pill ms-1"><?php                                             
                                            $count = mysqli_num_rows(mysqli_query($db, "select * from jobseeker_signup WHERE account_token = '" . $_SESSION['account_token'] . "'  "));
                                                                                        echo number_format($count); ?></span></span>
                                </a>

                                <div id="navbarVerticalMenuPagesUserProfileMenu" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenuPagesMenu"> <a class="nav-link "
                                        href="registered-users">
                                        <i class="bi-people-fill nav-icon"></i>
                                        Registered Users<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab('jobseeker_signup')) ?></span></a>
                                    <a class="nav-link " href="applicants?cat=<?php echo base64_encode('applied'); ?>">
                                        <i class="bi-people-fill nav-icon"></i>
                                        Applicants<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('jobs_applied', 'status', 'applied', $_SESSION['account_token'])) ?></span></a>
                                    <a class="nav-link " href="applicants?cat=<?php echo base64_encode('assessment'); ?>">
                                        <i class="bi-stopwatch-fill nav-icon"></i>
                                        Assesments<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo  number_format(sub_count_tab_val('jobs_applied', 'status', 'assessment', $_SESSION['account_token'])); ?></span></a>
                                    <a class="nav-link "
                                        href="applicants?cat=<?php echo base64_encode('first level interview'); ?>">
                                        <i class="bi-bank2 nav-icon"></i>
                                        First Level Interview<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('jobs_applied', 'status', 'First Level Interview', $_SESSION['account_token'])) ?></span></a>
                                    <a class="nav-link "
                                        href="applicants?cat=<?php echo base64_encode('second level interview'); ?>">
                                        <i class="bi-person-check-fill nav-icon"></i>
                                        Second Level Interview<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('jobs_applied', 'status', 'Second Level Interview', $_SESSION['account_token'])) ?></span></a>
                                    <a class="nav-link " href="applicants?cat=<?php echo base64_encode('successful'); ?>">
                                        <i class="bi-hand-thumbs-up-fill nav-icon"></i>
                                        Successful<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('jobs_applied', 'status', 'Successful', $_SESSION['account_token'])) ?></span></a>
                                    <a class="nav-link " href="applicants?cat=<?php echo base64_encode('unsuccessful'); ?>">
                                        <i class="bi-hand-thumbs-down-fill nav-icon"></i>
                                        Unsuccessful<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('jobs_applied', 'status', 'Unsuccessful', $_SESSION['account_token'])) ?></span></a>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>


                        <?php if (check_module($_SESSION['privilege'], 'Onboarding') == 'yes') {
                        ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesAccountMenu"
                                    role="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarVerticalMenuPagesAccountMenu" aria-expanded="false"
                                    aria-controls="navbarVerticalMenuPagesAccountMenu">
                                    <i class="bi-person nav-icon"></i>
                                    <span class="nav-link-title">Onboarding<span
                                            class="badge bg-primary rounded-pill ms-1"><?php                                            
                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_staff_details where (completed = 'Y' || completed = 'N') AND account_token = '" . $_SESSION['account_token'] . "'  "));
                                                                                        echo number_format($count); ?></span></span>
                                </a>

                                <div id="navbarVerticalMenuPagesAccountMenu" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenuPagesMenu">
                                    <a class="nav-link " href="add-staff">
                                        <i class="bi-person-fill nav-icon"></i>
                                        Add Existing Staff</a>
                                    <a class="nav-link " href="onboarding-user?cat=<?php echo base64_encode('N'); ?>">
                                        <i class="bi-info-circle-fill nav-icon"></i>
                                        Pending<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('emp_staff_details', 'completed', 'N', $_SESSION['account_token'])) ?></span></a>
                                    <a class="nav-link " href="onboarding-user?cat=<?php echo base64_encode('Y'); ?>">
                                        <i class="bi-hand-thumbs-up-fill nav-icon"></i>
                                        Completed<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('emp_staff_details', 'completed', 'Y', $_SESSION['account_token'])) ?></span></a>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>


                        <?php if (check_module($_SESSION['privilege'], 'Verification') == 'yes') {
                            if (client_detail('verification') == 'yes') { ?>
                                <div class="nav-item">
                                    <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesEcommerceMenu"
                                        role="button" data-bs-toggle="collapse"
                                        data-bs-target="#navbarVerticalMenuPagesEcommerceMenu" aria-expanded="false"
                                        aria-controls="navbarVerticalMenuPagesEcommerceMenu">
                                        <i class="bi-person-check nav-icon"></i>
                                        <span class="nav-link-title">Verification<span
                                                class="badge bg-primary rounded-pill ms-1"><?php $count = mysqli_num_rows(mysqli_query($db, "select * from emp_staff_details where completed = 'Completed Verification' || completed = 'Pending Verification' "));
                                                                                            echo number_format($count); ?></span></span>
                                    </a>

                                    <div id="navbarVerticalMenuPagesEcommerceMenu" class="nav-collapse collapse "
                                        data-bs-parent="#navbarVerticalMenuPagesMenu">
                                        <a class="nav-link "
                                            href="verification?cat=<?php echo base64_encode('Pending Verification'); ?>">
                                            <i class="bi-info-circle-fill nav-icon"></i>
                                            New Verification<span
                                                class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('emp_staff_details', 'completed', 'Pending Verification', $_SESSION['account_token'])) ?></span></a>
                                        <a class="nav-link "
                                            href="verification?cat=<?php echo base64_encode('Completed Verification'); ?>">
                                            <i class="bi-hand-thumbs-up-fill nav-icon"></i>
                                            Completed Verification<span
                                                class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('emp_staff_details', 'completed', 'Completed Verification', $_SESSION['account_token'])) ?></span></a>
                                    </div>
                                </div>
                                <!-- End Collapse -->
                        <?php }
                        } ?>

                        <?php if (check_module($_SESSION['privilege'], 'Deployment') == 'yes') {
                        ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesProjectsMenu"
                                    role="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarVerticalMenuPagesProjectsMenu" aria-expanded="false"
                                    aria-controls="navbarVerticalMenuPagesProjectsMenu">
                                    <i class="bi-person nav-icon"></i>
                                    <span class="nav-link-title">Deploy Candidates<span
                                            class="badge bg-primary rounded-pill ms-1"><?php $count = mysqli_num_rows(mysqli_query($db, "select * from emp_staff_details where completed = 'Pool' and account_token = '" . $_SESSION['account_token'] . "'  "));
                                                                                        echo number_format($count); ?></span></span>
                                </a>

                                <div id="navbarVerticalMenuPagesProjectsMenu" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenuPagesMenu">
                                    <a class="nav-link " href="pool?cat=<?php echo base64_encode('pool'); ?>">
                                        <i class="bi-person-fill nav-icon"></i>
                                        Pool<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('emp_staff_details', 'completed', 'pool', $_SESSION['account_token'])) ?></span></a>
                                    <a class="nav-link " href="client?cat=<?php echo base64_encode('client'); ?>">
                                        <i class=" bi-hand-thumbs-up-fill nav-icon"></i>
                                        Assign To Client<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('emp_staff_details', 'completed', 'client', $_SESSION['account_token'])) ?></span></a>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>
                        <?php if (check_module($_SESSION['privilege'], 'HRBP') == 'yes' || (check_module($_SESSION['privilege'], 'Legal') == 'yes')) {
                        ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesProjectsMenu11"
                                    role="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarVerticalMenuPagesProjectsMenu11" aria-expanded="false"
                                    aria-controls="navbarVerticalMenuPagesProjectsMenu">
                                    <i class="bi-person nav-icon"></i>
                                    <span class="nav-link-title">HRBP<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('emp_staff_details', 'completed', 'client', $_SESSION['account_token'])) ?>
                                        </span></span>
                                </a>

                                <div id="navbarVerticalMenuPagesProjectsMenu11" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenuPagesMenu">
                                    <a class="nav-link " href="hrbp?cat=<?php echo base64_encode('client'); ?>">
                                        <i class=" bi-hand-thumbs-up-fill nav-icon"></i>
                                        Assigned Staff<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('emp_staff_details', 'completed', 'client', $_SESSION['account_token'])) ?></span></a>


                                    <a class="nav-link " href="assignedMessage">
                                        <i class=" bi-envelope-fill nav-icon"></i>
                                        Offer Letter Approvals<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab('approve_message')); ?></span></a>


                                    <a class="nav-link " href="hrbp?cat=<?php echo base64_encode('staff'); ?>">
                                        <i class=" bi-hand-thumbs-up-fill nav-icon"></i>
                                        Staff List<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('emp_staff_details', 'completed', 'staff', $_SESSION['account_token'])) ?></span></a>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>




                        <?php if (check_module($_SESSION['privilege'], 'Hr Operations') == 'yes') { ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesProjectMenu"
                                    role="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarVerticalMenuPagesProjectMenu" aria-expanded="false"
                                    aria-controls="navbarVerticalMenuPagesProjectMenu">
                                    <i class="bi-briefcase nav-icon"></i>
                                    <span class="nav-link-title">Hr Operation</span>
                                </a>

                                <div id="navbarVerticalMenuPagesProjectMenu" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenuPagesMenu">
                                    <a class="nav-link " href="grievances">
                                        <i class="bi-exclamation-triangle-fill nav-icon"></i>
                                        Grievances<span class="badge bg-primary rounded-pill ms-1"><?php
                                                                                                    if (privilege() == 'Super Admin') {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from emp_complaint"));
                                                                                                    } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from emp_complaint"));
                                                                                                    } else {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from emp_complaint  where access_type like '%" . get_priviledge($_SESSION['privilege_user']) . "%' "));
                                                                                                    }
                                                                                                    echo number_format($count); ?>
                                        </span></a>
                                    <div class="nav-item">
                                        <a class="nav-link dropdown-toggle"
                                            href="#navbarVerticalMenuPagesEcommerceCustomersMenu" role="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#navbarVerticalMenuPagesEcommerceCustomersMenu"
                                            aria-expanded="false"
                                            aria-controls="navbarVerticalMenuPagesEcommerceCustomersMenu">
                                            <i class="bi-door-open-fill nav-icon"></i>
                                            Leaves
                                        </a>

                                        <div id="navbarVerticalMenuPagesEcommerceCustomersMenu"
                                            class="nav-collapse collapse "
                                            data-bs-parent="#navbarVerticalMenuPagesMenuEcommerce">
                                            <a class="nav-link " href="leave-application">
                                                <i class="bi-door-open-fill nav-icon"></i>
                                                Leave Application<span
                                                    class="badge bg-primary rounded-pill ms-1"><?php
                                                                                                if (privilege() == 'Super Admin') {
                                                                                                    $count = mysqli_num_rows(mysqli_query($db, "select * from emp_leave_form where leave_type != 'Leave resumption' "));
                                                                                                } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                                    $count = mysqli_num_rows(mysqli_query($db, "select * from emp_leave_form where leave_type != 'Leave resumption' "));
                                                                                                } else {
                                                                                                    $count = mysqli_num_rows(mysqli_query($db, "select * from emp_leave_form where access_type like '%" . search_leave_priviledge($_SESSION['privilege_user']) . "%' and leave_type != 'Leave Resumption' order by id desc"));
                                                                                                }
                                                                                                echo number_format($count); ?></span></a>
                                            <a class="nav-link " href="leave-resumption">
                                                <i class="bi-door-open-fill nav-icon"></i>
                                                Leave Resumption<span
                                                    class="badge bg-primary rounded-pill ms-1">0</span></a>
                                        </div>
                                    </div>
                                    <a class="nav-link " href="introduction-letter">
                                        <i class="bi-envelope-fill nav-icon"></i>
                                        Reference Letter<span
                                            class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_reference"));
                                                                                        } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_reference  "));
                                                                                        } else {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_reference where access_type like '%" . get_priviledge($_SESSION['privilege_user']) . "%' "));
                                                                                        }
                                                                                        echo number_format($count); ?></span></a>
                                    <a class="nav-link " href="whistle">
                                        <i class="bi-megaphone-fill nav-icon"></i>
                                        Whistle<span class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                                    $count = mysqli_num_rows(mysqli_query($db, "select * from emp_whistle "));
                                                                                                } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                                    $count = mysqli_num_rows(mysqli_query($db, "select * from emp_whistle "));
                                                                                                } else {
                                                                                                    $count = mysqli_num_rows(mysqli_query($db, "select * from emp_whistle where access_type like '%" . get_priviledge($_SESSION['privilege_user']) . "%'"));
                                                                                                }
                                                                                                echo number_format($count); ?></span></a>
                                    <a class="nav-link " href="news">
                                        <i class="bi-newspaper nav-icon"></i>
                                        News/Events<span
                                            class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_resignation "));
                                                                                        } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_resignation "));
                                                                                        } else {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_resignation where access_type like '%" . get_priviledge($_SESSION['privilege_user']) . "%'"));
                                                                                        }
                                                                                        echo number_format($count); ?></span></a>
                                    <a class="nav-link " href="resignation">
                                        <i class="bi-person-x-fill   nav-icon"></i>
                                        Resignation<span
                                            class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_resignation "));
                                                                                        } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_resignation "));
                                                                                        } else {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_resignation where access_type like '%" . get_priviledge($_SESSION['privilege_user']) . "%'"));
                                                                                        }
                                                                                        echo number_format($count); ?></span></a>
                                    <a class="nav-link " href="document-forms">
                                        <i class="bi-archive-fill nav-icon"></i>
                                        Document & Forms<span
                                            class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_download "));
                                                                                        } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_download "));
                                                                                        } else {
                                                                                            $count = mysqli_num_rows(mysqli_query($db, "select * from emp_download where access_type like '%" . get_priviledge($_SESSION['privilege_user']) . "%'"));
                                                                                        }
                                                                                        echo number_format($count); ?></span></a>
                                    <a class="nav-link " href="staff-list">
                                        <i class="bi-people-fill nav-icon"></i>
                                        Staff List<span class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from emp_staff_details where staff = 'yes'"));
                                                                                                    } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from emp_staff_details where  staff = 'yes'"));
                                                                                                    } else {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from emp_staff_details where company_code like '%" . get_priviledge_2($_SESSION['privilege_user']) . "%' and staff = 'yes'"));
                                                                                                    }
                                                                                                    echo number_format($count); ?>
                                        </span></a>
                                    <a class="nav-link " href="staff-mgt">
                                        <i class="bi-person-check-fill nav-icon"></i>
                                        Staff MGT<span class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from emp_self_login "));
                                                                                                    } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from emp_self_login "));
                                                                                                    } else {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from emp_self_login where client_code like '%" . get_priviledge_3($_SESSION['privilege_user']) . "%'"));
                                                                                                    }
                                                                                                    echo number_format($count); ?></span></a>
                                    <a class="nav-link " href="payslip">
                                        <i class="bi-cash nav-icon"></i>
                                        Payslip<span class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                                    $count = mysqli_num_rows(mysqli_query($db, "select distinct token from emp_self_payslip "));
                                                                                                }
                                                                                                echo number_format($count); ?></span></a>
                                    <a class="nav-link " href="clockins">
                                        <i class="bi-clock nav-icon"></i>
                                        Clock ins</a>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>


                        <?php if (check_module($_SESSION['privilege'], 'Appraisal') == 'yes') {

                        ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle  collapsed" href="#" role="button"
                                    data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAuthentication"
                                    aria-expanded="false" aria-controls="navbarVerticalMenuAuthentication">
                                    <i class="bi-person-circle nav-icon"></i>
                                    <span class="nav-link-title">Employee Appraisal</span>
                                </a>

                                <div id="navbarVerticalMenuAuthentication" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenu">
                                    <div id="navbarVerticalMenuAuthenticationMenu">
                                        <a class="nav-link " href="custom_objective">
                                            <i class="bi-card-list nav-icon"></i>
                                            Set Custom Objective<span
                                                class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                                $count = mysqli_num_rows(mysqli_query($db, "select * from role "));
                                                                                            } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                                $count = mysqli_num_rows(mysqli_query($db, "select * from role "));
                                                                                            } else {
                                                                                                $count = mysqli_num_rows(mysqli_query($db, "select * from role where user =  '" . $_SESSION['privilege_user'] . "' "));
                                                                                            }
                                                                                            echo number_format($count); ?></span></a>
                                        <a class="nav-link" href="role">
                                            <i class="bi-list-check nav-icon"></i>
                                            Role<span class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from role "));
                                                                                                    } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from role "));
                                                                                                    } else {
                                                                                                        $count = mysqli_num_rows(mysqli_query($db, "select * from role where user = '" . $_SESSION['privilege_user'] . "' "));
                                                                                                    }
                                                                                                    echo number_format($count); ?></span></a>
                                        <a class="nav-link " href="set-appraisal">
                                            <i class="bi-check nav-icon"></i>
                                            Set-up Appraisal<span
                                                class="badge bg-primary rounded-pill ms-1"><?php if (privilege() == 'Super Admin') {
                                                                                                $count = mysqli_num_rows(mysqli_query($db, "select * from appraisal "));
                                                                                            } elseif ($_SESSION['privilege_user'] == 'ALL') {
                                                                                                $count = mysqli_num_rows(mysqli_query($db, "select * from appraisal "));
                                                                                            } else {
                                                                                                $count = mysqli_num_rows(mysqli_query($db, "select * from appraisal where user =  '" . $_SESSION['privilege_user'] . "' "));
                                                                                            }
                                                                                            echo number_format($count); ?></span></a>
                                        <a class="nav-link " href="ongoing-appraisal">
                                            <i class="bi-fast-forward-fill nav-icon"></i>
                                            Ongoing Appraisal<span class="badge bg-primary rounded-pill ms-1"><?php
                                                                                                                $count = mysqli_num_rows(mysqli_query($db, "select * from emp_appraisald_self where account_token = '".$_SESSION['account_token']."' and status != 'Completed' "));
                                                                                                                echo number_format($count);
                                                                                                                ?></span></a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>


                        <?php if (check_module($_SESSION['privilege'], 'Assessment') == 'yes') {

                        ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle  collapsed" href="#" role="button"
                                    data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAuthentication1"
                                    aria-expanded="false" aria-controls="navbarVerticalMenuAuthentication1">
                                    <i class="bi-bank nav-icon"></i>
                                    <span class="nav-link-title">Assessment</span>
                                </a>                               
                                    <div id="navbarVerticalMenuAuthentication1" class="nav-collapse collapse "
                                        data-bs-parent="#navbarVerticalMenu">
                                        <div id="navbarVerticalMenuAuthentication1Menu">
                                            <a class="nav-link" href="assessment-category">
                                                <i class="bi-journals nav-icon"></i>
                                                Assessment Type<span
                                                    class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab('assessment_category')); ?></span></a>
                                            <a class="nav-link " href="set-assessment">
                                                <i class="bi-gear-fill nav-icon"></i>
                                                Set-up Assessment</a>
                                            <a class="nav-link " href="add-question">
                                                <i class="bi-question  nav-icon"></i>
                                                Add Question</a>
                                            <a class="nav-link " href="view-questions">
                                                <i class="bi-eye-fill nav-icon"></i>
                                                View Question<span
                                                    class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab('questions')) ?></span></a>
                                            <a class="nav-link " href="add-candidate">
                                                <i class="bi-people-fill nav-icon"></i>
                                                Add Candidate</a>
                                            <a class="nav-link " href="view-candidate">
                                                <i class="bi-eye-fill  nav-icon"></i>
                                                View Candidate<span
                                                    class="badge bg-primary rounded-pill ms-1"><?php echo  number_format(sub_count_tab('participant')); ?></span></a>
                                            <a class="nav-link " href="view-score">
                                                <i class="bi-eye-fill nav-icon"></i>
                                                View Scores<span
                                                    class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('exam_result', 'archieved', 'NULL', $_SESSION['account_token'])); ?></span></a>
                                            <a class="nav-link " href="archieve">
                                                <i class="bi-archive-fill nav-icon"></i>
                                                Archieved<span
                                                    class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab_val('exam_result', 'archieved', 'yes', $_SESSION['account_token'])); ?></span></a>
                                        </div>
                                    </div>                                
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>


                        <?php if (check_module($_SESSION['privilege'], 'Clients') == 'yes' || check_module($_SESSION['privilege'], 'Admin') == 'yes') {
                        ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle  collapsed" href="#" role="button"
                                    data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAuthentication2"
                                    aria-expanded="false" aria-controls="navbarVerticalMenuAuthentication2">
                                    <i class="bi-people nav-icon"></i>
                                    <span class="nav-link-title">Clients<span
                                            class="badge bg-primary rounded-pill ms-1"><?php echo number_format(sub_count_tab('clients')); ?></span></span>
                                </a>

                                <div id="navbarVerticalMenuAuthentication2" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenu">
                                    <div id="navbarVerticalMenuAuthentication2Menu">
                                        <a class="nav-link " href="add-client">
                                            <i class="bi-person-plus-fill nav-icon"></i>
                                            Add Clients</a>
                                        <a class="nav-link " href="clients">
                                            <i class="bi-pencil-square  nav-icon"></i>
                                            View Clients</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>



                        <?php if (check_module($_SESSION['privilege'], 'Payroll') == 'yes') {
                        ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle  collapsed" href="#" role="button"
                                    data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAuthentication9"
                                    aria-expanded="false" aria-controls="navbarVerticalMenuAuthentication9">
                                    <i class="bi-credit-card nav-icon"></i>
                                    <span class="nav-link-title">Payroll</span>
                                </a>

                                <div id="navbarVerticalMenuAuthentication9" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenu">
                                    <div id="navbarVerticalMenuAuthentication2Menu">
                                        <div class="nav-item">
                                            <a class="nav-link dropdown-toggle"
                                                href="#navbarVerticalMenuPagesEcommerceCustomersMenu12" role="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#navbarVerticalMenuPagesEcommerceCustomersMenu12"
                                                aria-expanded="false"
                                                aria-controls="navbarVerticalMenuPagesEcommerceCustomersMenu12">
                                                <i class="bi-gear nav-icon"></i>
                                                Settings
                                            </a>

                                            <div id="navbarVerticalMenuPagesEcommerceCustomersMenu12"
                                                class="nav-collapse collapse "
                                                data-bs-parent="#navbarVerticalMenuPagesMenuEcommerce">
                                                <a class="nav-link " href="salary_band">
                                                    <i class="bi-gear-fill nav-icon"></i>
                                                    Salary Band</a>
                                                <a class="nav-link " href="payroll-setting">
                                                    <i class="bi-gear nav-icon"></i>
                                                    Payroll Settings</a>
                                                <a class="nav-link " href="schedule-setting">
                                                    <i class="bi-gear-fill nav-icon"></i>
                                                    Schedule Settings</a>
                                            </div>

                                        </div>
                                        <a class="nav-link " href="emp_salary">
                                            <i class="bi-person-fill  nav-icon"></i>
                                            Employee Salary</a>
                                        <a class="nav-link " href="disburse">
                                            <i class="bi-credit-card-fill nav-icon"></i>
                                            Disburse</a>
                                        <!-- <a class="nav-link " href="loan-application">
                                            <i class="bi-credit-card-fill nav-icon"></i>
                                            Loan Application</a> -->
                                        <a class="nav-link " href="staff-id-format">
                                            <i class="bi-alarm-fill nav-icon"></i>
                                            Schedule</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>

                        <?php if (check_module($_SESSION['privilege'], 'Learning & Development') == 'yes') {
                        ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle  collapsed" href="#" role="button"
                                    data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAuthentication20"
                                    aria-expanded="false" aria-controls="navbarVerticalMenuAuthentication20">
                                    <i class="bi-code-slash nav-icon"></i>
                                    <span class="nav-link-title">Learning & Development</span>
                                </a>

                                <div id="navbarVerticalMenuAuthentication20" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenu">
                                    <div id="navbarVerticalMenuAuthentication4Menu">
                                        <div class="nav-item">
                                            <a class="nav-link " href="view-skill">
                                                <i class="bi-code-slash nav-icon"></i>
                                                Learning A Skill</a>


                                        </div>
                                        <div class="nav-item">
                                            <a class="nav-link " href="view-facilitator">
                                                <i class="bi-person-fill nav-icon"></i>
                                                Facilitators</a>
                                        </div>
                                        <div class="nav-item">
                                            <a class="nav-link dropdown-toggle"
                                                href="#navbarVerticalMenuPagesEcommerceCustomersMenu22" role="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#navbarVerticalMenuPagesEcommerceCustomersMenu22"
                                                aria-expanded="false"
                                                aria-controls="navbarVerticalMenuPagesEcommerceCustomersMenu22">
                                                <i class="bi-code-slash nav-icon"></i>
                                                Training Evaluation
                                            </a>

                                            <div id="navbarVerticalMenuPagesEcommerceCustomersMenu22"
                                                class="nav-collapse collapse "
                                                data-bs-parent="#navbarVerticalMenuPagesMenuEcommerce">
                                                <div class="nav-item">
                                                    <a class="nav-link dropdown-toggle"
                                                        href="#navbarVerticalMenuPagesEcommerceCustomersMenu56"
                                                        role="button" data-bs-toggle="collapse"
                                                        data-bs-target="#navbarVerticalMenuPagesEcommerceCustomersMenu56"
                                                        aria-expanded="false"
                                                        aria-controls="navbarVerticalMenuPagesEcommerceCustomersMenu56">
                                                        <i class="bi-question-circle-fill nav-icon"></i>
                                                        Questionnaire
                                                    </a>

                                                    <div id="navbarVerticalMenuPagesEcommerceCustomersMenu56"
                                                        class="nav-collapse collapse "
                                                        data-bs-parent="#navbarVerticalMenuPagesMenuEcommerce">
                                                        <a class="nav-link " href="questionaire">
                                                            <i class="bi-plus nav-icon"></i>
                                                            Add Question</a>
                                                        <a class="nav-link " href="view-questionnaire">
                                                            <i class="bi-eye-fill nav-icon"></i>
                                                            View Question</a>
                                                    </div>
                                                </div>
                                                <div class="nav-item">
                                                    <a class="nav-link dropdown-toggle"
                                                        href="#navbarVerticalMenuPagesEcommerceCustomersMenu77"
                                                        role="button" data-bs-toggle="collapse"
                                                        data-bs-target="#navbarVerticalMenuPagesEcommerceCustomersMenu77"
                                                        aria-expanded="false"
                                                        aria-controls="navbarVerticalMenuPagesEcommerceCustomersMenu77">
                                                        <i class="bi-question-circle-fill nav-icon"></i>
                                                        Pre Evaluation
                                                    </a>

                                                    <div id="navbarVerticalMenuPagesEcommerceCustomersMenu77"
                                                        class="nav-collapse collapse "
                                                        data-bs-parent="#navbarVerticalMenuPagesMenuEcommerce">
                                                        <a class="nav-link " href="evaluation?evalution=pre">
                                                            <i class="bi-question-circle-fill nav-icon"></i>
                                                            Assign</a>
                                                        <a class="nav-link " href="result?r=pre">
                                                            <i class="bi-question-circle-fill nav-icon"></i>
                                                            Result</a>
                                                    </div>
                                                </div>
                                                <div class="nav-item">
                                                    <a class="nav-link dropdown-toggle"
                                                        href="#navbarVerticalMenuPagesEcommerceCustomersMenu78"
                                                        role="button" data-bs-toggle="collapse"
                                                        data-bs-target="#navbarVerticalMenuPagesEcommerceCustomersMenu78"
                                                        aria-expanded="false"
                                                        aria-controls="navbarVerticalMenuPagesEcommerceCustomersMenu78">
                                                        <i class="bi-question-circle-fill nav-icon"></i>
                                                        Post Evaluation
                                                    </a>

                                                    <div id="navbarVerticalMenuPagesEcommerceCustomersMenu78"
                                                        class="nav-collapse collapse "
                                                        data-bs-parent="#navbarVerticalMenuPagesMenuEcommerce">
                                                        <a class="nav-link " href="evaluation?evaluation=post">
                                                            <i class="bi-question-circle-fill nav-icon"></i>
                                                            Assign</a>
                                                        <a class="nav-link " href="result?r=post">
                                                            <i class="bi-question-circle-fill nav-icon"></i>
                                                            Result</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nav-item">
                                            <a class="nav-link dropdown-toggle"
                                                href="#navbarVerticalMenuPagesEcommerceCustomersMenu44" role="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#navbarVerticalMenuPagesEcommerceCustomersMenu44"
                                                aria-expanded="false"
                                                aria-controls="navbarVerticalMenuPagesEcommerceCustomersMenu44">
                                                <i class="bi-alarm-fill nav-icon"></i>
                                                Schedule Training
                                            </a>

                                            <div id="navbarVerticalMenuPagesEcommerceCustomersMenu44"
                                                class="nav-collapse collapse "
                                                data-bs-parent="#navbarVerticalMenuPagesMenuEcommerce">
                                                <a class="nav-link " href="schedule-training">
                                                    <i class="bi-alarm-fill nav-icon"></i>
                                                    Scheduled</a>
                                                <a class="nav-link " href="scheduled-training">
                                                    <i class="bi-alarm-fill nav-icon"></i>
                                                    Schedule Training</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>

                        <?php if (check_module($_SESSION['privilege'], 'General Setting') == 'yes' || check_module($_SESSION['privilege'], 'Admin') == 'yes') {
                        ?>
                            <!-- Collapse -->
                            <div class="nav-item">
                                <a class="nav-link dropdown-toggle  collapsed" href="#" role="button"
                                    data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAuthentication3"
                                    aria-expanded="false" aria-controls="navbarVerticalMenuAuthentication3">
                                    <i class="bi-gear-wide-connected nav-icon"></i>
                                    <span class="nav-link-title">General Setting</span>
                                </a>

                                <div id="navbarVerticalMenuAuthentication3" class="nav-collapse collapse "
                                    data-bs-parent="#navbarVerticalMenu">
                                    <div id="navbarVerticalMenuAuthentication3Menu">
                                        <a class="nav-link " href="add-industry">
                                            <i class="bi-house-fill nav-icon"></i>
                                            Industry</a>
                                        <a class="nav-link " href="cards">
                                            <i class="bi-gift-fill  nav-icon"></i>
                                            Greeting Card</a>
                                        <div class="nav-item">
                                            <a class="nav-link dropdown-toggle"
                                                href="#navbarVerticalMenuPagesEcommerceCustomersMenu" role="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#navbarVerticalMenuPagesEcommerceCustomersMenu"
                                                aria-expanded="false"
                                                aria-controls="navbarVerticalMenuPagesEcommerceCustomersMenu">
                                                <i class="bi-envelope-fill nav-icon"></i>
                                                Message Template
                                            </a>

                                            <div id="navbarVerticalMenuPagesEcommerceCustomersMenu"
                                                class="nav-collapse collapse "
                                                data-bs-parent="#navbarVerticalMenuPagesMenuEcommerce">
                                                <a class="nav-link " href="message-template">
                                                    <i class="bi-inbox-fill nav-icon"></i>
                                                    Add Template</a>
                                                <a class="nav-link " href="msg-template">
                                                    <i class="bi-pencil-square nav-icon"></i>
                                                    Template</a>
                                            </div>
                                        </div>
                                        <?php if (check_module($_SESSION['privilege'], 'User Management') == 'yes' || $_SESSION['account_token']) {
                                        ?>
                                            <a class="nav-link" href="user">
                                                <i class="bi-person-fill nav-icon"></i>
                                                User Management
                                            </a>
                                            <a class="nav-link " href="notification-mail">
                                                <i class="bi-bell-fill nav-icon"></i>
                                                Notification Email</a>                                           
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- End Collapse -->
                        <?php } ?>


                        <?php if (check_module($_SESSION['privilege'], 'Activity Log') == 'yes') {
                        ?>
                            <div class="nav-item">
                                <a class="nav-link " href="./activity-log" data-placement="left">
                                    <i class="bi-clock-history nav-icon"></i>
                                    <span class="nav-link-title">Activity Log</span>
                                </a>
                            </div>
                        <?php } ?>


                        <?php if (check_module($_SESSION['privilege'], 'Generate Report') == 'yes') {

                        ?>
                            <div class="nav-item">
                                <a class="nav-link " href="generate-report" data-placement="left">
                                    <i class="bi-graph-up nav-icon"></i>
                                    <span class="nav-link-title">General Report</span>
                                </a>
                            </div>
                        <?php } ?>



                        <div class="nav-item">
                            <a class="nav-link " href="logout" data-placement="left">
                                <i class="bi-unlock nav-icon"></i>
                                <span class="nav-link-title">Logout</span>
                            </a>
                        </div>
                        </div>



                </div>

            </div>
        </div>
</aside>