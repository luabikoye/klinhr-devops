<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user']) && $_GET['client_link'] == 'yes') {
    $hrb_email = get_val('notification_email', 'privilege', 'deployment', 'email');
    $_SESSION['Klin_admin_user'] =  'TempHRBP';
}

$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'id != "" ';

if ($_GET['cat']) {
    $cat = base64_decode($_GET['cat']);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Client | KlinHR</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/fav.png">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="./assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
    <link rel="stylesheet" href="./assets/vendor/quill/dist/quill.snow.css">

    <!-- CSS Front Template -->

    <link rel="preload" href="./assets/css/theme.min.css" data-hs-appearance="default" as="style">
    <link rel="preload" href="./assets/css/theme-dark.min.css" data-hs-appearance="dark" as="style">


    <script src="assests/js/jquery-1.11.1.min.js"></script>
    <script src="./assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="./assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

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
                "dist": ["assets/js/hs.theme-appearance.js", "assets/js/hs.theme-appearance-charts.js",
                    "assets/js/demo.js"
                ],
                "build": ["assets/css/theme.css",
                    "assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside-mini-cache.js",
                    "assets/js/demo.js", "assets/css/theme-dark.css", "assets/css/docs.css",
                    "assets/vendor/icon-set/style.css", "assets/js/hs.theme-appearance.js",
                    "assets/js/hs.theme-appearance-charts.js",
                    "node_modules/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js",
                    "assets/js/demo.js"
                ]
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

    <script src="ckeditor/ckeditor.js"></script>
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
            <!-- Page Header -->
            <div class="page-header">
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        Total Assigned to Client <span
                            class="badge bg-soft-dark text-dark ms-1"><?php echo number_format(count_tab_val('emp_staff_details', 'completed', 'staff')) ?></span>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Page Header -->
            <!-- Card -->
            <form action="export-hrbp-list" method="post" enctype="multipart/form-data">
                <div class="card">
                    <!-- Header -->
                    <div class="card-header card-header-content-md-between">
                        <div class="mb-2 mb-md-0">
                            <form>
                                <!-- Search -->
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend input-group-text">
                                        <i class="bi-search"></i>
                                    </div>
                                    <input id="datatableSearch" type="search" class="form-control"
                                        placeholder="Search users" aria-label="Search users">
                                </div>
                                <!-- End Search -->
                            </form>
                        </div>

                        <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                            <!-- Datatable Info -->
                            <div id="datatableCounterInfo">
                                <div class="d-flex align-items-center">
                                    <!-- <span class="fs-5 me-3">
                                        <span id="datatableCounter">0</span>
                                        Selected
                                    </span> -->
                                    <?php if ($_GET['cat']) {
                                    ?>
                                        <a type="submit" class="btn btn-outline-danger btn-sm"
                                            href="export-applicants?col=<?php echo base64_encode('completed') ?>&status=<?php echo base64_encode($cat); ?>">
                                            <i class=" bi-folder"></i> Export All Applicants
                                        </a>
                                </div>
                            </div>
                            <!-- End Datatable Info -->

                            <!-- Dropdown -->

                            <div class="dropdown">
                                <button type="button" class="btn btn-white btn-sm w-100" id="usersFilterDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi-filter me-1"></i> Filter <span
                                        class="badge bg-soft-dark text-dark rounded-circle ms-1">5</span>
                                </button>

                                <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered"
                                    aria-labelledby="usersFilterDropdown" style="min-width: 22rem;">
                                    <!-- Card -->
                                    <div class="card">
                                        <div class="card-header card-header-content-between">
                                            <h5 class="card-header-title">Filter users</h5>

                                            <!-- Toggle Button -->
                                            <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm ms-2">
                                                <i class="bi-x-lg"></i>
                                            </button>
                                            <!-- End Toggle Button -->
                                        </div>

                                        <div class="card-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">Client</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <select
                                                                class="js-select js-datatable-filter form-select form-select-sm"
                                                                data-target-column-index="5" data-hs-tom-select-options='{
                                                        "placeholder": "Any status",
                                                        "searchInDropdown": false,
                                                        "hideSearch": true,
                                                        "dropdownWidth": "10rem"
                                                        }'>
                                                                <option value=" ">Any client</option>
                                                                <?php random('client_name', 'jobs_applied') ?>
                                                            </select>
                                                        </div>
                                                        <!-- End Select -->
                                                    </div>

                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">Employement Date From</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <input type="date" name="dateFrom" class="form-control">
                                                            <!-- End Select -->
                                                        </div>
                                                    </div>

                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">Employement Date To</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <input type="date" name="dateTo" class="form-control">
                                                            <!-- End Select -->
                                                        </div>
                                                    </div>
                                                    <!-- End Col -->


                                                    <!-- End Col -->
                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">Role</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <select
                                                                class="js-select js-datatable-filter form-select form-select-sm"
                                                                data-target-column-index="3" data-hs-tom-select-options='{
                                                        "placeholder": "Any status",
                                                        "searchInDropdown": false,
                                                        "hideSearch": true,
                                                        "dropdownWidth": "10rem"
                                                        }'>
                                                                <option value=" ">Any Role</option>
                                                                <?php random('job_title', 'jobs_applied') ?>
                                                            </select>
                                                        </div>
                                                        <!-- End Select -->
                                                    </div>
                                                    <!-- End Col -->
                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">Location</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <select
                                                                class="js-select js-datatable-filter form-select form-select-sm"
                                                                data-target-column-index="4" data-hs-tom-select-options='{
                                                        "placeholder": "Any status",
                                                        "searchInDropdown": false,
                                                        "hideSearch": true,
                                                        "dropdownWidth": "10rem"
                                                        }'>
                                                                <option value=" ">choose location</option>
                                                                <?php echo list_state() ?>
                                                            </select>
                                                        </div>
                                                        <!-- End Select -->
                                                    </div>
                                                    <!-- End Col -->
                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">LastName</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <input type="text" name="name" class="form-control">
                                                        </div>
                                                        <!-- End Select -->
                                                    </div>
                                                    <!-- End Col -->
                                                </div>
                                                <!-- End Row -->

                                            </form>
                                        </div>
                                    </div>
                                    <!-- End Card -->
                                </div>
                            </div>
                        <?php } ?>
                        <!-- End Dropdown -->

                        <!-- Dropdown -->
                        <div class="dropdown">
                            <button type="button" class="btn btn-white btn-sm w-100" id="usersFilterDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-filter me-1"></i> Move Back To
                            </button>



                            <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered"
                                aria-labelledby="usersFilterDropdown" style="min-width: 22rem;">
                                <!-- Card -->
                                <div class="card">
                                    <div class="card-header card-header-content-between">
                                        <h5 class="card-header-title">Move Back To</h5>

                                        <!-- Toggle Button -->
                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm ms-2">
                                            <i class="bi-x-lg"></i>
                                        </button>
                                        <!-- End Toggle Button -->
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-4">
                                                <!-- <small class="text-cap text-body">Members</small> -->

                                                <!-- Select -->
                                                <div class="tom-select-custom">
                                                    <select class="js-select form-select" onchange="CheckStage();"
                                                        name="stage">
                                                        <!-- <option selected value="Pending Verification">Pending Verification</option>
                                                        <option selected value="Completed Verification">Completed Verification</option> -->
                                                        <option selected value="Pool">Pool</option>
                                                    </select>
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                            <!-- End Col -->
                                        </div>
                                        <!-- End Row -->

                                        <div class="d-grid">
                                            <input type="submit" id="move" class="btn btn-primary" name="btn_move"
                                                value="Move"
                                                onclick="return confirm('Are you sure you want to move these candidates?');">
                                        </div>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>
                        </div>
                        <!-- End Dropdown -->
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <?php if ($_GET['id'] == 'required') echo '<div class="alert alert-danger">No ID was selected </div>'; ?>

                        <?php

                        if ($success || $_GET['success']) {
                            echo '<div class="alert alert-success">' . $success . base64_decode($_GET['success']) . '</div>';
                        }
                        if ($error || $_GET['error']) {
                            echo '<div class="alert alert-danger">' . $error . base64_decode($_GET['error']) . '</div>';
                        }

                        ?>
                        <?php if ($_GET['del'] == 'success') echo '<div class="alert alert-success">Applicant successfully deleted</div>'; ?>

                        <?php if ($_GET['completed'] == 'verification') echo '<div class="alert alert-success">Applicant successfully moved to completed verification</div>'; ?>
                        <?php if ($_GET['pool'] == 'completed') echo '<div class="alert alert-success">Candidate successfully moved to Pool</div>'; ?>

                        <?php if ($_GET['pending'] == 'verification') echo '<div class="alert alert-success">Candidate successfully moved to verification</div>'; ?>

                        <?php if ($_GET['reversed'] == 'success') echo '<div class="alert alert-success">Candidate successfully reversed to Pending Documentation</div>'; ?>

                        <table id="datatable"
                            class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                            data-hs-datatables-options='{
                   "columnDefs": [{
                      "targets": [0],
                      "orderable": false
                    }],
                   "order": [],
                   "info": {
                     "totalQty": "#datatableWithPaginationInfoTotalQty"
                   },
                   "search": "#datatableSearch",
                   "entries": "#datatableEntries",
                   "pageLength": 15,
                   "isResponsive": false,
                   "isShowPaging": false,
                   "pagination": "datatablePagination"
                 }'>
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="table-column-pe-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="datatableCheckAll">
                                            <label class="form-check-label" for="datatableCheckAll"></label>
                                        </div>
                                    </th>
                                    <th>Action</th>
                                    <th>Date Deployed</th>
                                    <th>Staff ID</th>
                                    <th>Fullname</th>
                                    <th>Phone</th>
                                    <th>Client</th>
                                    <th>Role</th>
                                    <th>Employment Effective Date</th>
                                    <th>Work Location</th>
                                    <th>Salary</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                // $color = array('active','info','warning','active','danger','light blue');



                                if ($_GET['cat']) {
                                    $cat = base64_decode($_GET['cat']);
                                    $query = "select * from emp_staff_details where completed = '$cat' and $account_token order by date_moved desc limit 0,1600";
                                }
                                if (!$_GET['cat']) {
                                    $query = "select * from emp_staff_details where id = '" . base64_decode($_GET['single']) . "' and $account_token";
                                }
                                $result = mysqli_query($db, $query);
                                $num = mysqli_num_rows($result);
                                for ($i = 1; $i <= $num; $i++) {
                                    $row = mysqli_fetch_array($result);
                                ?>
                                    <tr>
                                        <td class="table-column-pe-0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="<?php echo $row['id']; ?>" name="id[]" id="usersDataCheck2">
                                                <label class="form-check-label" for="usersDataCheck2"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a target="blank" title="View Applicant"
                                                class="btn btn-sm btn-outline-secondary"
                                                href="view-applicants?id=<?php echo base64_encode($row['id']); ?>"><i
                                                    class=" bi-eye"></i></a>

                                            <a data-toggle="tooltip" data-placement="top" data-original-title="Download Cv"
                                                class="btn btn-sm btn-outline-secondary" download
                                                href="<?php echo FILE_DIR; ?>documents/<?php echo get_val('credentials', 'candidate_id', $row['candidate_id'], 'filepath'); ?>"><i
                                                    class="bi-download"></i></a>

                                            <a title="Download Cv" class="btn btn-sm btn-outline-secondary"
                                                href="upload_staff_documents.php?candidate_id=<?php echo base64_encode($row['candidate_id']); ?>"><i
                                                    class=" bi-upload"></i></a>

                                            <?php
                                            if (check_module($_SESSION['privilege'], 'HRBP') == 'yes') {
                                                if ($_GET['cat'] == base64_encode('client')) { ?>
                                                    <a data-toggle="tooltip" data-placement="top" data-original-title="Edit"
                                                        title="Generate Offer Letter" href="javascript:;" data-bs-toggle="modal"
                                                        data-bs-target="#newProjectModal<?= $row['id'] ?>"
                                                        class="btn btn-sm btn-outline-secondary identifyingClass"><i
                                                            class="bi-envelope"></i></a>
                                            <?php
                                                }
                                            } ?>


                                            <div class="modal fade" id="newProjectModal<?= $row['id'] ?>" tabindex="-1"
                                                aria-labelledby="newProjectModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="newProjectModalLabel">Generate Offer
                                                                Letter</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <!-- Body -->
                                                        <div class="modal-body">
                                                            <!-- Step Form -->
                                                            <form class="js-step-form" data-hs-step-form-options='{
                                                            "progressSelector": "#createProjectStepFormProgress",
                                                            "stepsSelector": "#createProjectStepFormContent",
                                                            "endSelector": "#createProjectFinishBtn",
                                                            "isValidate": false
                                                            }' method="post"
                                                                action="send_letter?cat=<?php echo base64_encode($row['id']); ?>"
                                                                target="_blank" enctype="multipart/form-data">


                                                                <!-- Content Step Form -->
                                                                <div id="createProjectStepFormContent">
                                                                    <div id="createProjectStepDetails" class="active">

                                                                        <!-- Form -->
                                                                        <div class="mb-4">


                                                                            <div class="row align-items-center">
                                                                                <div class="col-6 col-md-6 mb-3">
                                                                                    <label for="clientNewProjectLabel"
                                                                                        class="form-label">FirstName</label>
                                                                                    <div
                                                                                        class="input-group input-group-merge">
                                                                                        <input class="form-control"
                                                                                            id="clientNewProjectLabel"
                                                                                            placeholder="" name="name"
                                                                                            value="<?php echo $row['firstname']; ?>"
                                                                                            readonly>
                                                                                        <input type="hidden" name="id"
                                                                                            value="<?php echo $row['id']; ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6 col-md-6 mb-3">
                                                                                    <label for="clientNewProjectLabel"
                                                                                        class="form-label">LastName</label>
                                                                                    <div
                                                                                        class="input-group input-group-merge">
                                                                                        <input class="form-control"
                                                                                            id="clientNewProjectLabel"
                                                                                            placeholder="" name="lastname"
                                                                                            value="<?php echo $row['surname']; ?>"
                                                                                            readonly>
                                                                                        <input type="hidden"
                                                                                            value="<?php echo $cat ?>"
                                                                                            name="catid">
                                                                                    </div>
                                                                                </div>
                                                                                <!-- End Col -->
                                                                            </div>
                                                                            <!-- End Row -->
                                                                        </div>
                                                                        <!-- End Form -->

                                                                        <!-- Form -->
                                                                        <div class="mb-4">


                                                                            <div class="row align-items-center">
                                                                                <div class="col-6 col-md-6 mb-3">
                                                                                    <label for="clientNewProjectLabel"
                                                                                        class="form-label">Email</label>
                                                                                    <div
                                                                                        class="input-group input-group-merge">
                                                                                        <input type="email"
                                                                                            class="form-control"
                                                                                            id="clientNewProjectLabel"
                                                                                            placeholder="" name="email"
                                                                                            value="<?php echo $row['email_address']; ?>"
                                                                                            aria-label="" readonly>


                                                                                        <input type="hidden" name="id"
                                                                                            class="form-control" id="idss"
                                                                                            readonly value="">

                                                                                        <input type="hidden" name="position"
                                                                                            class="form-control"
                                                                                            id="position" readonly
                                                                                            value="<?= $row['position_code'] ?>">

                                                                                        <input type="hidden" name="clien"
                                                                                            class="form-control client<?= $i ?>"
                                                                                            id="clien" readonly
                                                                                            value="<?= $row['company_code'] ?>">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6 col-md-6 mb-3">
                                                                                    <label for="clientNewProjectLabel"
                                                                                        class="form-label">Phone
                                                                                        Number</label>
                                                                                    <div
                                                                                        class="input-group input-group-merge">
                                                                                        <input class="form-control"
                                                                                            id="clientNewProjectLabel"
                                                                                            placeholder="" name="phone"
                                                                                            value="<?php echo $row['mobile_phone_number']; ?>"
                                                                                            readonly aria-label="">
                                                                                    </div>
                                                                                </div>
                                                                                <!-- End Col -->
                                                                            </div>
                                                                            <!-- End Row -->
                                                                        </div>
                                                                        <!-- End Form -->

                                                                        <!-- Form -->
                                                                        <div class="mb-4">


                                                                            <div class="row align-items-center">
                                                                                <div class="col-6 col-md-6 mb-3">
                                                                                    <label for="clientNewProjectLabel"
                                                                                        class="form-label">Template</label>
                                                                                    <div
                                                                                        class="input-group input-group-merge">
                                                                                        <select name="template_id"
                                                                                            class="form-control"
                                                                                            id="template_id<?= $i ?>">
                                                                                            <option value="">Select</option>
                                                                                            <?php getmessagetem(); ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6 col-md-6 mb-3">
                                                                                    <label for="clientNewProjectLabel"
                                                                                        class="form-label">Subject</label>
                                                                                    <div
                                                                                        class="input-group input-group-merge">
                                                                                        <input type="text" name="subject"
                                                                                            id="subject<?= $i ?>"
                                                                                            class="form-control">
                                                                                        <input type="hidden"
                                                                                            name="messageId"
                                                                                            id="id<?= $i ?>"
                                                                                            class="form-control">
                                                                                        <input type="hidden" name="staff_id"
                                                                                            id="id_staff<?= $i ?>"
                                                                                            class="form-control"
                                                                                            value=<?= $row['staff_id'] ?>>


                                                                                    </div>
                                                                                </div>

                                                                                <!-- End Col -->
                                                                            </div>


                                                                            <!-- End Row -->
                                                                        </div>
                                                                        <!-- End Form -->

                                                                        <!-- Form -->
                                                                        <div class="mb-4">
                                                                            <label for="clientNewProjectLabel"
                                                                                class="form-label"></label>

                                                                            <div class="row align-items-center">
                                                                                <div class="col-12 col-md-12 mb-3">
                                                                                    <div
                                                                                        class="input-group input-group-merge">
                                                                                        <textarea name="body_msg"
                                                                                            id="body_msg<?= $i ?>"></textarea>
                                                                                        <script>
                                                                                            CKEDITOR.replace(
                                                                                                'body_msg<?= $i ?>');
                                                                                        </script>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- End Col -->


                                                                            </div>
                                                                            <!-- End Row -->
                                                                        </div>

                                                                        <!-- Footer -->
                                                                        <div class="d-flex align-items-center mt-5">
                                                                            <div class="">
                                                                                <input type="submit" name="generate"
                                                                                    value="Generate & Preview"
                                                                                    class="btn btn-primary"
                                                                                    id="showButton<?= $i ?>">
                                                                            </div>
                                                                            <div class="" style="margin-left: 30px;">
                                                                                <input type="submit"
                                                                                    value="Send Offer Letter"
                                                                                    name="offerletter"
                                                                                    class="btn btn-success"
                                                                                    id="hideButton<?= $i ?>"
                                                                                    style="display:none;">
                                                                            </div>
                                                                        </div>
                                                                        <!-- End Footer -->
                                                                    </div>
                                                                </div>
                                                                <!-- End Content Step Form -->
                                                            </form>
                                                            <!-- End Step Form -->
                                                        </div>
                                                        <!-- End Body -->
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                $('#showButton<?= $i ?>').click(function() {
                                                    $('#hideButton<?= $i ?>').show()
                                                })
                                            </script>
                                            <script type="text/javascript">
                                                $(document).ready(function() {


                                                    $("#template_id<?= $i ?>").change(function() {

                                                        var template_id = $(this).val();
                                                        $.ajax({
                                                            url: "get_message.php",
                                                            type: "POST",
                                                            data: {
                                                                template_id: template_id
                                                            },
                                                            dataType: "json",
                                                            success: function(response) {
                                                                $('#subject<?= $i ?>').val(response[
                                                                    0]);
                                                                CKEDITOR.instances[
                                                                        'body_msg<?= $i ?>']
                                                                    .setData(response[1]);
                                                                $('#sms<?= $i ?>').html(response[
                                                                    2]);
                                                                $('#id<?= $i ?>').val(response[3]);
                                                            }
                                                        });
                                                    });
                                                    // $(".client<?= $i ?>").change(function() {

                                                    var client = $(".client<?= $i ?>").val();
                                                    $.ajax({
                                                        url: "get_band.php",
                                                        method: "POST",
                                                        data: {
                                                            client: client
                                                        },
                                                        success: function(response) {
                                                            // alert(response)
                                                            $('#band<?= $i ?>').html(response);
                                                        }
                                                    });
                                                    // });
                                                });
                                            </script>
                                        </td>
                                        <td class="table-column-ps-0">
                                            <?php echo short_date($row['date_moved']); ?>
                                        </td>

                                        <td><a
                                                href="change-staff-id?id=<?php echo base64_encode($row['id']); ?>&n=<?php echo base64_encode($row['firstname'] . ' ' . $row['surname']); ?>&staff_id=<?php echo base64_encode($row['EmployeeID']); ?>"><?php echo $row['EmployeeID']; ?></a>
                                        </td>

                                        <td><?php echo $row['firstname']; ?> <?php echo $row['surname']; ?><br>
                                            <?php echo $row['email_address']; ?> </td>
                                        <td><?php echo $row['mobile_phone_number']; ?></td>
                                        <td><?php echo decode_client_name($row['company_code']); ?></td>
                                        <td><?php echo decode_position_name($row['position_code']); ?></td>
                                        <td><?php echo $row['effective_date']; ?></td>
                                        <td><?php echo decode_location_name($row['location_code']); ?></td>

                                        <td><?php echo $row['salary']; ?></td>


                                    </tr>


                                <?php } ?>


                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->

                    <!-- Footer -->
                    <div class="card-footer">
                        <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                            <div class="col-sm mb-2 mb-sm-0">
                                <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                                    <span class="me-2">Showing:</span>

                                    <!-- Select -->
                                    <div class="tom-select-custom">
                                        <select id="datatableEntries"
                                            class="js-select form-select form-select-borderless w-auto"
                                            autocomplete="off" data-hs-tom-select-options='{
                            "searchInDropdown": false,
                            "hideSearch": true
                          }'>
                                            <option value="10">10</option>
                                            <option value="15" selected>15</option>
                                            <option value="20">20</option>
                                        </select>
                                    </div>
                                    <!-- End Select -->

                                    <span class="text-secondary me-2">of</span>

                                    <!-- Pagination Quantity -->
                                    <span id="datatableWithPaginationInfoTotalQty"></span>
                                </div>
                            </div>
                            <!-- End Col -->

                            <div class="col-sm-auto">
                                <div class="d-flex justify-content-center justify-content-sm-end">
                                    <!-- Pagination -->
                                    <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                                </div>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Footer -->
                </div>
            </form>
            <!-- End Card -->
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

    <script>
        $("#btn_generate").click(function() {


            var staff_id_format = $('#staff_id_format').val();

            var job = $('#job').val();
            var effective_date = $('#effective_date').val();
            var clients = $('#clients').val();

            var basic_salary = $('#basic_salary').val();
            var housing = $('#housing').val();
            var transport = $('#transport').val();
            var meal = $('#meal').val();
            var utitliy = $('#utitliy').val();
            var entertainment = $('#entertainment').val();
            var leave_allowance = $('#leave_allowance').val();
            var annual_pay = $('#annual_pay').val();
            var monthly_net = $('#monthly_net').val();

            if (staff_id_format == '') {
                document.getElementById("staff_id_format").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Staff Id Format is required";
                return false;
            } else {
                document.getElementById("staff_id_format").style.borderColor = 'green';
            }

            if (effective_date == '') {

                document.getElementById("effective_date").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Effective Date is required";
                return false;
            } else {
                document.getElementById("effective_date").style.borderColor = 'green';
            }

            if (clients == 'select_client') {

                document.getElementById("clients").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Client is required";
                return false;
            } else {
                document.getElementById("clients").style.borderColor = 'green';
            }

            if (basic_salary == '') {

                document.getElementById("basic_salary").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Basic Salary is required";

                return false;
            } else {
                document.getElementById("basic_salary").style.borderColor = 'green';

            }


            if (housing == '') {

                document.getElementById("housing").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Housing is required";
                return false;
            } else {
                document.getElementById("housing").style.borderColor = 'green';
            }

            if (transport == '') {

                document.getElementById("transport").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Transport is required";
                return false;
            } else {
                document.getElementById("transport").style.borderColor = 'green';
            }

            if (meal == '') {

                document.getElementById("meal").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Meal is required";
                return false;
            } else {
                document.getElementById("meal").style.borderColor = 'green';
            }

            if (utility == '') {

                document.getElementById("utility").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Utility is required";
                return false;
            } else {
                document.getElementById("utility").style.borderColor = 'green';
            }

            if (entertainment == '') {

                document.getElementById("entertainment").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Entertainment is required";
                return false;
            } else {
                document.getElementById("entertainment").style.borderColor = 'green';
            }

            if (leave_allowance == '') {

                document.getElementById("leave_allowance").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Leave Allowance is required";
                return false;
            } else {
                document.getElementById("leave_allowance").style.borderColor = 'green';
            }

            if (annual_pay == '') {

                document.getElementById("annual_pay").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Total Annual Pay is required";
                return false;
            } else {
                document.getElementById("annual_pay").style.borderColor = 'green';
            }

            if (monthly_net == '') {

                document.getElementById("monthly_net").style.borderColor = 'red';
                document.getElementById("error").innerHTML = "Monthly Net is required";
                return false;
            } else {
                document.getElementById("monthly_net").style.borderColor = 'green';
            }

        });



        $('#clients').change(function() {
            tab_val = document.getElementById("clients").value;
            $('#p_client').val(tab_val);
        });




        $(document).ready(function() {


            $("#client").change(function() {

                var client = $(this).val();
                $.ajax({
                    url: "get_band.php",
                    method: "POST",
                    data: {
                        client: client
                    },
                    success: function(response) {
                        $('#band').html(response);
                    }
                });
            });
        });

        // $(document).ready(function() {


        //     $("#salary_band").change(function() {

        //         var salary_band = $(this).val();
        //         var client = $('#client').val();
        //         $.ajax({
        //             url: "get_level.php",
        //             method: "POST",
        //             data: {
        //                 salary_band: salary_band,
        //                 // client: client
        //             },
        //             success: function(response) {
        //                 $('#level').html(response);
        //             }
        //         });
        //     });
        // });
    </script>


    <!-- End New Project Modal -->
    <!-- ========== END SECONDARY CONTENTS ========== -->

    <!-- JS Global Compulsory  -->


    <script>
        $("#pool").click('click', (function() {

            // alert('yes')
            var emailCheck = 'yes';

            var checkID = $.map($("input[name='id[]']:checked"), function(e, i) {
                return +e.value;
            });


            if (checkID == "") {
                alert('You need to check at least one applicant');
                return false;

            } else {
                $.ajax({
                    url: "getModal.php",
                    type: "POST",
                    data: {
                        checkID: checkID,
                        emailCheck: emailCheck
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#name').val(response[0]);
                        $('#email').val(response[1]);
                        $('#mobile').val(response[2]);

                        $('#idss').val(response[4]);
                        $('#positio').val(response[6]);
                        $('#clien').val(response[7]);
                        $('#id_staff').val(response[8]);





                    }
                });
            }


        }));
    </script>

    <!-- JS Implementing Plugins -->
    <script src="./assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside.min.js"></script>
    <script src="./assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>

    <script src="./assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
    <script src="./assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
    <script src="./assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
    <script src="./assets/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="./assets/vendor/quill/dist/quill.min.js"></script>
    <script src="./assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
    <script src="./assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="./assets/vendor/datatables.net.extensions/select/select.min.js"></script>
    <script src="./assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="./assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="./assets/vendor/jszip/dist/jszip.min.js"></script>
    <script src="./assets/vendor/pdfmake/build/pdfmake.min.js"></script>
    <script src="./assets/vendor/pdfmake/build/vfs_fonts.js"></script>
    <script src="./assets/vendor/datatables.net-buttons/js/buttons5.min.js"></script>
    <script src="./assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="./assets/vendor/datatables.net-buttons/js/buttons.colVis.min.js"></script>

    <!-- JS Front -->
    <script src="./assets/js/theme.min.js"></script>

    <!-- JS Plugins Init. -->
    <script>
        $(document).on('ready', function() {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            HSCore.components.HSDatatables.init($('#datatable'), {
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        className: 'd-none'
                    },
                    {
                        extend: 'excel',
                        className: 'd-none'
                    },
                    {
                        extend: 'csv',
                        className: 'd-none'
                    },
                    {
                        extend: 'pdf',
                        className: 'd-none'
                    },
                    {
                        extend: 'print',
                        className: 'd-none'
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
                language: {
                    zeroRecords: `<div class="text-center p-4">
              <img class="mb-3" src="./assets/svg/illustrations/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="default">
              <img class="mb-3" src="./assets/svg/illustrations-light/oc-error.svg" alt="Image Description" style="width: 10rem;" data-hs-theme-appearance="dark">
            <p class="mb-0">No data to show</p>
            </div>`
                }
            });

            const datatable = HSCore.components.HSDatatables.getItem(0)

            $('#export-copy').click(function() {
                datatable.button('.buttons-copy').trigger()
            });

            $('#export-excel').click(function() {
                datatable.button('.buttons-excel').trigger()
            });

            $('#export-csv').click(function() {
                datatable.button('.buttons-csv').trigger()
            });

            $('#export-pdf').click(function() {
                datatable.button('.buttons-pdf').trigger()
            });

            $('#export-print').click(function() {
                datatable.button('.buttons-print').trigger()
            });

            $('.js-datatable-filter').on('change', function() {
                var $this = $(this),
                    elVal = $this.val(),
                    targetColumnIndex = $this.data('target-column-index');

                datatable.column(targetColumnIndex).search(elVal).draw();
            });
        });
    </script>

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


                // INITIALIZATION OF SELECT
                // =======================================================
                HSCore.components.HSTomSelect.init('.js-select')


                // INITIALIZATION OF FILE ATTACHMENT
                // =======================================================
                new HSFileAttach('.js-file-attach')


                // INITIALIZATION OF QUILLJS EDITOR
                // =======================================================
                HSCore.components.HSQuill.init('.js-quill')


                // INITIALIZATION OF DROPZONE
                // =======================================================
                HSCore.components.HSDropzone.init('.js-dropzone')


                // INITIALIZATION OF STEP FORM
                // =======================================================
                new HSStepForm('.js-step-form', {
                    finish: () => {
                        document.getElementById("createProjectStepFormProgress").style.display = 'none'
                        document.getElementById("createProjectStepFormContent").style.display = 'none'
                        document.getElementById("createProjectStepDetails").style.display = 'none'
                        document.getElementById("createProjectStepTerms").style.display = 'none'
                        document.getElementById("createProjectStepMembers").style.display = 'none'
                        document.getElementById("createProjectStepSuccessMessage").style.display =
                            'block'
                        const formContainer = document.getElementById('formContainer')
                    }
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
            const $variants = document.querySelectorAll(
                `[aria-labelledby="selectThemeDropdown"] [data-icon]`) // All items of the dropdown

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

    <!-- page jquery  -->
    <script type="text/javascript">
        $(document).ready(function() {

            $("#sendEmailInvite").click('click', (function() {


                var emailCheck = 'yes';
                var checkID = $.map($("input[name='id[]']:checked"), function(e, i) {
                    return +e.value;
                });
                if (checkID == "") {

                    // toastr.options.closeButton = true;
                    // toastr.options.positionClass = 'toast-bottom-right';
                    // toastr['#error']('You need to check at least one applicant');
                    alert('You need to check at least one applicant');
                    return false;



                } else {
                    $.ajax({
                        url: "get_email.php",
                        type: "POST",
                        data: {
                            checkID: checkID,
                            emailCheck: emailCheck
                        },
                        dataType: "json",
                        success: function(response) {
                            $('#emailInvite').modal('show');
                            $('#emailInviteCheck').val(response[0]);
                            $('#smsInviteCheck').val(response[1]);
                            $('#idList').val(response[2]);
                        }
                    });
                }
            }));
        });
    </script>
    <!-- //page jquery -->

    <script type="text/javascript">
        $(document).ready(function() {
            $("#move").on('click', (function() {
                var id = $.map($("input[name='id[]']:checked"), function(e, i) {
                    return +e.value;
                });
                if (id == "") {
                    alert('You need to check at least one applicant');
                    return false;

                }
            }));
        });
    </script>






    <script type="text/javascript">
        $(document).ready(function() {
            $("#exportSelect").on('click', (function() {
                var checkID = $.map($("input[name='id[]']:checked"), function(e, i) {
                    return +e.value;
                });
                if (checkID == "") {

                    alert('You need to check at least one applicant');
                    return false;

                }
            }));
        });
    </script>
</body>

</html>