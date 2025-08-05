<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}
validatePermission('Generate Report');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Generate Report | KlinHR</title>

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
    <script src="assets/js/jquery-1.11.1.min.js"></script>
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
            <div class="row justify-content-lg-center">
                <div class="col-lg-8">
                    <!-- Step -->
                    <ul id="addUserStepFormProgress" class="js-step-progress step step-sm step-icon-sm step step-inline step-item-between mb-3 mb-md-5">
                        <li class="step-item">
                            <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                                        "targetSelector": "#addUserStepProfile"
                                    }'>
                                <div class="step-content">
                                    <h3 class="">Please choose the type of report you want to generate.</h3>
                                </div>
                            </a>
                        </li>


                    </ul>
                    <!-- End Step -->

                    <!-- Content Step Form -->
                    <div id="addUserStepFormContent">
                        <!-- Card -->
                        <div id="addUserStepProfile" class="card card-lg active">
                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form -->
                                <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
                                <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="locationLabel" class="col-sm-3 col-form-label form-label">Choose Module</label>

                                    <div class="col-sm-9">
                                        <!-- Select -->
                                        <div class="tom-select-custom mb-4">
                                            <select class=" form-select" required id="tab" name="tab">
                                                <option value="">Select One</option>
                                                <option value="vacancies">Vacancies</option>
                                                <option value="job_seekers">Job Seekers</option>
                                                <option value="onboarding">Onboarding</option>
                                                <option value="verification">Verification</option>
                                                <option value="deploy_candidate">Deploy Candidate</option>
                                                <option value="grievances">Grievances</option>
                                                <option value="leaves">Leaves</option>
                                                <option value="reference">Introduction Letter</option>
                                                <option value="resignation">Resignation</option>
                                                <option value="appraisal">Employee Appraisal </option>
                                                <option value="assessment">Assessment</option>
                                                <option value="activities">Activities</option>
                                            </select>
                                        </div>
                                        <!-- End Select -->
                                    </div>
                                </div>
                                <!-- End Form -->
                                <!-- Form -->

                                <hr>
                                <!-- End Form -->
                                <!-- Form -->
                                <div class="row mb-4" id="verification">
                                    <form action="generate_verification" method="post" enctype="multipart/form-data">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Status</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <select class=" form-select" id="tab" name="tab">
                                                    <option value="">Select </option>
                                                    <option value="pending verification">Pending Verification </option>
                                                    <option value="completed verification">Completed Verification </option>
                                                </select>
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="card-footer d-flex justify-content-end align-items-center">
                                            <input type="submit" class="btn btn-primary" value="Generate Report" class="btn-sm btn btn-primary" onclick="return confirm('Click OK to generate this report'); ">

                                        </div>
                                    </form>
                                </div>
                                <!-- End Form -->
                                <!-- Form -->
                                <div class="row mb-4" id="deploy_candidate">
                                    <form action="generate_deploy_candidate" method="post" enctype="multipart/form-data">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Status</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <select class=" form-select" id="tab" name="tab">
                                                    <option value="">Select </option>
                                                    <option value="pool">Pool </option>
                                                    <option value="client">Assigned To Client </option>
                                                </select>
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="card-footer d-flex justify-content-end align-items-center">
                                            <input type="submit" class="btn btn-primary" value="Generate Report" class="btn-sm btn btn-primary" onclick="return confirm('Click OK to generate this report'); ">

                                        </div>
                                    </form>
                                </div>
                                <!-- End Form -->
                                <!-- Form -->
                                <div class="row mb-4" id="activities">
                                    <form action="generate_activity_log" method="post" enctype="multipart/form-data">
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-3 col-form-label form-label">Start Date</label>
                                                <input type="date" name="start_date" class="form-control" id="inputName">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-3 col-form-label form-label">End Date</label>
                                                <input type="date" name="end_date" class="form-control" id="inputName">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="card-footer d-flex justify-content-end align-items-center">
                                            <input type="submit" class="btn btn-primary" value="Generate Report" class="btn-sm btn btn-primary" onclick="return confirm('Click OK to generate this report'); ">

                                        </div>
                                    </form>
                                </div>
                                <!-- End Form -->
                                <!-- Form -->
                                <div class="row mb-4" id="onboarding">
                                    <form action="generate_onboarding" method="post" enctype="multipart/form-data">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Status</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <select class=" form-select" id="tab" name="tab">
                                                    <option value="">Select </option>
                                                    <option value="N">Pending Onboarding </option>
                                                    <option value="Y">Completed Onboarding </option>
                                                </select>
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="card-footer d-flex justify-content-end align-items-center">
                                            <input type="submit" class="btn btn-primary" value="Generate Report" class="btn-sm btn btn-primary" onclick="return confirm('Click OK to generate this report'); ">

                                        </div>
                                    </form>
                                </div>
                                <!-- End Form -->

                                <!-- Appraisal -->
                                <?php include('g_appraisal.php') ?>
                                <?php include('g_reference.php') ?>
                                <?php include('g_leave.php') ?>
                                <?php include('g_vacancies.php') ?>
                                <?php include('g_assessment.php') ?>
                                <?php include('g_jobseekers.php') ?>
                                <?php include('g_grievancies.php') ?>
                                <?php include('g_resignation.php') ?>
                                <!-- End Appraisal -->
                            </div>
                            <!-- End Body -->

                            <!-- Footer -->

                            <!-- End Footer -->

                            <!-- End Card -->
                            <!-- End Content Step Form -->
                        </div>
                    </div>
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

    <!-- Mode of testing -->
    <script>
        $(function() {
            $('#job_seekers').hide();
            $('#assessment').hide();
            $('#activities').hide();
            $('#vacancies').hide();
            $('#onboarding').hide();
            $('#verification').hide();
            $('#deploy_candidate').hide();
            $('#grievances').hide();
            $('#leaves').hide();
            $('#reference').hide();
            $('#resignation').hide();
            $('#appraisal').hide();


            $('#tab').change(function() {
                var tab = $(this).val();
                if (tab == 'vacancies') {
                    $('#vacancies').show();
                    $('#activities').hide();
                    $('#assessment').hide();
                    $('#job_seekers').hide();
                    $('#onboarding').hide();
                    $('#verification').hide();
                    $('#deploy_candidate').hide();
                    $('#grievances').hide();
                    $('#leaves').hide();
                    $('#reference').hide();
                    $('#resignation').hide();
                    $('#appraisal').hide();

                    // $('#report_form').attr('action', 'generate_vacancies');
                }

                if (tab == 'assessment') {
                    $('#assessment').show();
                    $('#vacancies').hide();
                    $('#job_seekers').hide();
                    $('#activities').hide();
                    $('#onboarding').hide();
                    $('#verification').hide();
                    $('#deploy_candidate').hide();
                    $('#grievances').hide();
                    $('#leaves').hide();
                    $('#reference').hide();
                    $('#resignation').hide();
                    $('#appraisal').hide();

                    // $('#report_form').attr('action', 'generate_assessment');
                }

                if (tab == 'job_seekers') {
                    $('#job_seekers').show();
                    $('#assessment').hide();
                    $('#activities').hide();
                    $('#vacancies').hide();
                    $('#onboarding').hide();
                    $('#verification').hide();
                    $('#deploy_candidate').hide();
                    $('#grievances').hide();
                    $('#leaves').hide();
                    $('#reference').hide();
                    $('#resignation').hide();
                    $('#appraisal').hide();

                    // $('#report_form').attr('action', 'generate_job_seekers');
                }
                if (tab == 'onboarding') {
                    $('#onboarding').show();
                    $('#assessment').hide();
                    $('#activities').hide();
                    $('#job_seekers').hide();
                    $('#vacancies').hide();
                    $('#verification').hide();
                    $('#deploy_candidate').hide();
                    $('#grievances').hide();
                    $('#leaves').hide();
                    $('#reference').hide();
                    $('#resignation').hide();
                    $('#appraisal').hide();

                    // $('#report_form').attr('action', 'generate_onboarding');
                }
                if (tab == 'verification') {
                    $('#verification').show();
                    $('#assessment').hide();
                    $('#activities').hide();
                    $('#job_seekers').hide();
                    $('#vacancies').hide();
                    $('#onboarding').hide();
                    $('#deploy_candidate').hide();
                    $('#grievances').hide();
                    $('#leaves').hide();
                    $('#reference').hide();
                    $('#resignation').hide();
                    $('#appraisal').hide();

                    // $('#report_form').attr('action', 'generate_verification');
                }

                if (tab == 'deploy_candidate') {
                    $('#deploy_candidate').show();
                    $('#assessment').hide();
                    $('#activities').hide();
                    $('#job_seekers').hide();
                    $('#vacancies').hide();
                    $('#onboarding').hide();
                    $('#verification').hide();
                    $('#grievances').hide();
                    $('#leaves').hide();
                    $('#reference').hide();
                    $('#resignation').hide();
                    $('#appraisal').hide();


                    // $('#report_form').attr('action', 'generate_deploy_candidate');
                }
                if (tab == 'grievances') {
                    $('#grievances').show();
                    $('#assessment').hide();
                    $('#activities').hide();
                    $('#job_seekers').hide();
                    $('#vacancies').hide();
                    $('#onboarding').hide();
                    $('#verification').hide();
                    $('#deploy_candidate').hide();
                    $('#leaves').hide();
                    $('#reference').hide();
                    $('#resignation').hide();
                    $('#appraisal').hide();

                    // $('#report_form').attr('action', 'generate_grievances');
                }
                if (tab == 'leaves') {
                    $('#leaves').show();
                    $('#assessment').hide();
                    $('#activities').hide();
                    $('#job_seekers').hide();
                    $('#vacancies').hide();
                    $('#onboarding').hide();
                    $('#verification').hide();
                    $('#deploy_candidate').hide();
                    $('#grievances').hide();
                    $('#reference').hide();
                    $('#resignation').hide();
                    $('#appraisal').hide();

                    // $('#report_form').attr('action', 'generate_leaves');
                }
                if (tab == 'reference') {
                    $('#reference').show();
                    $('#assessment').hide();
                    $('#activities').hide();
                    $('#job_seekers').hide();
                    $('#vacancies').hide();
                    $('#onboarding').hide();
                    $('#verification').hide();
                    $('#deploy_candidate').hide();
                    $('#grievances').hide();
                    $('#leaves').hide();
                    $('#resignation').hide();
                    $('#appraisal').hide();

                    // $('#report_form').attr('action', 'generate_reference');
                }
                if (tab == 'resignation') {
                    $('#resignation').show();
                    $('#assessment').hide();
                    $('#activities').hide();
                    $('#job_seekers').hide();
                    $('#vacancies').hide();
                    $('#onboarding').hide();
                    $('#verification').hide();
                    $('#deploy_candidate').hide();
                    $('#grievances').hide();
                    $('#leaves').hide();
                    $('#reference').hide();
                    $('#appraisal').hide();

                    // $('#report_form').attr('action', 'generate_resignation');
                }
                if (tab == 'appraisal') {
                    $('#appraisal').show();
                    $('#assessment').hide();
                    $('#activities').hide();
                    $('#job_seekers').hide();
                    $('#vacancies').hide();
                    $('#onboarding').hide();
                    $('#verification').hide();
                    $('#deploy_candidate').hide();
                    $('#grievances').hide();
                    $('#leaves').hide();
                    $('#reference').hide();
                    $('#resignation').hide();

                    // $('#report_form').attr('action', 'generate_appraisal');
                }

                if (tab == 'activities') {
                    $('#activities').show();
                    $('#vacancies').hide();
                    $('#assessment').hide();
                    $('#job_seekers').hide();
                    $('#onboarding').hide();


                    // $('#report_form').attr('action', 'generate_activity_log');
                }


            })

        })
    </script>

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
                        HSCore.components.HSTomSelect.init(field.querySelector('.-dynamic'))
                        HSCore.components.HSMask.init(field.querySelector('.js-input-mask'))
                    }
                })


                // INITIALIZATION OF SELECT
                // =======================================================
                HSCore.components.HSTomSelect.init('.', {
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

    <!-- End Style Switcher JS -->
</body>

</html>