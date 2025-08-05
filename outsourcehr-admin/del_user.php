<?php
ob_start();
session_start();

include('connection/connect.php');
require_once('inc/fns.php');
require_once('PHPMailer/PHPMailerAutoload.php');
validatePermission('General Setting');

if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

$id = $_GET['id'];

$query = "select * from login where id = '$id'";
$result = mysqli_query($db, $query);
$num = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$name =  $row['firstname'];

$query = "delete from login where id = '$id'";
$result = mysqli_query($db, $query);
if ($result) {
    activity_log($_SESSION['Klin_admin_user'], "Deleted a user $name");

    $success1 = "User successfully deleted";
    include('user.php');
    exit;
} else {
    $error1 = "User was not deleted, try again later";
    include('user.php');
    exit;
}
