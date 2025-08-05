<?php
ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
  header("Location: index");
  exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Assessment');
$job_id = mysqli_real_escape_string($db, $_POST['assessment_name']);
$assessment_name = get_val('job_post', 'id', $_POST['assessment_name'], 'job_title');
$no_of_question = mysqli_real_escape_string($db, $_POST['no_of_question']);
$pass_mark = mysqli_real_escape_string($db, $_POST['pass_mark']);
$duration = mysqli_real_escape_string($db, $_POST['duration']);
$cat = $_POST['category'];
$id = $_POST['id'];


// $cat = implode(',', $category);

if ($assessment_name == '') {
  $error = "Assessment name is required";
  include('set-assessment.php');
  exit;
}
if ($no_of_question == '') {
  $error = "No of question is required";
  include('set-assessment.php');
  exit;
}
if ($pass_mark == '') {
  $error = "Pass mark is required";
  include('set-assessment.php');
  exit;
}

if ($duration == '') {
  $error = "Durstion is required";
  include('set-assessment.php');
  exit;
}

if ($cat == 'Select Category') {
  $error = "Select a Category before submitting";
  include('set-assessment.php');
  exit;
}


$query = "update assessment set job_id = '$job_id', assessment_name = '$assessment_name', no_of_question =  '$no_of_question', pass_mark = '$pass_mark', duration = '$duration', category = '$cat' where id = '$id'";

$result = mysqli_query($db, $query);
if ($result) {
  $assessment_name = '';
  $no_of_question = '';
  $pass_mark = '';
  $duration = '';

  $success = "Assessment edit was successful";
  include('set-assessment.php');
  exit;
} else {
  $error = "Assessment esit was not successful. Assessment name may already exists";
  include('set-assessment.php');
  exit;
}
