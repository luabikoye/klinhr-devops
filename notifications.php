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
$sql = "update notification set status = 'Read' where id = '$exampleModal' ";
$notify_result = $db->query($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">

  <title>Notification | Job Portal | KlinHR</title>

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
            <?php include('notify-bell.php'); ?>
            <div id="dashboard_nav_menu31b"><img src="./dist/images/dnl.png" class="img-fluid"></div>
          </div>
          <div id="dashboard_nav_menu32">
            <div id="dash_userimg"><img src="<?php echo show_img('uploads/documents/' . $profile_row['passport']); ?>" class="img-fluid" style="height: 40px; width: 40px;"></div>
            <div id="dash_username">Hello <?php echo get_info($_SESSION['candidate_id'], 'firstname'); ?></div>
          </div>
        </div>
      </div>

      <div class="content_body">
        <div class="row">
          <div class="col-md-10">

            <div id="req_doc">Notifications(<?php echo $applied_num ?>)</div>
            <p>Our notification system is designed to keep you updated about important events and updates. From system changes to account activity, we’ll send notifications directly to your inbox so you’re always in the know.</p>

            <br>
            <?php
            if ($success) {
            ?>
              <div class="alert alert-success alert-dismissible mt-2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><?= $success; ?></strong>
              </div>

            <?php } ?>
            <?php
            if ($error) {
            ?>
              <div class="alert alert-danger alert-dismissible mt-2">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><?= $error; ?></strong>
              </div>

            <?php } ?>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">ID</th>
                    <th scope="col" style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">Message </th>
                    <th scope="col" style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">From</th>
                    <th scope="col" style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">Status</th>
                    <th scope="col" style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">Date</th>
                    <th scope="col" style="background-color: #006BFF; color: #FFF; font-weight: 500; border-bottom: none;">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $applied_query = "select * from notification where candidate_id = '" . $_SESSION['candidate_id'] . "' and deleted IS NULL";
                  $applied_result = $db->query($applied_query);
                  $applied_num = mysqli_num_rows($applied_result);

                  for ($i = 0; $i < $applied_num; $i++) {
                    $applied_row = mysqli_fetch_assoc($applied_result);

                  ?>
                    <tr <?= bold_text($applied_row['status']); ?>>
                      <td style="font-size: 12px;"><?= $i + 1; ?></td>
                      <td style="font-size: 12px;"><?= substr($applied_row['message'], 0, 30); ?>...
                        <a href="view_notification?id=<?php echo base64_encode($applied_row['id']); ?>">
                          more
                        </a>
                      </td>
                      <td><?= $applied_row['notifier']; ?></td>
                      <td><?= $applied_row['status']; ?></td>
                      <td><?= long_date($applied_row['date']); ?></td>
                      <td>
                        <a style="margin-right: 15px; " data-toggle="tooltip" data-placement="top" title="Delete Notification" class="btn btn-sm btn-outline-danger" href="del_notification?id=<?= base64_encode($applied_row['id']); ?>&tab=<?= base64_encode('notification'); ?>&section=<?= base64_encode('notification'); ?>&return=<?= base64_encode('notification'); ?>" onclick="return confirm('Are you sure you want to delete this notification, this action cannot be undone')"><i class="fa fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
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