<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Deployment');

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
    <title>Pool | KlinHR</title>

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
                <!-- Nav -->
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        Pool List <span
                            class="badge bg-soft-dark text-dark ms-1"><?php echo number_format(count_tab_val('emp_staff_details', 'completed', 'pool')) ?></span>

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
            <form action="ProcessOffer?cat=<?php echo base64_encode($cat); ?>" method="post"
                enctype="multipart/form-data">
                <div class="card">
                    <!-- Header -->
                    <div class="card-header card-header-content-md-between">
                        <div class="mb-2 mb-md-0">
                            <!-- <form> -->
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend input-group-text">
                                    <i class="bi-search"></i>
                                </div>
                                <input id="datatableSearch" type="search" class="form-control"
                                    placeholder="Search users" aria-label="Search users">
                            </div>
                            <!-- End Search -->
                            <!-- </form> -->
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
                                        <i class="bi-file-earmark"></i> Export Selected
                                    </a>
                                </div>
                            </div>
                            <!-- End Datatable Info -->
                            <!-- Datatable Info -->
                            <div id="datatableCounterInfo">
                                <div class="d-flex align-items-center">

                                    <a class="btn btn-outline-success btn-sm" href="javascript:;">
                                        <i class="bi-file-earmark"></i> Export All candidates
                                    </a>
                                </div>
                            </div>
                            <!-- End Datatable Info -->

                            <!-- Dropdown -->
                            <div class="dropdown">
                                <button type="button" class="btn btn-white btn-sm w-100" id="usersFilterDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi-filter me-1"></i> Assign Candidate To
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
                                                        <select class="js-select form-select" name="stage" id="stage">
                                                            <!-- <option label="empty">select</option> -->
                                                            <option selected value="Client">Client</option>
                                                        </select>
                                                    </div>
                                                    <!-- End Select -->
                                                </div>
                                                <!-- End Col -->
                                            </div>
                                            <!-- End Row -->

                                            <div class="d-grid">
                                                <button type="button" id="pool" class="btn btn-primary" name="btn_move"
                                                    value="Assign" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasKeyboardShortcuts"
                                                    data-target="#emailInvite"
                                                    aria-controls="offcanvasKeyboardShortcuts">Assign</button>
                                            </div>
                                            <!-- </form> -->
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
                            echo '<div class="alert alert-success">' . $success . $_GET['success'] . '</div>';
                        }
                        if ($error || $_GET['error']) {
                            echo '<div class="alert alert-danger">' . $error . $_GET['error'] . '</div>';
                        }

                        ?>
                        <?php if ($_GET['del'] == 'success') echo '<div class="alert alert-success">Applicant successfully deleted</div>'; ?>

                        <?php if ($_GET['completed'] == 'verification') echo '<div class="alert alert-success">Applicant successfully moved to completed verification</div>'; ?>
                        <?php if ($_GET['pool'] == 'completed') echo '<div class="alert alert-success">Candidate successfully moved to Pool</div>'; ?>

                        <?php if ($_GET['pending'] == 'verification') echo '<div class="alert alert-success">Candidate successfully moved to verification</div>'; ?>

                        <?php if ($_GET['reversed'] == 'success') echo '<div class="alert alert-success">Candidate successfully reversed to Pending Onboarding</div>'; ?>
                        <table id="datatable"
                            class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
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
                                    <th class="table-column-pe-0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="datatableCheckAll">
                                            <label class="form-check-label" for="datatableCheckAll"></label>
                                        </div>
                                    </th>
                                    <th class="table-column-ps-0">FullName</th>
                                    <th>Sex/Age</th>
                                    <th>Qualification</th>
                                    <th>Clients</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php

                                if ($_SESSION['account_token']) {

                                    if ($_GET['cat']) {
                                        $cat = base64_decode($_GET['cat']);

                                        $query = "select * from emp_staff_details where completed = '$cat' and account_token = '".$_SESSION['account_token']."' order by id desc limit 0,500";
                                    }
                                }else{
                                    if ($_GET['cat']) {
                                        $cat = base64_decode($_GET['cat']);

                                        $query = "select * from emp_staff_details where completed = '$cat' order by id desc limit 0,500";
                                    }
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
                                                value="<?php echo $row['id']; ?>" name="id[]" id="usersDataCheck1">
                                            <input class="checkbox-tick" type="hidden" value="<?php echo $row['id']; ?>"
                                                name="valid_id">

                                            <input class="checkbox-tick" type="hidden"
                                                value="<?php echo $row['candidate_id']; ?>" name="candidate_id[]">
                                            <label class="form-check-label" for="usersDataCheck1"></label>
                                        </div>
                                    </td>
                                    <td class="table-column-ps-0">
                                        <div class="ms-3">
                                            <span class="d-block h5 text-inherit mb-0">
                                                <?php echo $row['firstname']; ?> <?php echo $row['surname']; ?>
                                            </span>
                                            <span class="d-block fs-6 text-body">
                                                <?php echo $row['email_address']; ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php echo substr($row['sex'], 0, 1); ?>
                                            <span class="badge bg-soft-dark text-dark ms-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                title="tasks completed today"><?php echo get_age($row['date_of_birth']); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $row['1st_qualification_code']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['company_code']; ?>
                                    </td>
                                    <td>
                                        <?php echo VerificationStatus(($row['candidate_id'])); ?>
                                    </td>
                                    <td>
                                        <a target="blank" title="View Applicant"
                                            class="btn btn-sm btn-outline-secondary"
                                            href="view-onboarding?id=<?php echo base64_encode($row['id']); ?>"><i
                                                class="bi-eye"></i>
                                        </a>

                                        <a title="Upload Evidence" class="btn btn-sm btn-outline-secondary"
                                            href="upload_evidence?candidate_id=<?php echo base64_encode($row['candidate_id']); ?>"><i
                                                class=" bi-upload"></i></a>

                                        <?php
                                            $folder = 'generate_offer_letter';
                                            $exist =    $folder . '/' . (get_val('emp_staff_details', 'id', $row['id'], 'firstname') . ' ' . get_val('emp_staff_details', 'id', $row['id'], 'surname') . ' offer letter.pdf');
                                            if (file_exists($exist)) {

                                            ?>

                                        <a title="Send Offer Letter" target="_blank" id="valid" href="<?= $exist ?>"><i
                                                data-toggle="tooltip"
                                                class="btn btn-sm btn-outline-secondary bi-envelope"></i>
                                        </a>
                                        <?php } else {
                                            ?>
                                        <i class="btn btn-sm btn-outline-secondary bi-x" style="color: red;"
                                            onclick="return confirm('Offer letter has not been generated')"></i>
                                        <?php } ?>

                                        <?php if (privilege() == 'Super Admin' &&  'Admin') {
                                            ?>
                                        <?php } ?>
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
                <!-- End Card -->
            </form>
        </div>
        <!-- End Content -->

        <!-- Footer -->

        <?php include('inc/footer.php') ?>

        <!-- End Footer -->
    </main>
    <!-- ========== END MAIN CONTENT ========== -->

    <!-- ========== SECONDARY CONTENTS ========== -->
    <!-- Keyboard Shortcuts -->
    <form method="post" action="ProcessOffer?cat=<?php echo base64_encode($cat); ?>" enctype="multipart/form-data">
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
                                <span class="fw-semibold">Firstname</span>
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="firstname" id="firstname" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                <span class="fw-semibold">Lastname</span>
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="lastname" id="lastname" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                <span class="fw-semibold">Email</span>
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="email" name="email" id="email" class="form-control" readonly>
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
                                <input type="text" name="phone" id="phone" class="form-control" readonly>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                location
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <select name="location" class="form-control" id="location">
                                    <option value="">Select One</option>
                                    <?= list_val('locations', 'locationName', 'locationCode'); ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Client
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <select name="client" class="form-control" id="client">
                                    <option value="select_client">Select Client</option>
                                    <?php list_val('clients', 'client_name', 'client_code'); ?>
                                </select>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Salary Band
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end" id="band">
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Test Scores
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="scores" value="<?php echo $scores; ?>" id="scores"
                                    class="form-control">
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Staff ID Format
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="id_format" value="" id="staff_id" class="form-control">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Job
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="job" id="job" class="form-control"
                                    value="<?php echo get_val('jobs_applied', 'candidate_id', $row['candidate_id'], 'job_title'); ?>">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Effective Date
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" onfocus="(this.type='date')" name="date" id="effective_date"
                                    placeholder="Enter Date" class="form-control" value="">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-5">
                                Leave Days
                            </div>
                            <!-- End Col -->

                            <div class="col-7 text-end">
                                <input type="text" name="leave" id="leave" class="form-control" readonly value="20">
                                <!-- End Col -->
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <style>
                    #level {
                        --bs-list-group-border-color: #fff
                    }
                    </style>
                    <div id="level">

                    </div>



                </div>


                <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                    <div class="list-group-item">
                        <!-- <h5 class="mb-1">Sms Content</h5> -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <input type="hidden" id="id" name="id">
                                <input type="hidden" name="jobs_applied_id" id="idList">
                                <input type="hidden" name="p_client" id="p_client">
                                <input name="btn_generate" type="submit" id="btn_generate" class="btn btn-primary"
                                    value="Push to HRBP">
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


    $("#pool").click('click', (function() {
        var emailCheck = 'yes';

        var checkID = $.map($("input[name='id[]']:checked"), function(e, i) {
            return +e.value;
        });


        if (checkID == "") {
            alert('You need to check at least one applicant');
            return false;

        } else {
            $.ajax({
                url: "get_data.php",
                type: "POST",
                data: {
                    checkID: checkID,
                    emailCheck: emailCheck
                },
                dataType: "json",
                success: function(response) {
                    // alert(response);
                    $('#emailInvite').modal('show');
                    $('#firstname').val(response[0]);
                    $('#lastname').val(response[1]);
                    $('#email').val(response[2]);
                    $('#phone').val(response[3]);
                    $('#client').val(response[4]);
                    $('#id').val(response[5]);
                    $('#scores').val(response[6]);
                    console.log(response)
                    $.each(myJson, function(key, val) {
                        $('#client').append('<option value="' + key + '">' + val +
                            '</option>');
                    });





                }
            });
        }


    }));

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

    $(document).ready(function() {


        $("#salary_band").change(function() {

            var salary_band = $(this).val();
            var client = $('#client').val();
            $.ajax({
                url: "get_level.php",
                method: "POST",
                data: {
                    salary_band: salary_band,
                    // client: client
                },
                success: function(response) {
                    $('#level').html(response);
                }
            });
        });
    });
    </script>

    <script type="text/javascript">
    $(document).on('ready', function() {

        $("#client").attr('disabled', 'true');

        $("#location").change(function() {
            $("#client").removeAttr('disabled');
            gen_staff_id();
        });

        $("#client").change(function() {
            gen_staff_id();
        });


        function gen_staff_id() {
            var clients = $('#client').val();
            var location = $('#location').val();

            if (clients == 'select_client') {
                alert('You need to select a client before choosing a format ');
                return false;
            }

            $.ajax({
                url: "get_staff_id.php",
                type: "POST",
                data: {
                    clients: clients,
                    location: location
                },
                // dataType: "json",
                success: function(response) {
                    $('#staff_id').val(response);
                }
            });
        }
    });
    </script>
</body>

</html>