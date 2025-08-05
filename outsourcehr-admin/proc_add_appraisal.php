<?php
ob_start();
session_start();


if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('Appraisal');
$role = mysqli_real_escape_string($db, $_POST['role']);
$appraisal_role = mysqli_real_escape_string($db, $_POST['appraisal_role']);
$due_date = mysqli_real_escape_string($db, $_POST['due_date']);
$client =  $_POST['client'];
$date = date('Y-m-d');
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';


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

$sql = "select * from appraisal where $account_token and role = '$role' and client = '$client' AND due_date >= CURRENT_DATE()";
$result_1 = mysqli_query($db, $sql);
$num_exist = mysqli_num_rows($result_1);
$exist = mysqli_fetch_array($result_1);
if ($num_exist != 0) {
    $error = "Sorry this appraisal already exist";
    include('set-appraisal.php');
    exit;
}

$query = "insert into appraisal set account_token = '$account_token', role = '$role', appraisal_role = '$appraisal_role', due_date = '$due_date', client = '$client', date = '$date', user = '" . $_SESSION['Klin_admin_user'] . "', status = 'Pending' ";
$result = mysqli_query($db, $query);
if ($result) {
    activity_log($_SESSION['kennedia_admin_email'], "Set up a new appraisal $appraisal_role");

    $success = "Appraisal successfully created";
    include('set-appraisal.php');
    exit;
} else {
    $error = "Appraisal was not created, check if all information were correctly entered";
    include('set-appraisal.php');
    exit;
}
