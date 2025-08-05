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
if (($_GET['unique'])) {
    $id = base64_decode($_GET['unique']);
}

$client_query = "select * from clients where id = ('$id')";
$client_result = mysqli_query($db, $client_query);

$client_row = mysqli_fetch_array($client_result)

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Edit Client | KlinHR</title>

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
            <form class="js-step-form py-md-5" method="post" action="proc_edit_client" enctype="multipart/form-data" data-hs-step-form-options='{
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
                                <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                    "targetSelector": "#addUserStepProfile"
                  }'>
                                    <!-- <span class="step-icon step-icon-soft-dark">1</span> -->
                                    <div class="step-content">
                                        <h3>Edit Clients</h3>
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
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Client Name</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <input type="text" class="form-control" name="client_name" id="firstNameLabel" placeholder="" aria-label="Clarice" value="<?php echo $client_row['client_name']; ?>">
                                                <input type="hidden" name="id" value="<?php echo $client_row['id']; ?>">
                                            </div>
                                        </div>
                                        <!-- End Form -->


                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="locationLabel" class="col-sm-3 col-form-label form-label">Client Code</label>

                                            <div class="col-sm-9">
                                                <!-- Select -->
                                                <div class="tom-select-custom mb-4">
                                                    <input type="text" class="form-control" name="client_code" id="firstNameLabel" placeholder="" aria-label="Clarice" value="<?php echo $client_row['client_code']; ?>">
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                        </div>
                                        <!-- End Form -->

                                        <!-- Quill -->
                                        <div class="row mb-4">
                                            <label for="locationLabel" class="col-sm-3 col-form-label form-label">Contact Person</label>

                                            <div class="col-sm-9">
                                                <!-- Select -->
                                                <div class="tom-select-custom mb-4">
                                                    <input type="text" class="form-control" name="contact_person" id="firstNameLabel" placeholder="" aria-label="Clarice" value="<?= $client_row['contact_person'] ?>">
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                        </div>
                                        <!-- End Quill -->


                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Email </label>

                                            <div class="col-sm-9">
                                                <div class="input-group input-group-sm-vertical">
                                                    <input type="email" class="form-control" name="email" id="firstNameLabel" placeholder="" aria-label="Clarice" value="<?= $client_row['email'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Phone Number</label>

                                            <div class="col-sm-9">
                                                <div class="input-group input-group-sm-vertical">
                                                    <input type="text" class="form-control" name="phone" id="firstNameLabel" placeholder="" aria-label="Clarice" value="<?= $client_row['phone'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Upload Logo</label>
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-sm-vertical">
                                                    <input type="file" class="form-control" name="logo" id="firstNameLabel" placeholder="" aria-label="Clarice" value="<?= $client_row['logo'] ?>">
                                                </div>
                                            </div>
                                            <?php if ($client_row['logo']) {
                                            ?>
                                                <img style="width:60px;" src="../uploads/Clients/<?php echo $client_row['logo']; ?>"></span>
                                            <?php } ?>
                                        </div>


                                        <div class="row mb-4">
                                            <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Online Guarantor Form</label>

                                            <div class="col-sm-9">
                                                <label class="form-control" for="userAccountTypeRadio1">
                                                    <span class="form-check">
                                                        <input type="checkbox" class="form-check-input" value="yes" <?= client_setting('online_gua', $client_row['client_code']) == 'yes' ? 'checked' : '' ?> name="online" id="userAccountTypeRadio1">
                                                        <span class="form-check-label"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Clockin Settings</label>

                                            <div class="col-sm-4">
                                                <label class="form-control" for="userAccountTypeRadio2">
                                                    <span class="form-check">
                                                        <input type="radio" class="form-check-input" value="enabled" <?= client_setting('clockin', $client_row['client_code']) == 'enabled' ? 'checked' : '' ?> required name="clockin" id="userAccountTypeRadio2">
                                                        <span class="form-check-label">Enabled</span>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="form-control" for="userAccountTypeRadio3">
                                                    <span class="form-check">
                                                        <input type="radio" class="form-check-input" value="disabled" <?= client_setting('clockin', $client_row['client_code']) == 'disabled' ? 'checked' : '' ?> required name="clockin" id="userAccountTypeRadio3">
                                                        <span class="form-check-label">Disabled</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        <div id="clockin">

                                            <div class="row mb-4">
                                                <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">
                                                    Geofence Settings <br> <small>Select how users interact with your geofence locations</small>
                                                </label>


                                                <div class="col-sm-3">
                                                    <label class="form-control" for="userAccountTypeRadio4">
                                                        <span class="form-check">
                                                            <input type="radio" class="form-check-input" value="onsite" <?= clockin('geofence', $client_row['client_code']) == 'onsite' ? 'checked' : '' ?> name="geofence" id="userAccountTypeRadio4">
                                                            <span class="form-check-label">Onsite</span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-control" for="userAccountTypeRadio5">
                                                        <span class="form-check">
                                                            <input type="radio" class="form-check-input" value="flexible" <?= clockin('geofence', $client_row['client_code']) == 'flexible' ? 'checked' : '' ?> name="geofence" id="userAccountTypeRadio5">
                                                            <span class="form-check-label">Flexible </span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label class="form-control" for="userAccountTypeRadio6">
                                                        <span class="form-check">
                                                            <input type="radio" class="form-check-input" value="both" <?= clockin('geofence', $client_row['client_code']) == 'both' ? 'checked' : '' ?> name="geofence" id="userAccountTypeRadio6">
                                                            <span class="form-check-label">Flexible clock out</span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Geo Location</label>

                                                <div class="col-sm-9">
                                                    <div class="input-group input-group-sm-vertical">
                                                        <input type="text" class="form-control" name="location" id="firstNameLabel" placeholder="" aria-label="Clarice" value="<?= $client_row['geolocation'] ?>">
                                                    </div>
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
                                                Sve Client Details
                                            </button>
                                        </div>
                                        <!-- End Footer -->

                                        <!-- End Card -->
                                        <!-- End Content Step Form -->
                                    </div>
                                </div>
                                <!-- End Row -->
            </form>

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
    <script src="add-client.js"></script>

    <!-- End Style Switcher JS -->
</body>

</html>