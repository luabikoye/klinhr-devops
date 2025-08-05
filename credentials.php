<?php


ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();

$profile_query = "select * from jobseeker where candidate_id = '" . $_SESSION['candidate_id'] . "' ";
$profile_result = $db->query($profile_query);
$profile_num = mysqli_num_rows($profile_result);
$profile_row = mysqli_fetch_array($profile_result);


$query = "select * from credentials where candidate_id = '" . $_SESSION['candidate_id'] . "' order by id desc ";
$result = $db->query($query);
$num = mysqli_num_rows($result);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Credentials | Job Portal | KlinHR</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="dist/css/bootstrap.css">

    <link href="dist/font-awesome/css/all.css" rel="stylesheet" type="text/css">

    <link rel="icon" href="./dist/images/favicon.png" />

    <link href="dist/css/animate.css" rel="stylesheet">

    <link href="dist/css/owl.carousel.css" rel="stylesheet">

    <link href="dist/css/owl.theme.default.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="dist/js/jquery.3.4.1.min.js"></script>

    <script src="dist/js/popper.js" type="text/javascript"></script>

    <script src="dist/js/bootstrap.js" type="text/javascript"></script>

    <script src="dist/js/owl.carousel.js"></script>


    <!-- Main Stylesheet -->

    <link href="dist/style.css" rel="stylesheet" type="text/css" media="all">

    <script src="dist/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
</head>

