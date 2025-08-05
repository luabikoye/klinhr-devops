<?php
ob_start();
session_start();


if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Employee Appraisal');
$role = mysqli_real_escape_string($db, $_POST['role']);
$appraisal_role = mysqli_real_escape_string($db, $_POST['appraisal_role']);
$due_date = mysqli_real_escape_string($db, $_POST['due_date']);
$client =  $_POST['client'];
$date = date('Y-m-d');

$id = $_POST['id'];

if ($role == 'select_role') {
    $error = "Role is required";
    include('set-appraisal.php');
    exit;
}

if ($appraisal_role == 'select_appraisal_role') {
    $error = "Appraisal Role is required";
    include('set-appraisal.php');
    exit;
}

if ($date == 'due_date') {
    $error = "Email is required";
    include('set-appraisal.php');
    exit;
}

if ($client == 'select_client') {
    $error = "Phone is required";
    include('set-appraisal.php');
    exit;
}

$query = "update  appraisal set role = '$role', appraisal_role = '$appraisal_role', due_date = '$due_date', client = '$client', date = '$date', user = '" . $_SESSION['Klin_admin_user'] . "' where id = '$id' ";
$result = mysqli_query($db, $query);
if ($result) {
    activity_log($_SESSION['Klin_admin_email'], "Edited appraisal: $appraisal_role");

    $success = "Appraisal successfully edited";
    include('set-appraisal.php');
    exit;
} else {
    $error = "Appraisal was not edited, check if all information were correctly entered";
    include('set-appraisal.php');
    exit;
}
