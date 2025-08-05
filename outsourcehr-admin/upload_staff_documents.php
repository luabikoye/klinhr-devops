<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}
$candidate_id = base64_decode($_GET['candidate_id']);


$query = "select * from emp_staff_details where candidate_id = '$candidate_id'";
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
    <title>Onboard New Staff | KlinHR</title>

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
                <div class="row align-items-end">
                    <div class="col-sm mb-2 mb-sm-0">

                        <h1 class="page-header-title">Upload Staff Document</h1>
                    </div>
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
                            <button type="button" class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse"
                                data-bs-target="#navbarVerticalNavMenu" aria-label="Toggle navigation"
                                aria-expanded="false" aria-controls="navbarVerticalNavMenu">
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

                    </div>
                    <!-- End Navbar -->
                </div>

                <div class="col-lg-9">
                    <div class="d-grid gap-3 gap-lg-5">
                        <!-- Card -->
                        <div class="card">

                            <!-- Avatar -->
                            <?php if (get_val('jobseeker', 'candidate_id', $row['candidate_id'], 'passport')) {
                            ?>
                            <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar"
                                for="editAvatarUploaderModal">
                                <img id="editAvatarImgModal" class="avatar-img"
                                    src="document/<?php echo get_val('jobseeker', 'candidate_id', $row['candidate_id'], 'passport'); ?>"
                                    alt="Image Description">

                                <input type="file" class="js-file-attach avatar-uploader-input"
                                    id="editAvatarUploaderModal" data-hs-file-attach-options='{
                                        "textTarget": "#editAvatarImgModal",
                                        "mode": "image",
                                        "targetAttr": "src",
                                        "allowTypes": [".png", ".jpeg", ".jpg"]
                                            }'>


                            </label>
                            <?php } else {
                            ?>
                            <label class="avatar avatar-xxl avatar-circle avatar-uploader profile-cover-avatar"
                                for="editAvatarUploaderModal">
                                <img id="editAvatarImgModal" class="avatar-img" src="./assets/img/160x160/img1.jpg"
                                    alt="Image Description">

                                <input type="file" class="js-file-attach avatar-uploader-input"
                                    id="editAvatarUploaderModal" data-hs-file-attach-options='{
                                        "textTarget": "#editAvatarImgModal",
                                        "mode": "image",
                                        "targetAttr": "src",
                                        "allowTypes": [".png", ".jpeg", ".jpg"]
                                            }'>

                            </label>
                            <?php } ?>
                            <!-- End Avatar -->

                            <!-- Body -->
                            <!-- End Bo1dy -->
                        </div>
                        <!-- End Card -->

                        <!-- Card -->
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title h4">FILE DOCUMENT FOR <?php echo $row['firstname']; ?>
                                    <?php echo $row['surname']; ?></h2>
                            </div>

                            <!-- Body -->
                            <div class="card-body">
                                <!-- Form -->
                                <form
                                    action="ProcessStaffDoc.php?candidate_id=<?php echo base64_encode($candidate_id); ?>"
                                    method="post" enctype="multipart/form-data">
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

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Select
                                            Document <i class="bi-question-circle text-body ms-1"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Displayed on public forums, such as Front."></i></label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <select name="evidence" class="form-control">
                                                    <option value="select_document">Select Document</option>
                                                    <?php list_documents(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="emailLabel" class="col-sm-3 col-form-label form-label">Choose
                                            File</label>

                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" name="upload_evidence">
                                        </div>

                                        <input type="hidden" name="candidate_id" value="<?php echo ($candidate_id); ?>">
                                    </div>
                                    <!-- End Form -->


                                    <div class="d-flex justify-content-end">
                                        <button type="submit" name="verify" class="btn btn-primary">Upload File</button>
                                    </div>
                                </form>
                                <!-- End Form -->
                            </div>
                            <!-- End Body -->
                        </div>
                        <!-- End Card -->



                        <!-- Card -->
                        <div id="recentDevicesSection" class="card">
                            <div class="card-header">
                                <h4 class="card-title">Uploaded Document</h4>
                            </div>

                            <!-- Body -->
                            <div class="card-body">
                                <!-- <p class="card-text">View and manage devices where you're currently logged in.</p> -->
                            </div>
                            <!-- End Body -->

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-thead-bordered table-nowrap table-align-middle card-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>S/n</th>
                                            <th>Document Name</th>
                                            <?php
                                            if (privilege() == 'Super Admin') {
                                            ?>
                                            <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $credentials_query = "select * from verified_document where candidate_id = '$candidate_id' order by id desc";
                                        $credentials_result = mysqli_query($db, $credentials_query);
                                        $credentials_num = mysqli_num_rows($credentials_result);

                                        for ($i = 0; $i < $credentials_num; $i++) {
                                            $credentials_row = mysqli_fetch_array($credentials_result);

                                        ?>
                                        <tr>
                                            <td class="align-items-center">
                                                <?php echo $i + 1; ?>
                                            </td>
                                            <td><?php echo ucwords($credentials_row['document_name']); ?></td>
                                            <?php
                                                if (privilege() == 'Super Admin') {
                                                ?>
                                            <td>
                                                <a style="margin-right: 15px; " data-toggle="tooltip"
                                                    data-placement="top" title="View Document"
                                                    class="btn btn-sm btn-outline-success"
                                                    href="<?php echo FILE_DIR; ?>verified_documents/<?= ($credentials_row['filepath']); ?>"
                                                    target="_blank"><i class="bi-eye"></i>
                                                </a>
                                                <a data-toggle="tooltip" data-placement="top"
                                                    data-original-title="Upload Evidence Of"
                                                    class="btn btn-sm btn-outline-danger"
                                                    href="delete-document?id=<?php echo base64_encode($credentials_row['id']); ?>&candidate_id=<?= base64_encode($candidate_id) ?>"
                                                    onclick="return confirm('Are you sure you want to delete this file?');"><i
                                                        class="bi-trash"></i></a>
                                            </td>
                                            <?php  } ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->
                        </div>
                        <!-- End Card -->

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
    <?php include('inc/modal-activity.php') ?>
    <!-- End Welcome Message Modal -->
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
                targetSelector: document.getElementById('header').classList.contains('navbar-fixed') ?
                    '#header' : null
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
    <link rel="stylesheet" href="toastr/toastr.min.css">
    <script src="toastr/toastr.js"></script>
    <?php
    if (isset($_POST['del']) == 'success') {
        if ($num < 1) {
    ?>
    <script type="text/javascript">
    $(function() {
        toastr.options.closeButton = true;
        toastr.options.positionClass = 'toast-bottom-right';
        toastr['error']('File Deleted', );
    });
    </script>
    <?php }
    } ?>
    <!-- End Style Switcher JS -->
</body>


</html>