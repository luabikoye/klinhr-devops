<?php

ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';
if (!$account_token) {
    validatePermission('General Setting');
}
$card = mysqli_real_escape_string($db, $_POST['card']);

if ($card == '') {
    $error = "Card Title is required";
    include('cards.php');
    exit;
}

$file_loc = $_FILES['logo']['tmp_name'];
$file = $_FILES['logo']['name'];
$file_size = $_FILES['logo']['size'];
$file_type = $_FILES['logo']['type'];

$folder = '../uploads/Cards/';

$file_loc;
$logo_size = $file_size / 1024;

$logo_name = strtolower($file);

$file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));

if ($logo_size > 1550) {
    $error = "Sorry, your logo file is too large, the required file size is 1.5mb below";
    include('cards.php');
    exit;
}

if ($file == '') {
    $error = "Image template is required";
    include('cards.php');
    exit;
}


if ($file_ext == 'JPEG' || $file_ext == 'jpeg' || $file_ext == 'JPG' || $file_ext == 'jpg' || $file_ext == 'PNG' || $file_ext == 'png') {
    $logo = str_replace(' ', ' ', $logo_name);
    move_uploaded_file($file_loc, $folder . $logo);
} else {
    $error = "Please reupload your image template , the ony accepted file format is JPG, jpg, JPEG, jpeg, PNG, png";
    include('cards.php');
    exit;
}

$query = "insert into cards set $account_token, card_name = '$card', image= '$logo'";
$result = mysqli_query($db, $query);
if ($result) {
    activity_log($_SESSION['Klin_admin_email'], "Added a new image template : ($client_name)");

    $success = "Image template has been successfully added";
    include('cards.php');
    exit;
} else {
    $error = "This Image template already exist, try adding another";
    include('cards.php');
    exit;
}
