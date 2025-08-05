<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Payroll');
$month = date('F');
$year = date('Y');
$pay_month = date('F-Y');

$pay_token = $_GET['token'];
$payroll_mail = $_SESSION['payroll_mail'];
if ($_SESSION['role'] == "Super Admin" || $_GET['email'] == payroll_mail()) {
    if ($_GET['search']) {

        $search = $_GET['search'];
        $empSQL = "SELECT * FROM employees where pay_token= '$pay_token' ";
    } else {
        $empSQL = "SELECT * FROM employees where pay_token= '$pay_token' ";
    }
} else {
    if ($_GET['search']) {

        $search = $_GET['search'];

        $empSQL = "SELECT * FROM employees where pay_token= '$pay_token' ";
    } else {
        $empSQL = "SELECT * FROM employees where pay_token= '$pay_token'order by id desc  ";
    }
}

$empResult = mysqli_query($db, $empSQL);
$num = mysqli_num_rows($empResult);
$qr2 = "select * from clients";
$res2 = mysqli_query($db, $qr2);
$numb = mysqli_num_rows($res2);

$select2 = "select SUM(salary), SUM(paye) from employees where pay_token = '$pay_token'";
$result2 = mysqli_query($db, $select2);
$row2 = mysqli_fetch_assoc($result2);
$total_salary = ($row2['SUM(salary)']);
$total_paye = ($row2['SUM(paye)']);

