<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

if ($_GET['cat']) {
    $cat = base64_decode($_GET['cat']);
}
validatePermission('Job Seeker');
if ($_SESSION['account_token']) {
    if ($_GET['cat']) {
        $query = "select * from jobs_applied where status = '$cat' and account_token = '".$_SESSION['account_token']."' order by id desc limit 0,500";
    }
    if ($_GET['search']) {
        $search = base64_decode($_GET['search']);
        $query = "select * from jobs_applied where  firstname like '%" . $search . "%' ||  lastname like '%" . $search . "%' ||  middlename like '%" . $search . "%' and account_token = '".$_SESSION['account_token']."' order by id desc limit 0,500";
    }
} else {
    if ($_GET['cat']) {
        $query = "select * from jobs_applied where status = '$cat' order by id desc limit 0,500";
    }
    if ($_GET['search']) {
        $search = base64_decode($_GET['search']);
        $query = "select * from jobs_applied where  firstname like '%" . $search . "%' ||  lastname like '%" . $search . "%' ||  middlename like '%" . $search . "%'  order by id desc limit 0,500";
    }
}

if ($_POST['btn_filter']) {
    if ($_POST['ageFrom']) {
        $clause1 = " and age >= '" . $_POST['ageFrom'] . "'";
    }

    if ($_POST['ageTo']) {
        $clause2 = " and age <= '" . $_POST['ageTo'] . "'";
    }

    if ($_POST['job_title']) {
        $clause3 = " and job_title = '" . $_POST['job_title'] . "'";
    }

    if ($_POST['gender']) {
        $clause4 = " and gender = '" . $_POST['gender'] . "'";
    }

    if ($_POST['qualification']) {
        $clause5 = " and qualification = '" . $_POST['qualification'] . "'";
    }

    if ($_POST['class_degree']) {
        $clause6 = " and class_degree = '" . $_POST['class_degree'] . "'";
    }

    if ($_POST['state']) {
        $clause7 = " and state = '" . $_POST['state'] . "'";
    }

    if ($_POST['client_name']) {
        $clause8 = " and client_name = '" . $_POST['client_name'] . "'";
    }

    if ($_POST['country']) {
        $clause9 = " and country = '" . $_POST['country'] . "'";
    }

    $query = "select * from jobs_applied where status = '$cat'
                                                    $clause1$clause2$clause3$clause4$clause5$clause6$clause7$clause8$clause9 order by id desc limit 0,500";
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
    <title>Applicants | KlinHR</title>

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
                        Applicant List <span class="badge bg-soft-dark text-dark ms-1"><?php echo $num ?></span>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Page Header -->

            <!-- Card -->
            <div class="card mb-3 mb-lg-5">
                <!-- Body -->
                <!-- End Body -->
            </div>
            <!-- End Card -->

            <!-- Card -->
            <form action="process-app?cat=<?php echo base64_encode($cat); ?>" method="post"
                enctype="multipart/form-data">
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
                                    <input id="searchInput" type="search" class="form-control"
                                        placeholder="Search users" aria-label="Search users">
                                </div>
                                <!-- End Search -->
                            </form>
                        </div>

                        <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                            <!-- Datatable Info -->
                            <div id="datatableCounterInfo" style="display: none;">
                                <div class="d-flex align-items-center">
                                    <span class="fs-5 me-3">
                                        <span id="datatableCounter">0</span>
                                        Selected
                                    </span>
                                    <button type="submit" class="btn btn-outline-danger btn-sm" name="btn_export">
                                        <i class=" bi-file-earmark"></i> Export Selected
                                    </button>
                                </div>
                            </div>
                            <!-- End Datatable Info -->
                            <!-- Datatable Info -->
                            <div id="datatableCounterInfo">
                                <div class="d-flex align-items-center">
                                    <!-- <span class="fs-5 me-3">
                                        <span id="datatableCounter">0</span>
                                        Selected
                                    </span> -->
                                    <a type="submit" class="btn btn-outline-danger btn-sm"
                                        href="export-applicants?col=<?php echo base64_encode('status') ?>&val=<?php echo base64_encode($cat); ?>">
                                        <i class=" bi-folder"></i> Export All Applicants
                                    </a>
                                </div>
                            </div>
                            <!-- End Datatable Info -->

                            <!-- Datatable Info -->
                            <div id="datatableCounterInfo1">
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-outline-primary btn-sm" id="sendEmailInvite" type="button"
                                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasKeyboardShortcuts"
                                        data-target="#emailInvite" aria-controls="offcanvasKeyboardShortcuts">
                                        <i class=" bi-envelope"></i> Send Email Invite
                                    </button>
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
                                            <form id="filterForm">
                                                <div class="row">
                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">Sex</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <select id="sex"
                                                                class="js-select js-datatable-filter form-select form-select-sm"
                                                                data-target-column-index="2" data-hs-tom-select-options='{
                                      "placeholder": "gender",
                                      "searchInDropdown": false,
                                      "hideSearch": true,
                                      "dropdownWidth": "10rem"
                                    }'>
                                                                <option value="">Any</option>
                                                                <option value="Male">M</option>
                                                                <option value="Female">F</option>
                                                            </select>
                                                            <!-- End Select -->
                                                        </div>
                                                    </div>
                                                    <!-- End Col -->

                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">Client</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <select id="client_name"
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
                                                    <!-- End Col -->
                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">Role</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <select id="job_title"
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
                                                        <small class="text-cap text-body">Qualification</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <select id="qualification"
                                                                class="js-select js-datatable-filter form-select form-select-sm"
                                                                data-target-column-index="4" data-hs-tom-select-options='{
                                                        "placeholder": "Any status",
                                                        "searchInDropdown": false,
                                                        "hideSearch": true,
                                                        "dropdownWidth": "10rem"
                                                        }'>
                                                                <option value=" ">Any Qualification</option>
                                                                <?php random('qualification', 'jobs_applied') ?>
                                                            </select>
                                                        </div>
                                                        <!-- End Select -->
                                                    </div>
                                                    <!-- End Col -->
                                                    <div class="col-sm mb-4">
                                                        <small class="text-cap text-body">Class Of Degree</small>

                                                        <!-- Select -->
                                                        <div class="tom-select-custom">
                                                            <select id="class_degree"
                                                                class="js-select js-datatable-filter form-select form-select-sm"
                                                                data-target-column-index="4" data-hs-tom-select-options='{
                                                        "placeholder": "Any status",
                                                        "searchInDropdown": false,
                                                        "hideSearch": true,
                                                        "dropdownWidth": "10rem"
                                                        }'>
                                                                <option value=" ">Any Degree</option>
                                                                <?php random('class_degree', 'jobs_applied') ?>
                                                            </select>
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
                            <!-- End Dropdown -->

                            <!-- Dropdown -->
                            <div class="dropdown">
                                <button type="button" class="btn btn-white btn-sm w-100" id="usersFilterDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi-filter me-1"></i> Move Applicant To
                                </button>



                                <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered"
                                    aria-labelledby="usersFilterDropdown" style="min-width: 22rem;">
                                    <!-- Card -->
                                    <div class="card">
                                        <div class="card-header card-header-content-between">
                                            <h5 class="card-header-title">Move applicants</h5>

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
                                                            <option label="empty">select</option>
                                                            <option value="Applied">Applicants</option>
                                                            <option value="Assessment">Assessment</option>
                                                            <option value="Onboarding">Onboarding</option>
                                                            <option value="Successful">Successful</option>
                                                            <option value="Unsuccessful">Unsuccessful</option>
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
                        <?php

                        if ($success || $_GET['success']) {
                            echo '<div class="alert alert-success">' . $success . $_GET['success'] . '</div>';
                        }
                        if ($error || $_GET['error']) {
                            echo '<div class="alert alert-danger">' . $error . $_GET['error'] . '</div>';
                        }

                        ?>
                        <?php if ($_GET['del'] == 'success') echo '<div class="alert alert-success">Applicant successfully deleted</div>'; ?>


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
                                    <th class="table-column-ps-0">Full name</th>
                                    <th>Sex/Age</th>
                                    <th>Role</th>
                                    <th>Qualification</th>
                                    <th>Client</th>
                                    <th>Date Applied</th>
                                    <th>Class Of Degree</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
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
                                    <nav id="datatablePagination" aria-label="Activity pagination">
                                        <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                                            <ul id="datatable_pagination" class="datatablePagination pagination datatable-custom-pagination">
                                                <!-- dynamically generated items go here -->
                                            </ul>
                                        </div>
                                    </nav>
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
    <form method="post" action="proc-message?cat=<?php echo base64_encode($cat); ?>" enctype="multipart/form-data">
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasKeyboardShortcuts"
            aria-labelledby="offcanvasKeyboardShortcutsLabel">
            <div class="offcanvas-header">
                <h4 id="offcanvasKeyboardShortcutsLabel" class="mb-0">Send Message and Move Candidate</h4>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                    <div class="list-group-item">
                        <!-- <h5 class="mb-1">Formatting</h5> -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                <span class="fw-semibold">Email</span>
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="email" name="email" id="emailInviteCheck" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                <em>Phone Number</em>
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="phone" id="smsInviteCheck" class="form-control" readonly>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Template
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <select name="template_id" class="form-control" id="template_id">
                                    <option value="">Select</option>
                                    <?php list_val('message_template', 'template_name', 'id'); ?>
                                </select>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Subject
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="subject" id="subject" class="form-control">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">

                            <div class="col-12">
                                <textarea name="body_msg" id="body_msg" width="100%">

                                        </textarea>
                                <script>
                                    CKEDITOR.replace('body_msg');
                                </script>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->

                    </div>

                </div>

                <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                    <div class="list-group-item">
                        <h5 class="mb-1">Sms Content</h5>
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <textarea name="sms" id="sms" class="form-control">

                                   </textarea>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>

                </div>

                <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                    <div class="list-group-item">
                        <!-- <h5 class="mb-1">Sms Content</h5> -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" name="jobs_applied_id" id="idList">
                                <input type="submit" class="btn btn-primary" value="Send Invite">
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>

                </div>
            </div>
        </div>
    </form>
    <!-- End Keyboard Shortcuts -->


    <!-- Activity -->
    <?php include('inc/modal-activity.php') ?>
    <!-- End Activity -->




    <!-- End New Project Modal -->
    <!-- ========== END SECONDARY CONTENTS ========== -->

    <!-- JS Global Compulsory  -->
    <script src="assests/js/jquery-1.11.1.min.js"></script>
    <script src="./assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="./assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

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


            $("#template_id").change(function() {

                var template_id = $(this).val();
                $.ajax({
                    url: "get_message.php",
                    type: "POST",
                    data: {
                        template_id: template_id
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#subject').val(response[0]);
                        CKEDITOR.instances['body_msg'].setData(response[1]);


                        $('#sms').html(response[2]);
                    }
                });
            });
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

<script>
    localStorage.setItem('userPrivilege', '<?php echo 'Super Admin'; ?>');
    localStorage.setItem('cat', '<?php echo $cat; ?>');
    window.APP_CONFIG = {
        FILE_DIR: '<?php echo 'uploads/documents' ?>'
    };
</script>

</html>
<script src="applicant.js"></script>