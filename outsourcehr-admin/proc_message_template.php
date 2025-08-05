<?php
ob_start();
session_start();
if (!isset($_SESSION['Klin_admin_user'])) {
    header("Location: index");
    exit;
}

include('connection/connect.php');
require_once('inc/fns.php');

$account_token = $_SESSION['account_token'] ? 'account_token = "' . $_SESSION['account_token'] . '"' : 'account_token IS NULL ';
if (!$account_token) {
    validatePermission('General Setting');
}
$template_name = mysqli_real_escape_string($db, $_POST['template_name']);
$template_subject = mysqli_real_escape_string($db, $_POST['template_subject']);
$message = mysqli_real_escape_string($db, $_POST['message']);
$sms_content = mysqli_real_escape_string($db, $_POST['sms_content']);

if ($template_name == '') {
    $error = "Template name is required";
    include('message-template.php');
    exit;
}
if ($template_subject == '') {
    $error = "Template subject is required";
    include('message-template.php');
    exit;
}
if ($message == '') {
    $error = "Message is required";
    include('message-template.php');
    exit;
}
if ($sms_content == '') {
    $error = "Sms content is required";
    include('message-template.php');
    exit;
}

$query = "insert into message_template set $account_token, template_name = '$template_name', template_subject = '$template_subject', message = '$message', sms_content = '$sms_content'";
$result = mysqli_query($db, $query);
if ($result) {
    $template_name = '';
    $template_subject = '';
    $message = '';
    $sms_content = '';

    $success = "Template has been successfully added";
    include('message-template.php');
    exit;
} else {
    $error = "Template cannot be added, check if all information were correctly entered";
    include('message-template.php');
    exit;
}
