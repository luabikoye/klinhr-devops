<?php

ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}
validatePermission('Assessment');
if ($_SESSION['account_token']) {    
    $query = "select * from assessment where account_token = '".$_SESSION['account_token']."' order by id desc";
}else{
    $query = "select * from assessment order by id desc";
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
    <title>Set Assessment | KlinHR</title>

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

    <?php include('inc/side-nav.php')
    ?>

    <main id="content" role="main" class="main">
        <!-- Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-sm mb-2 mb-sm-0">
                        <!-- <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-no-gutter">
                                <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Pages</a></li>
                                <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Projects</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Overview</li>
                            </ol>
                        </nav> -->

                        Available Assessment <span class="badge bg-soft-dark text-dark ms-1"><?php echo number_format($num) ?></span>
                    </div>
                    <!-- End Col -->

                    <div class="col-sm-auto">
                        <a class="btn btn-primary" href="javascript:;" data-bs-toggle="modal" data-bs-target="#newProjectModal">
                            <i class="bi-plus me-1"></i> Add Assessment
                        </a>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->

                <!-- Nav -->
                <!-- <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        News/Events <span class="badge bg-soft-dark text-dark ms-1"><?php echo number_format($num) ?></span>
                    </li>
                    <li class="nav-item">
                    <a class="btn btn-primary" href="javascript:;" data-bs-toggle="modal" data-bs-target="#newProjectModal">
                        <i class="bi-plus me-1"></i> New project
                    </a>
                </li>
                </ul> -->
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
                                <input id="datatableSearch" type="search" class="form-control" placeholder="Search users" aria-label="Search users">
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
                    <?php if ($_GET['del']) echo '<div class="alert alert-success">Assessment Deleted</div>'; ?>
                    <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{
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
                                    S/N &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </th>
                                <th class="table-column-ps-0">Job Role</th>
                                <th class="table-column-ps-0">No Of Questions</th>
                                <th class="table-column-ps-0">Pass Mark</th>
                                <th class="table-column-ps-0">Duration</th>
                                <th class="table-column-ps-0">Categories</th>
                                <th class="table-column-ps-0">Action</th>

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
                                    <td>
                                        <?php echo ucfirst($row['assessment_name']); ?>
                                    </td>
                                    <td>
                                        <?php echo ucfirst($row['no_of_question']); ?>
                                    </td>
                                    <td>
                                        <?php echo $row['pass_mark']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['duration']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['category']; ?>
                                    </td>
                                    <td>
                                        <a data-bs-toggle="modal" data-bs-target="#newProjectModal<?php echo ($row['id']); ?>" href="javascript:;" class="btn btn-sm btn-outline-secondary"><i class="bi-pencil" style="margin-left:0px;"></i></a>

                                        <div class="modal fade" id="newProjectModal<?php echo ($row['id']); ?>" tabindex="-1" aria-labelledby="newProjectModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="newProjectModalLabel">Setup Assessment</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <!-- Body -->
                                                    <div class="modal-body">
                                                        <!-- Step Form -->
                                                        <form class="js-step-form" data-hs-step-form-options='{
                                                                                                        "progressSelector": "#createProjectStepFormProgress",
                                                                                                        "stepsSelector": "#createProjectStepFormContent",
                                                                                                        "endSelector": "#createProjectFinishBtn",
                                                                                                        "isValidate": false
                                                                                                        }' data-toggle="validator" method="post" action="proc_edit_assessment" enctype="multipart/form-data">

                                                            <!-- Content Step Form -->
                                                            <div id="createProjectStepFormContent">
                                                                <div id="createProjectStepDetails" class="active">


                                                                    <!-- Form -->
                                                                    <div class="mb-4">

                                                                        <div class="row align-items-center">
                                                                            <div class="col-12 col-md-6 mb-3">
                                                                                <label for="clientNewProjectLabel" class="form-label">Job Role</label>
                                                                                <div class="input-group input-group-merge">
                                                                                    <select data-hs-tom-select-options='{
                                                                                        "placeholder": "Select option"
                                                                                    }' name="assessment_name" class="form-control" required>
                                                                                        <option value="">Select One</option>

                                                                                        <option selected value="<?php echo $row['job_id']; ?>"><?php echo $row['assessment_name']; ?></option>
                                                                                        <?php list_val('job_post', 'job_title', 'id'); ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <!-- End Col -->

                                                                            <!-- <span class="col-auto mb-3">or</span> -->

                                                                            <div class="col-12 col-md-6 mb-3">
                                                                                <label for="clientNewProjectLabel" class="form-label">No Of Questions</label>
                                                                                <input type="number" class="form-control" id="clientNewProjectLabel" name="no_of_question" value="<?php echo $row['no_of_question']; ?>" placeholder="No Of Question">
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
                                                                                <label for="clientNewProjectLabel" class="form-label">Pass Mark(%)</label>
                                                                                <div class="input-group input-group-merge">
                                                                                    <input type="text" class="form-control" id="clientNewProjectLabel" name="pass_mark" value="<?php echo $row['pass_mark']; ?>" placeholder="Pass Mark">
                                                                                </div>
                                                                            </div>
                                                                            <!-- End Col -->

                                                                            <!-- <span class="col-auto mb-3">or</span> -->

                                                                            <div class="col-12 col-md-6 mb-3">
                                                                                <label for="clientNewProjectLabel" class="form-label">Duration (minutes)</label>
                                                                                <div class="input-group input-group-merge">
                                                                                    <input type="text" class="form-control" id="clientNewProjectLabel" name="duration" value="<?php echo $row['duration']; ?>" placeholder="Duration">
                                                                                </div>
                                                                            </div>
                                                                            <!-- End Col -->
                                                                        </div>
                                                                        <!-- End Row -->
                                                                    </div>
                                                                    <!-- End Form -->

                                                                    <div class="mb-4">

                                                                        <div class="row align-items-center">
                                                                            <div class="col-12 col-md-12 mb-3">
                                                                                <label for="clientNewProjectLabel" class="form-label">Assessment type</label>
                                                                                <div class="input-group input-group-merge">
                                                                                    <select data-hs-tom-select-options='{
                                                                                    "placeholder": "Select option"
                                                                                }' name="category" class="form-control" id="inputName" required multiple>
                                                                                        <?php if ($row['category']) { ?>
                                                                                            <option value="<?= $row['category'] ?>"><?= $row['category'] ?></option>
                                                                                            <option value=""></option>
                                                                                        <?php } else { ?>
                                                                                            <option value="">Select Type</option>
                                                                                        <?php } ?>

                                                                                        <?php list_val('assessment_category', 'category_name', 'category_name'); ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <!-- End Col -->
                                                                        </div>
                                                                        <!-- End Row -->


                                                                    </div>

                                                                    <!-- Footer -->
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="d-flex align-items-center mt-5">
                                                                                <div class="ms-auto">
                                                                                    <input type="hidden" value="<?php echo $row['id']; ?>" name="id">
                                                                                    <input type="submit" value="Add" class="btn btn-primary">
                                                                                </div>
                                                                            </div>
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

                                        <a data-toggle="tooltip" data-placement="top" data-original-title="Delete" onclick="return confirm('Are you sure?');" href="delete-record?id=<?php echo $row['id']; ?>&tab=assessment&return=set-assessment" class="btn btn-sm btn-outline-secondary"><i class="bi-trash" style="margin-left:0px;"></i></a>
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
                                    <select data-hs-tom-select-options='{
                                            "placeholder": "Select option"
                                        }' id="datatableEntries" class="js-select form-select form-select-borderless w-auto" autocomplete="off" data-hs-tom-select-options='{
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
    <?php include('inc/footer.php') ?>
    <!-- End Activity -->


    <!-- New Project Modal -->
    <div class="modal fade" id="newProjectModal" tabindex="-1" aria-labelledby="newProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newProjectModalLabel">Setup Assessment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <!-- Step Form -->
                    <form class="js-step-form" data-hs-step-form-options='{
                                                        "progressSelector": "#createProjectStepFormProgress",
                                                        "stepsSelector": "#createProjectStepFormContent",
                                                        "endSelector": "#createProjectFinishBtn",
                                                        "isValidate": false
                                                        }' data-toggle="validator" method="post" action="proc_setup" enctype="multipart/form-data">

                        <!-- Content Step Form -->
                        <div id="createProjectStepFormContent">
                            <div id="createProjectStepDetails" class="active">


                                <!-- Form -->
                                <div class="mb-4">

                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="clientNewProjectLabel" class="form-label">Job Role</label>
                                            <div class="input-group input-group-merge">
                                                <select data-hs-tom-select-options='{
                                            "placeholder": "Select option"
                                        }' name="assessment_name" class="form-control" required>
                                                    <?php list_val('job_post', 'job_title', 'id'); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <!-- <span class="col-auto mb-3">or</span> -->

                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="clientNewProjectLabel" class="form-label">No Of Questions</label>
                                            <input type="number" class="form-control" id="clientNewProjectLabel" name="no_of_question" value="<?php echo $no_of_question; ?>" placeholder="No Of Question">
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
                                            <label for="clientNewProjectLabel" class="form-label">Pass Mark(%)</label>
                                            <div class="input-group input-group-merge">
                                                <input type="text" class="form-control" id="clientNewProjectLabel" name="pass_mark" value="<?php echo $pass_mark; ?>" placeholder="Pass Mark">
                                            </div>
                                        </div>
                                        <!-- End Col -->

                                        <!-- <span class="col-auto mb-3">or</span> -->

                                        <div class="col-12 col-md-6 mb-3">
                                            <label for="clientNewProjectLabel" class="form-label">Duration (minutes)</label>
                                            <div class="input-group input-group-merge">
                                                <input type="test" class="form-control" id="clientNewProjectLabel" name="duration" value="<?php echo $duration; ?>" placeholder="Eg 30">
                                            </div>
                                        </div>
                                        <!-- End Col -->
                                    </div>
                                    <!-- End Row -->
                                </div>
                                <!-- End Form -->

                                <div class="mb-4">

                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-12 mb-3">
                                            <label for="clientNewProjectLabel" class="form-label">Assessment type</label>
                                            <div class="input-group input-group-merge">
                                                <select data-hs-tom-select-options='{
                                            "placeholder": "Select option"
                                        }' multiple name="category[]" class="form-control" id="inputName" required>

                                                    <option value="">Select Type</option>
                                                    <?php list_val('assessment_category', 'category_name', 'category_name'); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- End Col -->
                                    </div>
                                    <!-- End Row -->


                                </div>

                                <!-- Footer -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="d-flex align-items-center mt-5">
                                            <div class="ms-auto">
                                                <input type="submit" value="Add" class="btn btn-primary">
                                            </div>
                                        </div>
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
                        document.getElementById("createProjectStepSuccessMessage").style.display = 'block'
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