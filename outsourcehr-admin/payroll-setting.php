<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}
if ($_GET['bands']) {
    $salary = $_GET['bands'];
    $client = $_GET['clients'];
} else {

    $salary_band = base64_decode($_GET['band']);
    $salary_band = explode(',', $salary_band);
    $salary = $salary_band[0];
    $client = $salary_band[1];
    $sb = $salary . ' (' . $client . ')';
}





$query = "select * from settings where band = '$salary' and client = '$client'";
$qss = mysqli_query($db, $query);
$rss = mysqli_fetch_array($qss);
if ($rss['comp_stat_cont'] == '') {
    $query = "select * from settings where band = 'def'";
    $qss = mysqli_query($db, $query);
    $rss = mysqli_fetch_array($qss);

    $band_id = get_band_id($salary, $client);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Payroll Settings | KlinHR</title>

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
                <div class="col-lg-12">
                    <!-- Step -->
                    <ul id="addUserStepFormProgress" class="js-step-progress step step-sm step-icon-sm step step-inline step-item-between mb-3 mb-md-5">
                        <li class="step-item">
                            <a class="step-content-wrapper" href="javascript:;" data-hs-step-form-next-options='{
                                        "targetSelector": "#addUserStepProfile"
                                    }'>
                                <div class="step-content">
                                    <h3 class="">Payroll Setting</h3>
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
                            <form id="Settings" method="post" action="processSettings" enctype="multipart/form-data">
                                <div class="card-body">
                                    <!-- Form -->
                                    <?php if ($_GET['msg']) echo '<div class="alert alert-success"><strong>Success: </strong>Setting has been stored.</div>'; ?>
                                    <?php if ($_GET['err']) echo '<div class="alert alert-danger"><strong>Error: </strong>Settings not stored.</div>'; ?>
                                    <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Choose Module</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <select data-hs-tom-select-options='{
                                            "placeholder": "<?php if ($salary) {
                                                                echo $salary;
                                                            } else {
                                                                echo "Choose salary band";
                                                            } ?>"
                                        }' class="js-select form-select" id="client" required name="band">
                                                    <?php if ($salary) {
                                                    ?>
                                                        <option value="<?= $salary ?>" selected><?= $sb ?></option>
                                                    <?php } else {
                                                    ?>
                                                        <option value="">Choose salary band</option>
                                                    <?php }
                                                    salary_band() ?>
                                                </select>
                                            </div>

                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <!-- End Form -->
                                    <!-- Form -->

                                    <hr>
                                    <!-- End Form -->

                                    <h2>Deductions</h2>
                                    <h4>Pension</h4>
                                    <div class="row mb-4" id="activities">
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-12 col-form-label form-label">Company Contribution(%)</label>
                                                <input type="text" name="comp_stat_cont" class="form-control" id="inputName" value="<?php if ($comp_stat_cont) {
                                                                                                                                        $comp_stat_cont;
                                                                                                                                    } else {
                                                                                                                                        echo $rss['comp_stat_cont'];
                                                                                                                                    } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">

                                                <label for="locationLabel" class="col-sm-12 col-form-label form-label">Staff Contribution(%)</label>
                                                <input type="text" name="staff_stat_cont" class="form-control" id="inputName" value="<?php if ($staff_stat_cont) {
                                                                                                                                            $staff_stat_cont;
                                                                                                                                        } else {
                                                                                                                                            echo $rss['staff_stat_cont'];
                                                                                                                                        } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <h4>Tax</h4>
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-12 col-form-label form-label">Tax Deductions(%)</label>
                                                <input type="text" name="tax" class="form-control" id="inputName" value="<?php if ($tax) {
                                                                                                                                $tax;
                                                                                                                            } else {
                                                                                                                                echo $rss['tax'];
                                                                                                                            } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <h4>Loan</h4>
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-12 col-form-label form-label">Loan Deductions(%)</label>
                                                <input type="text" name="loan" class="form-control" id="inputName" value="<?php if ($loan) {
                                                                                                                                $loan;
                                                                                                                            } else {
                                                                                                                                echo $rss['loan'];
                                                                                                                            } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="d-flex align-items-center pb-5">
                                            <a href="javascript:;" class="other" type="button">[<i class=" bi-plus"></i>] Add Other Deductions</a>
                                        </div>
                                        <?php include('deductions.php') ?>

                                        <hr>
                                        <h2>Allowances</h2>
                                        <h4>Parameters</h4>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-3 col-form-label form-label">Basic(%)</label>
                                                <input type="text" name="basic" class="form-control" value="<?php if ($basic) {
                                                                                                                $basic;
                                                                                                            } else {
                                                                                                                echo $rss['basic'];
                                                                                                            } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-3 col-form-label form-label">Housing(%)</label>
                                                <input type="text" name="housing" class="form-control" value="<?php if ($house) {
                                                                                                                    $house;
                                                                                                                } else {
                                                                                                                    echo $rss['housing'];
                                                                                                                } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-12 col-form-label form-label">Transport(%)</label>
                                                <input type="text" name="transport" class="form-control" value="<?php if ($trans) {
                                                                                                                    $trans;
                                                                                                                } else {
                                                                                                                    echo $rss['transport'];
                                                                                                                } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-12 col-form-label form-label">Leave Allowance(%)</label>
                                                <input type="text" name="leave_allo" class="form-control" value="<?php if ($leave) {
                                                                                                                        $leave;
                                                                                                                    } else {
                                                                                                                        echo $rss['leave_allo'];
                                                                                                                    } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-3 col-form-label form-label">Utility(%)</label>
                                                <input type="text" name="utility" class="form-control" value="<?php if ($utility) {
                                                                                                                    $utility;
                                                                                                                } else {
                                                                                                                    echo $rss['utility'];
                                                                                                                } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-12 col-form-label form-label">Meal & Entertainment(%)</label>
                                                <input type="text" name="meals" class="form-control" value="<?php if ($meals) {
                                                                                                                $meals;
                                                                                                            } else {
                                                                                                                echo $rss['meals'];
                                                                                                            } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-3 col-form-label form-label">Dressing(%)</label>
                                                <input type="text" name="dressing" class="form-control" value="<?php if ($dress) {
                                                                                                                    $dress;
                                                                                                                } else {
                                                                                                                    echo $rss['dressing'];
                                                                                                                } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <label for="locationLabel" class="col-sm-12 col-form-label form-label">13th Month(%) </label>
                                                <input type="text" name="13th_month" class="form-control" value="<?php if ($month13) {
                                                                                                                        $month13;
                                                                                                                    } else {
                                                                                                                        echo $rss['13th_month'];
                                                                                                                    } ?>">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <p>Reliefs and Allowable Deductions</p>
                                        <div class="col-md-8">
                                            <p>NHF is 2.5% of Basic Salary. <br>
                                                Click to activate NHF</p>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="checkbox" name="nhf" value="2.5" data-color="primary" <?php if ($rss['nhf'] || $nhf) { ?> checked="checked" <?php } ?>>Nhf
                                        </div>
                                        <a href="javascript:;" class="allow" style="margin-left: 10px;">[<i class=" bi-plus"></i>]Add More Allowances</a>
                                        <?php include('allowances.php') ?>
                                        <div class="card-footer d-flex align-items-center">
                                            <input type="submit" value="Save" class="btn-sm btn btn-primary">
                                            <input type="hidden" name="client" value="<?php echo $client; ?>">
                                        </div>
                                    </div>
                                    <!-- </form> -->
                                    <!-- End Form -->
                                </div>
                            </form>
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
            $("#client").change(function() {

                var pension = $('select#client option:selected').val();

                alert(pension)
                $.ajax({
                    type: "POST",
                    url: "get-client",
                    data: {
                        pension: pension
                    },
                    success: function(response) {

                        window.location.href = response;

                    }

                });
            });

            $('#checkbox1').change(function() {
                if (this.checked)
                    $('#autoUpdate').fadeIn('slow');
                else
                    $('#autoUpdate').fadeOut('slow');

            });

        });
        <?php for ($i = 0; $i < 10; $i++) {
            $y = $i + 1;
        ?>
            $(".name<?= $i + 1 ?>").hide();
            $(".names<?= $i + 1 ?>").hide();
            $("#add<?= $i + 1 ?>").click(function() {
                $(".name<?= $y + 1 ?>").show()
                $("#add<?= $i + 1 ?>").hide();
                $("#remove<?= $i + 1 ?>").hide();
            })
            $("#adds<?= $i + 1 ?>").click(function() {
                $(".names<?= $y + 1 ?>").show()
                $("#adds<?= $i + 1 ?>").hide();
                $("#removes<?= $i + 1 ?>").hide();
            })
            $("#remove<?= $i + 1 ?>").click(function() {
                $(".name<?= $y ?>").hide()
                $("#add<?= $i ?>").show();
                $("#remove<?= $i ?>").show();
                $("#inputName<?= $i + 1 ?>").val("");
                $("#inputedName<?= $i + 1 ?>").val("");

            })
            $("#removes<?= $i + 1 ?>").click(function() {
                $(".names<?= $y ?>").hide()
                $("#adds<?= $i ?>").show();
                $("#removes<?= $i ?>").show();
                $("#inputNames<?= $i + 1 ?>").val("");
                $("#inputedNames<?= $i + 1 ?>").val("");

            })

            if ($("#inputName<?= $i + 1 ?>").val() != "") {
                $('.name<?= $i + 1 ?>').show()
                $("#add<?= $i + 1 ?>").show();
                $("#add<?= $i ?>").hide();
                $("#remove<?= $i ?>").show();
                $("#remove<?= $i ?>").hide();
                $(".other").hide();
            }
            if ($("#inputNames<?= $i + 1 ?>").val() != "") {
                $('.names<?= $i + 1 ?>').show()
                $("#adds<?= $i + 1 ?>").show();
                $("#adds<?= $i ?>").hide();
                $("#removes<?= $i ?>").show();
                $("#removes<?= $i ?>").hide();
                $(".allow").hide();
            }


        <?php } ?>
        $("#add10").hide()
        $("#adds10").hide()
        // $("#remove10").hide()
        $(".other").click(function() {
            $(".name1").show();
            $(".other").hide();
        })
        $(".allow").click(function() {
            $(".names1").show();
            $(".allow").hide();
        })
        $("#remove1").click(function() {
            $(".other").show();
        })
        $("#removes1").click(function() {
            $(".allow").show();
        })
    </script>

    <!-- End Style Switcher JS -->
</body>

</html>