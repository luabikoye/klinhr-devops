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
if (isset($_POST["upload"])) {

  $files = $_FILES['file']['name'];
  $file_loc = $_FILES['file']['tmp_name'];
  $file_size = $_FILES['file']['size'];
  $file_type = $_FILES['file']['type'];
  $account_token = $_SESSION['account_token'] ? $_SESSION['account_token'] : 'NULL';

  $file_ext = strtolower(pathinfo($files, PATHINFO_EXTENSION));

  if ($files == '') {
    $error = "File is required ";
    include('add-question.php');
    exit;
  }


  if ($file_ext != 'csv') {
    $error = "File is not a csv format";
    include('add-question.php');
    exit;
  }

  $file = $_FILES['file']['tmp_name'];
  $handle = fopen($file, "r");
  $c = 1;

  while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {

    $category = $filesop[1];
    $type = $filesop[2];
    $question = $filesop[3];
    $media = $filesop[4];
    $option_a = $filesop[5];
    $option_b = $filesop[6];
    $option_c = $filesop[7];
    $option_d = $filesop[8];
    $option_e = $filesop[9];
    $answer = $filesop[10];

    $query = "insert into questions (category, type, question, media, option_a, option_b, option_c, option_d, option_e, answer,account_token) 
    values ('$category', '$type', '$question','$media','$option_a', '$option_b', '$option_c', '$option_d', '$option_e', '$answer','$account_token')";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_execute($stmt);

    $c = $c + 1;
  }

  if ($query) {

    activity_log($_SESSION['Klin_admin_email'], "Bulk upload question");

    $check = "delete from questions where question = 'question'";
    $result = mysqli_query($db, $check);
    $success = "File has been successfully imported";
    include('add-question.php');
    exit;
  } else {
    $error = "File couldn't be imported";
    include('add-question.php');
    exit;
  }
}
