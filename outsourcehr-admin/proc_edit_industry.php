<?php
ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');
validatePermission('General Setting');
$dept_name = mysqli_real_escape_string($db, $_POST['dept_name']);


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
