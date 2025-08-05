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
if ($_GET['d'] || $_GET['upload']) {
    if ($_GET['d']) {
        $id = base64_decode($_GET['d']);
    } else {
        $id = $_GET['upload'];
    }
    // echo "select * from qa where refID = '$id' order by id asc";
    $qsPhase = mysqli_query($db, "select * from qa where refID = '$id' order by id asc");
    $nsPhase = mysqli_fetch_assoc($qsPhase);
    $question = explode(',', $nsPhase['question']);

    $question1 = $question[0];
    $question2 = $question[1];
    $question3 = $question[2];
    $question4 = $question[3];

    $option1 = $optionA[0];
    $option2 = $optionA[1];
    $option3 = $optionA[2];
    $option4 = $optionA[3];

    $option1 = $optionB[0];
    $option2 = $optionB[1];
    $option3 = $optionB[2];
    $option4 = $optionB[3];

    $answer1 = $answer[0];
    $answer2 = $answer[1];
    $answer3 = $answer[2];
    $answer4 = $answer[3];
    // echo "select * from questionnaire where refID = '$id'";exit;
    $qsID = mysqli_query($db, "select * from questionnaire where refID = '$id'");
    $rsID = mysqli_fetch_assoc($qsID);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Add Questionnaire | KlinHR</title>

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
            <form class="js-step-form py-md-5" action="processQuestionnaire" method="post" enctype="multipart/form-data" data-hs-step-form-options='{
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
                                        <h3 class=" text-black">Add Question</h3>
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
                                    <?php
                                    if ($_GET['success'] == '1') {
                                        echo '<div class="alert alert-success">Question updated</div>';
                                    }

                                    if ($_GET['success'] == '2') {
                                        echo '<div class="alert alert-success">Question Added</div>';
                                    }
                                    ?>
                                    <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>


                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="firstNameLabel" class="col-sm-3 col-form-label form-label">Title</label>

                                        <div class="col-sm-9">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="name" id="firstNameLabel" placeholder="Title" aria-label="" value="<?= $rsID['question'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <label for="locationLabel" class="col-sm-3 col-form-label form-label">Questionnaire For</label>

                                        <div class="col-sm-9">
                                            <!-- Select -->
                                            <div class="tom-select-custom mb-4">
                                                <select data-hs-tom-select-options='{
                                            "placeholder": "Select option"
                                        }' class="js-select form-select" id="locationLabel" name="type">
                                                    <option value="">Select option</option>
                                                    <option value="Pre Evaluation" <?php if ($rsID['type'] == 'Pre Evaluation') {
                                                                                        echo 'selected';
                                                                                    } ?>>Pre Evaluation</option>
                                                    <option value="Post Evaluation" <?php if ($rsID['type'] == 'Post Evaluation') {
                                                                                        echo 'selected';
                                                                                    } ?>>Post Evaluation</option>
                                                </select>
                                            </div>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <!-- End Form -->

                                    <!-- Form -->
                                    <div class="row mb-4">
                                        <!-- Quill -->
                                        <div class="mb-4">
                                            <label class="form-label">Description</label>

                                            <!-- Quill -->
                                            <div class="quill-custom">
                                                <textarea name="description" id="description" required><?php if ($rsID['description']) {
                                                                                                            echo $rsID['description'];
                                                                                                        } else { ?>
                                                                Hello there,
                                                                <br/>
                                                                <p>Please try to <b>paste some texts</b> here</p>
                                                                <?php } ?></textarea>
                                                <script>
                                                    CKEDITOR.replace('description');
                                                </script>
                                            </div>
                                            <!-- End Quill -->
                                        </div>
                                        <!-- End Quill -->

                                    </div>
                                    <div class="row mb-4">
                                        <label for="firstNameLabel" class="col-sm-2 col-form-label form-label">1<sup>st</sup> Question and Answer</label>

                                        <div class="col-sm-4">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="question" id="course" placeholder="" aria-label="" value="<?php echo $question1 ?>">
                                            </div>
                                            <a href="javascript:;" id="show"> [<i class="bi-plus"></i>] Add Another Question </a>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="optionA" id="course" placeholder="A" aria-label="" value="<?php echo $optionA1 ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="optionB" id="course" placeholder="B" aria-label="" value="<?php echo $optionB2 ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="answer" id="course" placeholder="Answer" aria-label="" value="<?php echo $answer1 ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4" id="first">
                                        <label for="firstNameLabel" class="col-sm-2 col-form-label form-label">2<sup>nd</sup> Question and answer</label>

                                        <div class="col-sm-4">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="question2" id="course2" placeholder="Question" aria-label="" value="<?= $question2 ?>">

                                            </div>
                                            <a href="javascript:;" id="show1"> [<i class="bi-plus"></i>] Add Another Question </a>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="optionA2" id="course" placeholder="A" aria-label="" value="<?php echo $optionA2 ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="optionB2" id="course" placeholder="B" aria-label="" value="<?php echo $optionB2 ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="answer2" id="course" placeholder="Answer" aria-label="" value="<?php echo $course[0] ?>">
                                                <a href="javascript:;" id="remove1" class="btn btn-danger"><i class=" bi-trash"></i></a>
                                            </div>
                                        </div>
                                        <!-- <a href=" javascript:;" id="remove1"><i class=" bi-trash"></i></a> -->

                                    </div>
                                    <div class="row mb-4" id="second">
                                        <label for="firstNameLabel" class="col-sm-2 col-form-label form-label">3<sup>rd</sup> Question and Answer</label>

                                        <div class="col-sm-4">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="question3" id="course3" placeholder="Question" aria-label="" value="<?= $question3 ?>">
                                            </div>
                                            <a href="javascript:;" id="show2"> [<i class="bi-plus"></i>] Add Another Question </a>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="optionA3" id="course" placeholder="A" aria-label="" value="<?php echo $optionA3 ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="optionB3" id="course" placeholder="B" aria-label="" value="<?php echo $optionB3 ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="answer3" id="course" placeholder="Answer" aria-label="" value="<?php echo $answer3 ?>">
                                                <a href=" javascript:;" id="remove2" class="btn btn-danger"><i class=" bi-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4" id="third">
                                        <label for="firstNameLabel" class="col-sm-2 col-form-label form-label">4<sup>th</sup> Question and Answer</label>

                                        <div class="col-sm-4">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="question4" id="course4" placeholder="Question" aria-label="" value="<?= $question4 ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="optionA4" id="course" placeholder="A" aria-label="" value="<?php echo $optionA4 ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" name="optionB4" id="course" placeholder="B" aria-label="" value="<?php echo $optionB4 ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="input-group input-group-sm-vertical">
                                                <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="answer4" id="course" placeholder="Answer" aria-label="" value="<?php echo $answer4 ?>">
                                                <a href=" javascript:;" id="remove3" class="btn btn-danger"><i class=" bi-trash"></i></a>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- End Body -->

                                    <!-- Footer -->

                                    <div class="card-footer d-flex align-items-center">

                                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                        <button type="submit" class="btn btn-primary">
                                            <?php if ($id) {
                                                echo 'Save Changes';
                                            } else {
                                                echo 'Add Questionnaire';
                                            } ?>
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


    <script>
        $(function() {
            if (!$('#course2').val()) {
                $('#first').hide();
            }
            if (!$('#course3').val()) {
                $('#second').hide();
            }
            if (!$('#course4').val()) {
                $('#third').hide();
            }


            //show
            $('#show').click(function() {
                $('#first').show();
            })
            $('#show1').click(function() {
                $('#second').show();
            })
            $('#show2').click(function() {
                $('#third').show();
            })

            //hide
            $('#remove1').click(function() {
                $('#first').hide();
                $('#course2').val('');
            })
            $('#remove2').click(function() {
                $('#second').hide();
                $('#course3').val('');
            })
            $('#remove3').click(function() {
                $('#third').hide();
                $('#course4').val('');
            })

        })
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