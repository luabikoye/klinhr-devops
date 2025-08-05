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

if ($_GET['unique']) {
    $id = $_GET['unique'];
}

$query = "select * from job_post where id = '$id'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);

$query2 = "select * from recruitment_plan where job_post_id = '$id'";
$result2 = mysqli_query($db, $query2);
$row2 = mysqli_fetch_array($result2);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Edit Job | KlinHR</title>

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
            <form class="js-step-form py-md-5" action="edit-prev-job" method="post" enctype="multipart/form-data" data-hs-step-form-options='{
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
                                    <div class="step-content">
                                        <h3 class="">Edit job: <?php echo $row['job_title'] ?></h3>
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
                                    <div class="row mb-4">
                                        <label class="col-sm-3 col-form-label form-label">Job Image</label>

                                        <div class="col-sm-9">
                                            <div class="d-flex align-items-center">
                                                <!-- Avatar -->
                                                <label class="avatar avatar-xl avatar-circle avatar-uploader me-5" for="avatarUploader">
                                                    <img id="avatarImg" class="avatar-img" src="../uploads/jOBS_IMAGE/JOB<?php echo $row['job_image'] ?>" alt="Image Description">

                                                    <input type="file" class="js-file-attach avatar-uploader-input" name="job_image" id="avatarUploader" data-hs-file-attach-options='{
                                    "textTarget": "#avatarImg",
                                    "mode": "image",
                                    "targetAttr": "src",
                                    "resetTarget": ".js-file-attach-reset-img",
                                    "resetImg": "../uploads/jOBS_IMAGE/JOB<?php echo $row['job_image'] ?>",
                                    "allowTypes": [".png", ".jpeg", ".jpg"]
                                 }'>

                                                    <span class="avatar-uploader-trigger">
                                                        <i class="bi-pencil avatar-uploader-icon shadow-sm"></i>
                                                    </span>
                                                </label>
                                                <!-- End Avatar -->

                                                <button type="button" class="js-file-attach-reset-img btn btn-white">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Job Title <i class="bi-question-circle text-body ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Displayed on public forums, such as Front."></i></label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="job_title" id="firstNameLabel" placeholder="Clarice" aria-label="Clarice" value="<?php echo $row['job_title'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form -->


                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Industry</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <select class="js-select form-select" id="locationLabel" name="category">
                                                    <option><?php echo $row['category']; ?></option>
                                                    <option></option>
                                                    <!-- <option value="" selected>Select Indutry</option> -->
                                                    <?php list_val('category', 'industry', 'industry'); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- End Form -->


                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="locationLabel" class="col-sm-3 col-form-label form-label">Minimum Qualification</label>

                                            <div class="col-sm-9">
                                                <!-- Select -->
                                                <div class="tom-select-custom mb-4">
                                                    <select class="js-select form-select" id="locationLabel" name="qualification">
                                                        <option value="" selected>Select Qualification</option>
                                                        <option <?php if ($row['qualification'] == 'BACHELOR DEGREE') {
                                                                    echo 'selected';
                                                                } ?> value="BACHELOR DEGREE">BACHELOR DEGREE</option>
                                                        <option <?php if ($row['qualification'] == 'BACHELOR DEGREE, MASTERS') {
                                                                    echo 'selected';
                                                                } ?> value="BACHELOR DEGREE, MASTERS">BACHELOR DEGREE, MASTERS</option>
                                                        <option <?php if ($row['qualification'] == 'OND, HND, BACHELOR') {
                                                                    echo 'selected';
                                                                } ?> value="OND, HND, BACHELOR">OND, HND, BACHELOR</option>
                                                        <option <?php if ($row['qualification'] == 'HND, BACHELOR') {
                                                                    echo 'selected';
                                                                } ?> value="HND, BACHELOR">HND, BACHELOR</option>
                                                        <option <?php if ($row['qualification'] == 'MASTERS') {
                                                                    echo 'selected';
                                                                } ?> value="MASTERS">MASTERS</option>
                                                        <option <?php if ($row['qualification'] == 'PHD') {
                                                                    echo 'selected';
                                                                } ?> value="PHD">PHD</option>
                                                        <option <?php if ($row['qualification'] == 'HND') {
                                                                    echo 'selected';
                                                                } ?> value="HND">HND</option>
                                                        <option <?php if ($row['qualification'] == 'OND') {
                                                                    echo 'selected';
                                                                } ?> value="OND">OND</option>
                                                        <option <?php if ($row['qualification'] == 'NCE') {
                                                                    echo 'selected';
                                                                } ?> value="NCE">NCE</option>
                                                        <option <?php if ($row['qualification'] == 'HIGH SCHOOL (S.S.C.E)') {
                                                                    echo 'selected';
                                                                } ?> value="HIGH SCHOOL (S.S.C.E)">HIGH SCHOOL (S.S.C.E)</option>
                                                        <option <?php if ($row['qualification'] == 'OTHERS') {
                                                                    echo 'selected';
                                                                } ?> value="OTHERS">OTHERS</option>
                                                    </select>
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                        </div>
                                        <!-- End Form -->


                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="locationLabel" class="col-sm-3 col-form-label form-label">Experience</label>

                                            <div class="col-sm-9">
                                                <!-- Select -->
                                                <div class="tom-select-custom mb-4">
                                                    <select class="js-select form-select" id="locationLabel" name="experience">
                                                        <?php if ($experience) { ?>
                                                            <option value="<?= $experience ?>"><?= $experience ?></option>
                                                        <?php } ?>
                                                        <option value="" disabled>Select Experience</option>
                                                        <option value="Entry Level" <?php if ($row['experience'] == 'Entry level') {
                                                                                        echo 'selected';
                                                                                    } ?>>Entry Level</option>
                                                        <option value="0 - 1 year" <?php if ($row['experience'] == '0 - 1') {
                                                                                        echo 'selected';
                                                                                    } ?>>0 - 1 year</option>
                                                        <option value="1 - 3 years" <?php if ($row['experience'] == '1 - 3') {
                                                                                        echo 'selected';
                                                                                    } ?>>1 - 3 years</option>
                                                        <option value="3 - 5 years" <?php if ($row['experience'] == '3 - 5') {
                                                                                        echo 'selected';
                                                                                    } ?>>3 - 5 years</option>
                                                        <option value="5 - 7 years" <?php if ($row['experience'] == '5 - 7') {
                                                                                        echo 'selected';
                                                                                    } ?>>5 - 7 years</option>
                                                        <option value="7 - 10 years" <?php if ($row['experience'] == '7 - 10') {
                                                                                            echo 'selected';
                                                                                        } ?>>7 - 10 years</option>
                                                        <option value="10 - 15 years" <?php if ($row['experience'] == '10 - 15') {
                                                                                            echo 'selected';
                                                                                        } ?>>10 - 15 years</option>
                                                        <option value="15+" <?php if ($row['experience'] == '15+') {
                                                                                echo 'selected';
                                                                            } ?>>15+</option>
                                                    </select>
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                        </div>
                                        <!-- End Form -->
                                        <!-- End Form -->



                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="locationLabel" class="col-sm-3 col-form-label form-label">Clients</label>

                                            <div class="col-sm-9">
                                                <!-- Select -->
                                                <div class="tom-select-custom mb-4">
                                                    <select class="js-select form-select" id="locationLabel" name="client_name">
                                                        <option value="<?php echo $row['client_id']; ?>">
                                                            <?php echo get_val('clients', 'id', $row['client_id'], 'client_name'); ?>
                                                        </option>
                                                        <option value=""></option>
                                                        <!-- <option value="" selected>Select Clients</option> -->
                                                        <?php list_val('clients', 'client_name', 'id'); ?>
                                                    </select>
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="locationLabel" class="col-sm-3 col-form-label form-label">Clients Logo</label>

                                            <!-- clients logo  -->
                                            <div class="col-sm-9">
                                                <div class="input-group input-group-sm-vertical">
                                                    <!-- Radio Check -->
                                                    <label class="form-control" for="userAccountTypeRadio1">
                                                        <span class="form-check">
                                                            <input type="checkbox" class="form-check-input" name="show_client" value="yes" id="userAccountTypeRadio1" <?php if ($row['show_client']) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                            <span class="form-check-label">Display client logo on career portal</span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- / clients logo  -->
                                        </div>
                                        <!-- End Form -->



                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="locationLabel" class="col-sm-3 col-form-label form-label">State</label>

                                            <div class="col-sm-9">
                                                <!-- Select -->
                                                <div class="tom-select-custom mb-4">
                                                    <select class="js-select form-select" multiple id="locationLabel" name="state">
                                                        <option selected><?php echo $row['state']; ?></option>
                                                        <option></option>
                                                        <!-- <option value="" selected>Select state</option> -->
                                                        <?php list_val_distinct('local_govt', 'state'); ?>
                                                    </select>
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="locationLabel" class="col-sm-3 col-form-label form-label">Job Type</label>

                                            <div class="col-sm-9">
                                                <!-- Select -->
                                                <div class="tom-select-custom mb-4">
                                                    <select class="js-select form-select" id="locationLabel" name="job_type" required>
                                                        <option selected><?php echo $row['job_type']; ?></option>
                                                        <option value=""></option>
                                                        <!-- <option value="" selected>Select Job Type</option> -->
                                                        <option value="Full time">Full time</option>
                                                        <option value="Part time">Part time</option>
                                                        <option value="Hybrid">Hybrid</option>
                                                        <option value="Remote">Remote</option>
                                                    </select>
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="locationLabel" class="col-sm-3 col-form-label form-label">Application Type</label>

                                            <div class="col-sm-9">
                                                <!-- Select -->
                                                <div class="tom-select-custom mb-4">
                                                    <select class="js-select form-select" required id="locationLabel" name="application_type">
                                                        <option selected><?php echo $row['application_type']; ?></option>
                                                        <option value=""></option>
                                                        <!-- <option value="" selected>Select Application Type</option> -->
                                                        <option value="Professional">Professional</option>
                                                        <option value="Artisan">Artisan</option>
                                                    </select>
                                                </div>
                                                <!-- End Select -->
                                            </div>
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->

                                        <div class="row mb-4">
                                            <label for="organizationLabel" class="col-sm-3 col-form-label form-label">Salary</label>

                                            <div class="col-sm-9">
                                                <input type="text" required class="form-control" name="salary" id="organizationLabel" placeholder="N300,000 monthly. Negotiable" aria-label="Htmlstream" value="<?php echo $row['salary'] ?>">
                                            </div>
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="departmentLabel" class="col-sm-3 col-form-label form-label">Date Posted</label>

                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" required name="date_posted" id="departmentLabel" placeholder="Date Posted" aria-label="Human resources" value="<?php echo $row['date_posted']; ?>">
                                            </div>
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="row mb-4">
                                            <label for="departmentLabel" class="col-sm-3 col-form-label form-label">Deadline</label>

                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" required name="deadline" id="departmentLabel" placeholder="Deadline" aria-label="Human resources" value="<?php echo $row['deadline']; ?>">
                                            </div>
                                        </div>
                                        <!-- End Form -->

                                        <!-- Quill -->
                                        <div class="mb-4">
                                            <label class="form-label">Job Purpose</label>

                                            <!-- Quill -->
                                            <div class="quill-custom">
                                                <textarea name="description" id="description" required>
                                                    <?php echo $row['description'] ?>
                                                </textarea>
                                                <script>
                                                    CKEDITOR.replace('description');
                                                </script>
                                            </div>
                                            <!-- End Quill -->
                                        </div>
                                        <!-- End Quill -->

                                        <!-- Quill -->
                                        <div class="mb-4">
                                            <label class="form-label">Responsibilities</label>

                                            <!-- Quill -->
                                            <div class="quill-custom">
                                                <textarea name="responsibilities" id="responsibilities" required>
                                                    <?php echo $row['responsibilities'] ?>
                                                </textarea>
                                                <script>
                                                    CKEDITOR.replace('responsibilities');
                                                </script>
                                            </div>
                                            <!-- End Quill -->
                                        </div>
                                        <!-- End Quill -->


                                        <!-- Quill -->
                                        <div class="mb-4">
                                            <label class="form-label">Requirements</label>

                                            <!-- Quill -->
                                            <div class="quill-custom">
                                                <textarea name="qualification_requirement" id="qualification_requirement" required>
                                                    <?php echo $row['qualification_requirement'] ?>
                                                </textarea>
                                                <script>
                                                    CKEDITOR.replace('qualification_requirement');
                                                </script>
                                            </div>
                                            <!-- End Quill -->
                                        </div>
                                        <!-- End Quill -->

                                        <!-- Form -->
                                        <!-- End Form -->
                                    </div>
                                    <!-- End Body -->

                                    <!-- Footer -->
                                    <div class="card-footer d-flex align-items-center">
                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                        <button type="submit" class="btn btn-primary">
                                            Save Job Post
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

    <!-- End Style Switcher JS -->
</body>

</html>