<body>


    <?php include('sidebar.php') ?>

    <div class="content">
        <div class="dashboard_nav_menu">
            <div class="dashboard_nav_menu1">
                <div id="dashboard_nav_menu1h">Credentials</div>
            </div>
            <div class="dashboard_nav_menu2">
                <i class="fa-solid fa-magnifying-glass"></i>
                <form action="dashboard" method="GET">
                    <input type="text" placeholder="Search for Job..." name="glo_search">
                </form>
            </div>
            <div class="dashboard_nav_menu3">
                <div id="dashboard_nav_menu31">
                    <?php include('notify-bell.php'); ?>
                    <div id="dashboard_nav_menu31b"><img src="./dist/images/dnl.png" class="img-fluid"></div>
                </div>
                <div id="dashboard_nav_menu32">
                    <div id="dash_userimg"><img
                            src="<?php echo show_img('uploads/documents/' . $profile_row['passport']); ?>"
                            class="img-fluid" style="height: 40px; width: 40px;"></div>
                    <div id="dash_username">Hello <?php echo get_info($_SESSION['candidate_id'], 'firstname'); ?></div>
                </div>
            </div>
        </div>

        <div class="content_body">
            <form action="save_credentials.php" method="post" enctype="multipart/form-data" class="row">
                <?php if ($update_error) echo $update_error; ?>
                <?php if ($error) echo $error; ?>
                <?php if ($success) {
                    echo $success;
                } ?>
                <?php if ($update_success) {
                    echo $update_success;
                }
                ?>
                <?php if ($_GET['cv'] == 'null') {
                    $_SESSION['cv'] = 'null';
                    echo '<div class="alert alert-danger alert-dismissible mt-2">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Kindly upload your CV to complete your profile</strong>
                            </div>';
                }
                ?>
                <?php if ($_GET['del'] == 'success') {
                    echo '<div class="alert alert-success alert-dismissible mt-2">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Document successfully  deleted</strong>
                             </div>';
                }
                ?>
                <?php if ($_GET['del'] == 'failed') {
                    echo '<div class="alert alert-danger alert-dismissible mt-2">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Unable to delete document, try again later</strong>
                             </div>';
                }
                ?>
                <div class="col-md-10">
                    <div id="app_history">Upload Your Supporting Documents</div>
                    <div id="">Required Documents</div>
                    <div id="document_area">
                        <select
                            class="p-2 p-md-3 px-md-4 border-5 shadow mt-2 d-flex justify-content-between align-items-center"
                            name="document" id="document_list">
                            <option value="">Choose an option</option>
                            <option value="CV">CV</option>
                            <option value="SSCE / WAEC / NECO / NAPTECH">SSCE / WAEC / NECO / NAPTECH</option>
                            <option value="Means of Identification">Means of Identification</option>
                            <option value="BVN Printout">BVN Printout</option>
                            <option value="BSC / BA / BTECH / B Eng Certificate">BSC / BA / BTECH / B Eng Certificate
                            </option>
                            <option value="NCE Certificate">NCE Certificate</option>
                            <option value="National Diploma">National Diploma</option>
                            <option value="Higher National Diploma">Higher National Diploma</option>
                            <option value="NYSC Certificate">NYSC Certificate</option>
                            <option value="Birth Certificate">Birth Certificate</option>
                            <option value="Others">Other Document</option>

                            <img src="assets/dropdown_icon.png" class="img-fluid pointer" />
                        </select>
                    </div><br><br>

                    <div>
                        <fieldset class="upload_dropZone text-center mb-3 p-4">
                            <div id="upload_svg"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                            <p id="small">Drop files here</p>
                            <input id="upload_image_background" data-post-name="image_background" data-post-url="#"
                                class="position-absolute invisible" name="file" type="file" multiple
                                accept="application/pdf, image/jpeg, image/png, image/svg+xml, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />

                            <label class="btn btn-upload mb-3" for="upload_image_background"><span>Or</span> Browse
                                files <span>from your computer</span></label>
                            <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"></div>
                        </fieldset>
                    </div>

                    <div class="my-2 my-md-5">
                        <button name="btn_credentials" type="submit" class="credentials-btn"
                            style="background-color: #006BFF; border: none; padding:1rem 1.5rem; border-radius: 2rem; color: #EFF4F2;">Upload</button>
                    </div>

                    <p>View Uploaded Documents</p>
                    <br>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"
                                        style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">
                                        ID</th>
                                    <th scope="col"
                                        style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">
                                        Document </th>
                                    <th scope="col"
                                        style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">
                                        Filepath</th>
                                    <th scope="col"
                                        style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < $num; $i++) {
                                    $row = mysqli_fetch_array($result);
                                ?>
                                    <tr>
                                        <td style="font-size: 12px;" scope="row" style="background-color:#fff;">
                                            <?= $i + 1; ?></td>
                                        <td style="font-size: 12px;"><?= $row['document']; ?></td>
                                        <td style="font-size: 12px;"><?= $row['filepath']; ?> </td>


                                        <td style="font-size: 12px;">
                                            <a style="margin-right: 15px; " data-toggle="tooltip" data-placement="top"
                                                title="View Document" class="btn btn-sm btn-outline-success"
                                                href="/uploads/documents/<?= $row['filepath']; ?>" target="_blank"><i
                                                    style="margin-right: 5px; " class="fa fa-eye"></i>
                                            </a>

                                            <a style="margin-right: 15px; " data-toggle="tooltip" data-placement="top"
                                                title="Delete Document" class="btn btn-sm btn-outline-danger"
                                                href="delete?id=<?php echo base64_encode($row['id']); ?>&tab=<?php echo base64_encode('credentials'); ?>&section=<?php echo base64_encode('my-credentials'); ?>&return=<?php echo base64_encode('credentials'); ?>"
                                                onclick="return confirm('Are you sure you want to delete this document, this action cannot be undone')"><i
                                                    class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>


                                <?php } ?>
                                <!-- <tr>
                        <td style="font-size: 12px;">Certificate</td>
                        <td style="font-size: 12px;">Description </td>
                        <td><span><i class="fa-solid fa-circle-exclamation"></i></span> Awaiting Upload</td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px; background-color: #EFF4F2;">Nysc Cert</td>
                        <td style="font-size: 12px; background-color: #EFF4F2;">Description </td>
                        <td style="background-color: #EFF4F2;"><span><i class="fa-solid fa-circle-exclamation"></i></span> Awaiting Upload</td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;">Sec. School Cert</td>
                        <td style="font-size: 12px;">Description </td>
                        <td><span><i class="fa-solid fa-circle-exclamation"></i></span> Awaiting Upload</td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px; background-color: #EFF4F2;">National ID</td>
                        <td style="font-size: 12px; background-color: #EFF4F2;">Description </td>
                        <td style="background-color: #EFF4F2;"><span><i class="fa-solid fa-circle-exclamation"></i></span> Awaiting Upload</td>
                      </tr>
                      <tr>
                        <td style="font-size: 12px;">Birth Cert</td>
                        <td style="font-size: 12px;">Description </td>
                        <td><span><i class="fa-solid fa-circle-exclamation"></i></span> Awaiting Upload</td>
                      </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        console.clear();
        ('use strict');



        (function() {

            'use strict';

            // Four objects of interest: drop zones, input elements, gallery elements, and the files.
            // dataRefs = {files: [image files], input: element ref, gallery: element ref}

            const preventDefaults = event => {
                event.preventDefault();
                event.stopPropagation();
            };

            const highlight = event =>
                event.target.classList.add('highlight');

            const unhighlight = event =>
                event.target.classList.remove('highlight');

            const getInputAndGalleryRefs = element => {
                const zone = element.closest('.upload_dropZone') || false;
                const gallery = zone.querySelector('.upload_gallery') || false;
                const input = zone.querySelector('input[type="file"]') || false;
                return {
                    input: input,
                    gallery: gallery
                };
            }

            const handleDrop = event => {
                const dataRefs = getInputAndGalleryRefs(event.target);
                dataRefs.files = event.dataTransfer.files;
                handleFiles(dataRefs);
            }


            const eventHandlers = zone => {

                const dataRefs = getInputAndGalleryRefs(zone);
                if (!dataRefs.input) return;

                // Prevent default drag behaviors
                ;
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(event => {
                    zone.addEventListener(event, preventDefaults, false);
                    document.body.addEventListener(event, preventDefaults, false);
                });

                // Highlighting drop area when item is dragged over it
                ;
                ['dragenter', 'dragover'].forEach(event => {
                    zone.addEventListener(event, highlight, false);
                });;
                ['dragleave', 'drop'].forEach(event => {
                    zone.addEventListener(event, unhighlight, false);
                });

                // Handle dropped files
                zone.addEventListener('drop', handleDrop, false);

                // Handle browse selected files
                dataRefs.input.addEventListener('change', event => {
                    dataRefs.files = event.target.files;
                    handleFiles(dataRefs);
                }, false);

            }


            // Initialise ALL dropzones
            const dropZones = document.querySelectorAll('.upload_dropZone');
            for (const zone of dropZones) {
                eventHandlers(zone);
            }


            // No 'image/gif' or PDF or webp allowed here, but it's up to your use case.
            // Double checks the input "accept" attribute
            const isImageFile = file => ['image/jpeg', 'image/png', 'image/svg+xml'].includes(file.type);


            function previewFiles(dataRefs) {
                if (!dataRefs.gallery) return;
                for (const file of dataRefs.files) {
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onloadend = function() {
                        let img = document.createElement('img');
                        img.className = 'upload_img mt-2';
                        img.setAttribute('alt', file.name);
                        img.src = reader.result;
                        dataRefs.gallery.appendChild(img);
                    }
                }
            }

            // Based on: https://flaviocopes.com/how-to-upload-files-fetch/
            const imageUpload = dataRefs => {

                // Multiple source routes, so double check validity
                if (!dataRefs.files || !dataRefs.input) return;

                const url = dataRefs.input.getAttribute('data-post-url');
                if (!url) return;

                const name = dataRefs.input.getAttribute('data-post-name');
                if (!name) return;

                const formData = new FormData();
                formData.append(name, dataRefs.files);

                fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('posted: ', data);
                        if (data.success === true) {
                            previewFiles(dataRefs);
                        } else {
                            console.log('URL: ', url, '  name: ', name)
                        }
                    })
                    .catch(error => {
                        console.error('errored: ', error);
                    });
            }


            // Handle both selected and dropped files
            const handleFiles = dataRefs => {

                let files = [...dataRefs.files];

                // Remove unaccepted file types
                files = files.filter(item => {
                    if (!isImageFile(item)) {
                        console.log('Not an image, ', item.type);
                    }
                    return isImageFile(item) ? item : null;
                });

                if (!files.length) return;
                dataRefs.files = files;

                previewFiles(dataRefs);
                imageUpload(dataRefs);
            }

        })();
    </script>




</body>

</html>