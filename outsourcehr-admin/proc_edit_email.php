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
$id = $_POST['id'];
$email = mysqli_real_escape_string($db, $_POST['email']);
$privilege = mysqli_real_escape_string($db, $_POST['privilege']);

$query = "update notification_email set email = '$email', privilege = '$privilege' where id = '$id'";
$result = mysqli_query($db, $query);

if ($result) {
    activity_log($_SESSION['Klin_admin_user'], "Edited Notification Email: ($email)");

    $success1 = "Notification Email successfully edited";
    include('notification-mail.php');
    exit;
} else {
    $error1 = "Notification Email not edited, try again";
    include('notification-mail.php');
    exit;
}
