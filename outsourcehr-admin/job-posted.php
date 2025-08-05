<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}


if ($_SESSION['account_token']) {
    if ($_GET['search']) {
        $search = base64_decode($_GET['search']);
        $query = "select * from job_post where job_title like '%" . $search . "%' and account_token = '" . $_SESSION['account_token'] . "' order by id desc";
    }

    if ($_GET['expired']) {
        $query = "select * from job_post where deadline <= '" . $_GET['expired'] . "' and account_token = '" . $_SESSION['account_token'] . "' order by id desc";
        $return = 'expired=' . $_GET['expired'];
    } else {
        $query = "select * from job_post where deadline >= '" . $_GET['valid'] . "' and account_token = '" . $_SESSION['account_token'] . "' order by id desc";
        $return = 'valid=' . $_GET['valid'];
    }
}else{
    validatePermission('Job Seeker');
    if ($_GET['search']) {
        $search = base64_decode($_GET['search']);
        $query = "select * from job_post where job_title like '%" . $search . "%' order by id desc";
    }
    
    if ($_GET['expired']) {
        $query = "select * from job_post where deadline <= '" . $_GET['expired'] . "' order by id desc";
        $return = 'expired=' . $_GET['expired'];
    } else {
        $query = "select * from job_post where deadline >= '" . $_GET['valid'] . "'order by id desc";
        $return = 'valid=' . $_GET['valid'];
    }
    
}

$result = mysqli_query($db, $query);
$num = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Job Posted | KlinHR</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/fav.png">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap-icons/font/bootstrap-icons.css">

    <!-- CSS Front Template -->

    <link rel="preload" href="./assets/css/theme.min.css" data-hs-appearance="default" as="style">
    <link rel="preload" href="./assets/css/theme-dark.min.css" data-hs-appearance="dark" as="style">

    <style data-hs-appearance-onload-styles>
        * {
            transition: unset !important;
        }

        body {
            opacity: 0;
        }
    </style>

    <script>
        window.hs_config = {
            "autopath": "@@autopath",
            "deleteLine": "hs-builder:delete",
            "deleteLine:build": "hs-builder:build-delete",
            "deleteLine:dist": "hs-builder:dist-delete",
            "previewMode": false,
            "startPath": "/index",
            "vars": {
                "themeFont": "https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap",
                "version": "?v=1.0"
            },
            "layoutBuilder": {
                "extend": {
                    "switcherSupport": true
                },
                "header": {
                    "layoutMode": "default",
                    "containerMode": "container-fluid"
                },
                "sidebarLayout": "default"
            },
            "themeAppearance": {
                "layoutSkin": "default",
                "sidebarSkin": "default",
                "styles": {
                    "colors": {
                        "primary": "#377dff",
                        "transparent": "transparent",
                        "white": "#fff",
                        "dark": "132144",
                        "gray": {
                            "100": "#f9fafc",
                            "900": "#1e2022"
                        }
                    },
                    "font": "Inter"
                }
            },
            "languageDirection": {
                "lang": "en"
            },
            "skipFilesFromBundle": {
                "dist": ["assets/js/hs.theme-appearance.js", "assets/js/hs.theme-appearance-charts.js", "assets/js/demo.js"],
                "build": ["assets/css/theme.css", "assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js", "assets/js/demo.js", "assets/css/theme-dark.css", "assets/css/docs.css", "assets/vendor/icon-set/style.css", "assets/js/hs.theme-appearance.js", "assets/js/hs.theme-appearance-charts.js", "node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js", "assets/js/demo.js"]
            },
            "minifyCSSFiles": ["assets/css/theme.css", "assets/css/theme-dark.css"],
            "copyDependencies": {
                "dist": {
                    "*assets/js/theme-custom.js": ""
                },
                "build": {
                    "*assets/js/theme-custom.js": "",
                    "node_modules/bootstrap-icons/font/*fonts/**": "assets/css"
                }
            },
            "buildFolder": "",
            "replacePathsToCDN": {},
            "directoryNames": {
                "src": "./src",
                "dist": "./dist",
                "build": "./build"
            },
            "fileNames": {
                "dist": {
                    "js": "theme.min.js",
                    "css": "theme.min.css"
                },
                "build": {
                    "css": "theme.min.css",
                    "js": "theme.min.js",
                    "vendorCSS": "vendor.min.css",
                    "vendorJS": "vendor.min.js"
                }
            },
            "fileTypes": "jpg|png|svg|mp4|webm|ogv|json"
        }
        window.hs_config.gulpRGBA = (p1) => {
            const options = p1.split(',')
            const hex = options[0].toString()
            const transparent = options[1].toString()

            var c;
            if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)) {
                c = hex.substring(1).split('');
                if (c.length == 3) {
                    c = [c[0], c[0], c[1], c[1], c[2], c[2]];
                }
                c = '0x' + c.join('');
                return 'rgba(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ',' + transparent + ')';
            }
            throw new Error('Bad Hex');
        }
        window.hs_config.gulpDarken = (p1) => {
            const options = p1.split(',')

            let col = options[0].toString()
            let amt = -parseInt(options[1])
            var usePound = false

            if (col[0] == "#") {
                col = col.slice(1)
                usePound = true
            }
            var num = parseInt(col, 16)
            var r = (num >> 16) + amt
            if (r > 255) {
                r = 255
            } else if (r < 0) {
                r = 0
            }
            var b = ((num >> 8) & 0x00FF) + amt
            if (b > 255) {
                b = 255
            } else if (b < 0) {
                b = 0
            }
            var g = (num & 0x0000FF) + amt
            if (g > 255) {
                g = 255
            } else if (g < 0) {
                g = 0
            }
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
        }
        window.hs_config.gulpLighten = (p1) => {
            const options = p1.split(',')

            let col = options[0].toString()
            let amt = parseInt(options[1])
            var usePound = false

            if (col[0] == "#") {
                col = col.slice(1)
                usePound = true
            }
            var num = parseInt(col, 16)
            var r = (num >> 16) + amt
            if (r > 255) {
                r = 255
            } else if (r < 0) {
                r = 0
            }
            var b = ((num >> 8) & 0x00FF) + amt
            if (b > 255) {
                b = 255
            } else if (b < 0) {
                b = 0
            }
            var g = (num & 0x0000FF) + amt
            if (g > 255) {
                g = 255
            } else if (g < 0) {
                g = 0
            }
            return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16)
        }
    </script>
