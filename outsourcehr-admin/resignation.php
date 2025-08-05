<?php

ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}
validatePermission('Hr Operations');

if ($_SESSION['privilege_user'] == 'administrator') {
    $query = "SELECT * FROM emp_resignation order by date asc, id desc";
} elseif ($_SESSION['privilege_user'] == 'ALL') {
    $query = "SELECT * FROM emp_resignation  order by id desc";
} else {
    $query = "SELECT * FROM emp_resignation where access_type like '%" . get_priviledge($_SESSION['privilege_user']) . "%' order by date asc, id desc";
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
    <title>Resignation | KlinHR</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/fav.png">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="./assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
    <link rel="stylesheet" href="./assets/vendor/quill/dist/quill.snow.css">
    <script src="ckeditor/ckeditor.js"></script>

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
                <div class="row align-items-end">
                    <!-- <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb breadcrumb-no-gutter">
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Projects</a></li>
                <li class="breadcrumb-item active" aria-current="page">Overview</li>
              </ol>
            </nav>

            <h1 class="page-header-title">Overview</h1>
          </div> -->
                    <!-- End Col -->

                    <!-- <div class="col-sm-auto">
            <a class="btn btn-primary" href="javascript:;" data-bs-toggle="modal" data-bs-target="#newProjectModal">
              <i class="bi-plus me-1"></i> New project
            </a>
          </div> -->
                    <!-- End Col -->
                </div>
                <!-- End Row -->

                <!-- Nav -->
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        Resignation <span
                            class="badge bg-soft-dark text-dark ms-1"><?php echo number_format($num) ?></span>
                    </li>
                    <!-- <li class="nav-item">
            <a class="nav-link" href="./projects-timeline">
              Timeline
            </a>
          </li> -->
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Page Header -->

            <!-- Card -->
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
                        <div id="datatableCounterInfo" style="display: none;">
                            <div class="d-flex align-items-center">
                                <span class="fs-5 me-3">
                                    <span id="datatableCounter">0</span>
                                    Selected
                                </span>
                                <a class="btn btn-outline-danger btn-sm" href="javascript:;">
                                    <i class="bi-download"></i> Delete
                                </a>
                            </div>
                        </div>
                        <!-- End Datatable Info -->
                    </div>
                </div>
                <!-- End Header -->

                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
                    <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
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
                                    <!-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                        <label class="form-check-label" for="datatableCheckAll"></label>
                                    </div> -->
                                    S/N
                                </th>
                                <th class="table-column-ps-0">Date</th>
                                <th class="table-column-ps-0">Staff ID</th>
                                <th class="table-column-ps-0">Full name</th>
                                <th>Client</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php




                            $color = array('active', 'info', 'warning', 'active', 'danger', 'light blue');

                            for ($i = 0; $i < $num; $i++) {
                                $row = mysqli_fetch_array($result);
                            ?>
                            <tr>
                                <td class="table-column-pe-0">
                                    <!-- <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="<?php echo $row['id']; ?>" name="id[]" id="usersDataCheck2">
                                                <label class="form-check-label" for="usersDataCheck2"></label>
                                            </div> -->
                                    <?php echo $i + 1 ?>
                                </td>
                                <td><?php echo short_date($row['letter_date']); ?></td>
                                <td><?php echo $staff_id = $row['staff_id']; ?></td>
                                <td class="table-column-ps-0">
                                    <span class="d-flex align-items-center">
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="text-inherit mb-0">
                                                <?php echo $row['names']; ?>
                                            </h5>
                                        </div>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php echo $row['access_type']; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo substr($row['reason'], 0, 10); ?>...<a href="javascript:;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#newProjectModal<?php echo ($row['id']); ?>">more</a>
                                    <div class="modal fade" id="newProjectModal<?php echo ($row['id']); ?>"
                                        tabindex="-1" aria-labelledby="newProjectModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="newProjectModalLabel">
                                                        <?php echo get_names($row['staff_id']); ?>(<?= $row['staff_id']; ?>)
                                                    </h5>
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
                                                        }'>
                                                        <!-- Step -->
                                                        <!-- <ul id="createProjectStepFormProgress" class="js-step-progress step step-sm step-icon-sm step-inline step-item-between mb-3 mb-sm-7">
                                                    <li class="step-item">
                                                        <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                                                            "targetSelector": "#createProjectStepDetails"
                                                        }'>
                                                        <span class="step-icon step-icon-soft-dark">1</span>
                                                        <div class="step-content">
                                                            <span class="step-title">Details</span>
                                                        </div>
                                                        </a>
                                                    </li>

                                                    <li class="step-item">
                                                        <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                                                            "targetSelector": "#createProjectStepTerms"
                                                        }'>
                                                        <span class="step-icon step-icon-soft-dark">2</span>
                                                        <div class="step-content">
                                                            <span class="step-title">Terms</span>
                                                        </div>
                                                        </a>
                                                    </li>

                                                    <li class="step-item">
                                                        <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                                                            "targetSelector": "#createProjectStepMembers"
                                                        }'>
                                                        <span class="step-icon step-icon-soft-dark">3</span>
                                                        <div class="step-content">
                                                            <span class="step-title">Members</span>
                                                        </div>
                                                        </a>
                                                    </li>
                                                    </ul> -->
                                                        <!-- End Step -->

                                                        <!-- Content Step Form -->
                                                        <div id="createProjectStepFormContent">
                                                            <div id="createProjectStepDetails" class="active">


                                                                <!-- Form -->
                                                                <div class="mb-4">

                                                                    <div class="row align-items-center">
                                                                        <div class="col-12 col-md-6 mb-3">
                                                                            <label for="clientNewProjectLabel"
                                                                                class="form-label">Email</label>
                                                                            <div class="input-group input-group-merge">
                                                                                <input class="form-control"
                                                                                    id="clientNewProjectLabel" readonly
                                                                                    value="<?php echo stripslashes($row['email']); ?>"
                                                                                    aria-label="Add creater name">
                                                                            </div>
                                                                        </div>
                                                                        <!-- End Col -->

                                                                        <!-- <span class="col-auto mb-3">or</span> -->

                                                                        <div class="col-12 col-md-6 mb-3">
                                                                            <label for="clientNewProjectLabel"
                                                                                class="form-label">Phone</label>
                                                                            <div class="input-group input-group-merge">
                                                                                <input class="form-control"
                                                                                    id="clientNewProjectLabel"
                                                                                    value="<?php echo stripslashes($row['phone']); ?>"
                                                                                    readonly
                                                                                    aria-label="Add creater name">
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
                                                                        <div class="col-12 col-md-6 mb-3">
                                                                            <label for="clientNewProjectLabel"
                                                                                class="form-label">Supervisor
                                                                                Name</label>
                                                                            <div class="input-group input-group-merge">
                                                                                <input class="form-control"
                                                                                    id="clientNewProjectLabel" readonly
                                                                                    value="<?php echo ucwords($row['supervisor_name']); ?>"
                                                                                    aria-label="Add creater name">
                                                                            </div>
                                                                        </div>
                                                                        <!-- End Col -->

                                                                        <!-- <span class="col-auto mb-3">or</span> -->

                                                                        <div class="col-12 col-md-6 mb-3">
                                                                            <label for="clientNewProjectLabel"
                                                                                class="form-label">Supervisor
                                                                                Email</label>
                                                                            <div class="input-group input-group-merge">
                                                                                <input class="form-control"
                                                                                    id="clientNewProjectLabel"
                                                                                    value="<?php echo stripslashes($row['supervisor_email']); ?>"
                                                                                    readonly
                                                                                    aria-label="Add creater name">
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
                                                                        <div class="col-12 col-md-6 mb-3">
                                                                            <label for="clientNewProjectLabel"
                                                                                class="form-label">Job Role</label>
                                                                            <div class="input-group input-group-merge">
                                                                                <input class="form-control"
                                                                                    id="clientNewProjectLabel" readonly
                                                                                    value="<?php echo ucwords($row['job_role']); ?>"
                                                                                    aria-label="Add creater name">
                                                                            </div>
                                                                        </div>
                                                                        <!-- End Col -->

                                                                        <!-- <span class="col-auto mb-3">or</span> -->

                                                                        <div class="col-12 col-md-6 mb-3">
                                                                            <label for="clientNewProjectLabel"
                                                                                class="form-label">Branch</label>
                                                                            <div class="input-group input-group-merge">
                                                                                <input class="form-control"
                                                                                    id="clientNewProjectLabel"
                                                                                    value="<?php echo ucwords($row['branch']); ?>"
                                                                                    readonly
                                                                                    aria-label="Add creater name">
                                                                            </div>
                                                                        </div>
                                                                        <!-- End Col -->
                                                                    </div>
                                                                    <!-- End Row -->
                                                                </div>
                                                                <!-- End Form -->

                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <!-- Form -->
                                                                        <div class="mb-4">
                                                                            <label for="projectDeadlineNewProjectLabel"
                                                                                class="form-label text-danger">Date
                                                                                Applied</label>

                                                                            <div id="projectDeadlineNewProject"
                                                                                class="input-group input-group-merge">
                                                                                <input type="date" class="form-control"
                                                                                    id="projectDeadlineNewProjectLabel"
                                                                                    value="<?php echo stripslashes($row['letter_date']); ?>"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!-- End Form -->
                                                                    </div>
                                                                    <!-- End Col -->

                                                                    <div class="col-sm-6">
                                                                        <!-- Form -->
                                                                        <div class="mb-4">
                                                                            <label for="ownerNewProjectLabel"
                                                                                class="form-label text-danger">Date Of
                                                                                Employment</label>

                                                                            <!-- Select -->
                                                                            <div id="projectDeadlineNewProject"
                                                                                class="input-group input-group-merge">
                                                                                <input type="date" class="form-control"
                                                                                    id="projectDeadlineNewProjectLabel"
                                                                                    value="<?= $row['date_appoint']; ?>"
                                                                                    readonly>
                                                                            </div>
                                                                            <!-- End Select -->
                                                                        </div>
                                                                        <!-- End Form -->
                                                                    </div>
                                                                    <!-- End Col -->
                                                                </div>
                                                                <!-- End Row -->

                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <!-- Form -->
                                                                        <div class="mb-4">
                                                                            <label for="projectDeadlineNewProjectLabel"
                                                                                class="form-label text-danger">Date of
                                                                                Resignation</label>

                                                                            <div id="projectDeadlineNewProject"
                                                                                class="input-group input-group-merge">
                                                                                <input type="date" class="form-control"
                                                                                    id="projectDeadlineNewProjectLabel"
                                                                                    value="<?php echo stripslashes($row['date']); ?>"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>
                                                                        <!-- End Form -->
                                                                    </div>
                                                                    <!-- End Col -->
                                                                </div>
                                                                <!-- End Row -->

                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="mb-4">
                                                                            <label for="ownerNewProjectLabel"
                                                                                class="form-label">Reason For
                                                                                Leaving</label>

                                                                            <!-- Select -->
                                                                            <div id="projectDeadlineNewProject"
                                                                                class="input-group input-group-merge">
                                                                                <span class="form-control"
                                                                                    id="projectDeadlineNewProjectLabel"><?php echo stripslashes($row['reason']);  ?></span>
                                                                            </div>
                                                                            <!-- End Select -->
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Footer -->
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="d-flex align-items-center mt-5">
                                                                            <div class="ms-auto">
                                                                                <a download
                                                                                    href="<?php echo $row['image_path']; ?>"
                                                                                    class="btn btn-primary">
                                                                                    Download Resignation Letter
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <div class="d-flex align-items-center mt-5">
                                                                            <div class="ms-auto">
                                                                                <?php if (!empty($row['image_path_exit'])) { ?>
                                                                                <a download
                                                                                    href="<?php echo $row['image_path_exit']; ?>"
                                                                                    class="btn btn-primary">Download
                                                                                    Exit Letter</a>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- End Footer -->
                                                            </div>

                                                            <div id="createProjectStepTerms" style="display: none;">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <!-- Form -->
                                                                        <div class="mb-4">
                                                                            <label for="paymentTermsNewProjectLabel"
                                                                                class="form-label">Terms</label>

                                                                            <!-- Select -->
                                                                            <div class="tom-select-custom">
                                                                                <select class="js-select form-select"
                                                                                    id="paymentTermsNewProjectLabel"
                                                                                    data-hs-tom-select-options='{
                                                                        "searchInDropdown": false,
                                                                        "hideSearch": true
                                                                        }'>
                                                                                    <option value="fixed" selected>Fixed
                                                                                    </option>
                                                                                    <option value="Per hour">Per hour
                                                                                    </option>
                                                                                    <option value="Per day">Per day
                                                                                    </option>
                                                                                    <option value="Per week">Per week
                                                                                    </option>
                                                                                    <option value="Per month">Per month
                                                                                    </option>
                                                                                    <option value="Per quarter">Per
                                                                                        quarter</option>
                                                                                    <option value="Per year">Per year
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <!-- End Select -->
                                                                        </div>
                                                                        <!-- End Form -->
                                                                    </div>
                                                                    <!-- End Col -->

                                                                    <div class="col-sm-6">
                                                                        <label for="expectedValueNewProjectLabel"
                                                                            class="form-label">Expected value</label>

                                                                        <!-- Form -->
                                                                        <div class="mb-4">
                                                                            <div class="input-group input-group-merge">
                                                                                <div
                                                                                    class="input-group-prepend input-group-text">
                                                                                    <i class="bi-currency-dollar"></i>
                                                                                </div>
                                                                                <input type="text" class="form-control"
                                                                                    name="expectedValue"
                                                                                    id="expectedValueNewProjectLabel"
                                                                                    placeholder="Enter value here"
                                                                                    aria-label="Enter value here">
                                                                            </div>
                                                                        </div>
                                                                        <!-- End Form -->
                                                                    </div>
                                                                    <!-- End Col -->
                                                                </div>
                                                                <!-- End Form Row -->

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <!-- Form -->
                                                                        <div class="mb-4">
                                                                            <label for="milestoneNewProjectLabel"
                                                                                class="form-label">Milestone <a
                                                                                    class="small ms-1"
                                                                                    href="javascript:;">Change
                                                                                    probability</a></label>

                                                                            <!-- Select -->
                                                                            <div class="tom-select-custom">
                                                                                <select class="js-select form-select"
                                                                                    id="milestoneNewProjectLabel"
                                                                                    data-hs-tom-select-options='{
                                                                        "searchInDropdown": false,
                                                                        "hideSearch": true
                                                                        }'>
                                                                                    <option value="New">New</option>
                                                                                    <option value="Qualified">Qualified
                                                                                    </option>
                                                                                    <option value="Meeting">Meeting
                                                                                    </option>
                                                                                    <option value="Proposal">Proposal
                                                                                    </option>
                                                                                    <option value="Negotiation">
                                                                                        Negotiation</option>
                                                                                    <option value="Contact">Contact
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <!-- End Select -->
                                                                        </div>
                                                                        <!-- End Form -->
                                                                    </div>
                                                                    <!-- End Col -->

                                                                    <div class="col-lg-6">
                                                                        <!-- Form -->
                                                                        <div class="mb-4">
                                                                            <label for="privacyNewProjectLabel"
                                                                                class="form-label me-2">Privacy</label>

                                                                            <!-- Select -->
                                                                            <div class="tom-select-custom">
                                                                                <select class="js-select form-select"
                                                                                    id="privacyNewProjectLabel"
                                                                                    data-hs-tom-select-options='{
                                                                        "searchInDropdown": false,
                                                                        "hideSearch": true
                                                                        }'>
                                                                                    <option value="privacy1"
                                                                                        data-option-template='<span class="d-flex"><i class="bi-people fs2 text-body"></i><span class="flex-grow-1 ms-2"><span class="d-block">Everyone</span><small class="tom-select-custom-hide">Public to Front Dashboard</small></span></span>'>
                                                                                        Everyone</option>
                                                                                    <option value="privacy2" disabled
                                                                                        data-option-template='<span class="d-flex"><i class="bi-lock fs2 text-body"></i><span class="flex-grow-1 ms-2"><span class="d-block">Private to project members <span class="badge bg-soft-primary text-primary">Upgrade to Premium</span></span><small class="tom-select-custom-hide">Only visible to project members</small></span></span>'>
                                                                                        Private to project members
                                                                                    </option>
                                                                                    <option value="privacy3"
                                                                                        data-option-template='<span class="d-flex"><i class="bi-person fs2 text-body"></i><span class="flex-grow-1 ms-2"><span class="d-block">Private to me</span><small class="tom-select-custom-hide">Only visible to you</small></span></span>'>
                                                                                        Private to me</option>
                                                                                </select>
                                                                            </div>
                                                                            <!-- End Select -->
                                                                        </div>
                                                                        <!-- End Form -->
                                                                    </div>
                                                                    <!-- End Col -->
                                                                </div>
                                                                <!-- End Form Row -->

                                                                <div class="d-grid gap-2">
                                                                    <!-- Check -->
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="" id="budgetNewProjectCheckbox">
                                                                        <label class="form-check-label"
                                                                            for="budgetNewProjectCheckbox">
                                                                            Budget resets every month
                                                                        </label>
                                                                    </div>
                                                                    <!-- End Check -->

                                                                    <!-- Check -->
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="" id="emailAlertNewProjectCheckbox"
                                                                            checked>
                                                                        <label class="form-check-label"
                                                                            for="emailAlertNewProjectCheckbox">
                                                                            Send email alerts if project exceeds <span
                                                                                class="font-weight-bold">50.00%</span>
                                                                            of budget
                                                                        </label>
                                                                    </div>
                                                                    <!-- End Check -->
                                                                </div>

                                                                <!-- Footer -->
                                                                <div class="d-flex align-items-center mt-5">
                                                                    <button type="button"
                                                                        class="btn btn-ghost-secondary me-2"
                                                                        data-hs-step-form-prev-options='{
                                                            "targetSelector": "#createProjectStepDetails"
                                                            }'>
                                                                        <i class="bi-chevron-left"></i> Previous step
                                                                    </button>

                                                                    <div class="ms-auto">
                                                                        <button type="button" class="btn btn-primary"
                                                                            data-hs-step-form-next-options='{
                                                                    "targetSelector": "#createProjectStepMembers"
                                                                    }'>
                                                                            Next <i class="bi-chevron-right"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <!-- End Footer -->
                                                            </div>

                                                            <div id="createProjectStepMembers" style="display: none;">
                                                                <!-- Form -->
                                                                <div class="mb-4">
                                                                    <div class="input-group mb-2 mb-sm-0">
                                                                        <input type="text" class="form-control"
                                                                            name="fullName"
                                                                            placeholder="Search name or emails"
                                                                            aria-label="Search name or emails">

                                                                        <div
                                                                            class="input-group-append input-group-append-last-sm-down-none">
                                                                            <!-- Select -->
                                                                            <div
                                                                                class="tom-select-custom tom-select-custom-end">
                                                                                <select
                                                                                    class="js-select form-select tom-select-custom-form-select-invite-user"
                                                                                    autocomplete="off"
                                                                                    data-hs-tom-select-options='{
                                                                        "searchInDropdown": false,
                                                                        "hideSearch": true,
                                                                        "dropdownWidth": "11rem"
                                                                        }'>
                                                                                    <option value="guest" selected>Guest
                                                                                    </option>
                                                                                    <option value="can edit">Can edit
                                                                                    </option>
                                                                                    <option value="can comment">Can
                                                                                        comment</option>
                                                                                    <option value="full access">Full
                                                                                        access</option>
                                                                                </select>
                                                                            </div>
                                                                            <!-- End Select -->

                                                                            <a class="btn btn-primary d-none d-sm-inline-block"
                                                                                href="javascript:;">Invite</a>
                                                                        </div>
                                                                    </div>

                                                                    <a class="btn btn-primary w-100 d-sm-none"
                                                                        href="javascript:;">Invite</a>
                                                                </div>
                                                                <!-- End Form -->

                                                                <ul class="list-unstyled list-py-3 mb-5">
                                                                    <!-- List Group Item -->
                                                                    <li>
                                                                        <div class="d-flex">
                                                                            <div class="flex-shrink-0">
                                                                                <span
                                                                                    class="icon icon-soft-dark icon-sm icon-circle">
                                                                                    <i class="bi-people-fill"></i>
                                                                                </span>
                                                                            </div>

                                                                            <div class="flex-grow-1 ms-3">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-sm">
                                                                                        <h5 class="text-body mb-0">
                                                                                            #digitalmarketing</h5>
                                                                                        <span class="d-block fs-6">8
                                                                                            members</span>
                                                                                    </div>
                                                                                    <!-- End Col -->

                                                                                    <div class="col-sm-auto">
                                                                                        <!-- Select -->
                                                                                        <div
                                                                                            class="tom-select-custom tom-select-custom-sm-end">
                                                                                            <select
                                                                                                class="js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0"
                                                                                                autocomplete="off"
                                                                                                data-hs-tom-select-options='{
                                                                                "searchInDropdown": false,
                                                                                "hideSearch": true,
                                                                                "dropdownWidth": "11rem"
                                                                            }'>
                                                                                                <option value="guest"
                                                                                                    selected>Guest
                                                                                                </option>
                                                                                                <option
                                                                                                    value="can edit">Can
                                                                                                    edit</option>
                                                                                                <option
                                                                                                    value="can comment">
                                                                                                    Can comment</option>
                                                                                                <option
                                                                                                    value="full access">
                                                                                                    Full access</option>
                                                                                                <option value="remove"
                                                                                                    data-option-template='<div class="text-danger">Remove</div>'>
                                                                                                    Remove</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <!-- End Select -->
                                                                                    </div>
                                                                                    <!-- End Col -->
                                                                                </div>
                                                                                <!-- End Row -->
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <!-- End List Group Item -->

                                                                    <!-- List Group Item -->
                                                                    <li>
                                                                        <div class="d-flex">
                                                                            <div class="flex-shrink-0">
                                                                                <div
                                                                                    class="avatar avatar-sm avatar-circle">
                                                                                    <img class="avatar-img"
                                                                                        src="./assets/img/160x160/img3.jpg"
                                                                                        alt="Image Description">
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex-grow-1 ms-3">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-sm">
                                                                                        <h5 class="text-body mb-0">David
                                                                                            Harrison</h5>
                                                                                        <span
                                                                                            class="d-block fs-6">david@site.com</span>
                                                                                    </div>
                                                                                    <!-- End Col -->

                                                                                    <div class="col-sm-auto">
                                                                                        <!-- Select -->
                                                                                        <div
                                                                                            class="tom-select-custom tom-select-custom-sm-end">
                                                                                            <select
                                                                                                class="js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0"
                                                                                                autocomplete="off"
                                                                                                data-hs-tom-select-options='{
                                                                                "searchInDropdown": false,
                                                                                "hideSearch": true,
                                                                                "dropdownWidth": "11rem"
                                                                            }'>
                                                                                                <option value="guest"
                                                                                                    selected>Guest
                                                                                                </option>
                                                                                                <option
                                                                                                    value="can edit">Can
                                                                                                    edit</option>
                                                                                                <option
                                                                                                    value="can comment">
                                                                                                    Can comment</option>
                                                                                                <option
                                                                                                    value="full access">
                                                                                                    Full access</option>
                                                                                                <option value="remove"
                                                                                                    data-option-template='<div class="text-danger">Remove</div>'>
                                                                                                    Remove</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <!-- End Select -->
                                                                                    </div>
                                                                                    <!-- End Col -->
                                                                                </div>
                                                                                <!-- End Row -->
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <!-- End List Group Item -->

                                                                    <!-- List Group Item -->
                                                                    <li>
                                                                        <div class="d-flex">
                                                                            <div class="flex-shrink-0">
                                                                                <div
                                                                                    class="avatar avatar-sm avatar-circle">
                                                                                    <img class="avatar-img"
                                                                                        src="./assets/img/160x160/img9.jpg"
                                                                                        alt="Image Description">
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex-grow-1 ms-3">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-sm">
                                                                                        <h5 class="text-body mb-0">Ella
                                                                                            Lauda <i
                                                                                                class="tio-verified text-primary"
                                                                                                data-toggle="tooltip"
                                                                                                data-placement="top"
                                                                                                title="Top endorsed"></i>
                                                                                        </h5>
                                                                                        <span
                                                                                            class="d-block fs-6">Markvt@site.com</span>
                                                                                    </div>
                                                                                    <!-- End Col -->

                                                                                    <div class="col-sm-auto">
                                                                                        <!-- Select -->
                                                                                        <div
                                                                                            class="tom-select-custom tom-select-custom-sm-end">
                                                                                            <select
                                                                                                class="js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0"
                                                                                                autocomplete="off"
                                                                                                data-hs-tom-select-options='{
                                                                                "searchInDropdown": false,
                                                                                "hideSearch": true,
                                                                                "dropdownWidth": "11rem"
                                                                            }'>
                                                                                                <option value="guest"
                                                                                                    selected>Guest
                                                                                                </option>
                                                                                                <option
                                                                                                    value="can edit">Can
                                                                                                    edit</option>
                                                                                                <option
                                                                                                    value="can comment">
                                                                                                    Can comment</option>
                                                                                                <option
                                                                                                    value="full access">
                                                                                                    Full access</option>
                                                                                                <option value="remove"
                                                                                                    data-option-template='<div class="text-danger">Remove</div>'>
                                                                                                    Remove</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <!-- End Select -->
                                                                                    </div>
                                                                                    <!-- End Col -->
                                                                                </div>
                                                                                <!-- End Row -->
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <!-- End List Group Item -->

                                                                    <!-- List Group Item -->
                                                                    <li>
                                                                        <div class="d-flex">
                                                                            <div class="flex-shrink-0">
                                                                                <span
                                                                                    class="icon icon-soft-dark icon-sm icon-circle">
                                                                                    <i class="bi-people-fill"></i>
                                                                                </span>
                                                                            </div>

                                                                            <div class="flex-grow-1 ms-3">
                                                                                <div class="row align-items-center">
                                                                                    <div class="col-sm">
                                                                                        <h5 class="text-body mb-0">
                                                                                            #conference</h5>
                                                                                        <span class="d-block fs-6">3
                                                                                            members</span>
                                                                                    </div>
                                                                                    <!-- End Col -->

                                                                                    <div class="col-sm-auto">
                                                                                        <!-- Select -->
                                                                                        <div
                                                                                            class="tom-select-custom tom-select-custom-sm-end">
                                                                                            <select
                                                                                                class="js-select form-select form-select-borderless tom-select-custom-form-select-invite-user tom-select-form-select-ps-0"
                                                                                                autocomplete="off"
                                                                                                data-hs-tom-select-options='{
                                                                                "searchInDropdown": false,
                                                                                "hideSearch": true,
                                                                                "dropdownWidth": "11rem"
                                                                            }'>
                                                                                                <option value="guest"
                                                                                                    selected>Guest
                                                                                                </option>
                                                                                                <option
                                                                                                    value="can edit">Can
                                                                                                    edit</option>
                                                                                                <option
                                                                                                    value="can comment">
                                                                                                    Can comment</option>
                                                                                                <option
                                                                                                    value="full access">
                                                                                                    Full access</option>
                                                                                                <option value="remove"
                                                                                                    data-option-template='<div class="text-danger">Remove</div>'>
                                                                                                    Remove</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <!-- End Select -->
                                                                                    </div>
                                                                                    <!-- End Col -->
                                                                                </div>
                                                                                <!-- End Row -->
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <!-- End List Group Item -->
                                                                </ul>

                                                                <div class="d-grid gap-3">
                                                                    <!-- Form Switch -->
                                                                    <label class="row form-check form-switch"
                                                                        for="addTeamPreferencesNewProjectSwitch1">
                                                                        <span class="col-8 col-sm-9 ms-0">
                                                                            <i class="bi-bell text-primary me-3"></i>
                                                                            <span class="text-dark">Inform all project
                                                                                members</span>
                                                                        </span>
                                                                        <span class="col-4 col-sm-3 text-end">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                id="addTeamPreferencesNewProjectSwitch1"
                                                                                checked>
                                                                        </span>
                                                                    </label>
                                                                    <!-- End Form Switch -->

                                                                    <!-- Form Switch -->
                                                                    <label class="row form-check form-switch"
                                                                        for="addTeamPreferencesNewProjectSwitch2">
                                                                        <span class="col-8 col-sm-9 ms-0">
                                                                            <i
                                                                                class="bi-chat-left-dots text-primary me-3"></i>
                                                                            <span class="text-dark">Show team
                                                                                activity</span>
                                                                        </span>
                                                                        <span class="col-4 col-sm-3 text-end">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                id="addTeamPreferencesNewProjectSwitch2">
                                                                        </span>
                                                                    </label>
                                                                    <!-- End Form Switch -->
                                                                </div>

                                                                <!-- Footer -->
                                                                <div class="d-sm-flex align-items-center mt-5">
                                                                    <button type="button"
                                                                        class="btn btn-ghost-secondary mb-3 mb-sm-0 me-2"
                                                                        data-hs-step-form-prev-options='{
                                                            "targetSelector": "#createProjectStepTerms"
                                                            }'>
                                                                        <i class="bi-chevron-left"></i> Previous step
                                                                    </button>

                                                                    <div
                                                                        class="d-flex justify-content-end gap-3 ms-auto">
                                                                        <button type="button" class="btn btn-white"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close">Cancel</button>
                                                                        <button id="createProjectFinishBtn"
                                                                            type="button" class="btn btn-primary">Create
                                                                            project</button>
                                                                    </div>
                                                                </div>
                                                                <!-- End Footer -->
                                                            </div>
                                                        </div>
                                                        <!-- End Content Step Form -->

                                                        <!-- Message Body -->
                                                        <div id="createProjectStepSuccessMessage" style="display:none;">
                                                            <div class="text-center">
                                                                <img class="img-fluid mb-3"
                                                                    src="./assets/svg/illustrations/oc-hi-five.svg"
                                                                    alt="Image Description"
                                                                    data-hs-theme-appearance="default"
                                                                    style="max-width: 15rem;">
                                                                <img class="img-fluid mb-3"
                                                                    src="./assets/svg/illustrations-light/oc-hi-five.svg"
                                                                    alt="Image Description"
                                                                    data-hs-theme-appearance="dark"
                                                                    style="max-width: 15rem;">

                                                                <div class="mb-4">
                                                                    <h2>Successful!</h2>
                                                                    <p>New project has been successfully created.</p>
                                                                </div>

                                                                <div class="d-flex justify-content-center gap-3">
                                                                    <a class="btn btn-white" href="./projects">
                                                                        <i class="bi-chevron-left"></i> Back to projects
                                                                    </a>

                                                                    <a class="btn btn-primary" href="javascript:;"
                                                                        data-toggle="modal"
                                                                        data-target="#newProjectModal">
                                                                        <i class="bi-building"></i> Add new project
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Message Body -->
                                                    </form>
                                                    <!-- End Step Form -->
                                                </div>
                                                <!-- End Body -->
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php echo fa_status($row['status']); ?>
                                </td>
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
                                        class="js-select form-select form-select-borderless w-auto" autocomplete="off"
                                        data-hs-tom-select-options='{
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
            <!-- End Card -->
        </div>
        <!-- End Content -->

        <!-- Footer -->

        <?php include('inc/footer.php') ?>

        <!-- End Footer -->
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

    <!-- ========== SECONDARY CONTENTS ========== -->

    <!-- Activity -->
    <?php include('inc/modal-activity.php') ?>
    <!-- End Activity -->

    <!-- Welcome Message Modal -->
    <?php include('inc/welcome-modal.php') ?>

    <!-- End Welcome Message Modal -->

    <!-- Edit user -->
    <?php include('inc/create-user-modal.php') ?>
    <!-- End Edit user -->

    <!-- New Project Modal -->


    <!-- End New Project Modal -->
    <!-- ========== END SECONDARY CONTENTS ========== -->

    <!-- JS Global Compulsory  -->
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
</body>

</html>