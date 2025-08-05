<?php
ob_start();
session_start();
include('connection/connect.php');
require_once('inc/fns.php');


if (!isset($_SESSION['Klin_admin_user'])) {
    include('index.php');
    exit;
}

$id = $_GET['id'];

if (privilege() == 'Super Admin' &&  'Admin') {


    $query = "delete from job_post where id = '$id'";
    $result = mysqli_query($db, $query);

    if ($result) {
        activity_log($_SESSION['Klin_admin_email'], "Deleted Job");
        $success = "Job has successfully been deleted";
        include('job-posted.php');
        exit;
    } else {
        $error = "Job cannot be deleted, try again later";
        include('job-posted.php');
        exit;
    }
} else {
    $error = 'You do not have priviledge to delete job';
    include('job-posted.php');
    exit;
}
