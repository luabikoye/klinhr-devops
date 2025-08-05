<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}
validatePermission('Vacancies');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Add Job Post | KlinHR</title>

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
    <link rel="stylesheet" href="./assets/vendor/quill/dist/quill.snow.css">
    <style data-hs-appearance-onload-styles>
        * {
            transition: unset !important;
        }

        body {
            opacity: 0;
        }
    </style>
    <style>
        .step-content a {
            font-size: 1.1484375rem;
            padding: 15px;
            color: #000;
        }

        .act {
            background-color: #377dff;
            color: #fff !important
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
            <!-- Step Form -->
            <div class="js-step-form py-md-5" data-hs-step-form-options='{
              "progressSelector": "#addUserStepFormProgress",
              "stepsSelector": "#addUserStepFormContent",
              "endSelector": "#addUserFinishBtn",
              "isValidate": false
            }'>
                <div class="row justify-content-lg-center">
                    <div class="col-lg-12">
                        <!-- Step -->
                        <ul id="addUserStepFormProgress" class="js-step-progress step step-sm step-icon-sm step step-inline step-item-between mb-3 mb-md-5">
                            <li class="step-item">
                                <span class="step-content-wrapper">
                                    <div class="step-content ">
                                        <a class="act smtp" href="javascript:;">SMTP</a>
                                    </div>
                                    <div class="step-content">
                                        <a class="client" href="javascript:;">Client</a>
                                    </div>
                                    <div class="step-content">
                                        <a class="sms" href="javascript:;">SMS</a>
                                    </div>
                                </span>
                            </li>
                        </ul>
                        <!-- End Step -->

                        <!-- Content Step Form -->
                        <form action="update-smtp" id="smtp" method="post" enctype="multipart/form-data" id="addUserStepFormContent">
                            <!-- Card -->
                            <div id="addUserStepProfile" class="card card-lg active">
                                <!-- Body -->
                                <div class="card-body">
                                    <!-- Form -->
                                    <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
                                    <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Username </label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="username" value="<?= smtp_detail('username') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Password</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="password" class="form-control" name="password" value="<?= smtp_detail('password') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form -->


                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Host</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="host" value="<?= smtp_detail('host') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <!-- End Form -->


                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Secure</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="secure" value="<?= smtp_detail('secure') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                    <!-- End Form -->



                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Sender</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="sender" value="<?= smtp_detail('sender') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Admin Email</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="admin" value="<?= smtp_detail('admin') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Hr Name</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="hr" value="<?= smtp_detail('hr') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Hr Email</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="hr_email" value="<?= smtp_detail('hr_email') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">No Reply Email</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="reply" value="<?= smtp_detail('reply') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Port Number</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="port" value="<?= smtp_detail('port') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->

                                    <!-- End Form -->
                                </div>
                                <!-- End Body -->

                                <!-- Footer -->
                                <div class="card-footer d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary">
                                        Update Details
                                    </button>
                                </div>
                                <!-- End Footer -->

                                <!-- End Card -->
                                <!-- End Content Step Form -->
                            </div>
                        </form>
                        <form action="update-client" id="client" method="post" enctype="multipart/form-data" id="addUserStepFormContent">
                            <!-- Card -->
                            <div id="addUserStepProfile" class="card card-lg active">
                                <!-- Body -->
                                <div class="card-body">
                                    <!-- Form -->
                                    <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
                                    <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Client Full Name </label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="name" value="<?= client_detail('client_name') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Client Abbrivation</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="abbr" value="<?= client_detail('client_abbr') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Show Assesment Result</label>

                                        <!-- clients logo  -->
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <!-- Radio Check -->
                                                <label class="form-control" for="userAccountTypeRadio1">
                                                    <span class="form-check">
                                                        <input type="checkbox" class="form-check-input" value="yes" <?= client_detail('assessment') == 'yes' ? 'checked' : '' ?> name="result" id="userAccountTypeRadio1">
                                                        <span class="form-check-label"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- / clients logo  -->
                                    </div>
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Show Job Image</label>

                                        <!-- clients logo  -->
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <!-- Radio Check -->
                                                <label class="form-control" for="userAccountTypeRadio1">
                                                    <span class="form-check">
                                                        <input type="checkbox" class="form-check-input" value="yes" <?= client_detail('job_img') == 'yes' ? 'checked' : '' ?> name="job_image" id="userAccountTypeRadio1">
                                                        <span class="form-check-label"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- / clients logo  -->
                                    </div>
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Client Logo</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="file" class="form-control" name="logo" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Verification Module</label>

                                        <!-- clients logo  -->
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <!-- Radio Check -->
                                                <label class="form-control" for="userAccountTypeRadio1">
                                                    <span class="form-check">
                                                        <input type="checkbox" class="form-check-input" value="yes" <?= client_detail('verification') == 'yes' ? 'checked' : '' ?> name="verify" id="userAccountTypeRadio1">

                                                        <span class="form-check-label"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- / clients logo  -->
                                    </div>
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Recieve email before approving jobs posted</label>

                                        <!-- clients logo  -->
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <!-- Radio Check -->
                                                <label class="form-control" for="userAccountTypeRadio1">
                                                    <span class="form-check">
                                                        <input type="checkbox" class="form-check-input" value="yes" <?= client_detail('recruitment') == 'yes' ? 'checked' : '' ?> name="recruitment" id="userAccountTypeRadio1">

                                                        <span class="form-check-label"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- / clients logo  -->
                                    </div>

                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Number Of Guarantor</label>

                                        <!-- clients logo  -->
                                        <div class="col-sm-9">
                                            <!-- Radio Check -->
                                            <div class="tom-select-custom mb-4">
                                                <select data-hs-tom-select-options='{
                                            "placeholder": "Select option"
                                        }' class="js-select form-select" id="locationLabel" name="gua">
                                                    <option value="1" <?= client_detail('guarantor') == '1' ? 'selected' : '' ?>>1</option>
                                                    <option value="2" <?= client_detail('guarantor') == '2' ? 'selected' : '' ?>>2</option>
                                                    <option value="3" <?= client_detail('guarantor') == '3' ? 'selected' : '' ?>>3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- / clients logo  -->
                                    </div>

                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">No Of Previous Employer</label>

                                        <!-- clients logo  -->
                                        <div class="col-sm-9">
                                            <div class="tom-select-custom mb-4">
                                                <select data-hs-tom-select-options='{
                                            "placeholder": "Select option"
                                        }' class="js-select form-select" id="locationLabel" name="employer">
                                                    <option value="1" <?= client_detail('employer') == '1' ? 'selected' : '' ?>>1</option>
                                                    <option value="2" <?= client_detail('employer') == '2' ? 'selected' : '' ?>>2</option>
                                                    <option value="3" <?= client_detail('employer') == '3' ? 'selected' : '' ?>>3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- / clients logo  -->
                                    </div>
                                    <div class="mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">About Company</label>

                                        <!-- clients logo  -->
                                        <div class="quill-custom">
                                            <textarea name="about" id="responsibilities" required><?= client_detail('about') ?></textarea>
                                            <script>
                                                CKEDITOR.replace('responsibilities');
                                            </script>
                                        </div>
                                        <!-- / clients logo  -->
                                    </div>
                                </div>
                                <!-- End Body -->



                                <!-- Footer -->
                                <div class="card-footer d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary">
                                        Update Details
                                    </button>
                                </div>
                                <!-- End Footer -->

                                <!-- End Card -->
                                <!-- End Content Step Form -->
                            </div>
                        </form>
                        <form action="update-sms" id="sms" method="post" enctype="multipart/form-data" id="addUserStepFormContent">
                            <!-- Card -->
                            <div id="addUserStepProfile" class="card card-lg active">
                                <!-- Body -->
                                <div class="card-body">
                                    <!-- Form -->
                                    <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
                                    <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Send Sms Messages</label>

                                        <!-- clients logo  -->
                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <!-- Radio Check -->
                                                <label class="form-control" for="userAccountTypeRadio1">
                                                    <span class="form-check">
                                                        <input type="checkbox" class="form-check-input" value="yes" <?= sms_detail('sms_approval') == 'yes' ? 'checked' : '' ?> name="sms_approval" id="userAccountTypeRadio1">
                                                        <span class="form-check-label"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- / clients logo  -->
                                    </div>
                                    <div class="row mb-4">
                                        <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Sms API </label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="api" value="<?= sms_detail('sms_api') ?>" id="firstNameLabel" placeholder="" aria-label="Clarice">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                </div>
                                <!-- End Body -->

                                <!-- Footer -->
                                <div class="card-footer d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary">
                                        Update Details
                                    </button>
                                </div>
                                <!-- End Footer -->

                                <!-- End Card -->
                                <!-- End Content Step Form -->
                            </div>
                        </form>
                        <!-- End Row -->
                    </div>
                    <!-- End Step Form -->
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
    <script src="./assets/vendor/quill/dist/quill.min.js"></script>
    <script src="./assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
    <script src="./assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
    <script src="./assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
    <script src="./assets/vendor/imask/dist/imask.min.js"></script>
    <script src="./assets/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>

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



                // INITIALIZATION OF QUILLJS EDITOR
                // =======================================================
                HSCore.components.HSQuill.init('.js-quill')


                // INITIALIZATION OF FILE ATTACH
                // =======================================================
                new HSFileAttach('.js-file-attach')


                // INITIALIZATION OF STEP FORM
                // =======================================================
                new HSStepForm('.js-step-form', {
                    finish: () => {
                        document.getElementById("addUserStepFormProgress").style.display = 'none'
                        document.getElementById("addUserStepProfile").style.display = 'none'
                        document.getElementById("addUserStepBillingAddress").style.display = 'none'
                        document.getElementById("addUserStepConfirmation").style.display = 'none'
                        document.getElementById("successMessageContent").style.display = 'block'
                        scrollToTop('#header');
                        const formContainer = document.getElementById('formContainer')
                    },
                    onNextStep: function() {
                        scrollToTop()
                    },
                    onPrevStep: function() {
                        scrollToTop()
                    }
                })

                function scrollToTop(el = '.js-step-form') {
                    el = document.querySelector(el)
                    window.scrollTo({
                        top: (el.getBoundingClientRect().top + window.scrollY) - 30,
                        left: 0,
                        behavior: 'smooth'
                    })
                }


                // INITIALIZATION OF ADD FIELD
                // =======================================================
                new HSAddField('.js-add-field', {
                    addedField: field => {
                        HSCore.components.HSTomSelect.init(field.querySelector('.js-select-dynamic'))
                        HSCore.components.HSMask.init(field.querySelector('.js-input-mask'))
                    }
                })


                // INITIALIZATION OF SELECT
                // =======================================================
                HSCore.components.HSTomSelect.init('.js-select', {
                    render: {
                        'option': function(data, escape) {
                            return data.optionTemplate || `<div>${data.text}</div>>`
                        },
                        'item': function(data, escape) {
                            return data.optionTemplate || `<div>${data.text}</div>>`
                        }
                    }
                })


                // INITIALIZATION OF INPUT MASK
                // =======================================================
                HSCore.components.HSMask.init('.js-input-mask')
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

    <script>
        $(document).ready(function() {
            $('#client').hide()
            $('#sms').hide()
            $('.client').click(function() {
                $('.smtp').removeClass('act')
                $('.sms').removeClass('act')
                $('#smtp').hide()
                $('#sms').hide()
                $('.client').addClass('act')
                $('#client').show()
            })
            $('.smtp').click(function() {
                $('.client').removeClass('act')
                $('.sms').removeClass('act')
                $('#client').hide()
                $('.smtp').addClass('act')
                $('#smtp').show()
                $('#sms').hide()
            })
            $('.sms').click(function() {
                $('.client').removeClass('act')
                $('.smtp').removeClass('act')
                $('#client').hide()
                $('.sms').addClass('act')
                $('#sms').show()
                $('#smtp').hide()
            })
        })
    </script>

    <!-- End Style Switcher JS -->
</body>

</html>