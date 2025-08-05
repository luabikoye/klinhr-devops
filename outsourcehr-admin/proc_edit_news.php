<?php

ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');
validatePermission('Hr Operations');
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

$id = $_POST['id'];

$admin_fullname = get_fullname($_SESSION['kennedia_admin_user']);

$title = mysqli_real_escape_string($db, $_POST['title']);
$job_image = mysqli_real_escape_string($db, $_POST['job_image']);
$access_type = mysqli_real_escape_string($db, $_POST['access_type']);
$content = mysqli_real_escape_string($db, $_POST['content']);
$date_posted = date('Y-m-d');


if ($title == '') {
    $error = "News title is required";
    include('add-news.php');
    exit;
}

if ($content == '') {
    $error = "Content is required";
    include('add-news.php');
    exit;
}

if ($access_type == 'select_option') {
    $error = "Access type is required";
    include('add-news.php');
    exit;
}

if ($_FILES['job_image']['name']) {
    $path = $_FILES['job_image']['name'];
    $file_loc = $_FILES['job_image']['tmp_name'];
    $file_size = $_FILES['job_image']['size'];
    $file_type = $_FILES['job_image']['type'];
    $folder = UPLOAD_DIR."news/$path";

    $doc_size = $file_size / 1024;

    $file_name = strtolower($path);

    $file_ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    if ($doc_size > 1550) {
        $error = 'Sorry, your file is too large, the required file size is 1.5mb below';
        include('add-news.php');
        exit;
    }

    // if(!in_array($file_ext, array('jpg', 'jpeg', 'png', 'gif')))
    // {
    //     $error = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed';
    //     include ('add-news.php');
    //     exit;
    // }

    if (!isset($_POST['job_image'])) {
        if ($file_ext == 'JPEG' || $file_ext == 'jpeg' || $file_ext == 'JPG' || $file_ext == 'jpg' || $file_ext == 'PNG' || $file_ext == 'png') {
            $path = str_replace(' ', ' ', $file_name);
            move_uploaded_file($file_loc, $folder);
        }
    } else {
        $error = 'Please reupload your file , the ony accepted file format is JPG, JPEG, PNG, PDF, DOCX, DOC ';
        include('add-news.php');
        exit;
    }

    $sql = "update  emp_news set  filename = '$path' where id = '$id' ";
    $result1 = mysqli_query($db, $sql);
}

if ($access_type == 'all') {
    echo '<script>alert("You have selected all access type. This will make the news available to all users. Please note that this will not be reflected in the news feed.")</script>';

    $access_type = 'ALL';
}

$job_post = $_SESSION['Klin_admin_user'];

$query = "update  emp_news set title = '$title',  content = '$content', date = '$date_posted', access_type = '$access_type', summary = '$content' where id = '$id' ";
$result = mysqli_query($db, $query);
if ($result) {
    $job_post_id = mysqli_insert_id($db);

    $query1 = "select * from login where username = '$job_post'";
    $result1 = mysqli_query($db, $query1);
    $row1 = mysqli_fetch_array($result1);
    $name =  ucfirst($row1['firstname']) . ' ' . ucfirst($row1['lastname']);

    activity_log($_SESSION['Klin_admin_email'], "Edited  news with title: $title");

    $success = "News has been successfully edited";
    include('add-news.php');
    exit;
} else {
    $error = "News not added, check if all information were correctly entered";
    include('add-news.php');
    exit;
}