</head>

<body class="has-navbar-vertical-aside navbar-vertical-aside-show-xl   footer-offset">

    <script src="./assets/js/hs.theme-appearance.js"></script>

    <script src="./assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js"></script>

    <!-- ========== HEADER ========== -->

    <?php include('inc/header.php') ?>

    <!-- ========== END HEADER ========== -->

    <!-- ========== MAIN CONTENT ========== -->
    <!-- Navbar Vertical -->

    <?php include('inc/side-nav.php') ?>

    <main id="content" role="main" class="main">
        <!-- Content -->
        <div class="content container-fluid">
            <div class="row justify-content-lg-center">
                <div class="col-lg-10">
                    <!-- Profile Cover -->
                    <div class="profile-cover">
                        <div class="profile-cover-img-wrapper">
                            <img class="profile-cover-img" src="./assets/img/1920x400/img1.jpg" alt="Image Description">
                        </div>
                    </div>
                    <!-- End Profile Cover -->

                    <!-- Filter -->
                    <div class="row align-items-center mb-5 mt-10 pb-3" style="border-bottom: 1px solid rgba(231, 234, 243, 0.7);">
                        <div class="col">
                            <h3 class="mb-0"><?php echo $num ?> Job<?php if ($num > 1) {
                                                                        echo 's';
                                                                    } ?> Posted</h3>
                        </div>

                    </div>
                    <!-- End Filter -->


                    <!-- Tab Content -->
                    <div class="tab-content" id="projectsTabContent">
                        <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                            <div class="row row-cols-1 row-cols-md-2">
                                <?php
                                for ($i = 0; $i < $num; $i++) {
                                    $row = mysqli_fetch_array($result);
                                    $dateDifference = date_diff(date_create(date("Y-m-d")), date_create($row['date_posted']));
                                    $month = $dateDifference->m;
                                    $year = $dateDifference->y;
                                    $day = $dateDifference->d;

                                    if ($year > 1) {
                                        $date = $year . ' years ago';
                                    } elseif ($month > 1) {
                                        $date = $month . ' months ago';
                                    } elseif ($day > 1) {
                                        $date = $day . ' days ago';
                                    } else {
                                        $date = 'Today';
                                    }

                                    $deadlinediff = date_diff(date_create(date($row['deadline'])), date_create($row['date_posted']));
                                    $dmonth = $dateDifference->m;
                                    $dyear = $dateDifference->y;
                                    $dday = $dateDifference->d;

                                    if ($dyear > 1) {
                                        $deadline = '<span class="h4">' . $dyear . '</span><span class="d-block fs-5">years left</span>';
                                    } elseif ($dmonth > 1) {
                                        $deadline = '<span class="h4">' . $dmonth . '</span><span class="d-block fs-5">months left</span>';
                                    } elseif ($day > 1) {
                                        $deadline = '<span class="h4">' . $dday . '</span><span class="d-block fs-5">Days left</span>';
                                    } else {
                                        $deadline = '<span class="h4">Today</span>';
                                    }




                                ?>
                                    <div class="col mb-3 mb-lg-5">
                                        <!-- Card -->
                                        <div class="card card-hover-shadow text-center h-100">
                                            <div class="card-progress-wrap">
                                                <!-- Progress -->
                                                <div class="progress card-progress">
                                                    <div class="progress-bar" role="progressbar" style="width: <?php echo progress($row['status']); ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <!-- End Progress -->
                                            </div>

                                            <!-- Body -->
                                            <div class="card-body">
                                                <div class="row align-items-center text-start mb-4">
                                                    <div class="col">
                                                        <span class="badge bg-soft-<?php echo status_color($row['status']); ?> text-secondary p-2"> <?php echo ucwords($row['status']); ?></span>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-auto">
                                                        <!-- Dropdown1 -->
                                                        <div class="dropdown">
                                                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsGridDropdown8" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi-three-dots-vertical"></i>
                                                            </button>

                                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsGridDropdown8">
                                                                <a class="dropdown-item" href="edit-job?unique=<?php echo $row['id']; ?>">Edit Job </a>
                                                                <!-- <a class="dropdown-item" href="#">Add to favorites</a>-->
                                                                <a class="dropdown-item" href="close_job?id=<?php echo base64_encode($row['id']); ?>&status=<?php echo $row['status']; ?>&d=<?= $return ?>" onclick="return confirm('Are you sure you want to update job post?');"><?php if ($row['status'] == 'approved') {
                                                                                                                                                                                                                                                                                        echo 'Close Job Post';
                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                        echo 'Re-Open Vacancy';
                                                                                                                                                                                                                                                                                    } ?></a>
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item text-danger" href="delete-job?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this job post?');">Delete</a>
                                                            </div>
                                                        </div>
                                                        <!-- End Dropdown -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>

                                                <div class="d-flex justify-content-center mb-2">
                                                    <!-- Avatar -->
                                                    <img class="avatar avatar-lg" src="../uploads/jOBS_IMAGE/JOB<?= $row['job_image'] ?>" alt="Image Description">
                                                </div>

                                                <div class="mb-4">
                                                    <h2 class="mb-1"><?php echo $row['job_title']; ?></h2>

                                                    <span class="fs-5">Posted <?php echo $date ?></span>
                                                </div>

                                                <small class="card-subtitle"><?php echo get_client_name($row['client_id']) ?></small>

                                                <div class="d-flex justify-content-center">
                                                    <!-- Avatar Group -->
                                                    <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">
                                                        <a class="" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $row['category'] ?>">
                                                            <span class="avatar-initials">
                                                                <?php if (strlen($row['category']) > 7) {
                                                                    echo substr($row['category'], 0, 7) . '...';
                                                                } else {
                                                                    echo $row['category'];
                                                                } ?>
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <!-- End Avatar Group -->
                                                </div>

                                                <a class="stretched-link" href="#"></a>
                                            </div>
                                            <!-- End Body -->

                                            <!-- Footer -->
                                            <div class="card-footer">
                                                <!-- Stats -->
                                                <div class="row col-divider">
                                                    <div class="col">
                                                        <span class="h4"><?php echo $row['experience'] ?></span>
                                                        <span class="d-block fs-5">Experience</span>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col">
                                                        <span class="h4"><?php echo $row['job_type'] ?></span>
                                                        <span class="d-block fs-5">Job Type</span>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col">
                                                        <?php echo $deadline ?>
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Stats -->
                                            </div>
                                            <!-- End Footer -->
                                        </div>
                                        <!-- End Card -->
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- End Row -->
                        </div>

                        <div class="tab-pane fade" id="list" role="tabpanel" aria-labelledby="list-tab">
                            <div class="row row-cols-1">
                                <?php
                                for ($i = 0; $i < $num; $i++) {
                                    $row1 = mysqli_fetch_array($result);
                                    echo $row1['date_posted'];
                                    $dateDifference = date_diff(date_create(date("Y-m-d")), date_create($row['date_posted']));
                                    $month = $dateDifference->m;
                                    $year = $dateDifference->y;
                                    $day = $dateDifference->d;

                                    if ($year > 1) {
                                        $date = $year . ' years ago';
                                    } elseif ($month > 1) {
                                        $date = $month . ' months ago';
                                    } elseif ($day > 1) {
                                        $date = $day . ' days ago';
                                    } else {
                                        $date = 'Today';
                                    }

                                    $deadlinediff = date_diff(date_create(date($row['deadline'])), date_create($row['date_posted']));
                                    $dmonth = $dateDifference->m;
                                    $dyear = $dateDifference->y;
                                    $dday = $dateDifference->d;

                                    if ($dyear > 1) {
                                        $deadline = ' <span class="fs-5">Years left:</span>
    <span class="fw-semibold text-dark">' . $dyear . '</span>';
                                    } elseif ($dmonth > 1) {
                                        $deadline = $dmonth . ' <span class="fs-5">Months left:</span>
    <span class="fw-semibold text-dark">' . $dmonth . '</span>';
                                    } elseif ($day > 1) {
                                        $deadline = ' <span class="fs-5">Days left:</span>
    <span class="fw-semibold text-dark">' . $dday . '</span>';
                                    } else {
                                        $deadline = 'Today';
                                    }




                                ?>
                                    <div class="col mb-3 mb-lg-5">
                                        <!-- Card -->
                                        <div class="card card-body">
                                            <div class="d-flex">
                                                <!-- Avatar -->
                                                <div class="flex-shrink-0 me-3 me-lg-4">
                                                    <img class="avatar" src="../uploads/jOBS_IMAGE/JOB<?= $row1['job_image'] ?>" alt="Image Description">
                                                </div>

                                                <div class="flex-grow-1 ms-3">
                                                    <div class="row align-items-sm-center">
                                                        <div class="col">
                                                            <span class="badge bg-soft-<?php echo status_color($row1['status']); ?> text-secondary p-2 mb-2"><?php echo $row1['status']; ?></span>

                                                            <h3 class="mb-1"><?php echo $row1['job_title'] ?></h3>
                                                        </div>
                                                        <!-- End Col -->

                                                        <div class="col-md-3 d-none d-md-flex justify-content-md-end ms-n3">
                                                            <!-- Avatar Group -->
                                                            <div class="avatar-group avatar-group-sm avatar-circle card-avatar-group">

                                                                <a class="" href="#" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo $row1['category'] ?>">
                                                                    <span class="avatar-initials"><?php echo substr($row1['category'], 0, 7) . '...' ?></span>
                                                                </a>
                                                            </div>
                                                            <!-- End Avatar Group -->
                                                        </div>

                                                        <div class="col-auto">
                                                            <!-- Dropdown -->
                                                            <div class="dropdown">
                                                                <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm card-dropdown-btn rounded-circle" id="projectsListDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="bi-three-dots-vertical"></i>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectsListDropdown1">
                                                                    <a class="dropdown-item" href="#">Edit Job </a>
                                                                    <a class="dropdown-item" href="close_job?id=<?php echo $row1['id']; ?>&status=<?php echo $row1['status']; ?>" onclick="return confirm('Are you sure you want to update job post?');"><?php if ($row1['status'] == 'approved') {
                                                                                                                                                                                                                                                                echo 'Close Job Post';
                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                echo 'Re-Open Vacancy';
                                                                                                                                                                                                                                                            } ?></a>
                                                                    <!-- <a class="dropdown-item" href="#">Archive project</a> -->
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item text-danger" href="delete-job?id=<?php echo $row1['id']; ?>" onclick="return confirm('Are you sure you want to delete this job post?');">Delete</a>
                                                                </div>
                                                            </div>
                                                            <!-- End Unfold -->
                                                        </div>
                                                    </div>
                                                    <!-- End Row -->

                                                    <!-- Stats -->
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <span class="fs-5">Posted:</span>
                                                            <span class="fw-semibold text-dark"><?php echo $date ?></span>
                                                        </li>

                                                        <li class="list-inline-item">
                                                            <span class="fs-5">Job Type:</span>
                                                            <span class="fw-semibold text-dark"><?php echo $row1['job_type'] ?></span>
                                                        </li>

                                                        <li class="list-inline-item">
                                                            <span class="fs-5">Experience:</span>
                                                            <span class="fw-semibold text-dark"><?php echo $row1['experience'] ?></span>
                                                        </li>

                                                        <li class="list-inline-item">
                                                            <?php echo $deadline ?>
                                                        </li>
                                                    </ul>
                                                    <!-- End Stats -->

                                                    <!-- Progress -->
                                                    <div class="progress card-progress">
                                                        <div class="progress-bar" role="progressbar" style="width: <?php echo progress($row1['status']); ?>%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <!-- End Progress -->

                                                    <a class="stretched-link" href="#"></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Card -->
                                    </div>
                                <?php } ?>
                            </div>
                            <!-- End Row -->
                        </div>
                    </div>
                    <!-- End Tab Content -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Content -->

        <!-- Footer -->
        <?php include('inc/footer.php') ?>

        <!-- End Footer -->
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

    <!-- ========== SECONDARY CONTENTS ========== -->
    <!-- Keyboard Shortcuts -->
    <!-- End Keyboard Shortcuts -->

    <!-- Activity -->
    <?php include('inc/modal-activity.php') ?>
    <!-- End Activity -->

    <!-- Welcome Message Modal -->
    <?php include('inc/welcome-modal.php') ?>

    <!-- End Welcome Message Modal -->
    <!-- ========== END SECONDARY CONTENTS ========== -->

    <!-- JS Global Compulsory  -->
    <script src="./assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="./assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS Implementing Plugins -->
    <script src="./assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside.min.js"></script>
    <script src="./assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>

    <script src="./assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
    <script src="./assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>

    <!-- JS Front -->
    <script src="./assets/js/theme.min.js"></script>

    <!-- JS Plugins Init. -->
    <script>
        (function() {
            window.onload = function() {


                // INITIALIZATION OF NAVBAR VERTICAL ASIDE
                // =======================================================
                new HSSideNav('.js-navbar-vertical-aside').init()


                // INITIALIZATION OF FORM SEARCH
                // =======================================================
                new HSFormSearch('.js-form-search')


                // INITIALIZATION OF BOOTSTRAP DROPDOWN
                // =======================================================
                HSBsDropdown.init()


                // INITIALIZATION OF NAV SCROLLER
                // =======================================================
                new HsNavScroller('.js-nav-scroller')


                // INITIALIZATION OF STICKY BLOCKS
                // =======================================================
                new HSStickyBlock('.js-sticky-block', {
                    targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ? '#header' : null
                })
            }
        })()
    </script>

    <!-- Style Switcher JS -->

    <script>
        (function() {
            // STYLE SWITCHER
            // =======================================================
            const $dropdownBtn = document.getElementById('selectThemeDropdown') // Dropdowon trigger
            const $variants = document.querySelectorAll(`[aria-labelledby="selectThemeDropdown"] [data-icon]`) // All items of the dropdown

            // Function to set active style in the dorpdown menu and set icon for dropdown trigger
            const setActiveStyle = function() {
                $variants.forEach($item => {
                    if ($item.getAttribute('data-value') === HSThemeAppearance.getOriginalAppearance()) {
                        $dropdownBtn.innerHTML = `<i class="${$item.getAttribute('data-icon')}" />`
                        return $item.classList.add('active')
                    }

                    $item.classList.remove('active')
                })
            }

            // Add a click event to all items of the dropdown to set the style
            $variants.forEach(function($item) {
                $item.addEventListener('click', function() {
                    HSThemeAppearance.setAppearance($item.getAttribute('data-value'))
                })
            })

            // Call the setActiveStyle on load page
            setActiveStyle()

            // Add event listener on change style to call the setActiveStyle function
            window.addEventListener('on-hs-appearance-change', function() {
                setActiveStyle()
            })
        })()
    </script>

    <!-- End Style Switcher JS -->
</body>

</html>