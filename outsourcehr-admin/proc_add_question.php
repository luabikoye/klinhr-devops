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
$category = mysqli_real_escape_string($db, $_POST['category']);
$type = mysqli_real_escape_string($db, $_POST['type']);
$media = mysqli_real_escape_string($db, $_POST['media']);
$question =  $_POST['question'];
$option_a = mysqli_real_escape_string($db, $_POST['option_a']);
$option_b = mysqli_real_escape_string($db, $_POST['option_b']);
$option_c = mysqli_real_escape_string($db, $_POST['option_c']);
$option_d = mysqli_real_escape_string($db, $_POST['option_d']);
$option_e = mysqli_real_escape_string($db, $_POST['option_e']);
$answer = mysqli_real_escape_string($db, $_POST['answer']);
$account_token = $_SESSION['account_token'] ? $_SESSION['account_token'] : 'NULL';


if ($category == 'Select Category') {
    $error1 = "Category not selected";
    include('add-question.php');
    exit;
}

if ($type == 'Select Type') {
    $error1 = "Type not selected";
    include('add-question.php');
    exit;
}

if ($question == '' || $option_a == '' || $option_b == '' || $option_c == '' || $option_d == '' || $answer == '') {
    $error1 = 'All fields are required before you can continue ';
    include('add-question.php');
    exit;
}

$file = $_FILES['media']['name'];
$file_loc = $_FILES['media']['tmp_name'];
$file_size = $_FILES['media']['size'];
$file_type = $_FILES['media']['type'];
$folder = "../uploads/assessment/";

$new_size = $file_size / 1024;

$new_file_name = strtolower($file);

$file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));


if ($file) {

    if ($new_size > 1550) {
        $error1 = "Sorry, your image file is too large, the required file size is 1.5mb below";
        include('add-question.php');
        exit;
    }

    // if(strlen($new_file_name) > 20)
    // {
    //     $error1 = "Sorry, your filename is longer than 20 characters";
    //     include('add-question.php');
    //     exit;
    // }

    if ($file_ext == 'jpg' || $file_ext == 'png' || $file_ext == 'JPG' || $file_ext == 'PNG' || $file_ext == 'jpeg'  || $file_ext == 'JPEG' || $file_ext == 'GIF' || $file_ext == 'gif') {
        $media = str_replace(' ', ' ', $new_file_name);
        move_uploaded_file($file_loc, $folder . $media);
    } else {
        $error1 = "Please reupload your image , the ony accepted file format is JPG, jpg, JPEG, jpeg, PNG, png, GIF, gif";
        include('add-question.php');
        exit;
    }
}

$new_ques = $_SESSION['Klin_admin_user'];


$query = "insert into questions (category, type, media,  question, option_a, option_b, option_c, option_d, option_e, answer, account_token ) values ('$category', '$type', '$media',  '$question', '$option_a', '$option_b', '$option_c', '$option_d', '$option_e', '$answer', '$account_token')";

$result = mysqli_query($db, $query);
if ($result) {
    activity_log($_SESSION['Klin_admin_user'], "Added a new question");

    $success1 = 'Question has been added successfully';
    include('add-question.php');
    exit;
} else {
    $error1 = 'Question not added';
    include('add-question.php');
    exit;
}
