<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}
$client = base64_decode($_GET['client']);
$select = "select * from clients where client_code = '$client'";
$sel_result = mysqli_query($db, $select);
$rows = mysqli_fetch_array($sel_result);

$client_name = $rows['client_name'];

$query = "select * from salary_band where client = '$client'";
$qss = mysqli_query($db, $query);
$rss = mysqli_fetch_assoc($qss);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Salary Band | KlinHR</title>

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
                                    <h3 class="">Salary Band</h3>
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
                                <?php if ($_GET['msg']) echo '<div class="alert alert-success"><strong>Success: </strong>Salary has been stored.</div>'; ?>
                                <?php if ($_GET['msg'] == 'error') echo '<div class="alert alert-danger"><strong>Error: </strong>Salary not stored.</div>'; ?>
                                <?php if ($_GET['msg1'] == 'error') echo '<div class="alert alert-danger"><strong>Error: </strong>Salary band already in database. Please create new Salary band</div>'; ?>
                                <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>

                                <!-- Form -->
                                <div class="row mb-4">
                                    <label for="locationLabel" class="col-sm-3 col-form-label form-label">Choose Client</label>

                                    <div class="col-sm-9">
                                        <!-- Select -->
                                        <div class="tom-select-custom mb-4">
                                            <select class="js-select form-select" required id="client" name="client">
                                                <?php if ($client) {
                                                ?>
                                                    <option value="<?= $client ?>"><?= $client_name ?></option>
                                                <?php } else {
                                                ?>
                                                    <option value="Choose Client"></option>
                                                <?php }
                                                client_code() ?>
                                            </select>
                                        </div>
                                        <?php if (!$client) {
                                        ?>
                                            <p><small>You can set salaryband per client if needed</small></p>
                                        <?php } else { ?>
                                            <p><small>You can set salary band for <?= $client ?></small></p>
                                        <?php } ?>
                                        <!-- End Select -->
                                    </div>
                                </div>
                                <!-- End Form -->
                                <!-- Form -->

                                <!-- Form -->
                                <form id="Settings" method="post" action="processSalary" enctype="multipart/form-data">
                                    <div class="row mb-4" id="activities">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Salary Band</label>
                                        <div class="col-md-9">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <input type="text" name="band" class="form-control" id="inputName" value="">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Salary</label>
                                        <div class="col-md-9">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <input type="text" name="salary" class="form-control" id="salary" value="">
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                        <div class=" card-footer d-flex align-items-center">
                                            <input type="submit" value="Save" class="btn-sm btn btn-primary">
                                            <!-- <input type="reset" value="Clear" class="btn btn-outline-primary" style="margin-left: 10px;"> -->
                                            <input type="hidden" name="client" value="<?php echo $client; ?>">
                                        </div>
                                    </div>
                                </form>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->

                            <!-- Footer -->

                            <!-- End Footer -->

                            <!-- End Card -->
                            <!-- End Content Step Form -->
                        </div>
                    </div>
                    <br><br> <!-- End Row -->


                    <?php if ($client) {   ?>
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
                                                S/N
                                            </th>
                                            <th class="table-column-ps-0">Salary Band</th>
                                            <th class="table-column-ps-0">Salary</th>
                                            <th class="table-column-ps-0">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $sel = "select * from salary_band where client = '$client'";
                                        $res = mysqli_query($db, $sel);
                                        $nums = mysqli_num_rows($res);
                                        for ($i = 1; $i <= $nums; $i++) {
                                            $rows = mysqli_fetch_array($res);
                                        ?>
                                            <tr>
                                                <td class="table-column-pe-0">
                                                    <?php echo $i; ?>
                                                </td>
                                                <td class="table-column-ps-0">
                                                    <?php echo $rows['band']; ?>
                                                </td>
                                                <td class="table-column-ps-0">
                                                    <?php echo number_format($rows['salary']); ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-outline-secondary" href="javascript:;" data-bs-toggle="modal" data-bs-target="#newProjectModal<?= $rows['id'] ?>"><i class="bi-pencil"></i></a>
                                                    <div class="modal fade" id="newProjectModal<?= $rows['id'] ?>" tabindex="-1" aria-labelledby="newProjectModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="newProjectModalLabel">Edit Salary Band</h5>
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
                                                            }' action="edit_band" method="post" enctype="multipart/form-data">


                                                                        <!-- Content Step Form -->
                                                                        <div id="createProjectStepFormContent">
                                                                            <div id="createProjectStepDetails" class="active">

                                                                                <!-- Form -->
                                                                                <div class="mb-4">
                                                                                    <label for="clientNewProjectLabel" class="form-label">Salary Band</label>

                                                                                    <div class="row align-items-center">
                                                                                        <div class="col-12 col-md-12 mb-3">
                                                                                            <div class="input-group input-group-merge">
                                                                                                <input class="form-control" id="clientNewProjectLabel" placeholder="" name="band" value="<?= $rows['band'] ?>" aria-label="Add creater name">

                                                                                                <input type="hidden" class="form-control" id="clientNewProjectLabel" placeholder="" name="id" value="<?= $rows['id'] ?>" aria-label="Add creater name">
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- End Col -->
                                                                                    </div>
                                                                                    <input class="form-control" id="price" placeholder="" name="salary" value="<?= $rows['salary'] ?>" aria-label="Add creater name">
                                                                                    <!-- End Row -->
                                                                                </div>
                                                                                <!-- End Form -->

                                                                                <!-- Footer -->
                                                                                <div class="d-flex align-items-center mt-5">
                                                                                    <div class="ms-auto">
                                                                                        <button type="submit" class="btn btn-primary" data-hs-step-form-next-options='{
                                                                        "targetSelector": "#createProjectStepTerms"
                                                                        }' name="edit_industry">
                                                                                            Save
                                                                                        </button>
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
                    <?php } ?>
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
    <script src="./assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="./assets/vendor/datatables.net.extensions/select/select.min.js"></script>
    <script src="./assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="./assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="./assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
    <script src="./assets/vendor/imask/dist/imask.min.js"></script>
    <script src="./assets/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="./assets/vendor/datatables.net-buttons/js/buttons5.min.js"></script>
    <script src="./assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="./assets/vendor/datatables.net-buttons/js/buttons.colVis.min.js"></script>

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

                $.ajax({
                    type: "POST",
                    url: "check_salary_details",
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

            $("#salary").on("keyup", function() {
                var inputValue = $(this).val();
                var cleanedValue = inputValue.replace(/,/g, ''); // Remove all commas from the input value
                $(this).val(cleanedValue);
            });
            $("#price").on("keyup", function() {
                var inputValue = $(this).val();
                var cleanedValue = inputValue.replace(/,/g, ''); // Remove all commas from the input value
                $(this).val(cleanedValue);
            });

        });
    </script>

    <!-- End Style Switcher JS -->
</body>

</html>