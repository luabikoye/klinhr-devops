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

$admin_fullname = get_fullname($_SESSION['Klin_admin_user']);

$caption = mysqli_real_escape_string($db, $_POST['caption']);
$job_image = mysqli_real_escape_string($db, $_POST['job_image']);
$access_type = mysqli_real_escape_string($db, $_POST['access_type']);
$content = $_POST['content'];
$date_posted = date('Y-m-d');


if ($caption == '') {
    $error = "Caption  is required";
    include('document-forms.php');
    exit;
}



if ($access_type == 'select_option') {
    $error = "Access type is required";
    include('document-forms.php');
    exit;
}

if ($_FILES['job_image']['name']) {
    $path = $_FILES['job_image']['name'];
    $file_loc = $_FILES['job_image']['tmp_name'];
    $file_size = $_FILES['job_image']['size'];
    $file_type = $_FILES['job_image']['type'];
    $folder = "../uploads/downloads/";

    $doc_size = $file_size / 1024;

    $file_name = strtolower($path);

    $file_ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    if ($doc_size > 1550) {
        $error = 'Sorry, your file is too large, the required file size is 1.5mb below';
        include('document-forms.php');
        exit;
    }




    if ($file_ext == 'JPEG' || $file_ext == 'jpeg' || $file_ext == 'JPG' || $file_ext == 'jpg' || $file_ext == 'PNG' || $file_ext == 'png') {
        $path = str_replace(' ', ' ', $file_name);
        move_uploaded_file($file_loc, $folder . $path);
    } else {
        $error = 'Please reupload your file , the ony accepted file format is JPG, JPEG, PNG, PDF, DOCX, DOC ';
        include('document-forms.php');
        exit;
    }

    $sql = "update  emp_download set  filename = '$path', size = '$file_size' where id = '$id' ";
    $result1 = mysqli_query($db, $sql);
}

if ($access_type == 'all') {
    echo '<script>alert("You have selected all access type. This will make the document available to all users.")</script>';

    $access_type = 'ALL';
}

$job_post = $_SESSION['Klin_admin_user'];

$query = "update  emp_download set caption = '$caption',   date_posted = '$date_posted', access_type = '$access_type' where id = '$id' ";
$result = mysqli_query($db, $query);
if ($result) {
    $job_post_id = mysqli_insert_id($db);

    $query1 = "select * from login where username = '$job_post'";
    $result1 = mysqli_query($db, $query1);
    $row1 = mysqli_fetch_array($result1);
    $name =  ucfirst($row1['firstname']) . ' ' . ucfirst($row1['lastname']);

    activity_log($_SESSION['Klin_admin_email'], "Edited  news with title: $title");

    $success = "News has been successfully edited";
    include('document-forms.php');
    exit;
} else {
    $error = "News not edited, check if all information were correctly entered";
    include('document-forms.php');
    exit;
}
