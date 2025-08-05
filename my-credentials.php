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

  <title>My Credentials | KlinHR Portal</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="new_dist/css/bootstrap.css">

  <link href="new_dist/font-awesome/css/all.css" rel="stylesheet" type="text/css">

  <link rel="icon" href="./new_dist/images/fav.png" />

  <link href="new_dist/css/animate.css" rel="stylesheet">

  <link href="new_dist/css/owl.carousel.css" rel="stylesheet">

  <link href="new_dist/css/owl.theme.default.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="new_dist/js/jquery.3.4.1.min.js"></script>

  <script src="new_dist/js/popper.js" type="text/javascript"></script>

  <script src="new_dist/js/bootstrap.js" type="text/javascript"></script>

  <script src="new_dist/js/owl.carousel.js"></script>

  <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>


  <!-- Main Stylesheet -->

  <link href="new_dist/style.css" rel="stylesheet" type="text/css" media="all">

  <script src="new_dist/js/wow.min.js"></script>
  <script>
    new WOW().init();
  </script>
</head>

<body>

  <div class="container-fluid">
    <div class="dashboard-section">
      <div class="row">
        <?php include('include/side-nav.php') ?>
        <div class="col-md-9 dashboardNavRight">
          <div class="dashboard_body">
            <div class="dashboard_body_nav">
              <div class="dashboard_body_navL">
                <div id="dashboard_body_navLsearch">
                  <i class="fa-solid fa-magnifying-glass"></i>
                  <input type="text" placeholder="Search...">
                </div>
              </div>
              <div class="dashboard_body_navR">
                <div class="dashboard_body_navR1">
                  <i class="fa-regular fa-bell"></i>
                  <span></span>
                </div>
                <div class="dashboard_body_navR2">
                  <div class="dashboard_body_navR2a">
                    <img src="./new_dist/images/d1.png" class="img-fluid">
                  </div>
                  <div class="dashboard_body_navR2b">
                    <div id="dashboard_body_navR2bh"><?php echo get_info($_SESSION['candidate_id'], 'firstname'); ?> <br> <span>Online</span> </div>
                  </div>
                </div>
              </div>
            </div>
            <form action="save_credentials.php" method="post" enctype="multipart/form-data" class="container">
              <div id="changeph">My Credentials</div>
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

              <div class="row">
                <div class="col-md-4">
                  <div class="credentials_fms">
                    <select class="form-select" name="document" id="document_list">
                      <option selected>Choose Document</option>
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
                    </select>
                  </div>
                </div>
              </div>

              <p>Upload Document</p>
              <br>

              <div class="row">
                <div class="col-md-8">

                  <div>

                    <fieldset class="upload_dropZone text-center mb-3 p-4">
                      <i class="fa-solid fa-cloud-arrow-up fa-4x" style="color: #D7D7D7;"></i>

                      <p style="font-weight: 500; margin-top: 20px;">Drop your file here<br>or</p>

                      <input id="upload_image_background" name="file" data-post-name="image_background" data-post-url="#" class="position-absolute invisible" type="file" multiple accept="application/pdf, image/jpeg, image/png, image/svg+xml, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document" />

                      <label class="btn-upload mb-2" for="upload_image_background">Browse</label>
                      <p style="font-size: 10px; color: #D7D7D7;">Minimum file size 4MB</p>

                      <div class="upload_gallery d-flex flex-wrap justify-content-center gap-3 mb-0"></div>

                    </fieldset>

                    <div id="cr_uploadsave"><button name="btn_credentials" type="submit">Save</button></div>

                  </div>
                </div>


              </div>
              <br><br>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col" style="border-top: none; border-bottom: none;">ID</th>
                      <th scope="col" style="border-top: none; border-bottom: none;">Document</th>
                      <th scope="col" style="border-top: none; border-bottom: none;">Filepath</th>
                      <th scope="col" style="border-top: none; border-bottom: none;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Fetch records for the current page


                    // Display job applications
                    for ($i = 0; $i < $num; $i++) {
                      $row = mysqli_fetch_array($result);
                    ?>
                      <!-- <tr>
                        <th scope="row" style="border-top: none;"><?= get_val('clients', 'id', get_val('job_post', 'id', $row['jobs_id'], 'client_id'), 'client_name') ?></th>
                        <td style="border-top: none;">
                          <div id="apjbh"><?= ucwords(get_val('job_post', 'id', $row['jobs_id'], 'job_title')) ?> <br> <button><?= get_val('job_post', 'id', $row['jobs_id'], 'job_type') ?></button> <i class="fa-solid fa-location-dot"></i> <span><?= get_val('job_post', 'id', $row['jobs_id'], 'state') ?>.</span></div>
                        </td>
                        <td style="border-top: none;"><?= long_date(get_val('job_post', 'id', $row['jobs_id'], 'date_posted')) ?></td>
                        <td style="border-top: none;">
                          <a href="job-description?valid=<?= base64_encode($row['jobs_id']); ?>" style="color: #006bff;"><i title="View Job Description" class="fa-regular fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                          <a href="remove-fav?id=<?= base64_encode($row['id']) ?>" style="color: #E52936;"><i class="fa-solid fa-trash-can" title="Remove from saved Jobs"></i></a>
                        </td>
                      </tr> -->
                      <tr>
                        <td style="font-size: 12px;" scope="row" style="background-color:#fff;">
                          <?= $i + 1; ?></td>
                        <td style="font-size: 12px;"><?= $row['document']; ?></td>
                        <td style="font-size: 12px;"><?= $row['filepath']; ?> </td>


                        <td style="font-size: 12px;">
                          <a href="/uploads/documents/<?= $row['filepath']; ?>" target="_blank" data-toggle="tooltip" data-placement="top" style="color: #006bff;"><i title="View Document" class="fa-regular fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                          <a href="delete?id=<?php echo base64_encode($row['id']); ?>&tab=<?php echo base64_encode('credentials'); ?>&section=<?php echo base64_encode('my-credentials'); ?>&return=<?php echo base64_encode('my-credentials'); ?>" data-toggle="tooltip" data-placement="top" style=" color: #E52936;"><i title="Delete Document" onclick="return confirm('Are you sure you want to delete this document, this action cannot be undone')" class="fa-regular fa-trash-can"></i></a>

                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>





  <script>
    console.clear();
    ('use strict');


    // Drag and drop - single or multiple image files
    // https://www.smashingmagazine.com/2018/01/drag-drop-file-uploader-vanilla-js/
    // https://codepen.io/joezimjs/pen/yPWQbd?editors=1000
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