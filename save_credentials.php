<?php

ob_start();
session_start();
include('outsourcehr-admin/connection/connect.php');
require_once('outsourcehr-admin/inc/fns.php');
// include('timeout.php');
// SessionCheck();

$document = mysqli_real_escape_string($db, $_POST['document']);
$filepath = mysqli_real_escape_string($db, $_POST['file']);
$candidate =   get_job();


if ($document == 'Others') {
  $document = mysqli_real_escape_string($db, $_POST['document_other']);
}

if (isset($_POST['btn_credentials'])) {



  if ($document == '') {
    $error = '<div class="alert alert-danger alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Please choose the name of document before you upload</strong>
        </div>';
    include('my-credentials.php');
    exit;
  }

  $path = '' . $candidate . '_' . $_FILES['file']['name'];  
  $file_loc = $_FILES['file']['tmp_name'];
  $file_size = $_FILES['file']['size'];
  $file_type = $_FILES['file']['type'];
  $folder = "uploads/documents/";

  $doc_size = $file_size / 1024;

  $rand = rand(1000, 9999);
  $file_name = strtolower($rand . '_' . $path);

  $file_ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

  if ($doc_size > 1024) {
    $error = '<div class="alert alert-danger alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Sorry, your file is too large, the required file size is 1MB below </strong>
        </div>';
    include('my-credentials.php');
    exit;
  }

  if ($path == '') {
    $error = '<div class="alert alert-danger alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>File is required </strong>
        </div>';
    include('my-credentials.php');
    exit;
  }

  // if(strlen($file_name) > 25)
  // {
  //     $error = "Your file file name is too long, kindly rename it to at least 20 letters";
  //     include('my-credentials.php');
  //     exit;
  // }

  if ($file_ext == 'JPEG' || $file_ext == 'jpeg' || $file_ext == 'JPG' || $file_ext == 'jpg' || $file_ext == 'PNG' || $file_ext == 'png'  || $file_ext == 'PDF' || $file_ext == 'pdf' || $file_ext == 'DOCX'  || $file_ext == 'docx' || $file_ext == 'DOC' || $file_ext == 'doc') {
    $path = str_replace(' ', '', $file_name);
    move_uploaded_file($file_loc, $folder . $path);
  } else {
    $error = '<div class="alert alert-danger alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Please reupload your file , the ony accepted file format is JPG, JPEG, PNG, PDF, DOCX, DOC </strong>
        </div>';
    include('my-credentials.php');
    exit;
  }

  $query2 = "select * from credentials where candidate_id  = '" . $_SESSION['candidate_id'] . "'";
  $result2 = mysqli_query($db, $query2);
  $num2 = mysqli_num_rows($result2);
  for ($i = 0; $i < $num2; $i++) {
    $row2 = mysqli_fetch_assoc($result2);
    if (($row2['document'] == $document)) {
      $error = '<div class="alert alert-danger alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Sorry you cannot upload another ' . $document . ', kindly delete the previous document and reupload</strong>
        </div>';
      include('my-credentials.php');
      exit;
    }
  }


  if ($_SESSION['cv']) {
    if ($document == 'CV') {
      $query1 = "update jobseeker set cv = '$path' where candidate_id = '$candidate'";
      $result1 = mysqli_query($db, $query1);

      $query2 = "insert into credentials set document = '$document', filepath = '$path', candidate_id = '$candidate'";
      $result2 = mysqli_query($db, $query2);

      if (check_updated($_SESSION['candidate_id']) == 'yes') {
        $query_up = "update jobseeker set completed = 'updated' where candidate_id = '" . $_SESSION['candidate_id'] . "'";
        mysqli_query($db, $query_up);
      }
    }
    if ($result2) {

      $update_success = '<div class="alert alert-success alert-dismissible mt-2">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong> Your Profile has been successfully updated. Please proceed to Apply for <a href="jobs"> Jobs</a></strong>
        </div>';
      include('my-personal.php');
      exit;
    }
  } else {

    $query = "insert into credentials set document = '$document', filepath = '$path', candidate_id = '$candidate'";
    $result = mysqli_query($db, $query);
    if ($result) {
      if ($document == 'CV') {
        $update_query = "update jobseeker set cv = '$path' where candidate_id = '$candidate'";
      } else {
        $update_query = "update jobseeker set status = 'cv' where candidate_id = '$candidate'";
      }
      $update_result = $db->query($update_query);

      $success = '<div class="alert alert-success alert-dismissible mt-2">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Your document was successfully uploaded </strong>
      </div>';

      if (check_updated($_SESSION['candidate_id']) == 'yes') {
        $query_up = "update jobseeker set completed = 'updated' where candidate_id = '" . $_SESSION['candidate_id'] . "'";
        mysqli_query($db, $query_up);
      }


      include('my-credentials.php');
      exit;
    } else {
      $error = '<div class="alert alert-danger alert-dismissible mt-2">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Error, try uploading your document again </strong>
      </div>';
      include('my-credentials.php');
      exit;
    }
  }
} else {
  header('location: my-credentials');
  exit;
}
