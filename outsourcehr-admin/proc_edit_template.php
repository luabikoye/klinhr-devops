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

$template_name = mysqli_real_escape_string($db, $_POST['template_name']);
$template_subject = mysqli_real_escape_string($db, $_POST['template_subject']);
$message = $_POST['message'];
$sms_content = $_POST['sms_content'];

if ($template_name == '') {
    $error = "Template name is required";
    include('edit-msg.php');
    exit;
}
if ($template_subject == '') {
    $error = "Template subject is required";
    include('edit-msg.php');
    exit;
}
if ($message == '') {
    $error = "Message is required";
    include('edit-msg.php');
    exit;
}
if ($sms_content == '') {
    $error = "Sms content is required";
    include('edit-msg.php');
    exit;
}

$query = "update message_template set template_name = '$template_name', template_subject = '$template_subject', message = '$message', sms_content = '$sms_content' where id = '$id'";
$result = mysqli_query($db, $query);
if ($result) {
    $success = "Template has been successfully edited";
    include('message-template.php');
    exit;
} else {
    $error = "Template cannot be edited, try again later";
    include('edit-msg.php');
    exit;
}