$empSQL2 = "SELECT * FROM employees where pay_token= '$pay_token'order by id desc  ";
$empResult2 = mysqli_query($db, $empSQL2);
$row2 = mysqli_fetch_assoc($empResult2);
$current = date('F');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Employee Salary | KlinHR</title>

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
    <link rel="stylesheet" href="toastr/toastr.min.css">


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
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <h1 class="page-header-title">Employee Payroll Schedule for <?= $row['pay_month'] ?></h1>
                    </div>
                    <!-- End Col -->

                    <div class="col-md-auto">
                        <a type="button" class="btn btn-danger btn-sm mx-1" href="emp_salary">
                            <i class="bi bi-skip-backward-fill"></i> Go Back
                        </a>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Page Header -->


            <div class="page-header">

                <!-- Nav -->
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        Staff <span class="badge bg-soft-dark text-dark ms-1"><?php echo number_format($num) ?></span>
                    </li>
                    <li class="nav-item mx-1">
                        Total Gross Pay <span class="badge bg-soft-dark text-dark ms-1"><?php echo number_format($total_salary) ?></span>
                    </li>
                    <li class="nav-item mx-1">
                        Total Net Pay <span class="badge bg-soft-dark text-dark ms-1"><?php echo number_format($total_paye) ?></span>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- Card -->
            <div class="card">
                <!-- Header -->
                <!-- Header -->
                <div class="card-header card-header-content-md-between">
                    <div class="mb-2 mb-md-0">
                        <form>
                            <!-- Search -->
                            <div class="input-group input-group-merge input-group-flush">
                                <div class="input-group-prepend input-group-text">
                                    <i class="bi-search"></i>
                                </div>
                                <input id="searchInput" type="search" class="form-control" placeholder="Search users" aria-label="Search users">
                            </div>
                            <!-- End Search -->
                        </form>
                    </div>

                    <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">

                        <?php
                        if (!$payroll_mail) {
                        ?>
                            <!-- Datatable Info -->
                            <div id="datatableCounterInfo">
                                <div class="d-flex align-items-center">
                                    <?php if ($row2['status'] == 'pending') { ?>
                                        <a href="approve-mail?token=<?= $pay_token ?>" type="button" class="btn btn-outline-primary btn-sm">
                                            Send For Approval <i class=" bi-send"></i>
                                        </a>
                                    <?php } elseif ($row2['status'] == 'sent for approval') { ?>
                                        <a href="approve-mail?token=<?= $pay_token ?>" type="button" class="btn btn-outline-primary btn-sm">
                                            Resend For Approval <i class=" bi-send"></i>
                                        </a>
                                    <?php } else { ?>
                                        <a href="#" type="button" class="btn btn-outline-primary btn-sm">
                                            Approval Accepted
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } else {
                            if ($row2['status'] == 'approved') {
                            ?>
                                <a href="#" type="button" class="btn btn-outline-primary btn-sm">
                                    Approval Accepted
                                </a>
                            <?php } else { ?>
                                <a href="approve-employees-payroll.php?token=<?= $pay_token ?>" type="button" class="btn btn-outline-primary btn-sm">
                                    Approve Payroll <i class=" bi-send"></i>
                                </a>
                        <?php }
                        } ?>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-danger btn-sm" id="sendEmailInvite" type="button" onclick="window.location.href='export-payroll?token=<?= $pay_token ?>'" data-toggle="tooltip" data-placement="top" title="Export Payroll for <?php echo date('F, Y'); ?>" data-bs-toggle="offcanvas" data-bs-target="#offcanvasKeyboardShortcuts" data-target="#emailInvite" aria-controls="offcanvasKeyboardShortcuts">
                                <i class=" bi bi-folder"></i> Export All
                            </button>
                        </div>
                        <!-- End Datatable Info -->
                    </div>
                </div>
                <!-- End Header -->

                <!-- Table -->
                <div class="table-responsive datatable-custom">
                    <table id="datatable" class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table" data-hs-datatables-options='{
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
                        <?php if ($_GET['success']) echo '<div class="alert alert-success"><strong>Success: </strong>Staff Added.</div>'; ?>
                        <?php if ($_GET['error']) echo '<div class="alert alert-danger"><strong>Error: </strong>Staff not Added.</div>'; ?>


                        <thead class="thead-light">
                            <tr>
                                <th class="table-column-pe-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="datatableCheckAll">
                                        <label class="form-check-label" for="datatableCheckAll"></label>
                                    </div>
                                    <!-- S/N &nbsp;&nbsp;&nbsp;&nbsp; -->
                                </th>
                                <th class="table-column-ps-0">Name</th>
                                <th class="table-column-ps-0">Employee ID</th>
                                <th class="table-column-ps-0">Role</th>
                                <th class="table-column-ps-0">Salary</th>
                                <th class="table-column-ps-0">PAYE</th>
                                <th class="table-column-ps-0">Pension</th>
                                <?php
                                if (privilege() == 'Super Admin') {
                                ?>
                                    <th class="table-column-ps-0">Action</th>
                                <?php } ?>
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
            <!-- End Card -->


        </div>
        <!-- End Content -->

        <!-- Footer -->

        <?php include('inc/footer.php') ?>

        <!-- End Footer -->
        <?php include('inc/modal-activity.php') ?>
    </main>

    <!-- JS Global Compulsory  -->
    <script src="./assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="./assets/vendor/jquery-migrate/dist/jquery-migrate.min.js"></script>
    <script src="./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS Implementing Plugins -->
    <script src="./assets/vendor/hs-navbar-vertical-aside/dist/hs-navbar-vertical-aside.min.js"></script>
    <script src="./assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>

    <script src="./assets/vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js"></script>
    <script src="./assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
    <script src="./assets/vendor/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="./assets/vendor/imask/dist/imask.min.js"></script>
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


                // INITIALIZATION OF ADD FIELD
                // =======================================================
                new HSAddField('.js-add-field', {
                    addedField: field => {
                        HSCore.components.HSTomSelect.init(field.querySelector('.js-select-dynamic'))
                        HSCore.components.HSMask.init(field.querySelector('.js-input-mask'))
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

    <link rel="stylesheet" href="toastr/toastr.min.css">
    <script src="toastr/toastr.js"></script>
    <?php
    if ($_GET['sent'] == '2') {
    ?>
        <script type="text/javascript">
            $(function() {
                toastr.options.closeButton = true;
                toastr.options.positionClass = 'toast-bottom-right';
                toastr['success']('Payslip sent successfully', );
            });
        </script>
    <?php }
    if ($_GET['sent'] == '1') {
    ?>
        <script type="text/javascript">
            $(function() {
                toastr.options.closeButton = true;
                toastr.options.positionClass = 'toast-bottom-right';
                toastr['success']('<?php echo $num2; ?> result<?php if ($num2 > 1) echo 's'; ?> found', );
            });
        </script>
    <?php }
    ?>

    <!-- Error -->

    <?php if ($_GET['approve'] == 'success') { ?>
        <script>
            $(function() {
                toastr.options.closeButton = true;
                toastr.options.positionClass = 'toast-bottom-right';
                toastr['success']('Payroll Sent For Approval', );
            });
        </script>
    <?php } ?>

    <?php if ($_GET['approve'] == 'error') { ?>
        <script>
            $(function() {
                toastr.options.closeButton = true;
                toastr.options.positionClass = 'toast-bottom-right';
                toastr['error']('Payroll Not Sent For Approval', );
            });
        </script>
    <?php } ?>

    <?php if ($_GET['sent'] == 3) { ?>
        <script>
            $(function() {
                toastr.options.closeButton = true;
                toastr.options.positionClass = 'toast-bottom-right';
                toastr['success']('Payroll computed successfully', );
            });
        </script>
    <?php } ?>




    <!-- End Style Switcher JS -->
    <script>
        localStorage.setItem('userPrivilege', '<?php echo privilege(); ?>');
    </script>

    <script src="emp_month.js"></script>

    <script>
        
    </script>
</body>

</html>