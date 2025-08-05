<?php
ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
// validatePermission('General Setting');
$dept_name = mysqli_real_escape_string($db, $_POST['dept_name']);
$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';


if (isset($_POST['edit_industry'])) {
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $query = "update category set industry = '$dept_name' where id = '$id' ";
    $result = mysqli_query($db, $query);

    if ($result) {
        header('location: add-industry?edit=success');
        // exit;
    } else {
        $error = "Industry cannot be edited, try again later";
        include('add-industry.php');
        exit;
    }
}



if ($dept_name == '') {
    $error = "Industry is required";
    include('add-industry.php');
    exit;
}


$query = "insert into category set industry = '$dept_name', $account_token";
$result = mysqli_query($db, $query);
if ($result) {
    activity_log($_SESSION['Klin_admin_user'], "Added a new industry  ($dept_name)");

    $success = "Industry has been successfully added";
    include('add-industry.php');
    exit;
} else {
    $error = "Industry already exist, try adding another industry";
    include('add-industry.php');
    exit;
}
