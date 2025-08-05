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


if (($_GET['read'])) {
  $exampleModal = base64_decode($_GET['read']);
}


$id = base64_decode($_GET['id']);

$sql = "update notification set status = 'Read' where id = '$id'";
$result_2 = mysqli_query($db, $sql);

$query = "select * from notification where id = '" . $id . "'";
$result = mysqli_query($db, $query);
$row = mysqli_fetch_array($result);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">

  <title>View Notification | Job Portal | KlinHR</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="dist/css/bootstrap.css">

  <link href="dist/font-awesome/css/all.css" rel="stylesheet" type="text/css">

  <link rel="icon" href="./dist/images/favicon.png" />

  <link href="dist/css/animate.css" rel="stylesheet">

  <link href="dist/css/owl.carousel.css" rel="stylesheet">

  <link href="dist/css/owl.theme.default.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
    <?php
    $applied_query = "select * from notification where candidate_id = '" . $_SESSION['candidate_id'] . "' and deleted IS NULL";
    $applied_result = $db->query($applied_query);
    $applied_num = mysqli_num_rows($applied_result);

    if ($applied_num) {
    ?>
      <div class="dashboard_nav_menu">
        <div class="dashboard_nav_menu1">
          <div id="dashboard_nav_menu1h">Notification</div>
        </div>
        <div class="dashboard_nav_menu2">
          <i class="fa-solid fa-magnifying-glass"></i>
          <form action="dashboard" method="GET">
            <input type="text" placeholder="Search for Job..." name="glo_search">
          </form>
        </div>
        <div class="dashboard_nav_menu3">
          <div id="dashboard_nav_menu31">
            <a href="notifications">
              <div id="dashboard_nav_menu31a">
                <i class="fa-solid fa-bell"></i>
                <span><?php echo $applied_num ?></span>
              </div>
            </a>
            <div id="dashboard_nav_menu31b"><img src="./dist/images/dnl.png" class="img-fluid"></div>
          </div>
          <div id="dashboard_nav_menu32">
            <div id="dash_userimg"><img src="<?php echo show_img('uploads/documents/' . $profile_row['passport']); ?>" class="img-fluid" style="height: 40px; width: 40px;"></div>
            <div id="dash_username">Hello <?php echo get_info($_SESSION['candidate_id'], 'firstname'); ?></div>
          </div>
        </div>
      </div>

      <div class="container my-2 my-md-4 px-3 px-md-4 px-lg-5">
        <!-- Search button -->
        <div class="d-flex justify-content-end" style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)) ,url('assets/dash-bg.jpg'); background-position: center;">
          <div class="d-flex align-items-center">

            <h3 style="color:#fff;padding:80px 0px;padding-right:50px;">View Message</h3>
          </div>
        </div>

        <!-- Table -->


        <div class="data-holder">
          <?php if ($success) echo '<div class="alert alert-success">' . $success . '</div>'; ?>
          <?php if ($error) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
          <!-- <div class="c-accordion"> -->
          <!-- <div class="c-accordion-title"><i class="fa fa-unlock"></i> <span>Change Password</span> -->
          <!-- </div> -->
          <div class="c-accordion-content">
            <!-- <h3>Personal Details</h3> -->
            <div class="form">

              <div class="row">
                <div class="col-md-12">
                  <h4 style="margin-top:50px;margin-bottom: 20px; font-size: 15px;">Message from Admin</h4>
                  <div class="form-group">

                    <p name="message" id="achievement" style="height: 200px;" placeholder="Work Achievement" class="formfield">
                      <?php echo ($row['message']); ?>
                    </p>

                  </div>
                </div>
                <div class="col-md-2">
                  <div class="form-group">
                    <a href="notifications">
                      <button id="btn_credentials" name="submit" type="submit" class="btn1 no-shadow alert alert-success">
                        Go back
                      </button>
                    </a>
                  </div>
                </div>

                <div class="col-12"></div>

              </div>

            </div>
          </div>
        </div>



      </div>
    <?php } ?>
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