<?php
ob_start();
ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Vacancies');

if (!isset($_SESSION['Klin_admin_user'])) {
    include('index.php');
    exit;
}

$id = base64_decode($_GET['id']);
$status = $_GET['status'];
$return = $_GET['d'];

if ($status == 'approved') {
    $query = "update job_post set status = 'closed' where id = '$id'";
    $result = mysqli_query($db, $query);
} else {
    $query = "update job_post set status = 'approved' where id = '$id'";
    $result1 = mysqli_query($db, $query);
}
$result = mysqli_query($db, $query);

if ($result) {
    $success = "Job Post has been closed";
    // include('job-posted.php');
    header("Location: job-posted?$return");
    exit;
} elseif ($result1) {

    $success = "Job Post has been Approved";
    // include('job-posted.php');
    header("Location: job-posted?$return");
    exit;
} else {
    $error = "Job cannot be closed, try again later";
    // include('job-posted.php');
    header("Location: job-posted?$return");
    exit;
}
