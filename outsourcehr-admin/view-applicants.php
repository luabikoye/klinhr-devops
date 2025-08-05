<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Clients');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

$id = base64_decode($_GET['id']);


$unique = base64_decode($_GET['unique']);
if ($_GET['id']) {

    $query = "select * from emp_staff_details where id = '$id'  ";
} elseif ($_GET['unique']) {
    $query = "select * from emp_staff_details where email_address = '$unique'";
}

$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>View Onboarding | KlinHR</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/fav.png">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="./assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">

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

    <script src="ckeditor/ckeditor.js"></script>
    <script>
        window.hs_config = {
            "autopath": "@@autopath",
            "deleteLine": "hs-builder:delete",
            "deleteLine:build": "hs-builder:build-delete",
            "deleteLine:dist": "hs-builder:dist-delete",
            "previewMode": false,
            "startPath": "/index.html",
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
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-sm mb-2 mb-sm-0">

                        <h1 class="page-header-title">Candidate Profile</h1>
                    </div>
                    <!-- End Col -->

                    <div class="col-sm-auto">
                        <a class="btn btn-primary" href="edit-onboarding?d=<?= base64_encode($id) ?>">
                            <i class="bi-person-fill me-1"></i> Edit Candidate Profile
                        </a>
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Page Header -->

            <div class="row">
                <div class="col-lg-3">
                    <!-- Navbar -->
                    <div class="navbar-expand-lg navbar-vertical mb-3 mb-lg-5">
                        <!-- Navbar Toggle -->
                        <!-- Navbar Toggle -->
                        <div class="d-grid">
                            <button type="button" class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse" data-bs-target="#navbarVerticalNavMenu" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu">
                                <span class="d-flex justify-content-between align-items-center">
                                    <span class="text-dark">Menu</span>

                                    <span class="navbar-toggler-default">
                                        <i class="bi-list"></i>
                                    </span>

                                    <span class="navbar-toggler-toggled">
                                        <i class="bi-x"></i>
                                    </span>
                                </span>
                            </button>
                        </div>
                        <!-- End Navbar Toggle -->
                        <!-- End Navbar Toggle -->

                        <!-- Navbar Collapse -->
                        <div id="navbarVerticalNavMenu" class="collapse navbar-collapse fixed">
                            <ul id="navbarSettings" class="js-sticky-block js-scrollspy card card-navbar-nav nav nav-tabs nav-lg nav-vertical" data-hs-sticky-block-options='{
                                    "parentSelector": "#navbarVerticalNavMenu",
                                    "targetSelector": "#header",
                                    "breakpoint": "lg",
                                    "startPoint": "#navbarVerticalNavMenu",
                                    "endPoint": "#stickyBlockEndPoint",
                                    "stickyOffsetTop": 20
                                }'>
                                <li class="nav-item">
                                    <a class="nav-link active" href="#content">
                                        <i class="bi-person nav-icon"></i> Basic information
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#other">
                                        <i class="bi-person-plus nav-icon"></i> Other Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#Address">
                                        <i class=" bi-map nav-icon"></i> Address
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#preferencesSection">
                                        <i class="bi-person nav-icon"></i> Previous Employer
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#kin">
                                        <i class="bi-person nav-icon"></i> Next Of Kin
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#1gua">
                                        <i class="bi-person nav-icon"></i> 1st Guarantor Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#2gua">
                                        <i class="bi-person nav-icon"></i> 2nd Guarantor Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#1ref">
                                        <i class="bi-person nav-icon"></i> 1st Referee Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#2ref">
                                        <i class="bi-person nav-icon"></i> 2nd Referee Details
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#1qua">
                                        <i class="bi-file-earmark nav-icon"></i> Qualification 1
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#2qua">
                                        <i class="bi-file-earmark nav-icon"></i> Qualification 2
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#nysc">
                                        <i class="bi-file-earmark nav-icon"></i> Nysc
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#credential">
                                        <i class="bi-folder nav-icon"></i> Credential
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Navbar Collapse -->
                    </div>
                    <!-- End Navbar -->
                </div>

                <div class="col-lg-9">
                    <div class="d-grid gap-3 gap-lg-5">
                        <!-- Card -->
                        <div class="card">
                            <!-- Profile Cover -->
                            <div class="profile-cover">
                                <div class="profile-cover-img-wrapper">
                                    <img id="profileCoverImg" class="profile-cover-img" src="./assets/img/1920x400/img2.jpg" alt="Image Description">
                                </div>
                            </div>
                            <!-- End Profile Cover -->

                            <!-- Avatar -->
                            <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar" for="editAvatarUploaderModal">
                                <img id="editAvatarImgModal" class="avatar-img" src="./assets/img/160x160/img1.jpg" alt="Image Description">
                            </label>
                            <!-- End Avatar -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">Basic information</h2>
                            </div>

                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form -->
                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Full name <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Displayed on public forums, such as Front."></i></label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="firstName" readonly id="firstNameLabel" placeholder="Sur Name" aria-label="Your first name" value="<?= ucwords($row['surname']) ?>">
                                                <input type="text" class="form-control" name="lastName" id="lastNameLabel" readonly placeholder="First Name" aria-label="Your last name" value="<?= ucwords($row['firstname']) ?>">
                                                <input type="text" class="form-control" name="lastName" id="lastNameLabel" readonly placeholder="Middle Name" aria-label="Your last name" value="<?= ucwords($row['middlename']) ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="emailLabel" class="col-sm-3 col-form-label form-label">Email</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email" id="emailLabel" readonly placeholder="Email" aria-label="Email" value="<?= ucwords($row['email_address']) ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="phoneLabel" class="col-sm-3 col-form-label form-label">Phone <span class="form-label-secondary"></span></label>

                                        <div class="col-sm-9">
                                            <input type="text" class="js-input-mask form-control" name="phone" id="phoneLabel" readonly placeholder="+x(xxx)xxx-xx-xx" aria-label="+x(xxx)xxx-xx-xx" value="<?= $row['mobile_phone_number'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="organizationLabel" class="col-sm-3 col-form-label form-label">Client</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="organization" readonly id="organizationLabel" placeholder="Client" aria-label="Your organization" value="<?= $row['company_code'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="departmentLabel" class="col-sm-3 col-form-label form-label">Marital Status</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="department" id="departmentLabel" placeholder="Marital Status" aria-label="Your department" value="<?= $row['marital_status'] ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div id="accountType" class="row mb-4">
                                        <label class="col-sm-3 col-form-label form-label">Gender</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="department" id="departmentLabel" placeholder="" aria-label="Your department" value="<?= $row['sex'] ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Date Of Birth</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="department" id="departmentLabel" placeholder="" aria-label="Your department" value="<?= long_date($row['date_of_birth']) ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                </form>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div id="other" class="card">
                            <div class="card-header">
                                <h4 class="card-title">Other Details</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">

                                <!-- Form -->
                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">State Of Origin</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" readonly name="newEmail" id="newEmailLabel" placeholder="" aria-label="Enter new email address" value="<?= $row['state_origin'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">Local Government</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="newEmail" id="newEmailLabel" placeholder="" readonly aria-label="Enter new email address" value="<?= $row['local_govt_of_origin_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">Pension Fund Administrator</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="newEmail" id="newEmailLabel" placeholder="" aria-label="Enter new email address" value="<?= $row['pfa_code'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">Pension Pin</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="newEmail" id="newEmailLabel" placeholder="" aria-label="Enter new email address" value="<?= $row['pension_pin'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">NHF Pin</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="newEmail" id="newEmailLabel" placeholder="" aria-label="Enter new email address" value="<?= $row['nhf_pin'] ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                </form>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div id="Address" class="card">
                            <div class="card-header">
                                <h4 class="card-title">Address</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form -->
                                <form id="changetextForm">
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="currenttextLabel" class="col-sm-3 col-form-label form-label">Address 1</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="currenttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['current_address_1'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="currenttextLabel" class="col-sm-3 col-form-label form-label">City</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="currenttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['current_address_town'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="currenttextLabel" class="col-sm-3 col-form-label form-label">Address 2</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="currenttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['current_address_2'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="currenttextLabel" class="col-sm-3 col-form-label form-label">City 2</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="currenttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['current_address_state_code'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </form>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div id="preferencesSection" class="card">
                            <div class="card-header">
                                <h4 class="card-title">Previous Employer</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form -->
                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="languageLabel" class="col-sm-3 col-form-label form-label">Employer Name</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="currenttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_previous_employer_name'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="timeZoneLabel" class="col-sm-3 col-form-label form-label">Emplyer Position</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="timeZoneLabel" placeholder="" aria-label="Your time zone" readonly value="<?= $row['prev_employer_position'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="timeZoneLabel" class="col-sm-3 col-form-label form-label">Address 1</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="timeZoneLabel" placeholder="" aria-label="Your time zone" readonly value="<?= $row['1st_previous_employer_address_1'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="timeZoneLabel" class="col-sm-3 col-form-label form-label">Address 2</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="timeZoneLabel" placeholder="" aria-label="Your time zone" readonly value="<?= $row['1st_previous_employer_address_2'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="timeZoneLabel" class="col-sm-3 col-form-label form-label">City</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="timeZoneLabel" placeholder="" aria-label="Your time zone" readonly value="<?= $row['1st_previous_employer_town'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="timeZoneLabel" class="col-sm-3 col-form-label form-label">State</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="timeZoneLabel" placeholder="" aria-label="Your time zone" readonly value="<?= $row['1st_previous_employer_state_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="timeZoneLabel" class="col-sm-3 col-form-label form-label">Contact Person</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="timeZoneLabel" placeholder="" aria-label="Your time zone" readonly value="<?= $row['n_prev_1st_emp_person'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="timeZoneLabel" class="col-sm-3 col-form-label form-label">Contact Person's Email</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="timeZoneLabel" placeholder="" aria-label="Your time zone" readonly value="<?= $row['n_prev_1st_emp_email'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="timeZoneLabel" class="col-sm-3 col-form-label form-label">Contact Person's Phone</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="timeZoneLabel" placeholder="" aria-label="Your time zone" readonly value="<?= $row['n_prev_1st_emp_phone'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </form>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div id="kin" class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="mb-0">Next Of Kin Details</h4>
                                </div>
                            </div>

                            <!-- Body -->
                            <div class="card-body">

                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Next Of Kin's Name</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['next_of_kin_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Next Of Kin's Relationship</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['nok_relationship'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Address 1</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['next_of_kin_address_1'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Address 2</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['next_of_kin_address_2'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">City</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['next_of_kin_town'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">State</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['next_of_kin_state_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Phone</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['next_of_kin_phone'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Email</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['next_of_kin_email'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </form>
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div id="1gua" class="card">
                            <div class="card-header">
                                <h4 class="card-title">1st Guarantor Details</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">

                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Guarantor Name</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_guarantor_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Address 1</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_guarantor_address_1'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Address 2</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_guarantor_address_2'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">City</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_guarantor_town'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">State</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_guarantor_state_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Phone</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_guarantor_phone'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Email</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_guarantor_email'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Company Name</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['n_1st_guarantor_company'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Company Address</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['n_1st_guarantor_address'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Grade/Position</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['n_1st_guarantor_grade'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">No Of Years In Company</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['n_1st_guarantor_no_years'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </form>
                            </div>
                            <!-- End Body -->


                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div id="2gua" class="card">
                            <div class="card-header">
                                <h4 class="card-title">2nd Guarantor Details</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">

                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Guarantor Name</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_guarantor_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Address 1</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_guarantor_address_1'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Address 2</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_guarantor_address_2'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">City</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_guarantor_town'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">State</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_guarantor_state_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Phone</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_guarantor_phone'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Email</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_guarantor_email'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Company Name</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['n_2nd_guarantor_company'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Company Address</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['n_2nd_guarantor_address'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Grade/Position</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['n_2nd_guarantor_grade'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">No Of Years In Company</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['n_2nd_guarantor_no_years'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </form>
                            </div>
                            <!-- End Body -->

                        </div>
                        <!-- End Card  -->

                        <!-- Card -->
                        <div id="1ref" class="card">
                            <div class="card-header">
                                <h4 class="card-title">1st Referee Details</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">

                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Referee Name</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_referee_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Address 1</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_referee_address_1'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Address 2</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_referee_address_2'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">City</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_referee_town'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">State</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_referee_state_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Phone</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_referee_phone'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Email</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_referee_email'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </form>
                            </div>
                            <!-- End Body -->


                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div id="2ref" class="card">
                            <div class="card-header">
                                <h4 class="card-title">2nd Referee Details</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">

                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Referee Name</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_referee_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Address 1</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_referee_address_1'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Address 2</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_referee_address_2'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">City</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_referee_town'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">State</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_referee_state_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Phone</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_referee_phone'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Email</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_referee_email'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </form>
                            </div>
                            <!-- End Body -->

                        </div>
                        <!-- End Card  -->

                        <!-- Card -->
                        <div id="1qua" class="card">
                            <div class="card-header">
                                <h4 class="card-title">QUALIFICATION 1</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">

                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Institution</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_institution_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Qualification</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_qualification_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Course</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_course_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Grade</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_result_grade'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Month Started</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_graduation_month_started'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Year Started</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_graduation_year_started'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Month Ended</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_graduation_month_ended'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Graduation Year</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['1st_graduation_year'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </form>
                            </div>
                            <!-- End Body -->

                        </div>
                        <!-- End Card  -->

                        <!-- Card -->
                        <div id="2qua" class="card">
                            <div class="card-header">
                                <h4 class="card-title">QUALIFICATION 2</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">

                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Institution</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_institution_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Qualification</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_qualification_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Course</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_course_code'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Grade</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_result_grade'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Month Started</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_graduation_month_started'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Year Started</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_graduation_year_started'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Month Ended</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_graduation_month_ended'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Graduation Year</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['2nd_graduation_year'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </form>
                            </div>
                            <!-- End Body -->

                        </div>
                        <!-- End Card  -->

                        <!-- Card -->
                        <div id="nysc" class="card">
                            <div class="card-header">
                                <h4 class="card-title">NYSC</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">

                                <form>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">NYSC Id No</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= $row['nysc_id_no'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">Start Date</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= long_date($row['start_date']) ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="accounttextLabel" class="col-sm-3 col-form-label form-label">End Date</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="currenttext" id="accounttextLabel" placeholder="" aria-label="Enter current text" readonly value="<?= long_date($row['end_date']) ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </form>
                            </div>
                            <!-- End Body -->


                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div id="credential" class="card">
                            <div class="card-header">
                                <h4 class="card-title">Credentials</h4>
                            </div>

                            <form>

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
                                                        <i class="bi-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- End Datatable Info -->
                                        </div>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Table -->
                                    <div class="table-responsive datatable-custom">
                                        <?php if ($error1) echo '<div class="alert alert-danger">' . $error1 . '</div>'; ?>
                                        <?php if ($success1) echo '<div class="alert alert-success">' . $success1 . '</div>'; ?>
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
                                                        S/N
                                                    </th>
                                                    <th>Document</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php


                                                $credentials_query = "select * from cp_credentials where user = '" . get_val('emp_staff_details', 'id', $id, 'email_address') . "' || user = '$unique'  order by document_type asc";


                                                $credentials_result = mysqli_query($db, $credentials_query);
                                                $credentials_num = mysqli_num_rows($credentials_result);

                                                for ($i = 0; $i < $credentials_num; $i++) {
                                                    $credentials_row = mysqli_fetch_array($credentials_result);


                                                ?>
                                                    <tr>
                                                        <td class="table-column-pe-0">
                                                            <?php echo $i + 1; ?>
                                                        </td>
                                                        <td class="table-column-ps-0">
                                                            <?php echo $credentials_row['document_type']; ?>
                                                        </td>
                                                        <td>
                                                            <a style="margin-right: 15px; " data-toggle="tooltip" data-placement="top" title="View Document" class="btn btn-sm btn-outline-success" href="uploads/uploads_credentials/<?= ($credentials_row['credential']); ?>" target="_blank"><i class="bi-eye"></i>
                                                            </a>
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
                                                        <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto" autocomplete="off" data-hs-tom-select-options='{
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
                        <!-- End Card -->


                        <?php if ($row['completed'] == 'N' || $row['completed'] == 'Y') {

                        ?>
                            <!-- Card -->
                            <div id="deleteAccountSection" class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Send Message To Candidate</h4>
                                </div>

                                <form action="ProcessCandidate?candidate_id=<?php echo base64_encode($candidate_id); ?>" method="post">
                                    <!-- Body -->
                                    <div class="card-body">
                                        <input type="text" class="form-control" name="subject" id="accounttextLabel" placeholder="Enter Subject" aria-label="Enter Subject" value="<?= $subject ?>">

                                        <div class="mb-4 mt-4">
                                            <!-- Form Check -->
                                            <div class="form-check">
                                                <textarea name="comment" id="comment">
                                                    <?php echo $comment; ?>
                                                </textarea>
                                                <script>
                                                    CKEDITOR.replace('comment');
                                                </script>
                                            </div>
                                            <!-- End Form Check -->
                                        </div>

                                        <div class="d-flex gap-3">
                                            <span class="text-danger text-left" href="#">N:B This action would reverse the candidate to Pending Onboarding</span>
                                        </div>
                                        <button type="submit" class="btn mt-3 btn-primary" name="send_comment">Send Comment</button>
                                        <input type="hidden" name="candidate_id" value="<?php echo base64_encode($row['candidate_id']); ?>">
                                    </div>
                                    <!-- End Body -->
                                </form>
                            </div>
                            <!-- End Card -->
                        <?php } ?>
                    </div>

                    <!-- Sticky Block End Point -->
                    <div id="stickyBlockEndPoint"></div>
                </div>
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

    <!-- Activity -->
    <?php include('inc/modal-activity.php') ?>
    <!-- End Activity -->
    <!-- ========== END SECONDARY CONTENTS ========== -->

    <!-- JS Global Compulsory  -->
    <script src="./assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="./assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS Implementing Plugins -->
    <script src="./assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside.min.js"></script>
    <script src="./assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>

    <script src="./assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
    <script src="./assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
    <script src="./assets/vendor/hs-scrollspy/dist/hs-scrollspy.min.js"></script>
    <script src="./assets/vendor/imask/dist/imask.min.js"></script>
    <script src="./assets/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>

    <!-- JS Front -->
    <script src="./assets/js/theme.min.js"></script>

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


                // INITIALIZATION OF INPUT MASK
                // =======================================================
                HSCore.components.HSMask.init('.js-input-mask')


                // INITIALIZATION OF FILE ATTACHMENT
                // =======================================================
                new HSFileAttach('.js-file-attach')


                // INITIALIZATION OF STICKY BLOCKS
                // =======================================================
                new HSStickyBlock('.js-sticky-block', {
                    targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ? '#header' : null
                })


                // SCROLLSPY
                // =======================================================
                new bootstrap.ScrollSpy(document.body, {
                    target: '#navbarSettings',
                    offset: 100
                })

                new HSScrollspy('#navbarVerticalNavMenu', {
                    breakpoint: 'lg',
                    scrollOffset: -20
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