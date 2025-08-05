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


if ($_GET['id']) {

    $query = "select * from emp_leave_form where id = '$id'  ";
} else {
    header('Location: index');
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
    <title>View Reason | KlinHR</title>

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

                        <h1 class="page-header-title"><?php echo get_names($row['staff_id']); ?>(<?= $row['staff_id']; ?>)</h1>
                    </div>
                    <!-- End Col -->
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

                    </div>
                    <!-- End Navbar -->
                </div>

                <div class="col-lg-12">
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

                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form -->
                                <div>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">TOTAL LEAVE SCHEDULE IS <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Displayed on public forums, such as Front."></i></label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="firstName" readonly id="firstNameLabel" placeholder="Sur Name" aria-label="Your first name" value="<?php echo total_schedule($row['staff_id']); ?>
                                                            days">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="emailLabel" class="col-sm-3 col-form-label form-label">Email</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email" id="emailLabel" readonly placeholder="Email" aria-label="Email" value="<?= ucwords($row['email']) ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="phoneLabel" class="col-sm-3 col-form-label form-label">Manager <span class="form-label-secondary"></span></label>

                                        <div class="col-sm-9">
                                            <input type="text" class="js-input-mask form-control" name="phone" id="phoneLabel" readonly placeholder="+x(xxx)xxx-xx-xx" aria-label="+x(xxx)xxx-xx-xx" value="<?= $row['manager'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="organizationLabel" class="col-sm-3 col-form-label form-label">Manager Email</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="organization" readonly id="organizationLabel" placeholder="Client" aria-label="Your organization" value="<?= $row['manager_email'] ?>">
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="departmentLabel" class="col-sm-3 col-form-label form-label">Job Role</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="department" id="departmentLabel" placeholder="Marital Status" aria-label="Your department" value="<?= $row['job_role'] ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div id="accountType" class="row mb-4">
                                        <label class="col-sm-3 col-form-label form-label">Job Location</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="department" id="departmentLabel" placeholder="" aria-label="Your department" value="<?= $row['job_location'] ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Type of Leave</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="department" id="departmentLabel" placeholder="" aria-label="Your department" value="<?= ($row['leave_type']) ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                </div>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div id="other" class="card">

                            <!-- Body -->
                            <div class="card-body">

                                <!-- Form -->
                                <div>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">Date
                                            Applied</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" readonly name="newEmail" id="newEmailLabel" placeholder="" aria-label="Enter new email address" value="<?= $row['letter_date'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">Local Government</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="newEmail" id="newEmailLabel" placeholder="" readonly aria-label="Enter new email address" value="<?php if ($row['start_date'] != '0000-00-00') {
                                                                                                                                                                                                echo stripslashes($row['start_date']);
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo stripslashes($row['purpose']);
                                                                                                                                                                                            } ?>">
                                        </div>
                                    </div>
                                    <div class=" row mb-4">
                                        <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">End
                                            Date</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="newEmail" id="newEmailLabel" placeholder="" aria-label="Enter new email address" value="<?= $row['end_date'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">Resumption
                                            Date</label>

                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="newEmail" id="newEmailLabel" placeholder="" aria-label="Enter new email address" value="<?= $row['resumption_date'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label for="newEmailLabel" class="col-sm-3 col-form-label form-label">Purpose Of Leave</label>

                                        <div class="col-sm-9">
                                            <div type="email" class="form-control" id="newEmailLabel"><?= stripslashes($row['purpose']) ?></div>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                </div>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <form action="approve_leave" method="post" id="Address" class="card">
                            <div class="card-header">
                                <h4 class="card-title">If you are
                                    declining this leave,
                                    please
                                    state reasons below</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form -->
                                <div id="changetextForm">
                                    <!-- Form -->
                                    <div class="row mb-4">

                                        <div class="col-sm-9">
                                            <textarea style="width:100%;" rows="4"
                                                name="reason_txt"></textarea>
                                        </div>
                                        <?php $queryp = "select * from emp_leave_form where staff_id='" . $row['staff_id'] . "'";
                                        $resultp = mysqli_query($db, $queryp);
                                        $num_resultp = mysqli_num_rows($resultp);

                                        for ($y = 0; $y < $num_resultp; $y++) {
                                            $rowp = mysqli_fetch_array($resultp);
                                        ?>
                                            <li style="list-style-type: none;"><span
                                                    class="emp">From:</span>
                                                <?php echo long_date($rowp['start_date']); ?>&nbsp;&nbsp;&nbsp;
                                                -&nbsp;&nbsp;&nbsp;<span
                                                    class="emp">
                                                    To:</span>
                                                <?php echo long_date($rowp['end_date']); ?>
                                                <span class="emp"></span> --&gt; <a
                                                    onclick="return confirm('This action would cancel this leave. If you wish to continue, click OK')"
                                                    href="remove_plan?id=<?php echo $rowp['id']; ?>&staff_id=<?php echo $rowp['staff_id']; ?>&date_diff=<?php echo $rowp['date_diff']; ?>">Cancel
                                                    Leave</a>
                                            </li>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="d-flex align-items-center mt-5">
                                                <div class="ms-auto">
                                                    <a download
                                                        href="../staffportal/<?php echo $row['image_path']; ?>"
                                                        class="btn btn-primary"
                                                        data-hs-step-form-next-options='{
                                                                                    "targetSelector": "#createProjectStepTerms"
                                                                                    }'>
                                                        Download Signed From
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="d-flex align-items-center mt-5">
                                                <div class="ms-auto">
                                                    <input name="leave_id"
                                                        value="<?php echo $row['id']; ?>"
                                                        type="hidden">
                                                    <input type="submit" name="leave_action"
                                                        class="btn btn-success"
                                                        value="Approve">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="d-flex align-items-center mt-5">
                                                <div class="ms-auto">
                                                    <button type="submit"
                                                        class="btn btn-danger" value="Deny"
                                                        name="leave_action">
                                                        Deny
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- End Form -->
                                </div>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->
                        </form>
                        <!-- End Card -->

                        <!-- Card -->
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